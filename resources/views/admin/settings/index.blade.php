@extends('adminlte::page')

@section('title', 'Configurações')

@section('content_header')

    <h1> Configurações </h1>

@endsection


@section('content')

    <div class="card">

        <div class="card-body">

            <form action="{{route('settings.save')}}" method="POST" class="form-horizontal">
                @method('PUT')
                @csrf

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"> Titulo do site: </label>
                    <div class="col-sm-10 ">
                        <input type="text" name="name" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"> Sub-Titulo: </label>
                    <div class="col-sm-10 ">
                        <input type="text" name="subtitle" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"> E-mail para contato: </label>
                    <div class="col-sm-10 ">
                        <input type="email" name="email" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"> Cor do Fundo: </label>
                    <div class="col-sm-10 ">
                        <input type="color" name="bgcolor" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"> Cor do Texto: </label>
                    <div class="col-sm-10 ">
                        <input type="color" name="textcolor" class="form-control">
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

@endsection

