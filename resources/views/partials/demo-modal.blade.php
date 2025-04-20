<!-- Fenêtre modale pour demande de démo -->
<div class="modal fade" id="demoModal" tabindex="-1" aria-labelledby="demoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="demoModalLabel">Obtenez une démo gratuite</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="bi bi-envelope-paper fs-1 text-primary"></i>
                    <h4 class="mt-3">Découvrez ARCHIF en action</h4>
                    <p class="text-muted">Recevez notre démo gratuite directement dans votre boîte mail</p>
                </div>
                
                <form id="demoRequestForm">
                    @csrf
                    <div class="mb-3">
                    
                        <label for="demoEmail" class="form-label">Votre adresse email</label>
                        <input type="email" class="form-control" id="demoEmail" name="email" placeholder="exemple@domaine.com" required>
                        <div class="invalid-feedback" id="emailFeedback"></div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <span class="spinner-border spinner-border-sm d-none" id="demoSpinner" role="status" aria-hidden="true"></span>
                            Recevoir ma démo gratuite
                        </button>
                    </div>
                    
                    <div class="form-text text-center mt-2">
                        Nous ne partagerons jamais votre email avec des tiers.
                    </div>
                </form>
                
                <div class="alert alert-success mt-3 d-none" id="demoSuccess">
                    <i class="bi bi-check-circle me-2"></i>
                    <span id="successMessage">Merci ! Vous recevrez bientôt votre démo par email.</span>
                </div>
            </div>
        </div>
    </div>
</div> 