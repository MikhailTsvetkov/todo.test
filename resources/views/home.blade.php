@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8 mb-3">
            <button type="button" class="btn btn-primary" id="show-todo-add-form">Новая задача</button>
        </div>
    </div>

    {{--TODO add--}}
    <div class="row justify-content-center" style="display:none" id="todo-add-form">
        <form action="" method="post" class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">Новая задача</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Заголовок:</label>
                        <input type="text" class="form-control" name="name" id="name" aria-describedby="textHelp" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Описание:</label>
                        <textarea class="form-control" id="description" name="description" rows="3" aria-describedby="textHelp" required></textarea>
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
                        <ul class="text-danger" id="testimonial-errors">
                        </ul>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Добавить</button>
                </div>
            </div>
        </form>
    </div>



    {{--TODO List--}}
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">TODO List</div>

                <div class="card-body d-flex flex-column">
                    <div class="d-flex mb-3">
                        <div class="pe-3">
                            <img src="{{ Vite::asset('noimage.webp') }}" alt="">
                        </div>
                        <div>
                            <div class="mb-2 d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-1">Заголовок</h6>
                                <div>
                                    <button type="button" class="btn btn-secondary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"></path>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"></path>
                                        </svg>
                                    </button>
                                    <button type="button" class="btn btn-secondary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"></path>
                                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores consequuntur, voluptatem! Accusantium at esse eveniet ipsa molestiae nemo odit qui recusandae totam, veritatis. Accusamus alias debitis, eaque ex molestias ratione.</p>
                        </div>
                    </div>
                    <div>
                        <button type="button" class="btn btn-secondary py-0">tag1</button>
                        <button type="button" class="btn btn-secondary py-0">tag2</button>
                        <button type="button" class="btn btn-secondary py-0">tag3</button>
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </div>



</div>
@endsection
