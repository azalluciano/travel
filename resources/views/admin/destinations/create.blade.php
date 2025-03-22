@extends('layouts.app')

@section('title', 'Create New Destination')

@section('content')
    <!-- Bouton de retour à la liste des destinations -->
    <div class="mb-4">
        <a href="{{ route('admin.destinations.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Destinations
        </a>
    </div>

    <!-- Carte contenant le formulaire de création de destination -->
    <div class="card">
        <div class="card-header">
            <!-- Titre de la carte pour la création de destination -->
            <h1 class="card-title">Create New Destination</h1>
        </div>
        <div class="card-body">
            <!-- Formulaire pour créer une nouvelle destination -->
            <form action="{{ route('admin.destinations.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Champ pour le nom de la destination -->
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                        value="{{ old('name') }}" required>
                    @error('name')
                        <!-- Message d'erreur si le champ "name" n'est pas valide -->
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Champ pour la description de la destination -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                        name="description" rows="5" required>{{ old('description') }}</textarea>
                    @error('description')
                        <!-- Message d'erreur si le champ "description" n'est pas valide -->
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Champs pour le prix et la durée de la destination -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="price" class="form-label">Price</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" id="price"
                                name="price" step="0.01" value="{{ old('price') }}" required>
                            @error('price')
                                <!-- Message d'erreur si le champ "price" n'est pas valide -->
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="duration" class="form-label">Duration (days)</label>
                        <input type="number" class="form-control @error('duration') is-invalid @enderror" id="duration"
                            name="duration" value="{{ old('duration') }}" required>
                        @error('duration')
                            <!-- Message d'erreur si le champ "duration" n'est pas valide -->
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Champ pour télécharger une image pour la destination -->
                <div class="mb-4">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                    @error('image')
                        <!-- Message d'erreur si le champ "image" n'est pas valide -->
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Upload an image for this destination.</div>
                </div>

                <!-- Boutons pour annuler ou soumettre le formulaire -->
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('admin.destinations.index') }}" class="btn btn-secondary me-md-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Destination</button>
                </div>
            </form>
        </div>
    </div>
@endsection