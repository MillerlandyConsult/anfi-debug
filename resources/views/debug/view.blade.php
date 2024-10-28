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
    <div class="input-container">
        <label for="key-input">Enter Key(s) (comma separated):</label>
        <input type="text" id="key-input" value="{{ $keys }}">
        <button onclick="fetchVariables()">Fetch Variables</button>
    </div>
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

    .input-container {
        margin-bottom: 20px;
    }

    .key-container {
        margin-bottom: 30px;
        padding: 15px;
        background-color: #0062cc;
        color: #fff;
        border-radius: 6px;
    }

    .key-container h2 {
        margin: 0;
        font-size: 1.5em;
        text-transform: uppercase;
    }

    .variable-container {
        margin-bottom: 20px;
        padding: 10px;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 6px;
    }

    .variable-container h3 {
        background-color: #007bff;
        color: #fff;
        padding: 10px;
        border-radius: 4px;
        margin-bottom: 10px;
    }

    .variable-container pre {
        background-color: #e9ecef;
        padding: 15px;
        border-radius: 4px;
        overflow-x: auto;
    }
</style>
<script>
    function fetchVariables() {
        const keys = document.getElementById('key-input').value;
        axios.get('{{ url("/debug") }}', {
            params: {
                keys: keys
            }
        })
            .then(function (response) {
                document.getElementById('variables-container').innerHTML = response.data;
            });
    }
</script>
</body>
</html>