<x-layout title="Series" :successMessage="$successMessage">
    @auth()
        <a href="{{ route('series.create') }}" class="btn btn-dark m-2">Add</a>
    @endauth
    <ul class="list-group">
        @foreach ($series as $_series)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div class="d-flex justify-content-between align-items-center">
                    <img src="{{ asset($_series->cover == null ? 'movie.png' : 'storage/' . $_series->cover) }}"
                         alt="cover series"
                         style="max-width: 48px"
                         class="img-fluid img-thumbnail">
                @guest()
                    <span class="ml-5">{{ $_series->name }}</span>
                @endguest
                @auth()
                    <a href="{{ route('seasons.index', $_series->id) }}" class="ml-3">
                        {{ $_series->name }}
                    </a>
                @endauth
                </div>
                @auth()
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
                @endauth
            </li>
        @endforeach
    </ul>
</x-layout>
