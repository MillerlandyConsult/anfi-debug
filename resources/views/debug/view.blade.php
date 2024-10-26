<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Debug Variables</title>
    <link rel="stylesheet" href="{{ asset('css/debug.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Debug Variables</h1>
        <div id="variables-container">
            @include('debug.partials.variables', ['variables' => $variables])
        </div>
    </div>

    <script>
        setInterval(function() {
            axios.get('{{ url("/debug/{$key}") }}')
                .then(function (response) {
                    document.getElementById('variables-container').innerHTML = response.data;
                });
        }, 5000);
    </script>
</body>
</html>
