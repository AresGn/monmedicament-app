@extends('layouts.patient')

@section('title', 'Accueil')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<style>
    /* Styles mobile-first */
    .hero {
        background: linear-gradient(135deg, #0D9488 0%, #0EA5E9 100%);
        color: var(--white);
        text-align: center;
        padding: 2rem 1rem;
        width: 100%;
        box-sizing: border-box;
        display: flex;
        justify-content: center;
    }
    
    .hero-content {
        width: 100%;
        max-width: 1200px;
    }

    .hero h1 {
        font-size: 1.5rem;
        margin-bottom: 0.75rem;
        font-weight: 700;
        width: 100%;
    }

    .hero p {
        font-size: 1rem;
        margin-bottom: 1.5rem;
        opacity: 0.9;
        line-height: 1.4;
        width: 100%;
    }

    .search-bar {
        width: 100%;
        margin: 0 auto;
        box-sizing: border-box;
    }

    .search-options {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        width: 100%;
        box-sizing: border-box;
    }

    .search-input-container {
        display: flex;
        width: 100%;
        gap: 0.5rem;
        box-sizing: border-box;
        position: relative;
    }

    .search-input-container input {
        flex-grow: 1;
        padding: 0.75rem;
        border: none;
        border-radius: 0.25rem;
        font-size: 0.9rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .search-button {
        background: var(--secondary);
        color: var(--white);
        border: none;
        border-radius: 0.25rem;
        padding: 0 1rem;
        cursor: pointer;
        transition: background-color 0.3s;
        min-width: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
    }

    .search-button:hover {
        background-color: #218838;
    }

    .search-divider {
        position: relative;
        text-align: center;
        margin: 1rem 0;
    }

    .search-divider span {
        display: inline-block;
        padding: 0 0.75rem;
        background: var(--primary);
        color: white;
        font-weight: bold;
        position: relative;
        z-index: 1;
        border-radius: 20px;
        font-size: 0.8rem;
    }

    .search-divider:before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: rgba(255, 255, 255, 0.3);
    }

    .ordonnance-upload {
        background: white;
        border-radius: 0.25rem;
        padding: 1rem;
        width: 100%;
        box-sizing: border-box;
    }

    .ordonnance-upload h3 {
        color: var(--primary);
        margin-bottom: 0.75rem;
        font-size: 1.2rem;
        text-align: left;
        width: 100%;
    }

    .drop-area {
        border: 2px dashed #ddd;
        border-radius: 0.25rem;
        padding: 1.5rem 1rem;
        text-align: center;
        position: relative;
        transition: all 0.3s;
        background: #f9f9f9;
        width: 100%;
        box-sizing: border-box;
    }

    .drop-area:hover, .drop-area.dragover {
        border-color: var(--primary);
        background: #f0f9ff;
    }

    .drop-icon {
        margin-bottom: 0.75rem;
    }

    .drop-icon i {
        font-size: 2rem;
        color: #666;
    }

    .drop-area p {
        margin-bottom: 0.75rem;
        color: #666;
        font-size: 0.9rem;
    }

    .upload-buttons {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin: 1rem 0;
    }

    .upload-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 0.25rem;
        font-size: 0.9rem;
        font-weight: 600;
        background-color: var(--primary);
        color: white;
        cursor: pointer;
        transition: all 0.2s;
        text-align: center;
    }

    .upload-btn:hover {
        background-color: #1e40af;
    }

    .camera-btn {
        background-color: #2563eb;
    }

    .camera-btn:hover {
        background-color: #1d4ed8;
    }

    .reset-btn {
        background-color: #dc2626;
    }

    .reset-btn:hover {
        background-color: #b91c1c;
    }

    .file-formats {
        font-size: 0.7rem;
        color: #888;
        margin-top: 0.75rem;
    }

    .file-info {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #e6f7ff;
        padding: 0.5rem 0.75rem;
        border-radius: 0.25rem;
        margin: 0.75rem 0;
        border: 1px solid #0EA5E9;
        font-size: 0.85rem;
    }

    .file-info p {
        margin: 0;
        color: #333;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .file-info p i {
        color: #0EA5E9;
    }

    .remove-file {
        background: none;
        border: none;
        color: #ff4d4f;
        cursor: pointer;
    }

    /* Styles d'autocomplétion */
    .autocomplete-container {
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        max-height: 200px;
        overflow-y: auto;
        background-color: white;
        border-radius: 0.25rem;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        z-index: 10;
        display: none;
    }
    
    .autocomplete-container.active {
        display: block;
    }
    
    .autocomplete-item {
        padding: 0.75rem 1rem;
        cursor: pointer;
        border-bottom: 1px solid #f0f0f0;
        transition: background-color 0.2s;
    }
    
    .autocomplete-item:last-child {
        border-bottom: none;
    }
    
    .autocomplete-item:hover, .autocomplete-item.selected {
        background-color: #f0f9ff;
    }
    
    .autocomplete-item .medicine-name {
        font-weight: 600;
        color: #333;
    }
    
    .autocomplete-item .medicine-info {
        font-size: 0.8rem;
        color: #666;
        margin-top: 0.25rem;
    }
    
    .highlight-match {
        background-color: rgba(0, 123, 255, 0.15);
        font-weight: bold;
    }

    /* Tablet and Desktop styles */
    @media (min-width: 768px) {
        .hero {
            padding: 4rem 2rem;
            width: 100%;
        }

        .hero-content {
            max-width: 1200px;
            width: 100%;
        }

        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            max-width: 900px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            max-width: 900px;
            margin-left: auto;
            margin-right: auto;
        }

        .search-bar {
            max-width: 900px;
            width: 100%;
            margin: 0 auto;
        }

        .search-options {
            gap: 2rem;
            width: 100%;
        }

        .search-input-container {
            gap: 1rem;
            width: 100%;
        }

        .search-input-container input {
            padding: 1rem;
            font-size: 1rem;
            flex: 1;
        }

        .search-button {
            padding: 0 2rem;
            min-width: 150px;
        }

        .ordonnance-upload {
            padding: 1.5rem;
            border-radius: 0.5rem;
            width: 100%;
        }

        .ordonnance-upload h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .drop-area {
            padding: 2rem;
            border-radius: 0.5rem;
            width: 100%;
        }

        .drop-icon i {
            font-size: 2.5rem;
        }

        .drop-area p {
            font-size: 1rem;
        }

        .upload-buttons {
            flex-direction: row;
            justify-content: center;
        }

        .upload-btn {
            width: auto;
            padding: 0.75rem 1.5rem;
        }

        .file-formats {
            font-size: 0.8rem;
        }

        .file-info {
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
        }
    }

    /* Grands téléphones et tablettes compactes */
    @media (min-width: 480px) and (max-width: 767px) {
        .hero {
            padding: 3rem 1.5rem;
        }
        
        .hero h1 {
            font-size: 2rem;
        }
        
        .hero p {
            font-size: 1.1rem;
        }
        
        .search-input-container {
            display: flex;
            width: 100%;
        }
        
        .search-input-container input {
            flex: 1;
        }
        
        .search-button {
            width: auto;
            min-width: 120px;
        }
    }

    .how-it-works {
        padding: 4rem 2rem;
        text-align: center;
        background: var(--white);
    }

    .how-it-works h2 {
        color: #333;
        font-size: 2rem;
        margin-bottom: 3rem;
        position: relative;
    }

    .steps-container {
        display: flex;
        justify-content: center;
        gap: 2rem;
        max-width: 1200px;
        margin: 0 auto;
        position: relative;
    }

    .step-card {
        background: var(--neutral);
        padding: 2rem;
        border-radius: 1rem;
        flex: 1;
        position: relative;
        transition: transform 0.3s;
        max-width: 300px;
    }

    .step-card:hover {
        transform: translateY(-5px);
    }

    .step-icon {
        width: 80px;
        height: 80px;
        background: var(--white);
        border-radius: 50%;
        margin: 0 auto 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .step-icon i {
        font-size: 2rem;
        color: var(--primary);
    }

    .step-number {
        position: absolute;
        top: -10px;
        right: -10px;
        width: 30px;
        height: 30px;
        background: var(--primary);
        color: var(--white);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    .step-card h3 {
        color: #333;
        margin-bottom: 1rem;
        font-size: 1.3rem;
    }

    .step-card p {
        color: #666;
        line-height: 1.5;
    }

    .features {
        padding: 4rem 2rem;
        text-align: center;
        background: var(--white);
    }

    .features h2 {
        color: var(--primary);
        font-size: 2rem;
        margin-bottom: 1rem;
    }

    .features > p {
        color: #666;
        margin-bottom: 3rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .features-container {
        display: flex;
        justify-content: center;
        gap: 2rem;
        flex-wrap: wrap;
        max-width: 1200px;
        margin: 0 auto;
    }

    .feature-card {
        background: var(--neutral);
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transition: transform 0.3s;
        flex: 1;
        min-width: 300px;
        max-width: 350px;
        border: 2px solid var(--primary);
    }

    .feature-card:hover {
        transform: translateY(-5px);
        border-color: var(--secondary);
    }

    .feature-card i {
        color: var(--secondary);
        font-size: 2rem;
        margin-bottom: 1rem;
    }

    .feature-card p {
        color: var(--primary);
        font-size: 1.1rem;
        line-height: 1.5;
    }

    .why-choose-us {
        padding: 5rem 2rem;
        text-align: center;
        background: var(--white);
    }

    .why-choose-us h2 {
        color: var(--primary);
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .why-choose-us p {
        color: #666;
        margin-bottom: 2rem;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
        font-size: 1.1rem;
    }

    .button-container {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-bottom: 3rem;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
        border-radius: 0.5rem;
        overflow: hidden;
        border: 1px solid #f0f0f0;
    }

    .choice-btn {
        flex: 1;
        padding: 1rem;
        font-size: 1rem;
        border: none;
        background: #f8f9fa;
        cursor: pointer;
        transition: all 0.3s;
        font-weight: 500;
    }

    .choice-btn.active {
        background: var(--primary);
        color: var(--white);
    }

    .cards-container {
        display: flex;
        justify-content: center;
        gap: 2rem;
        flex-wrap: wrap;
        max-width: 1200px;
        margin: 0 auto;
    }

    .why-card {
        background: #fff;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: transform 0.3s;
        flex: 1;
        min-width: 250px;
        max-width: 350px;
        text-align: left;
        border: 1px solid #f0f0f0;
    }

    .why-card:hover {
        transform: translateY(-5px);
    }

    .why-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: rgba(220, 53, 69, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
    }

    .why-icon i {
        font-size: 1.5rem;
        color: var(--error);
    }

    .why-card h3 {
        color: #333;
        font-size: 1.3rem;
        margin-bottom: 1rem;
    }

    .why-card p {
        color: #666;
        font-size: 1rem;
        line-height: 1.5;
        margin-bottom: 0;
        text-align: left;
    }

    .testimonials {
        padding: 6rem 2rem;
        background: var(--white);
    }

    .testimonials h2 {
        text-align: center;
        color: #333;
        font-size: 2.5rem;
        margin-bottom: 3rem;
    }

    .testimonials-container {
        display: flex;
        gap: 2rem;
        max-width: 1200px;
        margin: 0 auto;
        flex-wrap: wrap;
        justify-content: center;
    }

    .testimonial-card {
        background: var(--neutral);
        border-radius: 1rem;
        padding: 2rem;
        flex: 1;
        min-width: 300px;
        max-width: 380px;
        transition: transform 0.3s ease;
    }

    .testimonial-card:hover {
        transform: translateY(-10px);
    }

    .testimonial-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin: 0 auto 1.5rem;
        overflow: hidden;
    }

    .testimonial-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .testimonial-content {
        text-align: center;
    }

    .quote-icon {
        color: var(--primary);
        font-size: 2rem;
        margin-bottom: 1rem;
    }

    .testimonial-text {
        color: #555;
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        font-style: italic;
    }

    .testimonial-author {
        margin-top: 1rem;
    }

    .testimonial-author strong {
        display: block;
        color: #333;
        font-size: 1.1rem;
    }

    .author-location {
        color: #666;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .steps-container {
            flex-direction: column;
            align-items: center;
        }

        .step-card {
            width: 100%;
            max-width: 100%;
        }

        .search-bar {
            flex-direction: column;
            padding: 0;
            width: 100%;
        }

        .search-input-container {
            width: 100%;
        }

        .search-input-container input {
            width: 100%;
        }

        .ordonnance-upload {
            width: 100%;
        }
        
        .drop-area {
            width: 100%;
        }

        .cards-container {
            flex-direction: column;
            align-items: center;
        }
        
        .why-card {
            width: 100%;
            max-width: 100%;
        }
        
        .search-btn-container {
            margin-top: 1rem;
        }
        
        .search-button-main {
            width: 100%;
            padding: 0.75rem 1rem;
        }
    }

    /* Search Results Styles */
    .search-results {
        width: 100%;
        box-sizing: border-box;
        padding: 1rem;
        background: #f7f9fc;
    }

    .search-results-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .search-results-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .search-results-header h2 {
        font-size: 1.25rem;
        color: var(--primary);
        margin: 0;
    }

    .search-actions {
        display: flex;
        gap: 0.75rem;
    }

    .filter-button, .location-button {
        background: white;
        border: 1px solid #ddd;
        border-radius: 0.25rem;
        padding: 0.5rem 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        font-size: 0.9rem;
    }

    .filter-button:hover, .location-button:hover {
        background: #f0f0f0;
    }

    .map-container {
        height: 300px;
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        width: 100%;
    }

    .pharmacy-results-container {
        width: 100%;
        overflow: hidden;
    }

    .pharmacy-results-scroll {
        display: flex;
        gap: 1rem;
        overflow-x: auto;
        padding: 0.5rem 0;
        scroll-behavior: smooth;
        scrollbar-width: thin;
        -webkit-overflow-scrolling: touch;
    }

    .pharmacy-results-scroll::-webkit-scrollbar {
        height: 8px;
    }

    .pharmacy-results-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 8px;
    }

    .pharmacy-results-scroll::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 8px;
    }

    .pharmacy-results-scroll::-webkit-scrollbar-thumb:hover {
        background: #aaa;
    }

    .pharmacy-card {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        padding: 1rem;
        min-width: 300px;
        max-width: 300px;
        border: 1px solid #eee;
        flex-shrink: 0;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .pharmacy-card:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }

    .pharmacy-card.highlight {
        border: 2px solid var(--primary);
        box-shadow: 0 0 0 2px rgba(13, 148, 136, 0.3);
    }
    
    .pharmacy-header {
        display: flex;
        flex-direction: column;
        margin-bottom: 0.5rem;
    }

    .pharmacy-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 0.25rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .pharmacy-rating {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
    }
    
    .pharmacy-rating .stars {
        display: flex;
        color: #FFD700;
        margin-right: 0.5rem;
    }
    
    .pharmacy-rating .stars i {
        margin-right: 2px;
    }
    
    .pharmacy-rating .reviews-count {
        font-size: 0.8rem;
        color: #666;
    }

    .pharmacy-distance-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        background: rgba(13, 148, 136, 0.1);
        color: var(--primary);
        font-size: 0.8rem;
        font-weight: 600;
        padding: 0.25rem 0.5rem;
        border-radius: 1rem;
        margin-bottom: 0.75rem;
    }

    .pharmacy-details {
        display: grid;
        grid-template-columns: 1fr;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
    }

    .pharmacy-info-item {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
        max-width: 100%;
    }

    .pharmacy-info-item i {
        color: var(--primary);
        font-size: 0.9rem;
        margin-top: 0.2rem;
        flex-shrink: 0;
        width: 12px;
        text-align: center;
    }

    .pharmacy-info-content {
        font-size: 0.9rem;
        color: #666;
        white-space: normal;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        max-width: calc(100% - 20px);
    }

    .medicine-list {
        background: #f9f9f9;
        border-radius: 0.25rem;
        padding: 0.75rem;
        margin: 0.75rem 0;
        max-height: 150px;
        overflow-y: auto;
        scrollbar-width: thin;
    }

    .medicine-list::-webkit-scrollbar {
        width: 6px;
    }

    .medicine-list::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .medicine-list::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 4px;
    }

    .medicine-item {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px solid #eee;
    }

    .medicine-item:last-child {
        border-bottom: none;
    }

    .medicine-name {
        font-weight: 500;
        font-size: 0.9rem;
    }

    .medicine-price {
        color: var(--primary);
        font-weight: 500;
        font-size: 0.9rem;
    }

    .stock-badge {
        display: inline-block;
        padding: 0.15rem 0.4rem;
        border-radius: 1rem;
        font-size: 0.7rem;
        font-weight: 500;
        margin-left: 0.5rem;
    }

    .in-stock {
        background: rgba(40, 167, 69, 0.1);
        color: var(--secondary);
    }

    .pharmacy-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
        justify-content: space-between;
    }

    .btn-action {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem;
        border-radius: 0.25rem;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.85rem;
        transition: all 0.2s;
        flex: 1;
    }

    .btn-details {
        background: var(--primary);
        color: white;
    }

    .btn-reserve {
        background: var(--secondary);
        color: white;
    }

    .btn-action:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }

    .loading, .error, .no-results {
        padding: 2rem;
        text-align: center;
        background: white;
        border-radius: 0.5rem;
        margin: 1rem 0;
    }

    /* Filters Bar Styles */
    .filters-bar {
        background: white;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .filter-group {
        margin-bottom: 0.5rem;
    }

    .filter-group h4 {
        color: #333;
        margin: 0 0 0.5rem 0;
        font-size: 1rem;
        font-weight: 600;
    }

    .filter-options.horizontal {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .filter-option {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        cursor: pointer;
    }

    .filter-label {
        font-size: 0.85rem;
        color: #555;
    }

    .filter-actions {
        display: flex;
        gap: 0.5rem;
        grid-column: 1 / -1;
        justify-content: flex-end;
        margin-top: 0.5rem;
    }

    .btn-apply-filters, .btn-reset-filters {
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        font-weight: 500;
        cursor: pointer;
        text-align: center;
        border: none;
        transition: all 0.2s;
        font-size: 0.9rem;
    }

    .btn-apply-filters {
        background-color: #007bff;
        color: white;
    }

    .btn-apply-filters:hover {
        background-color: #0069d9;
    }

    .btn-reset-filters {
        background-color: white;
        color: #333;
        border: 1px solid #ddd;
    }

    .btn-reset-filters:hover {
        background-color: #f8f9fa;
    }

    .search-input {
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        border: 1px solid #ddd;
        font-size: 0.9rem;
        background-color: white;
        min-width: 200px;
    }

    /* Tablet and Desktop styles */
    @media (min-width: 768px) {
        .search-results {
            padding: 2rem;
        }

        .search-results-header h2 {
            font-size: 1.5rem;
        }

        .map-container {
            height: 400px;
        }

        .pharmacy-results-scroll {
            gap: 1.5rem;
            padding: 0.5rem;
        }

        .pharmacy-card {
            min-width: 350px;
            max-width: 350px;
        }
    }

    /* Notifications styles */
    .notification {
        margin-bottom: 1.5rem;
        padding: 1rem;
        border-radius: 0.5rem;
        position: relative;
    }

    .notification h3 {
        margin-top: 0;
        margin-bottom: 0.5rem;
        font-size: 1.2rem;
    }

    .notification p {
        margin-bottom: 0.5rem;
    }

    .notification.success {
        background-color: #d1fae5;
        border-left: 4px solid #10b981;
    }
    
    .notification.info {
        background-color: #dbeafe;
        border-left: 4px solid #3b82f6;
    }

    .notification.warning {
        background-color: #fef3c7;
        border-left: 4px solid #f59e0b;
    }

    .notification.error {
        background-color: #fee2e2;
        border-left: 4px solid #ef4444;
    }
    
    /* Medicine not found styles */
    .medicine-not-found {
        margin-top: 1rem;
        padding-top: 0.75rem;
        border-top: 1px solid rgba(59, 130, 246, 0.2);
    }
    
    .medicine-not-found ul {
        margin-top: 0.5rem;
        padding-left: 1.25rem;
    }
    
    .medicine-not-found li {
        margin-bottom: 0.25rem;
        font-size: 0.9rem;
    }

    /* Identified medicines list */
    .identified-medicines-list {
        margin: 0.5rem 0;
        padding-left: 1.5rem;
    }

    .identified-medicines-list li {
        margin-bottom: 0.25rem;
    }

    .medicines-identified {
        background-color: #dbeafe;
        border-left: 4px solid #3b82f6;
    }

    /* Loading state */
    .loading {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 3rem 1rem;
        text-align: center;
        color: #6b7280;
    }

    .loading:before {
        content: '';
        width: 40px;
        height: 40px;
        margin-bottom: 1rem;
        border: 4px solid #e5e7eb;
        border-top-color: #3b82f6;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }

    /* File upload styles */
    .drop-area.file-selected {
        border-color: var(--primary);
        background-color: rgba(59, 130, 246, 0.05);
    }

    .drop-area.file-selected .drop-icon i {
        color: var(--primary);
        font-size: 2.2rem;
    }
    
    .search-btn-container {
        width: 100%;
        display: flex;
        justify-content: center;
        margin-top: 1.5rem;
    }
    
    .search-button-main {
        background: var(--secondary);
        color: var(--white);
        border: none;
        border-radius: 0.5rem;
        padding: 0.75rem 2rem;
        cursor: pointer;
        transition: background-color 0.3s;
        font-size: 1rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        min-width: 200px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    
    .search-button-main:hover {
        background-color: #1e7e34;
        transform: translateY(-2px);
    }
    
    @media (min-width: 768px) {
        .search-button-main {
            padding: 1rem 3rem;
            font-size: 1.1rem;
            min-width: 250px;
        }
    }
    
    /* Animation de pulsation pour attirer l'attention */
    @keyframes pulsate {
        0% {
            transform: scale(1);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        50% {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0,0,0,0.2);
        }
        100% {
            transform: scale(1);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
    }
    
    .search-button-main.pulsate {
        animation: pulsate 1.5s infinite;
        background-color: #1e7e34;
    }

    /* Error help styles */
    .error-help {
        margin-top: 1rem;
        padding-top: 0.75rem;
        border-top: 1px solid rgba(239, 68, 68, 0.2);
    }
    
    .error-help ul {
        margin-top: 0.5rem;
        padding-left: 1.25rem;
    }
    
    .error-help li {
        margin-bottom: 0.25rem;
        font-size: 0.9rem;
    }

    /* Empty results styles */
    .empty-results {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 3rem 1rem;
        text-align: center;
        color: #6b7280;
        background-color: #f9fafb;
        border-radius: 0.5rem;
        margin: 1rem 0;
    }
    
    .empty-results i {
        font-size: 3rem;
        color: #d1d5db;
        margin-bottom: 1rem;
    }
    
    .empty-results h3 {
        margin-bottom: 0.5rem;
        font-size: 1.2rem;
        color: #374151;
    }
    
    .empty-results p {
        margin-bottom: 0.5rem;
        max-width: 500px;
    }

    /* Loading indicators with different styles for the two cases */
    .loading.analysis {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
        text-align: center;
        color: var(--primary);
        background-color: rgba(14, 165, 233, 0.05);
        border-radius: 0.5rem;
        border: 1px dashed var(--primary);
    }

    .loading.analysis i {
        color: var(--primary);
        font-size: 2rem;
        margin-bottom: 0.75rem;
    }

    .loading.search {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
        text-align: center;
        color: var(--secondary);
        background-color: rgba(34, 197, 94, 0.05);
        border-radius: 0.5rem;
        border: 1px dashed var(--secondary);
    }

    .loading.search i {
        color: var(--secondary);
        font-size: 2rem;
        margin-bottom: 0.75rem;
    }

    /* Styles for transition message */
    .loading.transition {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
        text-align: center;
        color: #6366f1;
        background-color: rgba(99, 102, 241, 0.05);
        border-radius: 0.5rem;
        border: 1px dashed #6366f1;
    }

    .loading.transition i {
        color: #6366f1;
        font-size: 2rem;
        margin-bottom: 0.75rem;
    }

    /* Animation for loading icons */
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .loading i.fa-sync {
        animation: spin 2s linear infinite;
    }

    .loading i.fa-spinner {
        animation: spin 1s linear infinite;
    }

    .loading.analysis i, .loading.search i, .loading.transition i {
        color: inherit;
        font-size: 1.5rem;
        margin-right: 0.5rem;
    }

    .loading.analysis, .loading.search, .loading.transition {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
        text-align: center;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .loading.analysis {
        color: var(--primary);
        background-color: rgba(14, 165, 233, 0.05);
        border: 1px dashed var(--primary);
    }

    .loading.search {
        color: var(--secondary);
        background-color: rgba(34, 197, 94, 0.05);
        border: 1px dashed var(--secondary);
    }

    .loading.transition {
        color: #6366f1;
        background-color: rgba(99, 102, 241, 0.05);
        border: 1px dashed #6366f1;
    }

    /* Loading text styling */
    .loading-text {
        display: flex;
        flex-direction: column;
        text-align: left;
        flex: 1;
        margin: 0 1rem;
    }

    .loading-text span {
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .loading-text small {
        font-size: 0.8rem;
        opacity: 0.8;
    }

    .loading i.fa-spinner, .loading i.fa-sync {
        animation: spin 1s linear infinite;
    }

    .loading i {
        flex-shrink: 0;
    }
</style>
@endpush

@section('content')
    <section class="hero">
        <div class="hero-content">
            <h1>Trouvez vos médicaments en quelques clics</h1>
            <p>Localisez rapidement les pharmacies ayant vos médicaments en stock</p>
            <form action="#" method="GET" class="search-bar" enctype="multipart/form-data">
                <div class="search-options">
                    <div class="search-input-container">
                        <input type="text" name="query" id="searchInput" placeholder="Entrez les noms de vos médicaments (Ex: Paracétamol 200mg)...">
                        <div id="autocompleteContainer" class="autocomplete-container"></div>
                    </div>

                    <div class="search-divider">
                        <span>OU</span>
                    </div>

                    <div class="ordonnance-upload">
                        <h3>Votre ordonnance</h3>
                        <div class="drop-area" id="dropArea">
                            <div class="drop-icon">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <p>Glissez-déposez votre ordonnance ici ou</p>
                            <div class="upload-buttons">
                                <label for="fileUpload" class="upload-btn">
                                    <i class="fas fa-file-upload"></i>
                                    Importer un fichier
                                </label>
                                <label for="cameraCapture" class="upload-btn camera-btn">
                                    <i class="fas fa-camera"></i>
                                    Prendre en photo
                                </label>
                                <button type="button" id="resetUpload" class="upload-btn reset-btn" style="display: none;">
                                    <i class="fas fa-times"></i>
                                    Annuler
                                </button>
                            </div>
                            <input type="file" id="fileUpload" name="ordonnance" accept=".jpg,.jpeg,.png,.pdf" style="display: none;">
                            <input type="file" id="cameraCapture" name="ordonnance" accept="image/*" capture="camera" style="display: none;">
                            <p class="file-formats">Formats acceptés : JPG, PNG, PDF - Max 10MB</p>
                        </div>
                    </div>
                    
                    <div class="search-btn-container">
                        <button type="submit" class="search-button-main">
                            <i class="fas fa-search"></i> Rechercher
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Search Results Section - Initially Hidden -->
    <section id="searchResultsSection" class="search-results" style="display: none;">
        <div class="search-results-container">
            <div class="search-results-header">
                <h2>Résultats de recherche</h2>
                <div class="search-actions">
                    <button id="locationButton" class="location-button">
                        <i class="fas fa-location-arrow"></i> Ma position
                    </button>
                    <input type="text" id="searchQuery" class="search-input" value="Paracetamole 500Mg" readonly>
                </div>
            </div>

            <!-- Filters Bar -->
            <div class="filters-bar">
                <div class="filter-group">
                    <h4>Distance</h4>
                    <div class="filter-options horizontal">
                        <label class="filter-option">
                            <input type="radio" name="distance" value="all" checked>
                            <span class="filter-label">Toutes</span>
                        </label>
                        <label class="filter-option">
                            <input type="radio" name="distance" value="lt1">
                            <span class="filter-label">- de 1 km</span>
                        </label>
                        <label class="filter-option">
                            <input type="radio" name="distance" value="1-3">
                            <span class="filter-label">1-3 km</span>
                        </label>
                        <label class="filter-option">
                            <input type="radio" name="distance" value="3-5">
                            <span class="filter-label">3-5 km</span>
                        </label>
                        <label class="filter-option">
                            <input type="radio" name="distance" value="5-10">
                            <span class="filter-label">5-10 km</span>
                        </label>
                    </div>
                </div>

                <div class="filter-group">
                    <h4>Disponibilité</h4>
                    <div class="filter-options horizontal">
                        <label class="filter-option">
                            <input type="radio" name="availability" value="all" checked>
                            <span class="filter-label">Toutes</span>
                        </label>
                        <label class="filter-option">
                            <input type="radio" name="availability" value="in_stock">
                            <span class="filter-label">En stock</span>
                        </label>
                        <label class="filter-option">
                            <input type="radio" name="availability" value="limited_stock">
                            <span class="filter-label">Stock limité</span>
                        </label>
                    </div>
                </div>

                <div class="filter-group">
                    <h4>Horaires</h4>
                    <div class="filter-options horizontal">
                        <label class="filter-option">
                            <input type="radio" name="hours" value="all" checked>
                            <span class="filter-label">Toutes</span>
                        </label>
                        <label class="filter-option">
                            <input type="radio" name="hours" value="open_now">
                            <span class="filter-label">Ouvert maintenant</span>
                        </label>
                        <label class="filter-option">
                            <input type="radio" name="hours" value="open_24_7">
                            <span class="filter-label">Ouvert 24/7</span>
                        </label>
                        <label class="filter-option">
                            <input type="radio" name="hours" value="open_sunday">
                            <span class="filter-label">Ouvert le dimanche</span>
                        </label>
                    </div>
                </div>

                <div class="filter-group">
                    <h4>Services</h4>
                    <div class="filter-options horizontal">
                        <label class="filter-option">
                            <input type="radio" name="services" value="all" checked>
                            <span class="filter-label">Toutes</span>
                        </label>
                        <label class="filter-option">
                            <input type="radio" name="services" value="click_collect">
                            <span class="filter-label">Click & Collect</span>
                        </label>
                        <label class="filter-option">
                            <input type="radio" name="services" value="delivery">
                            <span class="filter-label">Livraison</span>
                        </label>
                        <label class="filter-option">
                            <input type="radio" name="services" value="card_payment">
                            <span class="filter-label">Paiement CB</span>
                        </label>
                    </div>
                </div>
                
                <div class="filter-actions">
                    <button id="applyFilters" class="btn-apply-filters">Appliquer</button>
                    <button id="resetFilters" class="btn-reset-filters">Réinitialiser</button>
                </div>
            </div>

            <!-- Top: Map Container -->
            <div class="map-container">
                <div id="resultsMap" style="width: 100%; height: 100%;"></div>
            </div>
            
            <!-- Bottom: Pharmacy Results (Horizontal) -->
            <div class="pharmacy-results-container">
                <div id="pharmacyResults" class="pharmacy-results-scroll">
                    <!-- Pharmacy results will be populated here dynamically -->
                </div>
            </div>
        </div>
    </section>

    <section class="how-it-works" id="how-it-works">
        <h2>Comment ça marche ?</h2>
        <div class="steps-container">
            <div class="step-card">
                <div class="step-icon">
                    <i class="fas fa-search"></i>
                    <span class="step-number">1</span>
                </div>
                <h3>Recherchez</h3>
                <p>Saisissez le nom de votre médicament ou scannez votre ordonnance.</p>
            </div>

            <div class="step-card">
                <div class="step-icon">
                    <i class="fas fa-map-marked-alt"></i>
                    <span class="step-number">2</span>
                </div>
                <h3>Localisez</h3>
                <p>Trouvez les pharmacies les plus proches ayant votre médicament en stock.</p>
            </div>

            <div class="step-card">
                <div class="step-icon">
                    <i class="fas fa-check-circle"></i>
                    <span class="step-number">3</span>
                </div>
                <h3>Obtenez</h3>
                <p>Contactez la pharmacie ou suivez l'itinéraire pour récupérer votre traitement.</p>
            </div>
        </div>
    </section>

    <section class="why-choose-us">
        <h2>Pourquoi choisir MonMedicament ?</h2>
        <p>Découvrez comment MonMedicament transforme votre expérience de recherche de médicaments et vous fait gagner du temps et de l'énergie.</p>
        
        <div class="button-container">
            <button class="choice-btn active" id="sans-btn">Sans MonMedicament</button>
            <button class="choice-btn" id="avec-btn">Avec MonMedicament</button>
        </div>

        <div class="cards-container">
            <div class="why-card">
                <div class="why-icon">
                    <i class="fas fa-walking"></i>
                </div>
                <h3>Déplacements multiples</h3>
                <p>Vous devez vous déplacer dans plusieurs pharmacies avant de trouver vos médicaments, souvent sans résultat.</p>
            </div>
            
            <div class="why-card">
                <div class="why-icon">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <h3>Perte de temps</h3>
                <p>Des heures perdues en déplacements et appels téléphoniques pour localiser vos médicaments urgents.</p>
            </div>
            
            <div class="why-card">
                <div class="why-icon">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <h3>Stress et frustration</h3>
                <p>Situation particulièrement stressante en cas d'urgence médicale ou pour les personnes à mobilité réduite.</p>
            </div>
        </div>
    </section>

    <section class="features">
        <h2>Fonctionnalités</h2>
        <p>Découvrez comment MonMedicament peut vous aider à trouver vos médicaments rapidement.</p>
        <div class="features-container">
            <div class="feature-card">
                <i class="fas fa-map-marker-alt"></i>
                <p>Trouvez les pharmacies les plus proches de vous en temps réel</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-check-circle"></i>
                <p>Vérifiez la disponibilité des médicaments avant de vous déplacer</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-phone"></i>
                <p>Contactez directement la pharmacie de votre choix</p>
            </div>
        </div>
    </section>

    <section class="testimonials">
        <h2>Ce que nos utilisateurs disent</h2>
        <div class="testimonials-container">
            <div class="testimonial-card">
                <div class="testimonial-avatar">
                    <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="Alice D.">
                </div>
                <div class="testimonial-content">
                    <div class="quote-icon">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <p class="testimonial-text">Grâce à MonMedicament, j'ai trouvé mon médicament en moins de 10 minutes. Très pratique !</p>
                    <div class="testimonial-author">
                        <strong>Alice D.</strong>
                        <span class="author-location">Cotonou, Bénin</span>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-avatar">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Jean K.">
                </div>
                <div class="testimonial-content">
                    <div class="quote-icon">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <p class="testimonial-text">Je recommande cette application à tous ceux qui cherchent des médicaments rapidement.</p>
                    <div class="testimonial-author">
                        <strong>Jean K.</strong>
                        <span class="author-location">Porto-Novo, Bénin</span>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-avatar">
                    <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Fatou M.">
                </div>
                <div class="testimonial-content">
                    <div class="quote-icon">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <p class="testimonial-text">MonMedicament m'a sauvé la vie lors d'une urgence médicale. Merci !</p>
                    <div class="testimonial-author">
                        <strong>Fatou M.</strong>
                        <span class="author-location">Parakou, Bénin</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchForm = document.querySelector('.search-bar');
        const searchInput = document.getElementById('searchInput');
        const dropArea = document.getElementById('dropArea');
        const fileUpload = document.getElementById('fileUpload');
        const cameraCapture = document.getElementById('cameraCapture');
        const searchResultsSection = document.getElementById('searchResultsSection');
        const pharmacyResults = document.getElementById('pharmacyResults');
        const filtersButton = document.getElementById('filtersButton');
        const locationButton = document.getElementById('locationButton');
        
        let map = null;
        let markers = [];
        let userMarker = null;
        let userLocation = null;
        
        // Liste des médicaments pour l'autocomplétion
        const medicines = [
            { name: 'Paracétamol 500mg', active: 'Paracétamol', laboratory: 'Sanofi', description: 'Analgésique et antipyrétique courant', category: 'PAINKILLERS', prescription: false },
            { name: 'Amoxicilline 250mg', active: 'Amoxicilline', laboratory: 'GSK', description: 'Antibiotique à large spectre', category: 'ANTIBIOTICS', prescription: true },
            { name: 'Ibuprofène 400mg', active: 'Ibuprofène', laboratory: 'Mylan', description: 'Anti-inflammatoire non stéroïdien', category: 'PAINKILLERS', prescription: false },
            { name: 'Doliprane 1000mg', active: 'Paracétamol', laboratory: 'Sanofi', description: 'Traitement symptomatique des douleurs et fièvre', category: 'PAINKILLERS', prescription: false },
            { name: 'Azithromycine 500mg', active: 'Azithromycine', laboratory: 'Pfizer', description: 'Antibiotique de la famille des macrolides', category: 'ANTIBIOTICS', prescription: true },
            { name: 'Vitamine C 1000mg', active: 'Acide ascorbique', laboratory: 'Bayer', description: 'Complément vitaminique', category: 'VITAMINS', prescription: false },
            { name: 'Augmentin 875mg', active: 'Amoxicilline + Acide clavulanique', laboratory: 'GSK', description: 'Antibiotique à large spectre renforcé', category: 'ANTIBIOTICS', prescription: true },
            { name: 'Aspirine 500mg', active: 'Acide acétylsalicylique', laboratory: 'Bayer', description: 'Analgésique, antipyrétique et anti-inflammatoire', category: 'PAINKILLERS', prescription: false },
            { name: 'Maalox', active: "Hydroxyde d'aluminium + Hydroxyde de magnésium", laboratory: 'Sanofi', description: 'Antiacide pour les troubles digestifs', category: 'OTHER', prescription: false },
            { name: 'Chloroquine 250mg', active: 'Chloroquine', laboratory: 'Sanofi', description: 'Traitement du paludisme', category: 'ANTIVIRALS', prescription: true }
        ];
        
        // Implémenter l'autocomplétion
        function setupAutocomplete() {
            const searchInput = document.getElementById('searchInput');
            const autocompleteContainer = document.getElementById('autocompleteContainer');
            
            // Événement d'entrée de texte dans le champ de recherche
            searchInput.addEventListener('input', function() {
                const query = this.value.trim().toLowerCase();
                
                // Effacer et masquer le conteneur s'il n'y a pas de saisie
                if (!query) {
                    autocompleteContainer.innerHTML = '';
                    autocompleteContainer.classList.remove('active');
                    return;
                }
                
                // Filtrer les médicaments correspondant à la requête
                const matches = medicines.filter(medicine => {
                    return medicine.name.toLowerCase().includes(query) || 
                           medicine.active.toLowerCase().includes(query) ||
                           medicine.laboratory.toLowerCase().includes(query);
                });
                
                // Mettre à jour et afficher les résultats d'autocomplétion
                if (matches.length > 0) {
                    updateAutocompleteResults(matches, query);
                    autocompleteContainer.classList.add('active');
                } else {
                    autocompleteContainer.innerHTML = '';
                    autocompleteContainer.classList.remove('active');
                }
            });
            
            // Fermer l'autocomplétion si on clique en dehors
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !autocompleteContainer.contains(e.target)) {
                    autocompleteContainer.classList.remove('active');
                }
            });
            
            // Gérer les touches de navigation (flèches haut/bas et entrée)
            searchInput.addEventListener('keydown', function(e) {
                const items = autocompleteContainer.querySelectorAll('.autocomplete-item');
                let selected = autocompleteContainer.querySelector('.autocomplete-item.selected');
                
                if (items.length === 0) return;
                
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    if (!selected) {
                        items[0].classList.add('selected');
                    } else {
                        selected.classList.remove('selected');
                        const next = selected.nextElementSibling;
                        if (next) {
                            next.classList.add('selected');
                        } else {
                            items[0].classList.add('selected');
                        }
                    }
                    
                    autocompleteContainer.querySelector('.autocomplete-item.selected')?.scrollIntoView({
                        block: 'nearest',
                        behavior: 'smooth'
                    });
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    if (!selected) {
                        items[items.length - 1].classList.add('selected');
                    } else {
                        selected.classList.remove('selected');
                        const prev = selected.previousElementSibling;
                        if (prev) {
                            prev.classList.add('selected');
                        } else {
                            items[items.length - 1].classList.add('selected');
                        }
                    }
                    
                    autocompleteContainer.querySelector('.autocomplete-item.selected')?.scrollIntoView({
                        block: 'nearest',
                        behavior: 'smooth'
                    });
                } else if (e.key === 'Enter' && selected) {
                    e.preventDefault();
                    selectAutocompleteItem(selected);
                } else if (e.key === 'Escape') {
                    autocompleteContainer.classList.remove('active');
                }
            });
        }
        
        // Mettre à jour les résultats d'autocomplétion
        function updateAutocompleteResults(results, query) {
            const autocompleteContainer = document.getElementById('autocompleteContainer');
            autocompleteContainer.innerHTML = '';
            
            results.forEach(medicine => {
                const item = document.createElement('div');
                item.className = 'autocomplete-item';
                
                // Mettre en surbrillance les parties correspondantes
                const nameParts = highlightMatch(medicine.name, query);
                const activeParts = highlightMatch(medicine.active, query);
                
                item.innerHTML = `
                    <div class="medicine-name">${nameParts}</div>
                    <div class="medicine-info">
                        <span>${activeParts}</span> - ${medicine.laboratory} 
                        ${medicine.prescription ? '<span style="color: #f59e0b"><i class="fas fa-prescription"></i> Sur ordonnance</span>' : ''}
                    </div>
                `;
                
                // Événement de clic sur un élément de la liste
                item.addEventListener('click', function() {
                    selectAutocompleteItem(this);
                });
                
                autocompleteContainer.appendChild(item);
            });
        }
        
        // Mettre en surbrillance les parties correspondantes
        function highlightMatch(text, query) {
            if (!query) return text;
            
            const lowerText = text.toLowerCase();
            const lowerQuery = query.toLowerCase();
            
            if (!lowerText.includes(lowerQuery)) return text;
            
            const startIndex = lowerText.indexOf(lowerQuery);
            const endIndex = startIndex + lowerQuery.length;
            
            return text.substring(0, startIndex) + 
                   `<span class="highlight-match">${text.substring(startIndex, endIndex)}</span>` + 
                   text.substring(endIndex);
        }
        
        // Sélectionner un élément d'autocomplétion
        function selectAutocompleteItem(item) {
            const searchInput = document.getElementById('searchInput');
            const medicineName = item.querySelector('.medicine-name').textContent;
            searchInput.value = medicineName;
            document.getElementById('autocompleteContainer').classList.remove('active');
        }
        
        // Initialiser l'autocomplétion
        setupAutocomplete();

        // Initialize the map
        function initMap() {
            if (map === null) {
                map = L.map('resultsMap').setView([6.3702, 2.3912], 13); // Cotonou coordinates
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);
            }
            return map;
        }

        // Clear existing markers from the map
        function clearMarkers() {
            if (markers.length > 0) {
                markers.forEach(marker => map.removeLayer(marker));
                markers = [];
            }
        }

        // Calculate distance between two coordinates in kilometers
        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371; // Radius of the earth in km
            const dLat = deg2rad(lat2 - lat1);
            const dLon = deg2rad(lon2 - lon1);
            const a = 
                Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
                Math.sin(dLon/2) * Math.sin(dLon/2); 
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
            const distance = R * c; // Distance in km
            return distance;
        }

        function deg2rad(deg) {
            return deg * (Math.PI/180);
        }

        // Format distance for display
        function formatDistance(distance) {
            if (distance < 1) {
                return `${Math.round(distance * 1000)} m`;
            } else {
                return `${distance.toFixed(1)} km`;
            }
        }

        // Generate star rating HTML
        function generateStarRating(rating, reviewCount) {
            const fullStars = Math.floor(rating);
            const halfStar = rating % 1 >= 0.5;
            const emptyStars = 5 - fullStars - (halfStar ? 1 : 0);
            
            let starsHtml = '';
            
            // Add full stars
            for (let i = 0; i < fullStars; i++) {
                starsHtml += '<i class="fas fa-star"></i>';
            }
            
            // Add half star if needed
            if (halfStar) {
                starsHtml += '<i class="fas fa-star-half-alt"></i>';
            }
            
            // Add empty stars
            for (let i = 0; i < emptyStars; i++) {
                starsHtml += '<i class="far fa-star"></i>';
            }
            
            return `<div class="stars">${starsHtml}</div><span class="reviews-count">(${reviewCount} avis)</span>`;
        }

        // Get user location
        function getUserLocation() {
            if (navigator.geolocation) {
                locationButton.disabled = true;
                locationButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Localisation...';
                
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        userLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        
                        // Update map with user location
                        if (map) {
                            if (userMarker) {
                                map.removeLayer(userMarker);
                            }
                            
                            // Create a custom icon for user location
                            const userIcon = L.divIcon({
                                className: 'user-location-marker',
                                html: '<div style="background-color: #0EA5E9; width: 16px; height: 16px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 5px rgba(0,0,0,0.3);"></div>',
                                iconSize: [22, 22],
                                iconAnchor: [11, 11]
                            });
                            
                            userMarker = L.marker([userLocation.lat, userLocation.lng], {icon: userIcon})
                                .addTo(map)
                                .bindPopup("Votre position")
                                .openPopup();
                            
                            // Center map on user location
                            map.setView([userLocation.lat, userLocation.lng], 13);
                            
                            // Update distances if we have pharmacy results
                            if (pharmacyResults.children.length > 0 && pharmacyResults.querySelector('.pharmacy-card')) {
                                updateDistancesInResults();
                            }
                        }
                        
                        locationButton.disabled = false;
                        locationButton.innerHTML = '<i class="fas fa-location-arrow"></i> Ma position';
                    },
                    (error) => {
                        console.error("Erreur de géolocalisation:", error);
                        locationButton.disabled = false;
                        locationButton.innerHTML = '<i class="fas fa-location-arrow"></i> Ma position';
                        alert('Impossible de déterminer votre position. Veuillez vérifier que vous avez autorisé l\'accès à votre localisation.');
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 5000,
                        maximumAge: 0
                    }
                );
            } else {
                alert("La géolocalisation n'est pas prise en charge par votre navigateur.");
            }
        }

        // Update distances in the results based on user location
        function updateDistancesInResults() {
            if (!userLocation) return;
            
            const pharmacyCards = document.querySelectorAll('.pharmacy-card');
            const distances = [];
            
            pharmacyCards.forEach(card => {
                const lat = parseFloat(card.dataset.lat);
                const lng = parseFloat(card.dataset.lng);
                
                if (!isNaN(lat) && !isNaN(lng)) {
                    const distance = calculateDistance(userLocation.lat, userLocation.lng, lat, lng);
                    distances.push({ card, distance });
                    
                    // Update distance display in the card
                    const distanceTag = card.querySelector('.pharmacy-distance-tag');
                    if (distanceTag) {
                        distanceTag.innerHTML = `<i class="fas fa-map-marker-alt"></i> ${formatDistance(distance)}`;
                    }
                }
            });
            
            // Sort cards by distance if user requests
            // This is optional and can be triggered by a sort button
        }

        // Add markers for pharmacies to the map
        function addPharmacyMarkers(pharmacies) {
            clearMarkers();
            
            pharmacies.forEach(pharmacy => {
                if (pharmacy.latitude && pharmacy.longitude) {
                    const marker = L.marker([pharmacy.latitude, pharmacy.longitude])
                        .addTo(map)
                        .bindPopup(`
                            <strong>${pharmacy.name}</strong><br>
                            ${pharmacy.address}<br>
                            <a href="tel:${pharmacy.phone_number}">${pharmacy.phone_number}</a>
                        `);
                    
                    // Store pharmacy id in the marker for reference
                    marker.pharmacyId = pharmacy.id;
                    
                    // When clicking on a marker, highlight the corresponding card
                    marker.on('click', function() {
                        const card = document.querySelector(`.pharmacy-card[data-id="${pharmacy.id}"]`);
                        if (card) {
                            // Remove highlight from all cards
                            document.querySelectorAll('.pharmacy-card').forEach(c => {
                                c.classList.remove('highlight');
                            });
                            
                            // Add highlight to clicked pharmacy card
                            card.classList.add('highlight');
                            
                            // Scroll the card into view
                            card.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                        }
                    });
                    
                    markers.push(marker);
                }
            });
            
            // If we have markers, fit the map to show all markers
            if (markers.length > 0) {
                const group = new L.featureGroup(markers);
                map.fitBounds(group.getBounds().pad(0.1));
            }
        }

        // Render pharmacy results in HTML
        function renderPharmacyResults(pharmacies) {
            if (!pharmacies || pharmacies.length === 0) {
                pharmacyResults.innerHTML = `
                    <div class="empty-results">
                        <i class="fas fa-search"></i>
                        <h3>Aucun résultat trouvé</h3>
                        <p>Aucune pharmacie n'a les médicaments recherchés en stock dans votre région.</p>
                        <p>Essayez d'élargir votre recherche ou contactez directement une pharmacie proche.</p>
                    </div>
                `;
                return;
            }

            let html = '';
            
            pharmacies.forEach(pharmacy => {
                let medicinesHtml = '';
                
                pharmacy.medicines.forEach(medicine => {
                    medicinesHtml += `
                        <div class="medicine-item">
                            <span class="medicine-name">${medicine.name}
                                <span class="stock-badge in-stock">En stock</span>
                            </span>
                            <span class="medicine-price">${medicine.price} FCFA</span>
                        </div>
                    `;
                });
                
                // Calculate distance if user location is available
                let distanceHtml = '';
                if (userLocation && pharmacy.latitude && pharmacy.longitude) {
                    const distance = calculateDistance(
                        userLocation.lat, 
                        userLocation.lng, 
                        parseFloat(pharmacy.latitude), 
                        parseFloat(pharmacy.longitude)
                    );
                    distanceHtml = `<div class="pharmacy-distance-tag"><i class="fas fa-map-marker-alt"></i> ${formatDistance(distance)}</div>`;
                } else {
                    distanceHtml = `<div class="pharmacy-distance-tag"><i class="fas fa-map-marker-alt"></i> Distance inconnue</div>`;
                }
                
                html += `
                    <div class="pharmacy-card" data-id="${pharmacy.id}" data-lat="${pharmacy.latitude}" data-lng="${pharmacy.longitude}">
                        <div class="pharmacy-header">
                            <h3 class="pharmacy-name">${pharmacy.name}</h3>
                            <div class="pharmacy-rating">
                                ${generateStarRating(4.5, pharmacy.reviews_count || 128)}
                            </div>
                        </div>
                        ${distanceHtml}
                        <div class="pharmacy-details">
                            <div class="pharmacy-info-item">
                                <i class="fas fa-location-arrow"></i>
                                <div class="pharmacy-info-content">${pharmacy.address}</div>
                            </div>
                            <div class="pharmacy-info-item">
                                <i class="fas fa-clock"></i>
                                <div class="pharmacy-info-content">Ouvert jusqu'à 20h00</div>
                            </div>
                            <div class="pharmacy-info-item">
                                <i class="fas fa-phone"></i>
                                <div class="pharmacy-info-content">${pharmacy.phone_number}</div>
                            </div>
                        </div>
                        
                        <div class="medicine-list">
                            ${medicinesHtml}
                        </div>
                        
                        <div class="pharmacy-actions">
                            <a href="/patient/pharmacy/${pharmacy.id}" class="btn-action btn-details">
                                <i class="fas fa-info-circle"></i> Détails
                            </a>
                            <a href="/reservations/create?pharmacy_id=${pharmacy.id}" class="btn-action btn-reserve">
                                <i class="fas fa-calendar-check"></i> Réserver
                            </a>
                        </div>
                    </div>
                `;
            });
            
            pharmacyResults.innerHTML = html;
            
            // Add click events to pharmacy cards
            document.querySelectorAll('.pharmacy-card').forEach(card => {
                card.addEventListener('click', function(e) {
                    // Don't trigger if clicking on a button or link
                    if (e.target.closest('a')) return;
                    
                    const pharmacyId = this.dataset.id;
                    const marker = markers.find(m => m.pharmacyId == pharmacyId);
                    
                    if (marker) {
                        // Center map on this pharmacy
                        map.setView(marker.getLatLng(), 15);
                        marker.openPopup();
                        
                        // Highlight this card
                        document.querySelectorAll('.pharmacy-card').forEach(c => {
                            c.classList.remove('highlight');
                        });
                        this.classList.add('highlight');
                    }
                });
            });
        }

        // Perform the search and show results
        function performSearch(query) {
            // Store the search query in localStorage for use in the verification page
            localStorage.setItem('lastMedicineSearch', query);
            
            // AJAX request to get search results
            fetch(`/api/medicines/search?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    renderPharmacyResults(data.pharmacies);
                    addPharmacyMarkers(data.pharmacies);
                    
                    // Request user location after results are loaded
                    if (!userLocation) {
                        // Ask for location after results are shown (optional)
                        // You could also automatically request it or wait for user to click button
                    }
                })
                .catch(error => {
                    console.error('Error fetching search results:', error);
                    pharmacyResults.innerHTML = `
                        <div class="notification error">
                            <h3>Erreur lors de la recherche</h3>
                            <p>Une erreur s'est produite lors de la recherche. Veuillez réessayer.</p>
                        </div>
                    `;
                });
        }

        // Handle search form submission
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent form submission
            const query = searchInput.value.trim();
            const hasFile = fileUpload.files.length > 0 || cameraCapture.files.length > 0;
            
            if (!query && !hasFile) {
                alert('Veuillez entrer le nom d\'un médicament ou importer une ordonnance.');
                // Mettre en évidence les deux options
                searchInput.focus();
                dropArea.classList.add('dragover');
                setTimeout(() => {
                    dropArea.classList.remove('dragover');
                }, 1000);
                return;
            }
            
            // Show loading state
            searchResultsSection.style.display = 'block';
            searchResultsSection.scrollIntoView({ behavior: 'smooth' });
            
            // Initialize map if not already initialized
            if (!map) {
                initMap();
            }
            
            if (hasFile) {
                // CAS 1: TÉLÉCHARGEMENT D'ORDONNANCE
                // Traitement de l'upload d'ordonnance pour identifier les médicaments
                // Afficher le message spécifique pour l'analyse d'ordonnance
                pharmacyResults.innerHTML = `
                    <div class="loading analysis">
                        <i class="fas fa-file-medical"></i>
                        <div class="loading-text">
                            <span>Analyse de l'ordonnance en cours...</span>
                            <small>Identification des médicaments prescrits</small>
                        </div>
                        <i class="fas fa-spinner"></i>
                    </div>
                `;
                
                const file = fileUpload.files.length > 0 ? fileUpload.files[0] : cameraCapture.files[0];
                
                // Préparer les données pour l'API
                const formData = new FormData();
                formData.append('ordonnance', file);
                
                // Appel API pour l'analyse de l'ordonnance
                fetch('/api/prescription/analyze', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Si on a des médicaments ou un contenu brut, on les traite
                        if ((data.medicines && data.medicines.length > 0) || data.raw_content) {
                            let medicines = data.medicines || [];
                            
                            // Si on a du contenu brut qui semble être du JSON, on essaie de le parser
                            if (data.raw_content && !medicines.length) {
                                try {
                                    const parsedContent = JSON.parse(data.raw_content);
                                    if (Array.isArray(parsedContent) && parsedContent.length > 0) {
                                        medicines = parsedContent;
                                    }
                                } catch (e) {
                                    console.log('Impossible de parser le contenu JSON:', e);
                                }
                            }
                            
                            if (medicines && medicines.length > 0) {
                                // Construction de la requête à partir des médicaments identifiés
                                const medicinesQuery = medicines.map(med => {
                                    if (med.nom && med.dosage) {
                                        return `${med.nom} ${med.dosage}`;
                                    } else if (med.nom) {
                                        return med.nom;
                                    }
                                    return '';
                                }).filter(item => item).join(', ');
                                
                                // Mettre à jour le champ de recherche
                                searchInput.value = medicinesQuery;
                                
                                // Mettre à jour le champ dans les résultats
                                const searchQueryInput = document.getElementById('searchQuery');
                                if (searchQueryInput) {
                                    searchQueryInput.value = medicinesQuery;
                                }
                                
                                // Lancer la recherche avec les médicaments identifiés
                                // Afficher un message de transition avant de lancer la recherche
                                pharmacyResults.innerHTML = `
                                    <div class="loading transition">
                                        <i class="fas fa-sync"></i>
                                        <div class="loading-text">
                                            <span>Recherche de pharmacies avec les médicaments identifiés...</span>
                                            <small>Nous cherchons les pharmacies proches ayant ces médicaments en stock</small>
                                        </div>
                                    </div>
                                `;
                                
                                // Lancer la recherche après un court délai pour montrer le message de transition
                                setTimeout(() => {
                                    performSearch(medicinesQuery);
                                    // Afficher les médicaments identifiés
                                    showIdentifiedMedicines(medicines, data.message);
                                }, 500);
                            } else {
                                // Aucun médicament identifié
                                pharmacyResults.innerHTML = `
                                    <div class="notification warning">
                                        <h3>Aucun médicament identifié</h3>
                                        <p>Nous n'avons pas pu identifier clairement les médicaments sur votre ordonnance. Veuillez vérifier que l'image est nette et réessayer, ou saisissez manuellement les noms des médicaments.</p>
                                        <p>${data.raw_content ? `<strong>Texte identifié:</strong> ${data.raw_content}` : ''}</p>
                                    </div>
                                `;
                            }
                        } else {
                            // Aucun médicament identifié
                            pharmacyResults.innerHTML = `
                                <div class="notification warning">
                                    <h3>Aucun médicament identifié</h3>
                                    <p>Nous n'avons pas pu identifier clairement les médicaments sur votre ordonnance. Veuillez vérifier que l'image est nette et réessayer, ou saisissez manuellement les noms des médicaments.</p>
                                </div>
                            `;
                        }
                    } else {
                        // Erreur lors de l'analyse
                        let errorMessage = data.message || 'Une erreur est survenue lors de l\'analyse de votre ordonnance.';
                        
                        pharmacyResults.innerHTML = `
                            <div class="notification error">
                                <h3>Erreur lors de l'analyse</h3>
                                <p>${errorMessage}</p>
                                <div class="error-help">
                                    <p><strong>Solutions possibles :</strong></p>
                                    <ul>
                                        <li>Vérifiez que votre image est claire et nette</li>
                                        <li>Essayez avec une autre image ou un autre format</li>
                                        <li>Vous pouvez également saisir manuellement les noms de médicaments</li>
                                    </ul>
                                </div>
                            </div>
                        `;
                        console.error('Erreur analyse:', data.error);
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    pharmacyResults.innerHTML = `
                        <div class="notification error">
                            <h3>Erreur de communication</h3>
                            <p>Une erreur est survenue lors de la communication avec le serveur.</p>
                            <div class="error-help">
                                <p><strong>Solutions possibles :</strong></p>
                                <ul>
                                    <li>Vérifiez votre connexion internet</li>
                                    <li>Rechargez la page et réessayez</li>
                                    <li>Vous pouvez également saisir manuellement les noms de médicaments</li>
                                </ul>
                            </div>
                        </div>
                    `;
                });
                
            } else if (query) {
                // CAS 2: RECHERCHE MANUELLE DE MÉDICAMENTS
                // Effectuer directement la recherche avec le texte entré
                // Afficher le message spécifique pour la recherche manuelle
                pharmacyResults.innerHTML = `
                    <div class="loading search">
                        <i class="fas fa-search"></i>
                        <div class="loading-text">
                            <span>Recherche en cours...</span>
                            <small>Nous cherchons les pharmacies proches ayant ce médicament en stock</small>
                        </div>
                        <i class="fas fa-spinner"></i>
                    </div>
                `;
                
                const searchQueryInput = document.getElementById('searchQuery');
                if (searchQueryInput) {
                    searchQueryInput.value = query;
                }
                
                // Lancer directement la recherche des pharmacies avec ce médicament
                performSearch(query);
            }
        });

        // Fonction pour afficher les médicaments identifiés
        function showIdentifiedMedicines(medicines, message) {
            // Créer une notification à insérer avant les résultats
            const notificationDiv = document.createElement('div');
            notificationDiv.className = 'notification success medicines-identified';
            
            let medicinesHtml = '<ul class="identified-medicines-list">';
            medicines.forEach(med => {
                medicinesHtml += `<li><strong>${med.nom}</strong>${med.dosage ? ` (${med.dosage})` : ''}</li>`;
            });
            medicinesHtml += '</ul>';
            
            let title = 'Médicaments identifiés sur votre ordonnance';
            let subtitle = 'Nous avons identifié les médicaments suivants sur votre ordonnance :';
            let additionalInfo = '';
            
            // Si un message est présent et contient "mode secours", ajuster le message
            if (message && message.includes('mode secours')) {
                title = 'Médicaments de test (mode démonstration)';
                subtitle = 'Nous utilisons des données de test pour la démonstration :';
            }
            
            // Ajouter une note si les résultats de recherche sont vides
            const resultsDiv = document.getElementById('pharmacyResults');
            if (resultsDiv && resultsDiv.children.length === 1 && resultsDiv.querySelector('.empty-results')) {
                additionalInfo = `<div class="medicine-not-found">
                    <p><strong>Note:</strong> Certains médicaments identifiés ne sont pas disponibles dans notre base de données ou n'ont pas été trouvés dans les pharmacies à proximité.</p>
                    <p>Suggestions:</p>
                    <ul>
                        <li>Vérifiez l'orthographe des noms de médicaments</li>
                        <li>Essayez une recherche avec un autre médicament</li>
                        <li>Contactez votre médecin pour des alternatives</li>
                    </ul>
                </div>`;
                
                // Modifier légèrement le style pour indiquer un avertissement
                notificationDiv.className = 'notification info medicines-identified';
            }
            
            notificationDiv.innerHTML = `
                <h3>${title}</h3>
                <p>${subtitle}</p>
                ${medicinesHtml}
                ${additionalInfo}
            `;
            
            // Insérer avant les résultats de recherche
            pharmacyResults.insertAdjacentElement('afterbegin', notificationDiv);
        }

        // Gestion du drag and drop et des événements de fichier
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        // Highlight drop area when dragging over it
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight() {
            dropArea.classList.add('dragover');
        }
        
        function unhighlight() {
            dropArea.classList.remove('dragover');
        }
        
        // Handle dropped files
        dropArea.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            if (files.length > 0) {
                fileUpload.files = files;
                dropArea.querySelector('p').textContent = `Fichier sélectionné: ${files[0].name}`;
            }
        }
        
        // Handle file input change
        fileUpload.addEventListener('change', function() {
            if (this.files.length > 0) {
                const fileName = this.files[0].name;
                dropArea.querySelector('p').textContent = `Fichier sélectionné: ${fileName}`;
                dropArea.classList.add('file-selected');
                
                // Ajouter une indication visuelle
                const icon = dropArea.querySelector('.drop-icon i');
                icon.className = 'fas fa-file-medical';
                icon.style.color = 'var(--primary)';
                
                // Afficher le bouton de réinitialisation
                document.getElementById('resetUpload').style.display = 'inline-flex';
                
                // Mettre en évidence le bouton de recherche
                highlightSearchButton();
            }
        });
        
        // Handle camera input change
        cameraCapture.addEventListener('change', function() {
            if (this.files.length > 0) {
                dropArea.querySelector('p').textContent = 'Photo capturée';
                dropArea.classList.add('file-selected');
                
                // Ajouter une indication visuelle
                const icon = dropArea.querySelector('.drop-icon i');
                icon.className = 'fas fa-camera';
                icon.style.color = 'var(--primary)';
                
                // Afficher le bouton de réinitialisation
                document.getElementById('resetUpload').style.display = 'inline-flex';
                
                // Mettre en évidence le bouton de recherche
                highlightSearchButton();
            }
        });
        
        // Handle reset button
        document.getElementById('resetUpload').addEventListener('click', function() {
            // Réinitialiser les champs de fichier
            fileUpload.value = '';
            cameraCapture.value = '';
            
            // Réinitialiser l'apparence
            dropArea.classList.remove('file-selected');
            dropArea.querySelector('p').textContent = 'Glissez-déposez votre ordonnance ici ou';
            
            // Réinitialiser l'icône
            const icon = dropArea.querySelector('.drop-icon i');
            icon.className = 'fas fa-cloud-upload-alt';
            icon.style.color = '';
            
            // Masquer le bouton de réinitialisation
            this.style.display = 'none';
            
            // Réinitialiser le style du bouton de recherche
            const searchBtn = document.querySelector('.search-button-main');
            searchBtn.classList.remove('pulsate');
        });
        
        // Fonction pour mettre en évidence le bouton de recherche
        function highlightSearchButton() {
            const searchBtn = document.querySelector('.search-button-main');
            searchBtn.classList.add('pulsate');
            
            // Faire défiler jusqu'au bouton pour s'assurer qu'il est visible
            searchBtn.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
        
        // Handle drop event
        dropArea.addEventListener('drop', function(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            if (files.length > 0) {
                fileUpload.files = files;
                const fileName = files[0].name;
                dropArea.querySelector('p').textContent = `Fichier sélectionné: ${fileName}`;
                dropArea.classList.add('file-selected');
                
                // Ajouter une indication visuelle
                const icon = dropArea.querySelector('.drop-icon i');
                icon.className = 'fas fa-file-medical';
                icon.style.color = 'var(--primary)';
                
                // Afficher le bouton de réinitialisation
                document.getElementById('resetUpload').style.display = 'inline-flex';
                
                // Mettre en évidence le bouton de recherche
                highlightSearchButton();
            }
        });

        // Apply filters
        const applyFiltersButton = document.getElementById('applyFilters');
        if (applyFiltersButton) {
            applyFiltersButton.addEventListener('click', function() {
                // Get selected filters
                const distance = document.querySelector('input[name="distance"]:checked').value;
                const availability = document.querySelector('input[name="availability"]:checked').value;
                const hours = document.querySelector('input[name="hours"]:checked').value;
                const services = document.querySelector('input[name="services"]:checked').value;

                // Apply filters to results
                applyFiltersToResults(distance, availability, hours, services);
            });
        }

        // Reset filters
        const resetFiltersButton = document.getElementById('resetFilters');
        if (resetFiltersButton) {
            resetFiltersButton.addEventListener('click', function() {
                // Reset all radio buttons to "Toutes"
                document.querySelector('input[name="distance"][value="all"]').checked = true;
                document.querySelector('input[name="availability"][value="all"]').checked = true;
                document.querySelector('input[name="hours"][value="all"]').checked = true;
                document.querySelector('input[name="services"][value="all"]').checked = true;

                // Reset filters
                applyFiltersToResults('all', 'all', 'all', 'all');
            });
        }

        // Function to apply filters to results
        function applyFiltersToResults(distance, availability, hours, services) {
            console.log('Applying filters:', { distance, availability, hours, services });
            
            // For now, just log the filters
            // This would filter the pharmacy cards based on the selected criteria
            
            // Example implementation (to be completed with actual filtering logic):
            const pharmacyCards = document.querySelectorAll('.pharmacy-card');
            
            pharmacyCards.forEach(card => {
                let visible = true;
                
                // Filter by distance
                if (distance !== 'all' && userLocation) {
                    const lat = parseFloat(card.dataset.lat);
                    const lng = parseFloat(card.dataset.lng);
                    
                    if (!isNaN(lat) && !isNaN(lng)) {
                        const distanceInKm = calculateDistance(
                            userLocation.lat, 
                            userLocation.lng, 
                            lat, 
                            lng
                        );
                        
                        switch (distance) {
                            case 'lt1':
                                visible = distanceInKm < 1;
                                break;
                            case '1-3':
                                visible = distanceInKm >= 1 && distanceInKm <= 3;
                                break;
                            case '3-5':
                                visible = distanceInKm >= 3 && distanceInKm <= 5;
                                break;
                            case '5-10':
                                visible = distanceInKm >= 5 && distanceInKm <= 10;
                                break;
                        }
                    }
                }
                
                // For now, we'll just hide/show based on distance
                // Additional filtering logic would go here
                
                // Apply visibility
                card.style.display = visible ? '' : 'none';
            });
            
            // Update map markers to match filtered results
            updateMapMarkersVisibility();
        }
        
        // Update map markers to match filtered results
        function updateMapMarkersVisibility() {
            if (!map || !markers.length) return;
            
            const visiblePharmacyIds = Array.from(document.querySelectorAll('.pharmacy-card:not([style*="display: none"])'))
                .map(card => card.dataset.id);
            
            markers.forEach(marker => {
                if (visiblePharmacyIds.includes(marker.pharmacyId)) {
                    // Show marker if not already on map
                    if (!map.hasLayer(marker)) {
                        marker.addTo(map);
                    }
                } else {
                    // Hide marker if on map
                    if (map.hasLayer(marker)) {
                        map.removeLayer(marker);
                    }
                }
            });
            
            // If we have visible markers, fit the map to show them
            const visibleMarkers = markers.filter(marker => 
                visiblePharmacyIds.includes(marker.pharmacyId)
            );
            
            if (visibleMarkers.length > 0) {
                const group = new L.featureGroup(visibleMarkers);
                map.fitBounds(group.getBounds().pad(0.1));
            }
        }

        // Location button functionality
        if (locationButton) {
            locationButton.addEventListener('click', function() {
                getUserLocation();
            });
        }

        // Gestion du drag and drop
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            dropArea.classList.add('dragover');
        }

        function unhighlight() {
            dropArea.classList.remove('dragover');
        }

        dropArea.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            if (files.length) {
                fileUpload.files = files;
                updateFileInfo(fileUpload.files[0]);
            }
        }

        // Afficher le nom du fichier sélectionné
        fileUpload.addEventListener('change', function() {
            if (this.files.length) {
                updateFileInfo(this.files[0]);
            }
        });

        cameraCapture.addEventListener('change', function() {
            if (this.files.length) {
                updateFileInfo(this.files[0]);
            }
        });

        function updateFileInfo(file) {
            if (file) {
                // Vérifier la taille du fichier (max 10MB)
                const maxSize = 10 * 1024 * 1024; // 10MB en octets
                if (file.size > maxSize) {
                    alert('Le fichier est trop volumineux. Veuillez sélectionner un fichier de moins de 10MB.');
                    return;
                }

                // Créer un élément pour afficher le nom du fichier
                const fileInfo = document.createElement('div');
                fileInfo.className = 'file-info';
                fileInfo.innerHTML = `
                    <p><i class="fas fa-file"></i> ${file.name}</p>
                    <button type="button" class="remove-file"><i class="fas fa-times"></i></button>
                `;

                // Remplacer le contenu de la zone de dépôt
                const existingInfo = dropArea.querySelector('.file-info');
                if (existingInfo) {
                    dropArea.removeChild(existingInfo);
                }
                
                // Cacher les éléments d'upload
                const elementsToHide = dropArea.querySelectorAll('.drop-icon, .drop-area > p:not(.file-formats), .upload-buttons');
                elementsToHide.forEach(el => el.style.display = 'none');
                
                // Ajouter l'info du fichier
                dropArea.insertBefore(fileInfo, dropArea.querySelector('.file-formats'));
                
                // Ajouter un gestionnaire pour supprimer le fichier
                const removeButton = fileInfo.querySelector('.remove-file');
                removeButton.addEventListener('click', function() {
                    fileUpload.value = '';
                    cameraCapture.value = '';
                    dropArea.removeChild(fileInfo);
                    
                    // Réafficher les éléments d'upload
                    elementsToHide.forEach(el => el.style.display = '');
                });
            }
        }

        // Pourquoi Nous Choisir buttons functionality
        const sansBtn = document.getElementById('sans-btn');
        const avecBtn = document.getElementById('avec-btn');
        const whyCards = document.querySelectorAll('.why-card');

        if (sansBtn && avecBtn) {
            sansBtn.addEventListener('click', function() {
                sansBtn.classList.add('active');
                avecBtn.classList.remove('active');
                
                // Change content for "Sans" state
                updateCardsForSansState();
            });

            avecBtn.addEventListener('click', function() {
                avecBtn.classList.add('active');
                sansBtn.classList.remove('active');
                
                // Change content for "Avec" state
                updateCardsForAvecState();
            });

            // Default state - Sans MonMedicament
            updateCardsForSansState();
        }

        function updateCardsForAvecState() {
            if (whyCards.length >= 3) {
                // First card - Localisation précise
                whyCards[0].querySelector('h3').textContent = 'Localisation précise';
                whyCards[0].querySelector('p').textContent = 'Trouvez immédiatement les pharmacies ayant vos médicaments en stock sans vous déplacer inutilement.';
                whyCards[0].querySelector('.why-icon i').className = 'fas fa-map-marker-alt';
                whyCards[0].querySelector('.why-icon').style.background = 'rgba(40, 167, 69, 0.1)';
                whyCards[0].querySelector('.why-icon i').style.color = 'var(--secondary)';
                
                // Second card - Gain de temps
                whyCards[1].querySelector('h3').textContent = 'Gain de temps';
                whyCards[1].querySelector('p').textContent = 'Économisez des heures précieuses en consultant les disponibilités en temps réel depuis votre smartphone.';
                whyCards[1].querySelector('.why-icon i').className = 'fas fa-clock';
                whyCards[1].querySelector('.why-icon').style.background = 'rgba(40, 167, 69, 0.1)';
                whyCards[1].querySelector('.why-icon i').style.color = 'var(--secondary)';
                
                // Third card - Tranquillité d'esprit
                whyCards[2].querySelector('h3').textContent = 'Tranquillité d\'esprit';
                whyCards[2].querySelector('p').textContent = 'Accédez rapidement à vos traitements, même en situation d\'urgence ou à mobilité réduite.';
                whyCards[2].querySelector('.why-icon i').className = 'fas fa-check-circle';
                whyCards[2].querySelector('.why-icon').style.background = 'rgba(40, 167, 69, 0.1)';
                whyCards[2].querySelector('.why-icon i').style.color = 'var(--secondary)';
            }
        }

        function updateCardsForSansState() {
            if (whyCards.length >= 3) {
                // First card - Déplacements multiples
                whyCards[0].querySelector('h3').textContent = 'Déplacements multiples';
                whyCards[0].querySelector('p').textContent = 'Vous devez vous déplacer dans plusieurs pharmacies avant de trouver vos médicaments, souvent sans résultat.';
                whyCards[0].querySelector('.why-icon i').className = 'fas fa-walking';
                whyCards[0].querySelector('.why-icon').style.background = 'rgba(220, 53, 69, 0.1)';
                whyCards[0].querySelector('.why-icon i').style.color = 'var(--error)';
                
                // Second card - Perte de temps
                whyCards[1].querySelector('h3').textContent = 'Perte de temps';
                whyCards[1].querySelector('p').textContent = 'Des heures perdues en déplacements et appels téléphoniques pour localiser vos médicaments urgents.';
                whyCards[1].querySelector('.why-icon i').className = 'fas fa-hourglass-half';
                whyCards[1].querySelector('.why-icon').style.background = 'rgba(220, 53, 69, 0.1)';
                whyCards[1].querySelector('.why-icon i').style.color = 'var(--error)';
                
                // Third card - Stress et frustration
                whyCards[2].querySelector('h3').textContent = 'Stress et frustration';
                whyCards[2].querySelector('p').textContent = 'Situation particulièrement stressante en cas d\'urgence médicale ou pour les personnes à mobilité réduite.';
                whyCards[2].querySelector('.why-icon i').className = 'fas fa-exclamation-circle';
                whyCards[2].querySelector('.why-icon').style.background = 'rgba(220, 53, 69, 0.1)';
                whyCards[2].querySelector('.why-icon i').style.color = 'var(--error)';
            }
        }
    });
</script>
@endpush 