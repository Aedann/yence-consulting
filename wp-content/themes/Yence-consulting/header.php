<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<!-- Menu Overlay (Mobile) -->
<div class="menu-overlay"></div>

<header class="site-header">
  <div class="header-container">
    <!-- Logo -->
    <a class="logo" href="<?php echo esc_url(home_url('/')); ?>">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-main.svg" alt="Yence Consulting">
    </a>

    <!-- Burger Menu Icon (Mobile) -->
    <button class="burger-menu" aria-label="Menu" aria-expanded="false">
      <span></span>
      <span></span>
      <span></span>
    </button>

    <!-- Navigation -->
    <nav class="main-nav">
      <?php
        wp_nav_menu([
          'theme_location' => 'primary',
          'container' => false,
          'menu_class' => 'nav-menu',
          'fallback_cb' => false,
        ]);
      ?>
      <?php get_template_part('templates/button', null, ['label' => 'Nous contacter', 'url' => '/contact', 'variant' => 'primary']); //variation : primary / secondary?>
    </nav>

    <!-- Contact Button with Phone Icon -->
    <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" class="contact-btn">
      <span class="contact-text">Contact</span>
      <svg class="phone-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
      </svg>
    </a>
  </div>
</header>
<main class="site-main">

