@extends('layouts.app')

@section('content')
    <h1>Dashboard Admin</h1>

    <h2>Utilisateurs</h2>
    <ul>
        @foreach($users as $user)
            <li>{{ $user->name }} ({{ $user->email }}) - {{ $user->is_admin ? 'Admin' : 'User' }}</li>
        @endforeach
    </ul>

    <h2>Objets</h2>
    <ul>
        @foreach($objets as $objet)
            <li>{{ $objet->nom }} — proposé par {{ $objet->user->name }}</li>
        @endforeach
    </ul>

    <h2>Trocs</h2>
    <ul>
        @foreach($trocs as $troc)
            <li>
                {{ $troc->objetOffert->nom }} ({{ $troc->userPropose->name }}) ⇄
                {{ $troc->objetDemande->nom }} ({{ $troc->userCible->name }})
                — Statut : {{ $troc->status ?? 'en attente' }}
            </li>
        @endforeach
    </ul>
@endsection
