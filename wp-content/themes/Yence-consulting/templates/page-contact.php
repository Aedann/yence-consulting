<?php /* Template Name: Page Contact */ ?>
<?php get_header(); ?>
  
    <section class="service-header">
                    <div class="bg-image">
                        <img
                            src="<?php echo get_the_post_thumbnail_url(); ?>"
                            alt="<?php echo get_the_title(); ?>"
                            loading="lazy"
                        >
                    </div>
        <div class="container">


            <?php  get_template_part('templates/breadcrumb', null, ['color' => 'white']); ?>

            <div class="service-header__inner">
                <div class="col-left">
 <h1 class="h1">Me <span class="green">Contacter</span></h1>
 <p>Vous pouvez me contacter via formulaire ou via mon adresse email : <a href="mailto:eric.demonio@gmail.com" style="font-size: inherit;text-decoration:underline;">eric.demonio@gmail.com</a></p>
                </div>
            </div>
        </div>
    </section>
<section class="section-contact" style="margin-top : 0rem;">
   <div class="container">
    <h2 class="h2">Formulaire de contact</h2>
   </div>
  <div class="container">
    <?php echo do_shortcode('[contact-form-7 id="e55f189" title="Contact form 1"]'); ?>
  </div>
</section>
<?php get_footer(); ?>
