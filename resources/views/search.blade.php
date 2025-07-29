<form action="/search" method="POST">
    @csrf
    <label>Search Query:</label>
    <input type="text" name="query" required value="{{ old('query', $query ?? '') }}">
    <button type="submit">Search</button>
</form>

@if(isset($results))
    <h2>Top Match:</h2>
    <p><strong>Category:</strong> {{ $results['category_name'] }}</p>
    <p><strong>Similarity Score:</strong> {{ $results['score'] }}</p>
@endif
