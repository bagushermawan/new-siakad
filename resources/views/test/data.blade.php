<h1>Data from DataTable</h1>

@isset($data)
    <pre>
        {{ var_dump($data) }}
    </pre>
@else
    <p>Data is not available.</p>
@endisset
