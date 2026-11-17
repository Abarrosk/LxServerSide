@extends('layouts.frontOffice')

@section('content')
    <h1>Adicionar Tasks</h1>
    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf
        <div class="mb-3">
            <label for="exampleInputNome" class="form-label">Nome</label>
            <input required type="text" name="name" class="form-control" id="exampleInputNome">
        </div>
        @error('name')
            <p>Nome inválido</p>
        @enderror

        <div class="mb-3">
            <label for="exampleInputDescription" class="form-label">Descricao</label>
            <input required type="text" name="description" class="form-control" id="exampleInputDescription">
            <div id="descriptionHelp" class="form-text">Coloque a descricao da tarefa</div>
        </div>
        @error('description')
            <p>Descricao invalida</p>
        @enderror
        <div class="mb-3">
            <label for="user_id" class="form-label">Utilizador</label>

            <select name="user_id" id="user_id" class="form-select" required>
                <option value="">Seleciona um utilizador</option>

                @foreach ($users as $user)
                    <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>

            @error('user_id')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <hr>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
