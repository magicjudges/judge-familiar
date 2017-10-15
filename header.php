<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Judge_Familiar
 */

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="apple-touch-icon" sizes="57x57" href="/wp-content/themes/judge-familiar/images/apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="/wp-content/themes/judge-familiar/images/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="/wp-content/themes/judge-familiar/images/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="/wp-content/themes/judge-familiar/images/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="/wp-content/themes/judge-familiar/images/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="/wp-content/themes/judge-familiar/images/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="/wp-content/themes/judge-familiar/images/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="/wp-content/themes/judge-familiar/images/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="/wp-content/themes/judge-familiar/images/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192"  href="/wp-content/themes/judge-familiar/images/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="/wp-content/themes/judge-familiar/images/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="/wp-content/themes/judge-familiar/images/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="/wp-content/themes/judge-familiar/images/favicon-16x16.png">
		<link rel="manifest" href="/wp-content/themes/judge-familiar/manifest.json">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="/wp-content/themes/judge-familiar/images/ms-icon-144x144.png">
		<meta name="theme-color" content="#ffffff">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

		<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php
		if ( function_exists('judge_banner') ) :
			judge_banner();
		endif;
	?>
	<div id="page" class="hfeed site container">
		<a class="skip-link sr-only" href="#content"><?php esc_html_e( 'Skip to content', 'judge-familiar' ); ?></a>

		<header id="masthead" class="row site-header" role="banner">
			<div class="site-info col-xs-12">
				<h1 class="site-title col-md-6">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
				</h1>
				<p class="site-description col-md-6">
					<span><?php bloginfo( 'description' ); ?></span>
				</p>
			</div>

			<?php if ( has_header_image() ): ?>
				<div class="site-header-image">
					<img 	class="col-lg-12"
								src="<?php header_image(); ?>"
								width="<?php echo get_theme_support( 'custom-header', 'width' ) ?>"
								height="<?php echo get_theme_support( 'custom-header', 'height' ) ?>"
								alt="Header Image"
					/>
				</div>
			<?php endif; ?>

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<div class="col-lg-9 col-xs-7 primary-menu">
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
	    		<span></span>
	    		<span></span>
	    		<span></span>
	  		</button>
				<?php wp_nav_menu( array(
					'theme_location' => 'primary',
					'menu_id' => 'primary-menu',
				 	'depth' => 3
				) ); ?>
			</div>
			<div class="col-lg-3 col-xs-5 secondary-menu">
				<?php wp_nav_menu( array(
					'theme_location' => 'language',
					'menu_id' => 'secondary-menu',
				 	'depth' => 1
				) ); ?>
			</div>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="row site-content">
