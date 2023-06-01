@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8 mb-3">
                <button type="button" class="btn btn-primary" id="show-todo-add-form">Новая задача</button>
            </div>
        </div>

        {{--TODO add--}}
        <div class="row justify-content-center">
            <form action="{{ route('tasks.store') }}" method="post" enctype='multipart/form-data' class="col-md-8"
                  style="display:none" id="task-create-form">
                @csrf
                <div class="card mb-4">
                    <div class="card-header">Новая задача</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Заголовок:</label>
                            <input type="text" class="form-control" name="title" id="title" aria-describedby="textHelp"
                                   required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Описание:</label>
                            <textarea class="form-control" id="description" name="description" rows="3"
                                      aria-describedby="textHelp" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="tags" class="form-label">Теги, разделенные пробелом:</label>
                            <input type="text" class="form-control" name="tags" id="tags" aria-describedby="textHelp">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Изображение:</label>
                            <input type="file" class="form-control" name="image" id="image">
                        </div>
                    </div>
                    <div class="card-footer py-3 d-flex justify-content-between align-items-start">
                        <div>
                            <ul class="text-danger" id="task-create-errors">
                            </ul>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Добавить</button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Tag Filter--}}
        <form method="get" class="row justify-content-center mb-3">
            <div class="col-md-8">
                @csrf
                <input type="text" class="form-control" id="tag-filter" placeholder="Поиск по тегам">
            </div>
        </form>


        {{--TODO List--}}
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" id="tasks-header">TODO List</div>

                    @foreach($tasks as $task)
                        @include('todo.show')
                    @endforeach

                </div>
            </div>
        </div>


    </div>
    <img src="{{ Vite::asset('noimage.webp') }}" alt="" class="d-none" id="noimage">
@endsection
