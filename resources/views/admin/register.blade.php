
{{--@extends('adminlte::register')--}}

<html>

<head>
    <title>Página de registro</title>
</head>

<body>

        <form method="POST">

            @csrf
            <br><br>Nome completo: <input type="text" name="name">
            <br><br>E-mail: <input type="email" name="email">
            <br><br>Senha: <input type="password" name="password">
            <br><br>Confirme a Senha: <input type="password" name="password_confirmation">
            <br><br> <input type="submit" name="Registrar">

        <form>

        <br><br>
        <a href="{{route('login')}}">Já tenho cadastro</a>

</body>

</html>
