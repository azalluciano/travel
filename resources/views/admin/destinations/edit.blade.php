@extends('layouts.app')

@section('title', 'Admin - Edit Destination')

@section('content')
    <!-- Bouton de retour à la liste des destinations -->
    <div class="mb-4">
        <a href="{{ route('admin.destinations.index') }}" class="btn btn-outline-secondary">
            Back to Destinations
        </a>
    </div>

    <!-- Carte contenant le formulaire d'édition de destination -->
    <div class="card">
        <div class="card-header">
            <!-- Titre de la carte avec le nom de la destination à modifier -->
            <h1 class="card-title">Edit Destination: {{ $destination->name }}</h1>
        </div>
        <div class="card-body">
            <!-- Formulaire pour modifier une destination -->
            <form action="{{ route('admin.destinations.update', $destination) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Champ pour le nom de la destination -->
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                        value="{{ old('name', $destination->name) }}" required>
                    @error('name')
                        <!-- Message d'erreur si le champ "name" n'est pas valide -->
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Champ pour la description de la destination -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                        name="description" rows="5" required>{{ old('description', $destination->description) }}</textarea>
                    @error('description')
                        <!-- Message d'erreur si le champ "description" n'est pas valide -->
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Champs pour le prix et la durée de la destination -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="price" class="form-label">Price ($)</label>
                        <input type="number" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror"
                            id="price" name="price" value="{{ old('price', $destination->price) }}" required>
                        @error('price')
                            <!-- Message d'erreur si le champ "price" n'est pas valide -->
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="duration" class="form-label">Duration (days)</label>
                        <input type="number" min="1" class="form-control @error('duration') is-invalid @enderror"
                            id="duration" name="duration" value="{{ old('duration', $destination->duration) }}" required>
                        @error('duration')
                            <!-- Message d'erreur si le champ "duration" n'est pas valide -->
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Champ pour télécharger l'image de la destination -->
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <!-- Affichage de l'image actuelle de la destination si elle existe -->
                    @if($destination->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $destination->image) }}" alt="{{ $destination->name }}" width="150"
                                class="img-thumbnail">
                        </div>
                    @endif
                    <!-- Champ pour télécharger une nouvelle image -->
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image"
                        accept="image/*">
                    <small class="text-muted">Leave empty to keep current image. Supported formats: JPG, PNG, GIF (max
                        2MB)</small>
                    @error('image')
                        <!-- Message d'erreur si le champ "image" n'est pas valide -->
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Boutons de soumission et d'annulation -->
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('admin.destinations.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Destination</button>
                </div>
            </form>
        </div>
    </div>
@endsection