<?php
/**
 * @since 1.0.0
 * @version 1.0.0
 */
?>
<!DOCTYPE html>
<html lang="it">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo get_bloginfo( 'name' ); ?></title>

	<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>
    <header>
      <a href="<?php echo ITAS_URL?>"> <img src="<?php echo ITAS_INCLUDES."img/logo.png"?>" alt="Logo" class="logo"> </a>
      <div class="hamburger">
		<span></span>
		<span></span>
		<span></span>
		<span></span>
	</div>
      <?php
		wp_nav_menu( ( [
			'theme_location' => 'main_menu',
			'container' => 'nav',
			'container_id' => '',
			'container_class' => '',
			'menu_id' => '',
			'menu_class' => ''
		]) ); ?>
    </header>