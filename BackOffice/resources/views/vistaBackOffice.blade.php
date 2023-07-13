<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BackOffice</title>
</head>
<body>

<form action="{{ route('producto.action') }}" method="POST">
    @csrf
    <button type="submit">Ejecutar</button>
</form>
    <button onclick="fotosintesis()">Ver dato</button>

        <script>
           function fotosintesis(){
                console.log('wait, that is ilegal')
                console.log(@json($datos))
           }
         </script>
</body>
</html>