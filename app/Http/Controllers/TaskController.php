<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class TaskController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->tags = array_diff(explode(' ', $request->tags), ['']);

        $user = \Auth::user();

        // Если строка поиска пустая, выводим всё
        if (!$this->tags) {
            $tasks = Task::where('user_id', '=', $user->id)
                ->with('tags')
                ->orderBy('created_at', 'desc')->get();
        }
        // Иначе выводим совпадения
        else {
            $tasks = Task::where('user_id', '=', $user->id)
                ->with('tags')
                ->whereHas('tags', function($query) {
                    $query->whereIn('name', $this->tags);
                })
                ->orderBy('created_at', 'desc')->get();
        }

        // Возвращаем отфильтрованные задачи фронтенду
        return view('todo.filter', compact('tasks'))->render();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Валидация входящих данных
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'tags' => 'max:255',
            'image' => 'nullable|image|max:4096',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        // Если есть изображение - сохраняем и возвращаем массив с путями к превью и оригиналу
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $this->storeImage($request);
        }

        // Создаем задачу
        $task = Task::create([
            'user_id' => \Auth::user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'image' => $image[0] ?? null,
            'image_orig' => $image[1] ?? null,
        ]);

        // Добавляем теги
        $request_tags = array_diff(explode(' ', $request->tags), ['']);
        foreach($request_tags as $request_tag) {
            $task->tags()->firstOrCreate(['name' => $request_tag]);
        }

        // Возвращаем новую задачу фронтенду
        return response()->json([
            'status' => 'success',
            'html' => view('todo.show', ['task'=>$task])->render(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = \Auth::user();
        $task = Task::where('id', '=', $id)
            ->where('user_id', '=', $user->id)
            ->with('tags')
            ->first();
        return view('todo.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, string $id)
    {
        // Валидация входящих данных
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'tags' => 'max:255',
            'image' => 'nullable|image|max:4096',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        // Получение объекта задачи
        $user = \Auth::user();
        $task = Task::where('id', '=', $id)
            ->where('user_id', '=', $user->id)
            ->with('tags')
            ->first();

        // Обновление заголовка и описание
        $update_data = [
            'title' => $request->title,
            'description' => $request->description,
        ];

        // Проверяем, нужно ли обновить изображение
        if (!isset($request->imgdel) && $request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $this->storeImage($request);
            $update_data['image'] = $image[0];
            $update_data['image_orig'] = $image[1];
        }

        // Проверяем, нужно ли удалить изображение
        if (isset($request->imgdel)) {
            $update_data['image'] = null;
            $update_data['image_orig'] = null;
            Storage::disk('public')->delete($task->image);
            Storage::disk('public')->delete($task->image_orig);
        }

        // Обновляем задачу
        $task->update($update_data);

        // Обновляем теги
        $task->tags()->detach();
        $request_tags = array_diff(explode(' ', $request->tags), ['']);
        foreach($request_tags as $request_tag) {
            $task->tags()->firstOrCreate(['name' => $request_tag]);
        }
        $task->load('tags');

        // Возвращаем обновленную задачу фронтенду
        return response()->json([
            'status' => 'success',
            'html' => view('todo.show', ['task'=>$task])->render(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = \Auth::user();
        $task = Task::where('id', '=', $id)
            ->where('user_id', '=', $user->id)
            ->with('tags')->first();
        if ($task->image) {
            Storage::disk('public')->delete($task->image);
            Storage::disk('public')->delete($task->image_orig);
        }
        $task->delete();
        return response()->json([
            'status' => 'success'
        ]);
    }

    private function storeImage(Request $request)
    {
        $dir = date('Y-m-d');

        // Сохраняем оригинал
        $image = $request->file('image')->store("images/$dir", 'public');
        $originalPath = storage_path('app/public/' . $image);
        $thumbnailPath = dirname($originalPath) . '/150x150/' . basename($originalPath);

        if (!File::exists(dirname($thumbnailPath))) {
            File::makeDirectory(dirname($thumbnailPath), 0755, true);
        }

        // Создаем превью
        Image::make($request->file('image'))->fit(150, 150)->save($thumbnailPath);
        $image_rs = "images/$dir/150x150/" . basename($originalPath);

        // Возвращаем массив с путями
        return [$image_rs, $image];
    }
}
