@extends('layouts.app')

@section('title', 'Admin - Destinations')

@section('content')
    <!-- Section pour le titre et le bouton d'ajout de destination -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manage Destinations</h1>
        <!-- Bouton pour ajouter une nouvelle destination -->
        <a href="{{ route('admin.destinations.create') }}" class="btn btn-success">
            Add New Destination
        </a>
    </div>

    <!-- Carte contenant la liste des destinations -->
    <div class="card">
        <div class="card-body">
            <!-- Vérifie si aucune destination n'est disponible -->
            @if($destinations->isEmpty())
                <div class="alert alert-info">
                    No destinations found. Click the "Add New Destination" button to create one.
                </div>
            @else
                <!-- Table responsive affichant les destinations -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <!-- En-têtes de colonne pour la table -->
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Duration</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Boucle pour afficher chaque destination -->
                            @foreach($destinations as $destination)
                                <tr>
                                    <!-- Affichage des détails de chaque destination -->
                                    <td>{{ $destination->id }}</td>
                                    <td>
                                        <!-- Affichage de l'image de la destination ou message si aucune image -->
                                        @if($destination->image)
                                            <img src="{{ asset('storage/' . $destination->image) }}" alt="{{ $destination->name }}"
                                                width="50" height="50" style="object-fit: cover;">
                                        @else
                                            <span class="badge bg-secondary">No Image</span>
                                        @endif
                                    </td>
                                    <td>{{ $destination->name }}</td>
                                    <td>${{ number_format($destination->price, 2) }}</td>
                                    <td>{{ $destination->duration }} days</td>
                                    <td>{{ $destination->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <!-- Groupement des actions disponibles pour chaque destination -->
                                        <div class="btn-group" role="group">
                                            <!-- Lien pour visualiser la destination -->
                                            <a href="{{ route('destinations.show', $destination) }}" class="btn btn-sm btn-info"
                                                target="_blank">View</a>
                                            <!-- Lien pour éditer la destination -->
                                            <a href="{{ route('admin.destinations.edit', $destination) }}"
                                                class="btn btn-sm btn-primary">Edit</a>
                                            <!-- Formulaire pour supprimer la destination avec confirmation -->
                                            <form action="{{ route('admin.destinations.destroy', $destination) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this destination?')">
                                                @csrf
                                                @method('DELETE')
                                                <!-- Bouton de suppression -->
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination des destinations -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $destinations->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection