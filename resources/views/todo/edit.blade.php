<form action="{{ route('tasks.update', $task->id) }}" method="post" enctype='multipart/form-data' class="card-body d-flex flex-column task-edit-form"
      id="task-edit-form-{{ $task->id }}">
    @csrf
    @method('PUT')

    <div class="d-flex mb-3">
        <div class="me-3 position-relative overflow-hidden">
            <div id="image-wrapper-{{ $task->id }}" class="image-wrapper">
                @if($task->image)
                    <img src="{{ asset('storage/'.$task->image) }}" alt="" id="preview-edit-{{ $task->id }}">
                @else
                    <img src="{{ Vite::asset('noimage.webp') }}" alt="" id="preview-edit-{{ $task->id }}">
                @endif
            </div>
            <div class="d-flex position-absolute justify-content-end img-buttons">
                <label for="image-edit-{{ $task->id }}" class="btn btn-secondary btn-sm" role="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square shadow" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"></path>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"></path>
                    </svg>
                </label>
                <input type="file" class="form-control d-none" name="image" id="image-edit-{{ $task->id }}" accept="image/png, image/gif, image/jpeg" onchange="onFileSelected(event, {{ $task->id }})">

                <label for="image-del-{{ $task->id }}" class="btn btn-secondary btn-sm img-del-label" style="margin-left:5px;" role="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash shadow" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"></path>
                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"></path>
                    </svg>
                </label>
                <input type="checkbox" class="form-control d-none" name="imgdel" id="image-del-{{ $task->id }}">
            </div>
        </div>
        <div class="flex-fill">
            <div class="mb-3">
                <label for="title-edit-{{ $task->id }}" class="form-label">Заголовок:</label>
                <input type="text" class="form-control" name="title" id="title-edit-{{ $task->id }}" aria-describedby="textHelp"
                       value="{{ $task->title }}" required>
            </div>
            <div class="mb-3">
                <label for="description-edit-{{ $task->id }}" class="form-label">Описание:</label>
                <textarea class="form-control" id="description-edit-{{ $task->id }}" name="description" rows="3"
                          aria-describedby="textHelp" required>{{ $task->description }}</textarea>
            </div>
            <div class="mb-3">
                <label for="tags-edit-{{ $task->id }}" class="form-label">Теги, разделенные пробелом:</label>
                <input type="text" class="form-control" name="tags" id="tags-edit-{{ $task->id }}" aria-describedby="textHelp"
                       value="@foreach($task->tags as $tag){{ $tag['name'].' ' }}@endforeach">
            </div>
            <div class="py-3 d-flex justify-content-between align-items-start">
                <div>
                    <ul class="text-danger" id="task-edit-errors"></ul>
                </div>
                <div>
                    <div id="task-edit-cancel" class="btn btn-dark" role="button" onclick="task_edit_cancel({{ $task->id }})">Отмена</div>
                    <button type="submit" name="submit" id="task-edit-save" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </div>
    </div>


</form>
