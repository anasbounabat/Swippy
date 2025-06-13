@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Mes propositions de troc</h1>

    <a href="{{ route('trocs.create') }}" class="btn btn-primary mb-4">Proposer un troc</a>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($trocs->count() > 0)
        <ul class="space-y-4">
            @foreach ($trocs as $troc)
                <li class="border p-4 rounded">
                    <p><strong>Objet offert :</strong> {{ $troc->objetOffert->title }} ({{ $troc->objetOffert->category->name }})</p>
                    <p><strong>Objet demandé :</strong> {{ $troc->objetDemande->title }} ({{ $troc->objetDemande->category->name }})</p>
                    <p><strong>Par :</strong> {{ $troc->userPropose->name }}</p>
                    <p><strong>À :</strong> {{ $troc->userCible->name }}</p>
                    <p><strong>Statut :</strong> {{ ucfirst($troc->status) }}</p>

                    @if(auth()->id() === $troc->user_cible_id && $troc->status === 'en_attente')
                        <form action="{{ route('trocs.update', $troc) }}" method="POST" class="inline-block mr-2">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="accepté">
                            <button type="submit" class="btn btn-success">Accepter</button>
                        </form>

                        <form action="{{ route('trocs.update', $troc) }}" method="POST" class="inline-block">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="refusé">
                            <button type="submit" class="btn btn-danger">Refuser</button>
                        </form>
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <p>Aucune proposition de troc en cours.</p>
    @endif
</div>
@endsection
