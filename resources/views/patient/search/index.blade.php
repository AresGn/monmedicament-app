@extends('layouts.patient')

@section('title', 'Recherche de médicaments - MonMédicament')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="h4 mb-0">Recherche de médicaments</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('patient.search.results') }}" method="GET">
                        <div class="form-group mb-4">
                            <label for="query" class="form-label">Nom du médicament</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="query" name="query" placeholder="Entrez le nom d'un médicament..." required>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Rechercher
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <div class="mt-4">
                        <h2 class="h5 mb-3">Recherche populaire</h2>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('patient.search.results', ['query' => 'Paracétamol']) }}" class="btn btn-outline-secondary btn-sm">Paracétamol</a>
                            <a href="{{ route('patient.search.results', ['query' => 'Ibuprofène']) }}" class="btn btn-outline-secondary btn-sm">Ibuprofène</a>
                            <a href="{{ route('patient.search.results', ['query' => 'Aspirine']) }}" class="btn btn-outline-secondary btn-sm">Aspirine</a>
                            <a href="{{ route('patient.search.results', ['query' => 'Doliprane']) }}" class="btn btn-outline-secondary btn-sm">Doliprane</a>
                            <a href="{{ route('patient.search.results', ['query' => 'Amoxicilline']) }}" class="btn btn-outline-secondary btn-sm">Amoxicilline</a>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <h2 class="h5 mb-3">Explorer par catégorie</h2>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('patient.search.results', ['category' => 'douleur']) }}" class="text-decoration-none">
                                    <div class="card text-center p-3">
                                        <i class="fas fa-thermometer-half text-primary fs-3 mb-2"></i>
                                        <h3 class="h6">Douleur et fièvre</h3>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('patient.search.results', ['category' => 'digestion']) }}" class="text-decoration-none">
                                    <div class="card text-center p-3">
                                        <i class="fas fa-pills text-primary fs-3 mb-2"></i>
                                        <h3 class="h6">Digestion</h3>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('patient.search.results', ['category' => 'rhume']) }}" class="text-decoration-none">
                                    <div class="card text-center p-3">
                                        <i class="fas fa-head-side-cough text-primary fs-3 mb-2"></i>
                                        <h3 class="h6">Rhume et grippe</h3>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('patient.search.pharmacy.list') }}" class="btn btn-outline-primary">
                            <i class="fas fa-store-alt"></i> Voir toutes les pharmacies
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 