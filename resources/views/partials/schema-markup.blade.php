<!-- Schema.org pour améliorer l'apparition des sitelinks dans Google -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebSite",
    "name": "ARCHIF",
    "url": "{{ url('/') }}",
    "potentialAction": {
        "@type": "SearchAction",
        "target": "{{ url('/') }}/search?q={search_term_string}",
        "query-input": "required name=search_term_string"
    },
    "sameAs": [
        "https://github.com/omgbwa-yasse/shelves"
    ]
}
</script>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "ARCHIF",
    "url": "{{ url('/') }}",
    "logo": "{{ asset('assets/img/favicon.svg') }}",
    "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+237 6202978935",
        "contactType": "customer service",
        "email": "omgbwayasse@gmail.com",
        "areaServed": "Cameroon"
    }
}
</script>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "SiteNavigationElement",
    "name": ["Accueil", "Documentation", "Tutoriels", "Développement", "FAQ"],
    "url": [
        "{{ route('home') }}",
        "{{ route('documentation') }}",
        "{{ route('tutoriels') }}",
        "{{ route('developpement') }}",
        "{{ route('faq') }}"
    ]
}
</script> 