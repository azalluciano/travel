@extends('layouts.app')

@section('title', 'Trip')

@section('content')
    <!-- Section de titre et barre de recherche -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Trip</h1>
            <p class="lead">Discover your perfect honeymoon getaway</p>
        </div>
        <div class="col-md-4">
            <!-- Formulaire de recherche des destinations -->
            <form action="{{ route('destinations.index') }}" method="GET" class="mt-3">
                <div class="input-group">
                    <input type="text" name="name" class="form-control" placeholder="Search destinations..."
                        value="{{ request('name') }}">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Affichage des destinations -->
    <div class="row">
        @forelse($destinations as $destination)
            <div class="col-md-4 mb-4">
                <div class="card destination-card h-100">
                    <!-- Affichage de l'image de la destination -->
                    @if($destination->image)
                        <img src="{{ asset('storage/' . $destination->image) }}" alt="{{ $destination->name }}"
                            class="card-img-top destination-image">
                    @else
                        <!-- Image par défaut si aucune image n'est associée à la destination -->
                        <img src="https://via.placeholder.com/300x200?text=No+Image" alt="No Image"
                            class="card-img-top destination-image">
                    @endif
                    <div class="card-body">
                        <!-- Titre de la destination -->
                        <h5 class="card-title">{{ $destination->name }}</h5>
                        <!-- Description tronquée de la destination -->
                        <p class="card-text text-truncate">{{ $destination->description }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Prix de la destination formaté -->
                            <span class="badge bg-primary">${{ number_format($destination->price, 2) }}</span>
                            <!-- Durée de la destination -->
                            <span class="badge bg-secondary">{{ $destination->duration }} days</span>
                        </div>
                    </div>
                    <!-- Footer de la carte avec un lien vers les détails de la destination -->
                    <div class="card-footer">
                        <a href="{{ route('destinations.show', $destination) }}" class="btn btn-sm btn-outline-primary">View
                            Details</a>
                    </div>
                </div>
            </div>
        @empty
            <!-- Message affiché s'il n'y a pas de destinations disponibles -->
            <div class="col-12">
                <div class="alert alert-info">
                    No destinations found. Please check back later.
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination pour naviguer entre les pages de destinations -->
    <div class="d-flex justify-content-center mt-4">
        {{ $destinations->links() }}
    </div>
@endsection