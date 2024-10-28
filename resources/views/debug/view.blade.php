<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ANFI-Debug Variables</title>
    <link rel="stylesheet" href="{{ asset('vendor/anfi-debug/css/debug.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
<div class="container">
    <h1>Debug Variables</h1>
    <div id="variables-container">
        @include('anfi-debug::debug.partials.variables', ['variables' => $variables])
    </div>
</div>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
    }

    .container {
        width: 80%;
        margin: 50px auto;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
    }

    .variable {
        margin-bottom: 20px;
    }

    .variable h2 {
        background-color: #007BFF;
        color: #fff;
        padding: 10px;
        border-radius: 4px;
    }

    .variable pre {
        background-color: #e9ecef;
        padding: 15px;
        border-radius: 4px;
        overflow-x: auto;
    }
</style>
<script>
    setInterval(function () {
        axios.get('{{ url("/debug/{$key}") }}')
            .then(function (response) {
                document.getElementById('variables-container').innerHTML = response.data;
            });
    }, 2000);
</script>
</body>
</html>
