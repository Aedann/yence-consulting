<?php /* Template Name: Page Engagements */ ?>
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
 <h1 class="h1">Engagements</h1>
 <p>Découvrez nos engagements envers nos clients et partenaires.</p>
                </div>
            </div>
        </div>
    </section>

   <?php get_template_part( 'templates/section-engagements' ); ?>

<?php get_template_part( 'templates/section-contact' ); ?>

<?php get_footer(); ?>
