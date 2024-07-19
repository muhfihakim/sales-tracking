<!DOCTYPE html>
<html>

<head>
    <title>403 Forbidden</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>403 Forbidden</h1>
        <div class="alert alert-danger">
            {{ $message }}
        </div>
        <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
    </div>
</body>

</html>
