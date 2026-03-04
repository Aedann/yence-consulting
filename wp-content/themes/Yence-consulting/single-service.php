
<?php
/**
 * Template : Single Service
 *
 * Champs ACF utilisés (groupe : group_service_fields) :
 *
 * ── Général ──────────────────────────────────────────────
 *  picto              (file   – url)
 *  image              (image  – array)
 *  couleur_principale (color_picker – string)
 *
 * ── Détails ──────────────────────────────────────────────
 *  details_surtitre   (text)
 *  details_titre      (text)
 *  details_sections   (repeater)
 *      └ photo        (image  – array)
 *      └ texte        (wysiwyg)
 *
 * ── Points clés ──────────────────────────────────────────
 *  points_surtitre    (text)
 *  points_titre       (text)
 *  points_description (textarea)
 *  points_liste       (repeater)
 *      └ picto        (file   – array)
 *      └ texte        (wysiwyg)
 *
 * ── Options ──────────────────────────────────────────────
 *  afficher_engagements (true_false)
 */

// ── Général ───────────────────────────────────────────────────────────────────
$picto   = get_field( 'picto' );              // string url
$image   = get_field( 'image' );              // array : url, alt, width, height
$couleur = get_field( 'couleur_principale' ); // string hex ex: #00545c

// ── Détails ───────────────────────────────────────────────────────────────────
$details_surtitre = get_field( 'details_surtitre' );
$details_titre    = get_field( 'details_titre' );
$details_sections = get_field( 'details_sections' ); // repeater

// ── Points clés ───────────────────────────────────────────────────────────────
$points_surtitre = get_field( 'points_surtitre' );
$points_titre    = get_field( 'points_titre' );
$points_desc     = get_field( 'points_description' );
$points_liste    = get_field( 'points_liste' );       // repeater

// ── Options ───────────────────────────────────────────────────────────────────
$afficher_eng = get_field( 'afficher_engagements' ); // bool

// Couleur exposée en variable CSS inline sur le wrapper
$style_couleur = $couleur ? ' style="--service-color:' . esc_attr( $couleur ) . ';"' : '';

get_header();
?>

<div class="single-service"<?php echo $style_couleur; ?>>
     
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
                    <h1 class="service-header__titre h1">
                        <?php the_title(); ?>
                    </h1>
                    <p class="page-description"><?php the_content();?></p>
                </div>
                <div class="col-right">
                    <?php if ( $picto ) : ?>
                    <div class="service-header__picto">
                        <img
                            src="<?php echo esc_url( $picto ); ?>"
                            alt="<?php echo esc_attr( get_the_title() ); ?>"
                            loading="lazy"
                            aria-hidden="true"
                        >
                    </div>
                <?php endif; ?>
                </div>



                

            </div>
        </div>
    </section>



    <?php if ( $details_surtitre || $details_titre || ! empty( $details_sections ) ) : ?>
    <section class="service-details">
        <div class="container">

            <div class="service-details__header">
                <?php if ( $details_surtitre ) : ?>
                    <p class="service-details__surtitre">
                        <?php echo esc_html( $details_surtitre ); ?>
                    </p>
                <?php endif; ?>

                <?php if ( $details_titre ) : ?>
                    <h2 class="service-details__titre h2">
                        <?php echo $details_titre; ?>
                    </h2>
                <?php endif; ?>
            </div><!-- /.service-details__header -->

            <?php if ( ! empty( $details_sections ) ) : ?>
                <div class="service-details__sections">

                    <?php foreach ( $details_sections as $index => $section ) :
                        $modifier = ( $index % 2 === 0 ) ? 'even' : 'odd';
                    ?>
                        <div class="service-details__section service-details__section--<?php echo $modifier; ?>">

                            <?php if ( ! empty( $section['photo']['url'] ) ) : ?>
                                <div class="service-details__section-photo">
                                        <div class="arrow">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="83.826" height="115.83" viewBox="0 0 83.826 115.83"><defs><linearGradient id="a" x1="-0.181" y1="0.363" x2="1.437" y2="0.568" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#00545c"/><stop offset="1" stop-color="#76c2a3"/></linearGradient></defs><g transform="translate(0.002 0)"><path d="M3902.59-3120.17c-.74,0-1.14-.85-1.32-1.34a4.849,4.849,0,0,1-.27-1.649,4.32,4.32,0,0,1,.44-1.97l23.26-45.99a16.376,16.376,0,0,0,0-13.95l-23.26-45.99a4.783,4.783,0,0,1-.17-3.6c.18-.489.58-1.339,1.32-1.339h15.1c.43,0,.84.34,1.15.939l27.791,54.971a4.915,4.915,0,0,1,0,4.01l-27.791,54.969c-.3.59-.72.94-1.15.94Zm56.48-26.08.03-21.78,4.51-8.4a4.853,4.853,0,0,0,.08-4l-4.56-9.59.03-20.78c.02-3.22,2.75-4.78,4.28-2.451l19.639,29.991v-.02a12.238,12.238,0,0,1-.26,13.01l-19.579,26.63a2.089,2.089,0,0,1-1.672.977C3960.293-3142.662,3959.07-3144.1,3959.07-3146.25Z" transform="translate(-3901 3236)" fill="url(#a)"/></g></svg>
                                        </div>
                                    <img
                                        src="<?php echo esc_url( $section['photo']['url'] ); ?>"
                                        alt="<?php echo esc_attr( $section['photo']['alt'] ?? '' ); ?>"
                                        width="<?php echo esc_attr( $section['photo']['width'] ?? '' ); ?>"
                                        height="<?php echo esc_attr( $section['photo']['height'] ?? '' ); ?>"
                                        loading="lazy"
                                    >
                                </div>
                            <?php endif; ?>

                            <?php if ( ! empty( $section['texte'] ) ) : ?>
                                <div class="service-details__section-texte">
                                    <div class="arrow">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="83.826" height="115.83" viewBox="0 0 83.826 115.83"><defs><linearGradient id="a" x1="-0.181" y1="0.363" x2="1.437" y2="0.568" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#00545c"/><stop offset="1" stop-color="#76c2a3"/></linearGradient></defs><g transform="translate(0.002 0)"><path d="M3902.59-3120.17c-.74,0-1.14-.85-1.32-1.34a4.849,4.849,0,0,1-.27-1.649,4.32,4.32,0,0,1,.44-1.97l23.26-45.99a16.376,16.376,0,0,0,0-13.95l-23.26-45.99a4.783,4.783,0,0,1-.17-3.6c.18-.489.58-1.339,1.32-1.339h15.1c.43,0,.84.34,1.15.939l27.791,54.971a4.915,4.915,0,0,1,0,4.01l-27.791,54.969c-.3.59-.72.94-1.15.94Zm56.48-26.08.03-21.78,4.51-8.4a4.853,4.853,0,0,0,.08-4l-4.56-9.59.03-20.78c.02-3.22,2.75-4.78,4.28-2.451l19.639,29.991v-.02a12.238,12.238,0,0,1-.26,13.01l-19.579,26.63a2.089,2.089,0,0,1-1.672.977C3960.293-3142.662,3959.07-3144.1,3959.07-3146.25Z" transform="translate(-3901 3236)" fill="url(#a)"/></g></svg>
                                    </div>
                                    <?php echo wp_kses_post( $section['texte'] ); ?>
                                </div>
                            <?php endif; ?>

                        </div><!-- /.service-details__section -->
                    <?php endforeach; ?>

                </div><!-- /.service-details__sections -->
            <?php endif; ?>

        </div><!-- /.container -->
    </section><!-- /.service-details -->
    <?php endif; ?>


    <?php /* ═══════════════════════════════════════════
     * 3. SECTION POINTS CLÉS
     * ═══════════════════════════════════════════ */ ?>
    <?php if ( $points_surtitre || $points_titre || $points_desc || ! empty( $points_liste ) ) : ?>
    <section class="service-points">
        <div class="container">
 
            <div class="service-points__header">
                <?php if ( $points_surtitre ) : ?>
                    <p class="service-points__surtitre">
                        <?php echo esc_html( $points_surtitre ); ?>
                    </p>
                <?php endif; ?>

                <?php if ( $points_titre ) : ?>
                    <h2 class="service-points__titre h2">
                        <?php echo $points_titre; ?>
                    </h2>
                <?php endif; ?>

                <?php if ( $points_desc ) : ?>
                    <div class="service-points__description">
                        <?php echo wp_kses_post( $points_desc ); ?>
                    </div>
                <?php endif; ?>
            </div><!-- /.service-points__header -->

            <?php if ( ! empty( $points_liste ) ) : ?>
                <ul class="service-points__liste">

                    <?php foreach ( $points_liste as $point ) : ?>
                        <li class="service-points__item">

                            <?php if ( ! empty( $point['picto'] ) ) : ?>
                                <div class="service-points__item-picto">
                                    <img
                                        src="<?php echo esc_url( $point['picto'] ); ?>"
                                        alt="<?php echo esc_attr( get_the_title() ); ?>"
                                        loading="lazy"
                                        aria-hidden="true"
                                    >
                                </div>
                            <?php endif; ?>

                            <?php if ( ! empty( $point['texte'] ) ) : ?>
                                <div class="service-points__item-texte">
                                    <?php echo wp_kses_post( $point['texte'] ); ?>
                                </div>
                            <?php endif; ?>

                        </li>
                    <?php endforeach; ?>

                </ul><!-- /.service-points__liste -->
            <?php endif; ?>

        </div><!-- /.container -->
    </section><!-- /.service-points -->
    <?php endif; ?>

 <?php get_template_part( 'templates/section-related', null, ['titre' => 'Nos autres services']); ?>

    <?php if ( $afficher_eng ) : ?>
        <?php get_template_part( 'templates/section-engagements' ); ?>
    <?php endif; ?>

    <?php get_template_part( 'templates/section-contact' ); ?>

</div><!-- /.single-service -->


<?php get_footer(); ?>
