@foreach($variables as $name => $value)
    <div class="variable">
        <h2>{{ $name }}</h2>
        <pre>{{ json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) }}</pre>
    </div>
@endforeach
