@extends('layouts.app')

@section('title', 'Foire Aux Questions')
@section('description', 'Découvrez les réponses aux questions fréquemment posées sur ARCHIF, la solution d\'archivage électronique open source africaine.')
@section('keywords', 'FAQ, questions fréquentes, aide, support, archivage électronique, open source, Cameroun, archif')

@section('content')
<div class="bg-primary text-white py-4">
    <div class="container">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('home') }}" class="text-white text-decoration-none">
                <i class="bi bi-arrow-left fs-4 me-2"></i>
                Retour à l'accueil
            </a>
        </div>
        <h1 class="display-4 fw-bold">Foire Aux Questions</h1>
        <p class="lead">Réponses aux questions les plus fréquemment posées sur ARCHIF</p>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="accordion shadow-sm" id="faqAccordion">
                @foreach($faqs as $index => $faq)
                <!-- Question {{ $index + 1 }} -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $index }}">
                        <button class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $index }}">
                            {{ $faq['question'] }}
                        </button>
                    </h2>
                    <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="heading{{ $index }}" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            {{ $faq['answer'] }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-5 text-center">
                <p>Vous n'avez pas trouvé la réponse à votre question ?</p>
                <a href="mailto:omgbwayasse@gmail.com" class="btn btn-primary">
                    <i class="bi bi-envelope me-2"></i>
                    Contactez-nous
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 