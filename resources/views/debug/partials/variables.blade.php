@foreach($variables as $name => $value)
    <div class="variable">
        <h2>{{ $name }}</h2>
        <pre>@dump($value)</pre>
    </div>
@endforeach
