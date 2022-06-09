<form action="{{ $action }}" method="post">
    @csrf

    @isset($update)
        @method('PUT')
    @endisset
    <div class="mb-3">
        <label for="name" class="form-label"></label>
        <input type="text"
               name="name"
               id="name"
               class="form-control"
               @isset($name)value="{{ $name }}"@endisset>
    </div>
    <a href="{{ route('series.index') }}" class="btn btn-secondary float-start">Back</a>
    <button type="submit" class="btn btn-primary float-end">Save</button>
</form>
