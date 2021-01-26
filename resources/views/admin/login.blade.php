
{{--@extends('adminlte::login')--}}

<html>

<head>

</head>

<body>

    <form method="POST">

        @csrf
        <br><br>Login: <input type="text" name="login">
        <br><br>Senha: <input type="password" name="password">
        <br><br> <input type="submit" name="Logar">

    <form>

    <br><br>
    <a href="{{route('register')}}">Registre-se</a>


</body>

</html>
