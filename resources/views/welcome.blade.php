@extends('layouts.app')

@section('title', 'Bienvenue')

@section('header')
    <div class="text-center py-12">
        <h1 class="text-4xl font-bold text-blue-700 mb-2">
            MonMedicament
        </h1>
        <p class="text-xl text-gray-600">
            Révolutionnez votre recherche de médicaments
        </p>
    </div>
@endsection

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <!-- Hero Section -->
            <div class="mb-12 text-center">
                <div class="mb-6">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Trouvez vos médicaments en quelques clics</h2>
                    <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                        Plus de recherches interminables de pharmacie en pharmacie. Localisez instantanément les médicaments dont vous avez besoin et réservez-les en ligne.
                    </p>
                </div>
                <div class="mt-8">
                    <a href="{{ route('patient.search.pharmacy.list') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Commencer votre recherche
                    </a>
                </div>
            </div>

            <!-- Features Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 my-12">
                <div class="text-center p-6 border border-gray-200 rounded-lg hover:shadow-lg transition-shadow">
                    <div class="text-blue-600 text-5xl mb-4">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Recherche en temps réel</h3>
                    <p class="text-gray-600">Trouvez instantanément les pharmacies disposant des médicaments dont vous avez besoin.</p>
                </div>
                
                <div class="text-center p-6 border border-gray-200 rounded-lg hover:shadow-lg transition-shadow">
                    <div class="text-blue-600 text-5xl mb-4">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Géolocalisation intelligente</h3>
                    <p class="text-gray-600">Identifiez les pharmacies les plus proches ayant vos médicaments en stock.</p>
                </div>
                
                <div class="text-center p-6 border border-gray-200 rounded-lg hover:shadow-lg transition-shadow">
                    <div class="text-blue-600 text-5xl mb-4">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Réservation facile</h3>
                    <p class="text-gray-600">Réservez vos médicaments en ligne pour les récupérer sans attendre.</p>
                </div>
            </div>

            <!-- How It Works Section -->
            <div class="my-16">
                <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">Comment ça marche ?</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="flex flex-col items-center text-center">
                        <div class="bg-blue-100 text-blue-600 rounded-full w-12 h-12 flex items-center justify-center font-bold text-xl mb-4">1</div>
                        <h3 class="text-lg font-semibold mb-2">Recherchez vos médicaments</h3>
                        <p class="text-gray-600">Entrez le nom de votre médicament ou prenez une photo de votre ordonnance.</p>
                    </div>
                    
                    <div class="flex flex-col items-center text-center">
                        <div class="bg-blue-100 text-blue-600 rounded-full w-12 h-12 flex items-center justify-center font-bold text-xl mb-4">2</div>
                        <h3 class="text-lg font-semibold mb-2">Trouvez la pharmacie idéale</h3>
                        <p class="text-gray-600">Comparez les pharmacies selon leur distance, disponibilité et prix.</p>
                    </div>
                    
                    <div class="flex flex-col items-center text-center">
                        <div class="bg-blue-100 text-blue-600 rounded-full w-12 h-12 flex items-center justify-center font-bold text-xl mb-4">3</div>
                        <h3 class="text-lg font-semibold mb-2">Réservez et récupérez</h3>
                        <p class="text-gray-600">Réservez en ligne et passez à la pharmacie pour récupérer vos médicaments.</p>
                    </div>
                </div>
            </div>

            <!-- Call to Action for Pharmacies -->
            <div class="my-16 bg-blue-50 p-8 rounded-lg text-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Vous êtes une pharmacie ?</h2>
                <p class="text-lg text-gray-600 mb-6">
                    Rejoignez notre plateforme pour augmenter votre visibilité et attirer de nouveaux clients.
                </p>
                <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Rejoindre MonMedicament
                </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection
