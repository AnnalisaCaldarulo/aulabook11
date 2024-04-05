<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>L'utente {{ $book->user->name }} ha richiesto la recesione del suo libro</h1>
    <p>Titolo: {{ $book->title }}</p>
</body>

</html>
