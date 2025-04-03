@extends('layouts.patient')

@section('title', 'Liste des pharmacies')

@push('styles')
<style>
    /* Mobile-first styles */
    .pharmacy-list {
        padding: 1rem;
        width: 100%;
        margin: 0 auto;
    }

    .pharmacy-list h1 {
        color: #333;
        margin-bottom: 1.5rem;
        text-align: center;
        font-size: 1.25rem;
    }

    .pharmacy-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .pharmacy-card {
        background: var(--white);
        border-radius: 0.5rem;
        padding: 1rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: transform 0.3s;
    }

    .pharmacy-card:hover {
        transform: translateY(-3px);
    }

    .pharmacy-name {
        color: var(--primary);
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }

    .pharmacy-info {
        color: #666;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .pharmacy-info p {
        margin-bottom: 0.5rem;
        display: flex;
        align-items: flex-start;
    }

    .pharmacy-info i {
        width: 20px;
        color: var(--primary);
        margin-right: 0.5rem;
        margin-top: 0.2rem;
    }

    .pharmacy-actions {
        margin-top: 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .pharmacy-actions a {
        width: 100%;
        text-align: center;
        padding: 0.75rem 0.5rem;
        border-radius: 0.25rem;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s;
        font-size: 0.9rem;
    }

    .btn-details {
        background: var(--primary);
        color: var(--white);
    }

    .btn-details:hover {
        background: #0056b3;
    }

    .btn-directions {
        background: var(--white);
        color: var(--primary);
        border: 1px solid var(--primary);
    }

    .btn-directions:hover {
        background: rgba(0, 123, 255, 0.1);
    }

    .pagination {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 0.3rem;
        margin-top: 1.5rem;
    }

    .pagination .page-item {
        list-style: none;
    }

    .pagination .page-link {
        display: block;
        padding: 0.4rem 0.8rem;
        border-radius: 0.25rem;
        text-decoration: none;
        color: var(--primary);
        background: var(--white);
        transition: all 0.3s;
        font-size: 0.85rem;
    }

    .pagination .page-item.active .page-link {
        background: var(--primary);
        color: var(--white);
    }

    .pagination .page-link:hover {
        background: var(--primary);
        color: var(--white);
    }
    
    /* No results message */
    .no-results {
        text-align: center;
        padding: 2rem;
        background: var(--white);
        border-radius: 0.5rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .no-results i {
        font-size: 2rem;
        color: #999;
        margin-bottom: 1rem;
    }
    
    .no-results p {
        color: #666;
        margin-bottom: 1rem;
    }
    
    .no-results .btn {
        display: inline-block;
        padding: 0.5rem 1rem;
        background: var(--primary);
        color: var(--white);
        border-radius: 0.25rem;
        text-decoration: none;
        transition: all 0.3s;
    }

    /* Tablet and Desktop styles */
    @media (min-width: 768px) {
        .pharmacy-list {
            padding: 2rem;
            max-width: 1200px;
        }
        
        .pharmacy-list h1 {
            font-size: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .pharmacy-grid {
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        
        .pharmacy-card {
            padding: 1.5rem;
            border-radius: 0.75rem;
        }
        
        .pharmacy-name {
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }
        
        .pharmacy-info {
            font-size: 1rem;
        }
        
        .pharmacy-actions {
            flex-direction: row;
            gap: 1rem;
            margin-top: 1.5rem;
        }
        
        .pharmacy-actions a {
            padding: 0.75rem 1rem;
            font-size: 1rem;
        }
        
        .pagination .page-link {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
    }
</style>
@endpush

@section('content')
<div class="pharmacy-list">
    <h1>Liste des pharmacies</h1>

    @if($pharmacies->count() > 0)
        <div class="pharmacy-grid">
            @foreach($pharmacies as $pharmacy)
                <div class="pharmacy-card">
                    <h2 class="pharmacy-name">{{ $pharmacy->name }}</h2>
                    <div class="pharmacy-info">
                        <p><i class="fas fa-map-marker-alt"></i> <span>{{ $pharmacy->address }}</span></p>
                        <p><i class="fas fa-phone"></i> <span>{{ $pharmacy->phone_number }}</span></p>
                        <p><i class="fas fa-pills"></i> <span>{{ $pharmacy->inventory_count }} médicaments en stock</span></p>
                    </div>
                    <div class="pharmacy-actions">
                        <a href="{{ route('patient.search.pharmacy.details', $pharmacy->id) }}" class="btn-details">
                            <i class="fas fa-info-circle d-inline d-md-none me-1"></i>Voir les détails
                        </a>
                        @if($pharmacy->latitude && $pharmacy->longitude)
                            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $pharmacy->latitude }},{{ $pharmacy->longitude }}" 
                               target="_blank" 
                               class="btn-directions">
                                <i class="fas fa-directions d-inline d-md-none me-1"></i>Itinéraire
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        {{ $pharmacies->links() }}
    @else
        <div class="no-results">
            <i class="fas fa-store-alt-slash"></i>
            <p>Aucune pharmacie trouvée.</p>
            <a href="{{ route('patient.search.index') }}" class="btn">
                Retour à la recherche
            </a>
        </div>
    @endif
</div>
@endsection 