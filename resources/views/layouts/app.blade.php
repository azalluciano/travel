<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Trip')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles -->
    <style>
        .destination-card {
            transition: transform 0.3s;
        }

        .destination-card:hover {
            transform: translateY(-5px);
            /* Effet de survol des cartes de destination */
        }

        .destination-image {
            height: 200px;
            object-fit: cover;
            /* Ajuste l'image pour qu'elle couvre toute la zone */
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <!-- Lien vers la page d'accueil des destinations -->
            <a class="navbar-brand" href="{{ route('destinations.index') }}">Trip</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        {{-- Uncomment if needed --}}
                        {{-- <a class="nav-link" href="{{ route('destinations.index') }}">Home</a> --}}
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <!-- Vérification de l'authentification de l'utilisateur -->
                    @auth
                        <!-- Si l'utilisateur est administrateur, afficher un lien vers le panneau d'administration -->
                        @if(auth()->user()->is_admin)
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('admin*') ? 'active' : '' }}"
                                    href="{{ route('admin.destinations.index') }}">Admin Panel</a>
                            </li>
                        @endif
                        <!-- Lien pour se déconnecter -->
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link">Logout</button>
                            </form>
                        </li>
                    @else
                        <!-- Liens de connexion et d'inscription si l'utilisateur n'est pas authentifié -->
                        <li class="nav-item d-flex">
                            <a class="nav-link auth-btn btn-sm btn-outline-light me-2 {{ request()->is('login') ? 'active' : '' }}"
                                href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Login
                            </a>
                            <a class="nav-link auth-btn btn-sm signup-btn {{ request()->is('register') ? 'active' : '' }}"
                                href="{{ route('register') }}">
                                <i class="bi bi-person-plus-fill me-1"></i> Sign Up
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Export Button -->
    <div class="container mt-3 text-end">
        {{-- @auth --}}
            <!-- Bouton pour exporter les destinations au format CSV (visible uniquement si l'utilisateur est authentifié) -->
            <a href="{{ route('destinations.export') }}" class="btn btn-success">
                <i class="bi bi-download"></i> Export Destinations
            </a>
        {{-- @endauth --}}
    </div>

    <!-- Contenu principal -->
    <main class="py-4">
        <div class="container">
            <!-- Affichage des messages de succès ou d'erreur si présents -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <!-- La section de contenu spécifique à chaque page sera insérée ici -->
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Trip</h5>
                    <p>Find your perfect honeymoon destination.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <!-- Copyright -->
                    <p>&copy; {{ date('Y') }} Trip. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>