/**
 * Script pour gérer la modale de demande de démo
 */
document.addEventListener('DOMContentLoaded', function () {
    // Vérifie si la modale a déjà été affichée (via localStorage)
    const hasSeenModal = localStorage.getItem('demoModalSeen');

    if (!hasSeenModal) {
        // Attend 5 secondes avant d'afficher la modale
        setTimeout(() => {
            const demoModalElement = document.getElementById('demoModal');
            if (demoModalElement) {
                const demoModal = new bootstrap.Modal(demoModalElement);
                demoModal.show();

                // Marque la modale comme vue pour ne pas la réafficher
                localStorage.setItem('demoModalSeen', 'true');
            }
        }, 5000);
    }

    // Gestion du formulaire
    const demoForm = document.getElementById('demoRequestForm');

    if (demoForm) {
        demoForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const emailInput = document.getElementById('demoEmail');
            const spinner = document.getElementById('demoSpinner');
            const feedbackEl = document.getElementById('emailFeedback');
            const successAlert = document.getElementById('demoSuccess');
            const successMsg = document.getElementById('successMessage');

            // Récupère le jeton CSRF
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            if (!csrfToken) {
                console.error('CSRF token not found');
                feedbackEl.textContent = 'Erreur de sécurité (CSRF). Veuillez rafraîchir la page.';
                emailInput.classList.add('is-invalid');
                return;
            }

            // Réinitialise les messages d'erreur
            emailInput.classList.remove('is-invalid');
            feedbackEl.textContent = '';
            successAlert.classList.add('d-none');

            // Affiche le spinner
            spinner.classList.remove('d-none');

            // Création de l'objet FormData pour envoyer le jeton CSRF correctement
            const formData = new FormData();
            formData.append('email', emailInput.value);
            formData.append('_token', csrfToken);

            // Envoie la requête AJAX
            fetch('/demo-request', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erreur réseau: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    // Cache le spinner
                    spinner.classList.add('d-none');

                    if (data.success) {
                        // Affiche le message de succès
                        demoForm.reset();
                        successMsg.textContent = data.message;
                        successAlert.classList.remove('d-none');

                        // Ferme la modale après 3 secondes
                        setTimeout(() => {
                            const modalInstance = bootstrap.Modal.getInstance(document.getElementById('demoModal'));
                            if (modalInstance) {
                                modalInstance.hide();
                            }
                        }, 3000);
                    } else {
                        // Affiche l'erreur
                        emailInput.classList.add('is-invalid');
                        feedbackEl.textContent = data.message;
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    spinner.classList.add('d-none');
                    emailInput.classList.add('is-invalid');
                    feedbackEl.textContent = 'Une erreur est survenue. Veuillez réessayer. (' + error.message + ')';
                });
        });
    }
}); 