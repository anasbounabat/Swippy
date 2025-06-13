@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-lg">
    <h1 class="text-2xl font-bold mb-4">Proposer un échange</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('trocs.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="objet_offert_id" class="block font-semibold mb-1">Votre objet à échanger</label>
            <select name="objet_offert_id" id="objet_offert_id" class="w-full border rounded px-3 py-2" required>
                <option value="">-- Choisir un objet --</option>
                @foreach ($userObjets as $objet)
                    <option value="{{ $objet->id }}">{{ $objet->title }} ({{ $objet->category->name }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="objet_demande_id" class="block font-semibold mb-1">Objet que vous souhaitez obtenir</label>
            <select name="objet_demande_id" id="objet_demande_id" class="w-full border rounded px-3 py-2" required>
                <option value="">-- Choisir un objet --</option>
                @foreach ($autresObjets as $objet)
                    <option value="{{ $objet->id }}">{{ $objet->title }} ({{ $objet->category->name }})</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Envoyer la proposition</button>
    </form>
</div>
@endsection
