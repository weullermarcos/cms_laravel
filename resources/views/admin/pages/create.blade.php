
@extends('adminlte::page')

@section('title', 'Nova Página')


@section('content_header')

    <h1>Nova Página</h1>

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

            <form method="POST" action="{{route('pages.store')}}" class="form-horizontal">

                @csrf
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Título: </label>
                    <div class="col-sm-10">
                        <input type="text" name="title" value="{{old('title')}}" class="form-control @error('title') is-invalid @enderror"/>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Conteúdo da página: </label>
                    <div class="col-sm-10">
                        <textarea name="body" class="form-control">{{old('body')}}</textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <input type="submit" value="Criar" class="btn btn-success"/>
                    </div>
                </div>

            </form>

        </div>
    </div>
@endsection

