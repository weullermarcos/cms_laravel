
{{--@extends('adminlte::login')--}}

<html>

<head>

</head>

<body>

    <form method="POST">

        @csrf
        <br><br>E-mail: <input type="email" name="email">
        <br><br>Senha: <input type="password" name="password">
        <br> <input type="checkbox" name="remember" id="remember"> Lembrar-me
        <br><br> <input type="submit" name="Logar">

    <form>

    <br><br>
    <a href="{{route('register')}}">Registre-se</a>


</body>

</html>
