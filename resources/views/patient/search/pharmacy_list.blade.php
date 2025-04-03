@extends('layouts.patient')

@section('title', 'Liste des pharmacies')

@push('styles')
<style>
    .pharmacy-list {
        padding: 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    .pharmacy-list h1 {
        color: #333;
        margin-bottom: 2rem;
        text-align: center;
    }

    .pharmacy-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .pharmacy-card {
        background: var(--white);
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transition: transform 0.3s;
    }

    .pharmacy-card:hover {
        transform: translateY(-5px);
    }

    .pharmacy-name {
        color: var(--primary);
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .pharmacy-info {
        color: #666;
        margin-bottom: 0.5rem;
    }

    .pharmacy-info i {
        width: 20px;
        color: var(--primary);
        margin-right: 0.5rem;
    }

    .pharmacy-actions {
        margin-top: 1.5rem;
        display: flex;
        gap: 1rem;
    }

    .pharmacy-actions a {
        flex: 1;
        text-align: center;
        padding: 0.5rem;
        border-radius: 0.5rem;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s;
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
        border: 2px solid var(--primary);
    }

    .btn-directions:hover {
        background: var(--primary);
        color: var(--white);
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 2rem;
    }

    .pagination .page-item {
        list-style: none;
    }

    .pagination .page-link {
        display: block;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        text-decoration: none;
        color: var(--primary);
        background: var(--white);
        transition: all 0.3s;
    }

    .pagination .page-item.active .page-link {
        background: var(--primary);
        color: var(--white);
    }

    .pagination .page-link:hover {
        background: var(--primary);
        color: var(--white);
    }

    @media (max-width: 768px) {
        .pharmacy-grid {
            grid-template-columns: 1fr;
        }

        .pharmacy-actions {
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')
<div class="pharmacy-list">
    <h1>Liste des pharmacies</h1>

    <div class="pharmacy-grid">
        @foreach($pharmacies as $pharmacy)
            <div class="pharmacy-card">
                <h2 class="pharmacy-name">{{ $pharmacy->name }}</h2>
                <div class="pharmacy-info">
                    <p><i class="fas fa-map-marker-alt"></i> {{ $pharmacy->address }}</p>
                    <p><i class="fas fa-phone"></i> {{ $pharmacy->phone_number }}</p>
                    <p><i class="fas fa-pills"></i> {{ $pharmacy->inventory_count }} médicaments en stock</p>
                </div>
                <div class="pharmacy-actions">
                    <a href="{{ route('patient.search.pharmacy.details', $pharmacy->id) }}" class="btn-details">
                        Voir les détails
                    </a>
                    @if($pharmacy->latitude && $pharmacy->longitude)
                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $pharmacy->latitude }},{{ $pharmacy->longitude }}" 
                           target="_blank" 
                           class="btn-directions">
                            Itinéraire
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    {{ $pharmacies->links() }}
</div>
@endsection 