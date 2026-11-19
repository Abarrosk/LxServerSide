@extends('layouts.frontOffice')
@section('title', 'Apresentar users')
@section('content')
    <h1>Aqui vamos carregar todos os utilizadores</h1>
    <h6>Users sem estarem carregados da base de dados</h6>
    <ul>
        @foreach ($usersWDB as $user)
            <li>{{ $user['name'] }}-->{{ $user['email'] }}</li>
        @endforeach
    </ul>

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form action="">
        <input type="text" name="search">
        <button class="btn btn-secondary" type="submit">Procurar</button>
    </form>

    <h6>Utilizadores da base de dados</h6>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Imagem</th>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Address</th>
                <th scope="col">NIF</th>
                @auth
                    <th scope="col">Apagar</th>
                    <th scope="col">Editar</th>
                @endauth
            </tr>
        </thead>
        <tbody>
            @foreach ($usersFromDB as $users)
                <tr>
                    <td><img src="{{ $users->photo ? asset('storage/' . $users->photo) : asset('images/nophoto.jpg') }}">
                    </td>
                    <th scope="row">{{ $users->id }}</th>
                    <td>{{ $users->name }}</td>
                    <td>{{ $users->email }}</td>
                    <td>{{ $users->address }}</td>
                    <td>{{ $users->nif }}</td>
                    @if (Auth::user() && Auth::user()->email == 'admin@gmail.com')
                        <td><a href="{{ route('users.delete', $users->id) }}" class="btn btn-danger">Apagar</a></td>
                    @endif
                    @auth
                        <td><a href="{{ route('users.edit', $users->id) }}" class="btn btn-info">Ver / Editar</a></td>
                    @endauth
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
