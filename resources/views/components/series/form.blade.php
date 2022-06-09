<form action="{{ $action }}" method="post">
    @csrf

    @isset($nome)
        @method('PUT')
    @endisset
    <div class="mb-3">
        <label for="nome" class="form-label"></label>
        <input type="text"
               name="nome"
               id="nome"
               class="form-control"
               @isset($nome)value="{{ $nome }}"@endisset>
    </div>
    <a href="{{ route('series.index') }}" class="btn btn-secondary float-start">Voltar</a>
    <button type="submit" class="btn btn-primary float-end">Salvar</button>
</form>
