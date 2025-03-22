@extends('layouts.app')

@section('title', $destination->name)

@section('content')
    <!-- Bouton de retour vers la liste des destinations -->
    <div class="mb-4">
        <a href="{{ route('destinations.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Destinations
        </a>
    </div>

    <!-- Carte affichant les détails d'une destination -->
    <div class="card">
        <div class="row g-0">
            <!-- Colonne pour l'image de la destination -->
            <div class="col-md-5">
                <!-- Vérification si une image est présente pour la destination -->
                @if($destination->image)
                    <img src="{{ asset('storage/' . $destination->image) }}" alt="{{ $destination->name }}"
                        class="img-fluid h-100 w-100" style="object-fit: cover;">
                @else
                    <!-- Image par défaut si aucune image n'est associée -->
                    <img src="https://via.placeholder.com/500x400?text=No+Image" alt="No Image" class="img-fluid h-100 w-100"
                        style="object-fit: cover;">
                @endif
            </div>

            <!-- Colonne pour les détails texte de la destination -->
            <div class="col-md-7">
                <div class="card-body">
                    <!-- Nom de la destination -->
                    <h1 class="card-title">{{ $destination->name }}</h1>

                    <!-- Affichage du prix et de la durée de la destination -->
                    <div class="d-flex gap-3 mb-4">
                        <div class="badge bg-primary fs-6">${{ number_format($destination->price, 2) }}</div>
                        <div class="badge bg-secondary fs-6">{{ $destination->duration }} days</div>
                    </div>

                    <!-- Description de la destination -->
                    <h5>Description</h5>
                    <p class="card-text">{{ $destination->description }}</p>

                    <!-- Informations supplémentaires sur la destination -->
                    <div class="mt-4">
                        <h5>Additional Information</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Price:</span>
                                <span class="fw-bold">${{ number_format($destination->price, 2) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Duration:</span>
                                <span class="fw-bold">{{ $destination->duration }} days</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection