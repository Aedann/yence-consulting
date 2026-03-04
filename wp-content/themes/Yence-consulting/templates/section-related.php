
  <section class="service-related">
  <div class="bg-image">
                        <img
                            src="<?php echo get_the_post_thumbnail_url(); ?>"
                            alt="<?php echo get_the_title(); ?>"
                            loading="lazy"
                        >
                    </div>
        <div class="container">
            <h2 class="service-related__titre h2">Nos services</h2>
            
            <?php
            $type = $args['type'] ?? 'notin';

            $args = array(
                'post_type'      => 'service',
                'posts_per_page' => -1,
                'post__not_in'   => array( get_the_ID() ),
            );
            
            if ( $type === 'all' ) {
                unset( $args['post__not_in'] );
            }
            
            $services = new WP_Query( $args );
            
            if ( $services->have_posts() ) :
            ?>
                <div class="service-related__liste">
                    <?php while ( $services->have_posts() ) : $services->the_post(); ?>
                        <a href="<?php the_permalink(); ?>" class="service-related__item">
                            <h3>Découvrez </br><span style="font-size:inherit;color: <?php echo esc_attr( get_field( 'couleur_principale' ) ); ?>;"><?php the_title(); ?></span></h3>
                            <div class="img-container"><img src="<?php the_field("image")?>" alt="<?php the_title(); ?>"><span style="background-color: <?php echo esc_attr( get_field( 'couleur_principale' ) ); ?>;">
    <svg id="Calque_2" data-name="Calque 2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 83.82 115.83">
  <defs>
  </defs>
  <g id="diagnosticContainer">
    <g>
      <path class="cls-1" fill="#ffffff"d="M16.69,0H1.59C.85,0,.45.85.27,1.34c-.33.9-.45,2.4.17,3.6l23.26,45.99c2.08,4.1,2.08,9.83,0,13.95L.44,110.87C.12,111.49,0,112.19,0,112.84s.11,1.21.27,1.65c.18.49.58,1.34,1.32,1.34h15.1c.43,0,.85-.35,1.15-.94l27.79-54.97c.57-1.15.57-2.87,0-4.01L17.84.94C17.53.34,17.12,0,16.69,0Z"/>
      <path class="cls-1" fill="#ffffff" d="M82.08,52.74l-19.64-29.99c-1.53-2.33-4.26-.77-4.28,2.45l-.03,20.78,4.56,9.59c.55,1.15.52,2.87-.08,4l-4.51,8.4-.03,21.78c0,3.13,2.6,4.76,4.17,2.61l19.58-26.63c2.57-3.49,2.68-9.32.26-13.01Z"/>
    </g>
  </g>
</svg>
</span></div>
                            
                            <?php the_excerpt(); ?>
                        </a>
                    <?php endwhile; ?>
                </div>
            <?php
            endif;
            wp_reset_postdata();
            ?>
        </div>
    </section>