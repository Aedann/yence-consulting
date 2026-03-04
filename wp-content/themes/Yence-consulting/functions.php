<?php
if (!defined('ABSPATH')) exit;

/**
 * Theme setup
 */
function wpdefaut_setup() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('html5', ['search-form','comment-form','comment-list','gallery','caption','style','script']);
  register_nav_menus([
    'primary' => __('Menu principal', 'wp-defaut'),
    'footer'  => __('Menu pied de page', 'wp-defaut'),
  ]);
}
add_action('after_setup_theme', 'wpdefaut_setup');

/**
 * Assets enqueue (vanilla JS + external vendor CDNs for performance)
 * You can swap CDNs for local files later if preferred.
 */
function wpdefaut_assets() {
  // Swiper CSS
  wp_enqueue_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', [], '11');

  // Theme CSS (compiled)
  $css_path = get_template_directory() . '/assets/css/main.css';
  $css_uri  = get_template_directory_uri() . '/assets/css/main.css';
  wp_enqueue_style('wpdefaut', $css_uri, ['swiper'], filemtime($css_path));

  // Vendor JS (placed in footer)
  wp_enqueue_script('gsap', 'https://cdn.jsdelivr.net/npm/gsap@3/dist/gsap.min.js', [], '3', true);
  wp_enqueue_script('lenis', 'https://cdn.jsdelivr.net/npm/@studio-freight/lenis@1.0.41/bundled/lenis.min.js', [], '1.0.41', true);
  wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', [], '11', true);

  // Theme JS
  $js_path = get_template_directory() . '/assets/js/main.js';
  $js_uri  = get_template_directory_uri() . '/assets/js/main.js';
  wp_enqueue_script('wpdefaut', $js_uri, ['gsap','lenis','swiper'], filemtime($js_path), true);
}
add_action('wp_enqueue_scripts', 'wpdefaut_assets');

/**
 * Preload critical fonts for better performance
 * Improves First Contentful Paint (FCP) and reduces font-loading delay
 */
function wpdefaut_preload_fonts() {
  $fonts = [
    // Variable font - priorité maximale (couvre tous les poids)
    [
      'href' => get_template_directory_uri() . '/assets/fonts/Josefin_Sans/JosefinSans-VariableFont_wght.ttf',
      'type' => 'font/ttf'
    ],
    // Italique variable
    [
      'href' => get_template_directory_uri() . '/assets/fonts/Josefin_Sans/JosefinSans-Italic-VariableFont_wght.ttf',
      'type' => 'font/ttf'
    ]
  ];

  foreach ($fonts as $font) {
    echo '<link rel="preload" href="' . esc_url($font['href']) . '" as="font" type="' . esc_attr($font['type']) . '" crossorigin>' . "\n";
  }
}
add_action('wp_head', 'wpdefaut_preload_fonts', 1);

/**
 * Register Custom Post Types
 */
function wpdefaut_register_cpts() {


   // Services
  register_post_type('service', [
    'labels' => [
      'name' => __('Services', 'wp-defaut'),
      'singular_name' => __('Services', 'wp-defaut'),
      'add_new_item' => __('Ajouter un service', 'wp-defaut'),
      'edit_item' => __('Modifier le service', 'wp-defaut'),
      'menu_name' => __('Services', 'wp-defaut'),
    ],
    'public' => true,
    'has_archive' => true,
    'menu_position' => 21,
    'menu_icon' => 'dashicons-building',
    'supports' => ['title','editor','thumbnail','excerpt','revisions'],
    'rewrite' => ['slug' => 'service'],
    'show_in_rest' => true
  ]);

}
add_action('init', 'wpdefaut_register_cpts');



/**
 * Create demo content on theme activation (3 of each CPT) if none exist.
 */
function wpdefaut_maybe_create_demo_content() {
  if (!current_user_can('manage_options')) return;

  // Avoid re-seeding if already done
  if (get_option('wpdefaut_demo_seeded')) return;

  // Helper to create posts
  $lipsum = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer facilisis.";


  // Create base pages if not exist
  $pages = [
    'Accueil' => ['slug' => 'accueil', 'template' => 'front-page.php'],
    'Contact' => ['slug' => 'contact', 'template' => 'templates/page-contact.php'],
    'Projets' => ['slug' => 'projets', 'template' => 'templates/page-projets.php'],
  ];
  foreach ($pages as $title => $data) {
    if (!get_page_by_path($data['slug'])) {
      $pid = wp_insert_post([
        'post_type' => 'page',
        'post_title' => $title,
        'post_name' => $data['slug'],
        'post_status' => 'publish',
        'meta_input' => ['_wp_page_template' => $data['template']]
      ]);
    }
  }

  // Set front page if "Accueil" exists
  $front = get_page_by_path('accueil');
  if ($front) {
    update_option('show_on_front', 'page');
    update_option('page_on_front', $front->ID);
  }

  update_option('wpdefaut_demo_seeded', 1);
}
add_action('after_switch_theme', 'wpdefaut_maybe_create_demo_content');

/**
 * Clean body class
 */
function wpdefaut_body_class($classes){
  $classes = array_filter($classes);
  return $classes;
}
add_filter('body_class', 'wpdefaut_body_class');


