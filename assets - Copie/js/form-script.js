jQuery(document).ready(function($) {
    
    $('#devis-form').on('submit', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var submitBtn = form.find('button[type="submit"]');
        var btnText = submitBtn.find('.btn-text');
        var btnLoading = submitBtn.find('.btn-loading');
        var messageDiv = $('#devis-message');
        
        // Désactiver le bouton
        submitBtn.prop('disabled', true);
        btnText.hide();
        btnLoading.show();
        
        // Récupérer les données
        var formData = {
            action: 'submit_devis',
            nonce: devisAjax.nonce,
            nom: $('#devis_nom').val(),
            email: $('#devis_email').val(),
            telephone: $('#devis_telephone').val(),
            entreprise: $('#devis_entreprise').val(),
            service: $('#devis_service').val(),
            message: $('#devis_message').val()
        };
        
        // Envoyer via AJAX
        $.ajax({
            url: devisAjax.ajax_url,
            type: 'POST',
            data: formData,
            success: function(response) {
                
                messageDiv.removeClass('error success');
                
                if (response.success) {
                    // Succès
                    messageDiv.addClass('success').html(response.data.message).show();
                    form[0].reset();
                } else {
                    // Erreur
                    messageDiv.addClass('error').html(response.data.message).show();
                }
            },
            error: function() {
                messageDiv.addClass('error').html('Une erreur est survenue. Veuillez réessayer.').show();
            },
            complete: function() {
                // Réactiver le bouton
                submitBtn.prop('disabled', false);
                btnText.show();
                btnLoading.hide();
                
                // Masquer le message après 5 secondes
                setTimeout(function() {
                    messageDiv.fadeOut();
                }, 5000);
            }
        });
    });
    
});