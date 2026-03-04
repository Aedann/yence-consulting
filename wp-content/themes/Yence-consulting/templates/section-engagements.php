<?php
/**
 * Template Part : Section Engagements
 *
 * Champs ACF utilisés (groupe : group_home_fields) :
 *  - eng_surtitre      (text)
 *  - eng_titre         (text)
 *  - eng_description   (textarea)
 *  - eng_image_fond    (image – array)
 *  - eng_btn_texte     (text)
 *  - eng_btn_lien      (link – array)
 *  - eng_liste         (repeater)
 *      └ titre         (text)
 *      └ picto         (file – url)
 *      └ description   (wysiwyg)
 *
 * Inclusion : get_template_part( 'templates/section-engagements' );
 */

// ── Champs principaux ─────────────────────────────────────────────────────────
$surtitre   = get_field( 'eng_surtitre', 15);
$titre      = get_field( 'eng_titre', 15);
$description = get_field( 'eng_description', 15 );
$image_fond = get_field( 'eng_image_fond', 15 );   // array : url, alt, width, height
$btn_texte  = get_field( 'eng_btn_texte', 15 );
$btn_lien   = get_field( 'eng_btn_lien', 15 );     // array : url, title, target
$eng_liste  = get_field( 'eng_liste', 15 );        // repeater

// ── Image de fond ─────────────────────────────────────────────────────────────
$bg_style = '';
if ( ! empty( $image_fond['url'] ) ) {
    $bg_style = ' style="background-repeat: no-repeat; background-size: cover; background-position: center; background-image: url(' . esc_url( $image_fond['url'] ) . ');"';
}
?>

<section class="defaut-section" id="engagements">
  <div class="container">
    <span class="sur-titre">[ OBJECTIFS ]</span>
    <h2 class="h2"><span class="green">Engagements</span></h2>
    <p class="description"><strong>Yence Consulting</strong> place <strong>l’accès aux soins</strong> et la <strong>responsabilité environnementale</strong> au cœur de son engagement.</p>
    <?php get_template_part('templates/button', null, ['label' => 'Découvrez nos domaines d’intervention', 'url' => '#engagements', 'variant' => 'primary']); //variation : primary / secondary?>
  </div>
</section>

<section class="section-engagements"<?php echo $bg_style; ?>>
    <div class="container">
`
        <?php /* ── Liste des engagements (repeater) ── */ ?>
        <?php if ( ! empty( $eng_liste ) ) : ?>
            <ul class="section-engagements__liste">

                <?php foreach ( $eng_liste as $item ) : ?>
                    <li class="section-engagements__item" style="--data-color: <?php echo esc_attr( $item['couleur_principale'] ?? '' ); ?>;">
 
                     

                        <?php if ( ! empty( $item['titre'] ) ) : ?>
                            <h3 class="section-engagements__item-titre h3">
                                <?php echo esc_html( $item['titre'] ); ?>
                            </h3>
                        <?php endif; ?>
                           <?php if ( ! empty( $item['picto'] ) ) : ?>
                            <div class="section-engagements__item-picto">
                                <img
                                    src="<?php echo esc_url( $item['picto'] ); ?>"
                                    alt="<?php echo esc_attr( $item['titre'] ?? '' ); ?>"
                                    loading="lazy"
                                    aria-hidden="true"
                                >
                            </div>
                        <?php endif; ?>

                        <?php if ( ! empty( $item['description'] ) ) : ?>
                            <div class="section-engagements__item-description">
                                <?php echo wp_kses_post( $item['description'] ); ?>
                            </div>
                        <?php endif; ?>
                        

                        <?php if ( ! empty( $item['titre2'] ) ) : ?>
                            <hr>
                            <h3 class="section-engagements__item-titre h3">
                                <?php echo esc_html( $item['titre2'] ); ?>
                            </h3>
                        <?php endif; ?>

                        <?php if ( ! empty( $item['description2'] ) ) : ?>
                            <div class="section-engagements__item-description">
                                <?php echo wp_kses_post( $item['description2'] ); ?>
                            </div>
                        <?php endif; ?>

                    </li>
                <?php endforeach; ?>

            </ul><!-- /.section-engagements__liste -->
        <?php endif; ?>

        

    </div><!-- /.container -->
</section><!-- /.section-engagements -->
