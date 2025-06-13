@extends('layouts.app')

@section('content')
    <h1>{{ $objet->nom }}</h1>
    <p>{{ $objet->description }}</p>
    <p>Ajouté par : {{ $objet->user->name }}</p>

    @auth
        <form method="POST" action="{{ url('/trocs') }}">
            @csrf
            <input type="hidden" name="objet_demande_id" value="{{ $objet->id }}">
            <input type="hidden" name="user_cible_id" value="{{ $objet->user->id }}">

            <label for="objet_offert_id">Quel objet proposes-tu en échange ?</label>
            <select name="objet_offert_id" required>
                @foreach(Auth::user()->objets as $monObjet)
                    <option value="{{ $monObjet->id }}">{{ $monObjet->nom }}</option>
                @endforeach
            </select>

            <button type="submit">Proposer un échange</button>
        </form>
    @else
        <p><a href="{{ route('login') }}">Connecte-toi</a> pour proposer un échange.</p>
    @endauth
@endsection
