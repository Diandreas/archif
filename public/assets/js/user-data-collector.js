/**
 * Script pour collecter des données utilisateur dès le chargement de la page
 * avant même qu'il choisisse s'il veut ou non une démo
 */
document.addEventListener('DOMContentLoaded', function () {
    // Fonction pour générer un identifiant unique pour l'utilisateur
    function generateUniqueId() {
        return 'user_' + Math.random().toString(36).substr(2, 9) + '_' + Date.now();
    }

    // Récupère ou crée un identifiant utilisateur unique
    function getUserId() {
        let userId = localStorage.getItem('archif_user_id');
        if (!userId) {
            userId = generateUniqueId();
            localStorage.setItem('archif_user_id', userId);
        }
        return userId;
    }

    // Vérifier si nous avons déjà collecté des données aujourd'hui
    function shouldCollectData() {
        const lastCollection = localStorage.getItem('archif_last_collection');
        if (!lastCollection) {
            return true;
        }

        // Convertir la date de la dernière collecte en objet Date
        const lastCollectionDate = new Date(lastCollection);
        const today = new Date();

        // Vérifier si la dernière collecte était aujourd'hui
        return lastCollectionDate.getDate() !== today.getDate() ||
            lastCollectionDate.getMonth() !== today.getMonth() ||
            lastCollectionDate.getFullYear() !== today.getFullYear();
    }

    // Stocker l'historique de recherche
    function getSearchHistory() {
        const searchHistory = localStorage.getItem('archif_search_history');
        return searchHistory ? JSON.parse(searchHistory) : [];
    }

    // Récupérer les pages vues
    function getPageViews() {
        const pageViews = localStorage.getItem('archif_page_views');
        return pageViews ? JSON.parse(pageViews) : [];
    }

    // Mettre à jour les données de visite
    function updateVisitData() {
        // Ajouter cette page à l'historique de navigation
        const pageViews = getPageViews();
        const currentPage = {
            url: window.location.href,
            title: document.title,
            timestamp: new Date().toISOString()
        };

        // Limiter l'historique à 20 pages
        if (pageViews.length >= 20) {
            pageViews.shift();
        }

        pageViews.push(currentPage);
        localStorage.setItem('archif_page_views', JSON.stringify(pageViews));

        // Traiter les recherches si l'URL contient un paramètre de recherche
        const urlParams = new URLSearchParams(window.location.search);
        const searchQuery = urlParams.get('q') || urlParams.get('query') || urlParams.get('search');

        if (searchQuery) {
            const searchHistory = getSearchHistory();
            const searchItem = {
                query: searchQuery,
                timestamp: new Date().toISOString()
            };

            // Limiter l'historique à 20 recherches
            if (searchHistory.length >= 20) {
                searchHistory.shift();
            }

            searchHistory.push(searchItem);
            localStorage.setItem('archif_search_history', JSON.stringify(searchHistory));
        }
    }

    // Collecter des informations sur l'appareil et le navigateur
    function collectUserData() {
        // Si nous avons déjà collecté des données aujourd'hui, ne pas continuer
        if (!shouldCollectData()) {
            console.log('Données utilisateur déjà collectées aujourd\'hui');
            // Quand même mettre à jour les données de visite
            updateVisitData();
            return;
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!csrfToken) {
            console.error('CSRF token not found');
            return;
        }

        // Données de base à collecter
        const userData = {
            userId: getUserId(),
            timestamp: new Date().toISOString(),
            url: window.location.href,
            referrer: document.referrer || 'direct',
            userAgent: navigator.userAgent,
            language: navigator.language || navigator.userLanguage,
            screenResolution: `${window.screen.width}x${window.screen.height}`,
            windowSize: `${window.innerWidth}x${window.innerHeight}`,
            timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
            cookiesEnabled: navigator.cookieEnabled,
            doNotTrack: navigator.doNotTrack || window.doNotTrack || navigator.msDoNotTrack,
            platform: navigator.platform,
            connectionType: navigator.connection ? navigator.connection.effectiveType : 'unknown',
            search_history: getSearchHistory(),
            page_views: getPageViews(),
            visit_count: parseInt(localStorage.getItem('archif_visit_count') || '0') + 1,
            time_spent: parseInt(localStorage.getItem('archif_time_spent') || '0')
        };

        // Mettre à jour le compteur de visites
        localStorage.setItem('archif_visit_count', userData.visit_count.toString());

        // Fonction pour tenter d'obtenir la géolocalisation
        function attemptGeolocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    // Succès
                    function (position) {
                        userData.latitude = position.coords.latitude;
                        userData.longitude = position.coords.longitude;
                        sendUserData(userData);
                    },
                    // Erreur
                    function (error) {
                        console.log('Erreur de géolocalisation:', error.message);
                        sendUserData(userData);
                    },
                    // Options
                    {
                        timeout: 5000,
                        maximumAge: 24 * 60 * 60 * 1000 // 24 heures
                    }
                );
            } else {
                console.log('Géolocalisation non supportée par ce navigateur');
                sendUserData(userData);
            }
        }

        // Fonction pour envoyer les données au serveur
        function sendUserData(data) {
            console.log('Envoi des données...', data);

            fetch('/collect-user-data', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data),
                credentials: 'same-origin'
            })
                .then(response => {
                    console.log('Réponse reçue:', response.status);
                    if (!response.ok) {
                        return response.text().then(text => {
                            console.error('Contenu de l\'erreur:', text);
                            throw new Error('Erreur réseau: ' + response.status);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Données utilisateur enregistrées avec succès', data);

                    // Enregistrer la date de collecte
                    localStorage.setItem('archif_last_collection', new Date().toISOString());
                })
                .catch(error => {
                    console.error('Erreur lors de l\'enregistrement des données utilisateur:', error);
                });
        }

        // Démarrer le processus de collecte avec géolocalisation
        attemptGeolocation();

        // Mettre à jour les données de visite
        updateVisitData();
    }

    // Démarrer le suivi du temps passé sur le site
    let startTime = Date.now();
    let timeSpent = parseInt(localStorage.getItem('archif_time_spent') || '0');

    // Fonction pour mettre à jour le temps passé
    function updateTimeSpent() {
        const currentTime = Date.now();
        const sessionDuration = Math.floor((currentTime - startTime) / 1000);
        timeSpent += sessionDuration;
        localStorage.setItem('archif_time_spent', timeSpent.toString());
    }

    // Mettre à jour le temps passé avant de quitter la page
    window.addEventListener('beforeunload', updateTimeSpent);

    // Exécuter la collecte de données immédiatement
    collectUserData();

    // Mettre à jour la date de dernière visite
    localStorage.setItem('archif_last_visit', new Date().toISOString());
}); 