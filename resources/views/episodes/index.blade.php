<x-layout title="Episodes of {{ $seriesName }}/season {{ $seasonNumber }}" :successMessage="$successMessage">
    <form method="post">
        @csrf
        <ul class="list-group">
            @foreach ($episodes as $episode)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Episode {{ $episode->number }}

                    <input type="checkbox"
                           name="episodes[]"
                           id="episodes"
                           value="{{ $episode->id }}"
                           @if ($episode->watched) checked @endif />
                </li>
            @endforeach
        </ul>
        <a href="/series/{{ $seriesId }}/seasons" class="btn btn-secondary mt-2">Back</a>
        <button type="submit" class="btn btn-primary float-end mt-2">Save</button>
    </form>
</x-layout>
