@extends('layouts.patient')

@section('title', 'Rechercher un médicament')

@push('styles')
<style>
    /* Mobile-first styles */
    .search-container {
        padding: 1rem;
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
    }
    
    .search-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 1rem;
        text-align: center;
    }
    
    .search-description {
        font-size: 0.9rem;
        color: #666;
        text-align: center;
        margin-bottom: 1.5rem;
        line-height: 1.4;
    }
    
    .search-form {
        width: 100%;
        margin-bottom: 1.5rem;
    }
    
    .search-input-container {
        position: relative;
        margin-bottom: 1rem;
    }
    
    .search-input {
        width: 100%;
        padding: 0.75rem 3rem 0.75rem 1rem;
        border: 1px solid #ddd;
        border-radius: 0.5rem;
        font-size: 0.9rem;
        outline: none;
        transition: all 0.3s;
    }
    
    .search-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
    }
    
    .search-button {
        position: absolute;
        right: 0;
        top: 0;
        height: 100%;
        padding: 0 1rem;
        background: transparent;
        border: none;
        color: var(--primary);
        cursor: pointer;
    }
    
    .error-message {
        color: var(--error);
        font-size: 0.8rem;
        margin-top: 0.5rem;
    }
    
    .alternate-option {
        text-align: center;
        margin: 1rem 0;
    }
    
    .alternate-option p {
        font-size: 0.85rem;
        color: #777;
        margin-bottom: 0.5rem;
    }
    
    .scan-button {
        padding: 0.5rem 1rem;
        border: 1px solid var(--primary);
        background: transparent;
        color: var(--primary);
        border-radius: 0.5rem;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.3s;
        opacity: 0.7;
    }
    
    .scan-button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    .scan-button i {
        margin-right: 0.5rem;
    }
    
    .scan-badge {
        font-size: 0.7rem;
        margin-left: 0.5rem;
    }
    
    .popular-searches {
        margin-top: 2rem;
    }
    
    .popular-searches h2 {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: #333;
    }
    
    .search-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .search-tag {
        padding: 0.5rem 0.75rem;
        background-color: #f1f1f1;
        color: #444;
        border-radius: 2rem;
        font-size: 0.8rem;
        text-decoration: none;
        transition: all 0.3s;
    }
    
    .search-tag:hover {
        background-color: #e0e0e0;
    }
    
    /* Tablet and desktop styles */
    @media (min-width: 768px) {
        .search-container {
            padding: 2rem;
            max-width: 800px;
            margin: 0 auto 2rem;
        }
        
        .search-title {
            font-size: 1.5rem;
        }
        
        .search-description {
            font-size: 1rem;
        }
        
        .search-input {
            padding: 1rem 3rem 1rem 1.25rem;
            font-size: 1rem;
        }
        
        .search-tag {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
    }
</style>
@endpush

@section('content')
<div class="search-container">
    <h1 class="search-title">Rechercher un médicament</h1>
    
    <p class="search-description">
        Entrez le nom du médicament dont vous avez besoin pour trouver les pharmacies où il est disponible.
    </p>
    
    <form action="{{ route('patient.search.results') }}" method="GET" class="search-form">
        <div class="search-input-container">
            <input type="text" 
                   name="query" 
                   id="query" 
                   class="search-input"
                   placeholder="Exemple: Paracétamol, Amoxicilline..."
                   required>
            <button type="submit" class="search-button">
                <i class="fas fa-search"></i>
            </button>
        </div>
        @error('query')
            <p class="error-message">{{ $message }}</p>
        @enderror
    </form>
    
    <!-- Future feature: Upload prescription image -->
    <div class="alternate-option">
        <p>ou</p>
        <button class="scan-button" disabled>
            <i class="fas fa-camera"></i> Scanner une ordonnance
            <span class="scan-badge">(Bientôt disponible)</span>
        </button>
    </div>
    
    <div class="popular-searches">
        <h2>Recherches populaires</h2>
        <div class="search-tags">
            <a href="{{ route('patient.search.results') }}?query=paracetamol" class="search-tag">Paracétamol</a>
            <a href="{{ route('patient.search.results') }}?query=ibuprofene" class="search-tag">Ibuprofène</a>
            <a href="{{ route('patient.search.results') }}?query=amoxicilline" class="search-tag">Amoxicilline</a>
            <a href="{{ route('patient.search.results') }}?query=doliprane" class="search-tag">Doliprane</a>
            <a href="{{ route('patient.search.results') }}?query=vitamine" class="search-tag">Vitamines</a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection 