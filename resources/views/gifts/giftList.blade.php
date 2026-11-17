@extends('layouts.frontOffice')
@section('title', 'Prendas de Natal')
@section('content')

    <h6>
        Prendas de Natal</h6>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Prenda</th>
                <th scope="col">Valor Previsto</th>
                <th scope="col">Quem deu</th>
                <th scope="col">Valor Gasto</th>
                <th scope="col">Diferença entre valores</th>
                <th scope="col">Atualizar Prenda</th>
                <th scope="col">Apagar Prenda</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($prendas as $prenda)
                <tr>
                    <th scope="row">{{ $prenda->id }}</th>
                    <td>{{ $prenda->nome_prenda }}</td>
                    <td>{{ $prenda->valor_previsto }}€</td>
                    <td>{{ $prenda->user_name }}</td>
                    <td>{{ $prenda->valor_gasto }}€</td>
                    <td
                        class=" @if ($prenda->diferencaValores > 0) table-success
                                @elseif ($prenda->diferencaValores < 0) table-danger
                                @else table-warning @endif">
                        {{ $prenda->diferencaValores }}€
                    </td>
                    <td><a href="{{ route('prendas.edit', $prenda->id) }}" class="btn btn-info">Editar</a></td>
                    <td>
                        <form method="POST" action="{{ route('prendas.delete', $prenda->id) }}">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">
                                Apagar
                            </button>
                        </form>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @php
        $formConfig = $giftInfo
            ? ['rota' => 'prendas.update', 'metodo' => 'PUT', 'botao' => 'Atualizar']
            : ['rota' => 'prendas.store', 'metodo' => 'POST', 'botao' => 'Adicionar Prenda'];
    @endphp

    {{-- Para o form aparecer a variavel giftInfo tem que existir, é a condicao do isset, portanto se quero que o form apareça sempre tenho que colocar dentro de cada input o value = $giftInfo->id ou " " (nada). --}}
    {{-- @isset($giftInfo) --}}
    <h6>Detalhes da prenda {{ $giftInfo->nome_prenda ?? '' }}</h6>

    {{-- se giftInfo for truthy usa uma .update, se nao usa .store --}}
    <form method="POST" action="{{ route($formConfig['rota']) }}">
        @csrf
        {{-- se for truthy usa put, se nao usa o post do form method="POST" --}}
        @if ($formConfig['metodo'] === 'PUT')
            @method('PUT')
        @endif

        <input type="hidden" name="id" value="{{ $giftInfo->id ?? '' }}">
        {{-- Nome da prenda --}}
        <div class="mb-3">
            <label class="form-label">Prenda</label>
            <input value="{{ old('nome_prenda', $giftInfo->nome_prenda ?? '') }}" required type="text"
                name="nome_prenda" class="form-control">
        </div>
        @error('nome_prenda')
            <p class="text-danger">Nome Invalido</p>
        @enderror

        {{-- Valor Previsto --}}
        <div class="mb-3">
            <label class="form-label">Valor Previsto</label>
            {{-- Colocar o old senao, se colocar valor invalido ele vai assumir o '' e nao mandar mensagem de erro --}}
            <input value="{{ old('valor_previsto', $giftInfo->valor_previsto ?? '') }}" name="valor_previsto"
                class="form-control">
        </div>
        @error('valor_previsto')
            <p class="text-danger">Valor Incorreto</p>
        @enderror

        {{-- User que deu a prenda --}}
        <select name="user_id" id="user_id" class="form-select" required>
            <option value="">Quem deu a prenda</option>
            @foreach ($quem_deu as $quemDeu)
                {{-- o old -> se carregar em submeter, mas a validação falhar porque, por exemplo, um campo é obrigatório, quando o Laravel me devolver ao formulário, irá reconhecer que tinha escolhido o user X e mantém essa opção selecionada
                old aceita 2 args: 'nome do campo', valor por defeito.
                1º arg ->  'user_id' — Procura o valor anteriormente enviado pelo formulário.
                2º arg -> $giftInfo->user_id ?? '' — Valor utilizado quando não existe um valor anterior.
                3º arg -> == $quemDeu->id --- Compara o resultado anterior com o ID de cada utilizador apresentado no @foreach  --}}

                <option value="{{ $quemDeu->id }}" @selected(old('user_id', $giftInfo->user_id ?? '') == $quemDeu->id)>
                    {{ $quemDeu->name }}
                </option>
            @endforeach
        </select>
        @error('user_id')
            <p class="text-danger">{{ $message }}</p>
        @enderror

        {{-- Valor Gasto --}}
        <div class="mb-3">
            <label class="form-label">Valor Gasto</label>
            <input value="{{ old('valor_gasto', $giftInfo->valor_gasto ?? '') }}" type="text" name="valor_gasto"
                class="form-control">
        </div>
        @error('valor_gasto')
            <p class="text-danger">Valor Incorreto</p>
        @enderror

        {{-- Botoes --}}
        {{-- se giftInfo for truthy entao atualizar, se for faulsy Adicionar prenda --}}
        <button type="submit" class="btn btn-primary">
            {{ $formConfig['botao'] }}
        </button>
        {{-- Botao que limpa o form de forma a poder adicionar uma nova prenda --}}
        <a href="{{ route('gifts.all') }}" class="btn btn-secondary">
            Nova Prenda
        </a>
        <a href="{{ route('gifts.all') }}" class="btn btn-secondary">
            Cancelar
        </a>

        {{-- @endisset --}}
    </form>
@endsection
