@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <!-- Section pour centrer le formulaire de login -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Carte contenant le formulaire de login -->
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="card-title mb-0">Login</h4>
                </div>
                <div class="card-body p-4">
                    <!-- Affichage d'un message d'erreur s'il y en a dans la session -->
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Formulaire de connexion -->
                    <form action="{{ route('login') }}" method="POST">
                        @csrf <!-- Protection CSRF -->

                        <!-- Champ email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email') }}" required autofocus>
                            <!-- Affichage des erreurs pour le champ email -->
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Champ mot de passe -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" required>
                            <!-- Affichage des erreurs pour le champ mot de passe -->
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Case à cocher pour "Se souvenir de moi" -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>

                        <!-- Bouton de soumission du formulaire -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection