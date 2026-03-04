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
 <h1 class="h1"><?php the_title(); ?></h1>
                </div>
            </div>
        </div>
    </section>
<section class="container section-index" style="margin-top: 2rem;margin-bottom: 2rem;">
  <?php if (have_posts()): while (have_posts()): the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <div class="entry"><?php the_content(); ?></div>
    </article>
  <?php endwhile; else: ?>
    <p><?php _e('Aucun contenu trouvé.', 'wp-defaut'); ?></p>
  <?php endif; ?>
</section>
<?php get_footer(); ?>
