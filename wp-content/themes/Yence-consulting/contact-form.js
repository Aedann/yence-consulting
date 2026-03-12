/**
 * Gestionnaire de formulaires de contact
 * Gère l'envoi des formulaires avec la classe "mailto-form"
 * Utilise FormSubmit (service externe gratuit)
 */
(function () {
  document.querySelectorAll(".mailto-form").forEach((form) => {
    if (form.dataset.initialized) return;

    form.addEventListener("submit", function (e) {
      e.preventDefault();

      const submitBtn = form.querySelector(
        'button[type="submit"], input[type="submit"]',
      );
      const originalText = submitBtn
        ? submitBtn.textContent || submitBtn.value
        : "";

      // Désactiver le bouton pendant l'envoi
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.textContent = submitBtn.value = "Envoi en cours...";
      }

      const formData = new FormData(form);

      // Utiliser FormSubmit.co (service gratuit)
      fetch("https://formsubmit.co/ajax/eric.demonio@gmail.com", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify({
          email: formData.get("email"),
          objet: "Yence Consulting - " + formData.get("objet"),
          message: formData.get("message"),
          _subject:
            formData.get("objet") || "Nouveau message depuis Yence Consulting",
        }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            alert("Votre message a été envoyé avec succès !");
            form.reset();
          } else {
            alert("Erreur lors de l'envoi. Veuillez réessayer.");
          }
        })
        .catch((error) => {
          console.error("Erreur:", error);
          alert("Erreur lors de l'envoi du message. Veuillez réessayer.");
        })
        .finally(() => {
          // Réactiver le bouton
          if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.textContent = submitBtn.value = originalText;
          }
        });
    });

    form.dataset.initialized = "true";
  });
})();
