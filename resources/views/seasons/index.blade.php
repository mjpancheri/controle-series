<x-layout title="Seasons of {{ $series->name }}">
    <ul class="list-group">
        @foreach ($seasons as $season)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ route('episodes.index', $season->id) }}">
                    Season {{ $season->number }}
                </a>

                <span class="badge bg-secondary">
                   {{ $season->numberOfWatchedEpisodes() }} / {{ $season->episodes->count() }}
                </span>
            </li>
        @endforeach
    </ul>
    <a href="/series" class="btn btn-secondary mt-2">Back</a>
</x-layout>
