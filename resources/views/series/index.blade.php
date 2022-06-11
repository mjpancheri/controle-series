<x-layout title="Series" :successMessage="$successMessage">
    <a href="{{ route('series.create') }}" class="btn btn-dark m-2">Add</a>

    <ul class="list-group">
        @foreach ($series as $_series)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ route('seasons.index', $_series->id) }}">
                    {{ $_series->name }}
                </a>

                <span class="d-flex justify-content-around align-items-center">
                    <a href="{{ route('series.edit', $_series->id) }}" class="btn btn-info btn-sm me-2">E</a>
                    <form action="{{ route('series.destroy', $_series->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            X
                        </button>
                    </form>
                </span>
            </li>
        @endforeach
    </ul>
</x-layout>
