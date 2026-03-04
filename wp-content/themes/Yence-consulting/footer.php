</main>
<footer>
  <div class="container">

      <!-- 🔹 Col 1 : Logo + Copyright -->
      <div class="col footer-logo">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="footer-brand">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-main.svg" alt="Yence Consulting">
        </a>
        <p class="footer-copy">
          &copy; <?php echo date('Y'); ?> Yence Consulting
        </p>
      </div>

      <!-- 🔹 Col 2 : Menu principal du footer -->
      <div class="col footer-menu">
        <p class="footer-title h3">Menu</p>
        <?php
        wp_nav_menu([
          'theme_location'  => 'footer',
          'container'       => 'nav',
          'container_class' => 'footer-nav',
          'menu_class'      => 'footer-menu-list',
        ]);
        ?>
      </div>

        <!-- 🔹 Col 4 : Services -->
        <div class="col footer-services">
          <p class="footer-title h3">Services</p>
          <ul class="footer-menu-list">
            <?php
            $services = get_posts([
          'post_type'      => 'service',
          'posts_per_page' => -1,
          'orderby'        => 'title',
          'order'          => 'ASC',
            ]);
            foreach ($services as $service) :
          echo '<li><a href="' . get_permalink($service) . '">' . esc_html($service->post_title) . '</a></li>';
            endforeach;
            ?>
          </ul>
        </div>
        <div class="col footer-infos">
          <p class="footer-title h3">Yence Consulting</p>
          <ul class="footer-menu-list">
            <li>33 000 Bordeaux</li>
            <li><a href="mailto:eric.demonio@gmail.com">eric.demonio@gmail.com</a></li>
            <li><a href="https://www.yence-consulting.com">www.yence-consulting.com</a></li>
            <li>Tél :<a href="tel:+33624254502">06 24 25 45 02</a></li>
            <li><a href="https://linkedin.com" target="_blank">Linkedin</a></li>
          </ul>
        </div>
        <div class="col footer-infos">
          <ul class="footer-menu-list">
            <li class="little">Activité hébergée par la Couveuse Anabase :</li>
            <li><a href="https://anabase-mie.org/" target="_blank">Couveuse ANABASE</a></li>
            <li>180 Rue Judaïque</li>
            <li>33000 Bordeaux <br>Tél :<a href="tel:+33556431186">05 56 43 11 86</a></li>
            <li>Siret : 514 548 957 00034</li>
            <li>TVA Intra/FR38514548957</li>
          </ul>
        </div>



  </div> <!-- /.container -->
</footer>

<?php wp_footer(); ?>
</body>
</html>
