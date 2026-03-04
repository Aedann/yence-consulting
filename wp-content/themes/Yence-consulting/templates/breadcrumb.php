  <?php 
    $color = $args['color'] ?? null;
  ?>
  
  
  <div class="breadcrumb <?php echo $color; ?>" id="breadcrumb">
    <?php 
    if ( function_exists('bcn_display') ) {
      bcn_display();
  }
    ?>
  </div>