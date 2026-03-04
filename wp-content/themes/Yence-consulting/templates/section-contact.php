<section class="defaut-section" style="padding-bottom: 0rem !important;">
  <div class="container">
    <span class="sur-titre">[ CONTACT ]</span>
    <h2 class="h2">Nous <span class="green">contacter</span></h2>
    <p class="description">Pour toute question, <strong>renseignement ou devis</strong>, n’hésitez pas à me contacter par téléphone ou en
<strong>remplissant le formulaire ci-dessous</strong>.</p>
    <?php get_template_part('templates/button', null, ['label' => 'Découvrez nos domaines d’intervention', 'url' => '#engagements', 'variant' => 'primary']); //variation : primary / secondary?>
  </div>
</section>

<section class="section-contact">
  <div class="container">
    <?php echo do_shortcode('[contact-form-7 id="e55f189" title="Contact form 1"]'); ?>
  </div>
</section>