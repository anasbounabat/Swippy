@extends('layouts.app')

@section('content')
    <h1>Objets disponibles</h1>

    @auth
        <a href="{{ route('objets.create') }}" class="btn btn-primary">Proposer un objet</a>
    @else
        <p><a href="{{ route('login') }}">Connecte-toi</a> pour proposer un objet.</p>
    @endauth

    <ul>
        @foreach($objets as $objet)
            <li>
                <a href="{{ url('/objets/' . $objet->id) }}">{{ $objet->nom }}</a>
                — proposé par {{ $objet->user->name }}
            </li>
        @endforeach
    </ul>
@endsection
