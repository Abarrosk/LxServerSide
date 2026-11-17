@extends('layouts.frontOffice')
@section('title', 'Homepage')
@section('content')
    <img src="{{ asset('images/IMG-20260613-WA0015.jpg') }}" alt="">

    @if (isset($courseName))
        {{-- Se nao tiver o else, apenas o if e a variavel nao existir, simplesmente nao carrega --}}
        <h5>Ola {{ $courseName }}</h5>
    @else
        <h5>Olá user</h5>
    @endif

    {{-- Usando ternarios --}}
    {{-- condicao ? valorSeVerdadeiro : valorSeFalso; --}}
    <h5>Bom dia {{ isset($userName) ? $userName : $courseName }}</h5>
    <h6>O contacto é o {{ $contactInfo['name'] }} - {{ $contactInfo['contact'] }}</h6>


    <h6>Os contactos do {{ $cesae_info['name'] }} são: {{ $cesae_info['address'] }} e {{ $cesae_info['email'] }}</h6>

    <h5>Alunos da turma</h5>
    <ul>
        @if (isset($students))
            @foreach ($students as $estudantes)
                <li>{{ $estudantes }}</li>
            @endforeach
        @endif
    </ul>

    <h5>Funcionalidades da nossa app</h5>
    <ul>
        <li><a href="{{ route('welcome') }}">Welcome Page</a></li>
        <li><a href="{{ route('users.all') }}">Ver / Apagar utilizadores</a></li>
        <li><a href="{{ route('users.add') }}">Adicionar Utilizador</a></li>
        <li><a href="{{ route('tasks.all') }}">Ver / Apagar Tarefas</a></li>
        <li><a href="{{ route('tasks.add') }}">Adicionar Tarefas</a></li>
        <li><a href="{{ route('gifts.all') }}">Prendas de Natal</a></li>
    </ul>
@endsection
