
@extends('adminlte::page')

@section('title', 'Editar Página')


@section('content_header')

    <h1>Editar Página</h1>

@endsection

@section('content')

    @if($errors->any())

        <div class="alert alert-danger">
            <h5>
                <i class="icon fas fa-ban"></i>
                Ocorreu um ou mais erros:
            </h5>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>

    @endif

    <div class="card">
        <div class="card-body">

            <form method="POST" action="{{route('pages.update', ['page' => $page->id])}}" class="form-horizontal">
                @method('PUT')
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Título: </label>
                    <div class="col-sm-10">
                        <input type="text" name="title" value="{{$page->title}}" class="form-control @error('title') is-invalid @enderror"/>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Conteúdo da Página: </label>
                    <div class="col-sm-10">
                        <textarea name="body" class="form-control bodyfiled">{{$page->body}}</textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <input type="submit" value="Salvar" class="btn btn-success"/>
                    </div>
                </div>

            </form>

        </div>
    </div>

    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>

    <script>

        tinymce.init({

            selector: "textarea.bodyfiled",
            height: 300,
            menubar: false,
            plugins: ['link', 'image', 'autoresize', 'lists'],
            toolbar: "undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | table | link image | bullist numlist",
            content_css: [
                '{{asset('assets/css/content.css')}}'
            ],

        });

    </script>

@endsection

