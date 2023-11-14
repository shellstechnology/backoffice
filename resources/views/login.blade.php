<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styleLogin.css">
    <title>Login</title>
</head>
<body>
    
<div class="principalBody">
        <div>
            <div class="formulario">
                <div class="imagenLogo">
                    <div style="margin-top: 50px;">
                        <img src="\img\Logo Aplicación.png" alt="FastTrackerLogo" width="150" height="150">
                    </div>
                </div>
                <form action="{{route('login')}}" method="post">
                    @csrf
                    <input class="campoTexto" type="text" name="name" id="name" placeholder="Ingrese su usuario: "> <br>
                    <input class="campoTexto" type="password" name="password" id="password" placeholder="Ingrese su contraseña: "> <br>
                    <input class="botonSubmit" type="submit" value="Iniciar Sesión">
                </form>
            </div>
        </div>
    </div>

</body>
</html>