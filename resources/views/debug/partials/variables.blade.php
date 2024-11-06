@foreach($variables as $key => $value)
    <div class="key-container">
        <h2>{{ $key }}</h2>
        @if(!is_array($value))
            <div class="variable-container">
                <pre>{{ json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) }}</pre>
            </div>
        @else
            @foreach($value as $name => $varValue)
                <div class="variable-container">
                    <h3>{{ $name }}</h3>
                    <pre>{{ json_encode($varValue, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) }}</pre>
                </div>
            @endforeach
        @endif
    </div>
@endforeach