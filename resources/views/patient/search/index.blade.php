@extends('layouts.app')

@section('title', 'Rechercher un médicament')

@section('header')
    <h1 class="text-xl font-semibold text-gray-800">
        Rechercher un médicament
    </h1>
@endsection

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="flex flex-col items-center">
                <div class="w-full md:w-2/3 lg:w-1/2 mb-8">
                    <p class="text-gray-600 text-center mb-6">
                        Entrez le nom du médicament dont vous avez besoin pour trouver les pharmacies où il est disponible.
                    </p>
                    
                    <form action="{{ route('patient.search.results') }}" method="POST" class="w-full">
                        @csrf
                        <div class="mb-4">
                            <div class="relative">
                                <input type="text" 
                                       name="query" 
                                       id="query" 
                                       class="w-full pl-4 pr-10 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Exemple: Paracétamol, Amoxicilline..."
                                       required>
                                <button type="submit" class="absolute inset-y-0 right-0 flex items-center px-4 text-blue-600 bg-transparent">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            @error('query')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </form>
                    
                    <!-- Future feature: Upload prescription image -->
                    <div class="mt-4 text-center">
                        <p class="text-sm text-gray-500">ou</p>
                        <button class="mt-2 px-4 py-2 border border-blue-300 text-blue-600 rounded-lg hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-400 disabled:opacity-50" disabled>
                            <i class="fas fa-camera mr-2"></i> Scanner une ordonnance
                            <span class="text-xs ml-2">(Bientôt disponible)</span>
                        </button>
                    </div>
                </div>
                
                <div class="w-full">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Recherches populaires</h2>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('patient.search.results') }}?query=paracetamol" 
                           class="px-4 py-2 bg-gray-100 text-gray-800 rounded-full hover:bg-gray-200">
                            Paracétamol
                        </a>
                        <a href="{{ route('patient.search.results') }}?query=ibuprofene" 
                           class="px-4 py-2 bg-gray-100 text-gray-800 rounded-full hover:bg-gray-200">
                            Ibuprofène
                        </a>
                        <a href="{{ route('patient.search.results') }}?query=amoxicilline" 
                           class="px-4 py-2 bg-gray-100 text-gray-800 rounded-full hover:bg-gray-200">
                            Amoxicilline
                        </a>
                        <a href="{{ route('patient.search.results') }}?query=doliprane" 
                           class="px-4 py-2 bg-gray-100 text-gray-800 rounded-full hover:bg-gray-200">
                            Doliprane
                        </a>
                        <a href="{{ route('patient.search.results') }}?query=vitamine" 
                           class="px-4 py-2 bg-gray-100 text-gray-800 rounded-full hover:bg-gray-200">
                            Vitamines
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection 