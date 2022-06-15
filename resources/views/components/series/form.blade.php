<form action="{{ $action }}" method="post" enctype="multipart/form-data">
    @csrf

    @isset($update)
        @method('PUT')
    @endisset
    <div class="row mb-3">
        <div class="col-8">
            <label for="name" class="form-label">Name</label>
            <input type="text"
                   autofocus="true"
                   name="name"
                   id="name"
                   class="form-control"
                   @isset($name)value="{{ $name }}"@endisset>
        </div>
        <div class="col-2">
            <label for="seasonsQty" class="form-label">Seasons</label>
            <input type="text"
                   name="seasonsQty"
                   id="seasonsQty"
                   class="form-control"
                   @isset($seasonsQty)value="{{ $seasonsQty }}"@endisset>
        </div>
        <div class="col-2">
            <label for="episodesPerSeason" class="form-label">Episodes</label>
            <input type="text"
                   name="episodesPerSeason"
                   id="episodesPerSeason"
                   class="form-control"
                   @isset($episodesPerSeason)value="{{ $episodesPerSeason }}"@endisset>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12">
            <label for="cover" class="form-label">Cover</label>
            <input type="file" name="cover" id="cover" class="form-control"
                   accept="image/gif, image/jpeg, image/png">
        </div>
    </div>
    <a href="{{ route('series.index') }}" class="btn btn-secondary float-start">Back</a>
    <button type="submit" class="btn btn-primary float-end">Save</button>
</form>
