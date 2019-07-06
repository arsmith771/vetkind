<?php
/**
 * vetkind.
 *
 * This file adds functions to the Vetkind theme (built on Genesis Sample Theme).
 *
 * @package vetkind
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

// Starts the engine.
require_once get_template_directory() . '/lib/init.php';

// Defines the child theme (do not remove).
define( 'CHILD_THEME_NAME', 'vetkind' );
define( 'CHILD_THEME_URL', '' );
define( 'CHILD_THEME_VERSION', '2.7.0' );

// Sets up the Theme.
require_once get_stylesheet_directory() . '/lib/theme-defaults.php';

add_action( 'after_setup_theme', 'genesis_sample_localization_setup' );
/**
 * Sets localization (do not remove).
 *
 * @since 1.0.0
 */
function genesis_sample_localization_setup() {

	load_child_theme_textdomain( 'genesis-sample', get_stylesheet_directory() . '/languages' );

}

// Adds helper functions.
require_once get_stylesheet_directory() . '/lib/helper-functions.php';

// Adds image upload and color select to Customizer.
require_once get_stylesheet_directory() . '/lib/customize.php';

// Includes Customizer CSS.
require_once get_stylesheet_directory() . '/lib/output.php';

// Adds WooCommerce support.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php';

// Adds the required WooCommerce styles and Customizer CSS.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php';

// Adds the Genesis Connect WooCommerce notice.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php';

add_action( 'after_setup_theme', 'genesis_child_gutenberg_support' );
/**
 * Adds Gutenberg opt-in features and styling.
 *
 * @since 2.7.0
 */
function genesis_child_gutenberg_support() { // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- using same in all child themes to allow action to be unhooked.
	require_once get_stylesheet_directory() . '/lib/gutenberg/init.php';
}

add_action( 'wp_enqueue_scripts', 'genesis_sample_enqueue_scripts_styles' );
/**
 * Enqueues scripts and styles.
 *
 * @since 1.0.0
 */
function genesis_sample_enqueue_scripts_styles() {

	wp_enqueue_style( 'dashicons' );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script(
		'genesis-sample-responsive-menu',
		get_stylesheet_directory_uri() . "/js/responsive-menus{$suffix}.js",
		array( 'jquery' ),
		CHILD_THEME_VERSION,
		true
	);

	wp_localize_script(
		'genesis-sample-responsive-menu',
		'genesis_responsive_menu',
		genesis_sample_responsive_menu_settings()
	);

	wp_enqueue_script(
		'genesis-sample',
		get_stylesheet_directory_uri() . '/js/genesis-sample.js',
		array( 'jquery' ),
		CHILD_THEME_VERSION,
		true
	);

	wp_enqueue_script(
		'main-js',
		get_stylesheet_directory_uri() . '/js/main.min.js',
		array( 'jquery' ),
		CHILD_THEME_VERSION,
		true
	);

}

/**
 * Defines responsive menu settings.
 *
 * @since 2.3.0
 */
function genesis_sample_responsive_menu_settings() {

	$settings = array(
		'mainMenu'         => __( 'Menu', 'genesis-sample' ),
		'menuIconClass'    => 'dashicons-before dashicons-menu',
		'subMenu'          => __( 'Submenu', 'genesis-sample' ),
		'subMenuIconClass' => 'dashicons-before dashicons-arrow-down-alt2',
		'menuClasses'      => array(
			'combine' => array(
				'.nav-primary',
			),
			'others'  => array(),
		),
	);

	return $settings;

}

// Adds support for HTML5 markup structure.
add_theme_support(
	'html5',
	array(
		'caption',
		'comment-form',
		'comment-list',
		'gallery',
		'search-form',
	)
);

// Adds support for accessibility.
add_theme_support(
	'genesis-accessibility',
	array(
		'404-page',
		'drop-down-menu',
		'headings',
		'search-form',
		'skip-links',
	)
);

// Adds viewport meta tag for mobile browsers.
add_theme_support(
	'genesis-responsive-viewport'
);

// Adds custom logo in Customizer > Site Identity.
add_theme_support(
	'custom-logo',
	array(
		'height'      => 120,
		'width'       => 700,
		'flex-height' => true,
		'flex-width'  => true,
	)
);

// Renames primary and secondary navigation menus.
add_theme_support(
	'genesis-menus',
	array(
		'primary'   => __( 'Header Menu', 'genesis-sample' ),
		'secondary' => __( 'Footer Menu', 'genesis-sample' ),
	)
);

// Adds image sizes.
add_image_size( 'sidebar-featured', 75, 75, true );
add_image_size( 'square-small', 360, 360, true );

// Adds support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Adds support for 3-column footer widgets.
add_theme_support( 'genesis-footer-widgets', 3 );

// Removes header right widget area.
unregister_sidebar( 'header-right' );

// Removes secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Removes site layouts.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

// Removes output of primary navigation right extras.
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

add_action( 'genesis_theme_settings_metaboxes', 'genesis_sample_remove_metaboxes' );
/**
 * Removes output of unused admin settings metaboxes.
 *
 * @since 2.6.0
 *
 * @param string $_genesis_admin_settings The admin screen to remove meta boxes from.
 */
function genesis_sample_remove_metaboxes( $_genesis_admin_settings ) {

	remove_meta_box( 'genesis-theme-settings-header', $_genesis_admin_settings, 'main' );
	remove_meta_box( 'genesis-theme-settings-nav', $_genesis_admin_settings, 'main' );

}

add_filter( 'genesis_customizer_theme_settings_config', 'genesis_sample_remove_customizer_settings' );
/**
 * Removes output of header settings in the Customizer.
 *
 * @since 2.6.0
 *
 * @param array $config Original Customizer items.
 * @return array Filtered Customizer items.
 */
function genesis_sample_remove_customizer_settings( $config ) {

	unset( $config['genesis']['sections']['genesis_header'] );
	return $config;

}

// Displays custom logo.
add_action( 'genesis_site_title', 'the_custom_logo', 0 );

// Repositions primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

// Repositions the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 10 );

add_filter( 'wp_nav_menu_args', 'genesis_sample_secondary_menu_args' );
/**
 * Reduces secondary navigation menu to one level depth.
 *
 * @since 2.2.3
 *
 * @param array $args Original menu options.
 * @return array Menu options with depth set to 1.
 */
function genesis_sample_secondary_menu_args( $args ) {

	if ( 'secondary' !== $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;
	return $args;

}

add_filter( 'genesis_author_box_gravatar_size', 'genesis_sample_author_box_gravatar' );
/**
 * Modifies size of the Gravatar in the author box.
 *
 * @since 2.2.3
 *
 * @param int $size Original icon size.
 * @return int Modified icon size.
 */
function genesis_sample_author_box_gravatar( $size ) {

	return 90;

}

add_filter( 'genesis_comment_list_args', 'genesis_sample_comments_gravatar' );
/**
 * Modifies size of the Gravatar in the entry comments.
 *
 * @since 2.2.3
 *
 * @param array $args Gravatar settings.
 * @return array Gravatar settings with modified size.
 */
function genesis_sample_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;
	return $args;

}

//* Remove the edit link in posts/pages
add_filter ( 'genesis_edit_post_link' , '__return_false' );


// Add user role class to body tag
add_filter('body_class','add_role_to_body');
function add_role_to_body($classes) {
    global $current_user;
    $user_role = $current_user->roles;
    return array_merge( $classes, array( $user_role[0] ) );
}

// Admin css
add_action('admin_enqueue_scripts', 'admin_styles');
function admin_styles() {
    wp_enqueue_style('backend-admin', get_stylesheet_directory_uri() . '/admin.css');
}

//* ----------------- Social media icons - header -----------------------


add_action('genesis_header', 'header_12', 10 );
function header_12(){

		echo '<div class="social-media-btns"><a href="https://www.facebook.com/vetkind.co.uk/" class="social-media-btns__facebook" title="Visit us on Facebook" target="_blank">Facebook</a></div>';

		/*
		echo '<div class="social-media-btns"><a href="https://www.facebook.com/vetkindedinburgh/" class="social-media-btns__facebook" title="Visit us on Facebook" target="_blank">Facebook</a> <a href="#" class="social-media-btns__instagram" title="Visit us on Instagram">Instagram</a></div>';
		 */

}


//----------------------  Generic page -----------------------
add_action('genesis_entry_content', 'default_row_10', 10 );
function default_row_10(){

	if ( is_page_template( 'generic.php') ){

		echo '<div class="row row--bg2"><div class="wrap">' . types_render_field( 'default-content', array() ) . '</div></div>';
	}
}

//----------------------  Home page -----------------------
add_action('genesis_entry_content', 'homepage_row_10', 10 );
function homepage_row_10(){

	if ( is_page_template( 'homepage.php') ){

		echo '<div class="row row--bg2 intro"><div class="wrap-3">' . types_render_field( 'home-intro-text', array() ) . '<p><a href="#five-reasons" id="toggle-3" class="toggle-2">Here’s five great reasons for you and your pet to use Vetkind</a></p></div><div class="wrap-3"><div id="five-reasons" class="block-6 hide-show">' . types_render_field( 'home-reasons', array() ) . '</div></div></div>';
	}
}

add_action('genesis_entry_content', 'homepage_row_11', 11 );
function homepage_row_11(){

	if ( is_page_template( 'homepage.php') ){

		echo '<div class="row row--p0"><div class="wrap-3"><h2 class="section-title">Our Services</h2><p class="intro" style="margin-bottom:3em; text-align:center;">Vetkind offers everything you would expect from a vet and more. <br>Here\'s just some of the services we offer.</p></div></div>';
		echo '<div class="row row--bg2"><div class="wrap">' . do_shortcode('[wpv-view name="services-listing"]') . '</div></div>';
	}
}

add_action('genesis_entry_content', 'homepage_row_12', 12 );
function homepage_row_12(){

	if ( is_page_template( 'homepage.php') ){

		echo '<div class="row row--p0"><div class="wrap"><h2 class="section-title">Meet the vets</h2></div></div>';
		echo '<div class="row row--pt0 row--bg5">
				<div class="wrap">
					<div class="dflex dflex--space-between">
						<article class="block-1"><figure class="block-1__inner">' . types_render_field( 'mhairi-photo', array('size' => 'thumbnail', 'alt'=>'Photo of Mhairi', 'class'=>'block-1__inner__img') ) . '<figcaption class="limited-view">' . types_render_field( 'mhairi-text', array() ) . '<span class="toggle-1"><a href="#" id="toggle-1">Show more</a></span></figcaption></figure></article>
						<article class="block-1"><figure class="block-1__inner">' . types_render_field( 'martha-photo', array('size' => 'thumbnail', 'alt'=>'Photo of Martha', 'class'=>'block-1__inner__img') ) . '<figcaption class="limited-view">' . types_render_field( 'martha-text', array() ) . '<span class="toggle-1"><a href="#" id="toggle-2">Show more</a></span></figcaption></figure></article>
					</div>
				</div>
			</div>';
	}
}

add_action('genesis_entry_content', 'homepage_row_13', 13 );
function homepage_row_13(){

	if ( is_page_template( 'homepage.php') ){

		echo '<div class="row row--bg3 row--tac"><div class="wrap intro"><h2 class="section-title" style="padding-top: 0;">Book your appointment</h2>
			<p>You can book an appointment using our online form.</p><a href="' . home_url() . '/book-your-appointment/"><button class="book-btn">Book your appointment</button></a></div></div>';
	}
}

add_action('genesis_entry_content', 'homepage_row_14', 14 );
function homepage_row_14(){

	if ( is_page_template( 'homepage.php') ){

		echo '<div class="row row--bg1 row--mb0 row--pb0 row--mt6 row--deco-3"><div class="wrap"><h2 class="section-title">Meet some of our happy pets</h2></div></div>
		<div class="row row--bg1 row--mt0 row--pt1"><div class="wrap">' . do_shortcode('[wpv-view name="meet-happy-pets"]') .'</div></div>';
	}
}
//----------------------  Price Guide page -----------------------

add_action('genesis_entry_content', 'price_guide_row_10', 10 );
function price_guide_row_10(){

	if ( is_page_template( 'price-guide.php') ){

		echo '<div class="row row--m0 row--pt1"><div class="wrap-3 intro">' . types_render_field( 'prices-intro-text', array() ) . '</div></div>';
	}
}

add_action('genesis_entry_content', 'price_guide_row_11', 11 );
function price_guide_row_11(){

	if ( is_page_template( 'price-guide.php') ){

		echo '<div class="row  row--m0 row--bg3"><div class="wrap">' . do_shortcode('[wpv-view name="price-guide"]') .'</div><div class="wrap">' . types_render_field( 'footnotes-for-prices', array() ) . '</div></div>';
	}
}

add_action('genesis_entry_content', 'price_guide_row_12', 12 );
function price_guide_row_12(){

	if ( is_page_template( 'price-guide.php') ){

		echo '<div class="row row--m0"><div class="wrap"><div class="dflex dflex--space-between"><div class="block-1"><h2 class="section-title section-title--mb">' . types_render_field( 'price-guide-header-left', array() ) . '</h2>' . types_render_field( 'price-guide-text-left', array() ) . '</div><div class="block-1"><h2 class="section-title section-title--mb">' . types_render_field( 'price-guide-header-right', array() ) . '</h2>' . types_render_field( 'price-guide-text-right', array() ) . '</div></div></div></div>';
	}
}

// ----------------- Services landing page --------------------
add_action('genesis_entry_content', 'services_landing_view', 10 );
function services_landing_view(){

	if ( is_page_template( 'services-landing.php') ){

		echo do_shortcode('[wpv-view name="services-landing"]');
		//echo 'xxxxxxxxxxxxxxxxxxxx';
	}
}


//-------------- Repeat Medication page ----------------------

add_action('genesis_entry_content', 'order_repeat_medi_10', 10);
function order_repeat_medi_10(){

	if ( is_page_template( 'order-repeat.php') ){

		echo '<div class="row row--m0 row--pt1"><div class="wrap-3 intro">' . types_render_field( 'repeat-pres-intro', array() ) . '</div></div>';
	}
}

add_action('genesis_entry_content', 'order_repeat_medi_11', 11 );
function order_repeat_medi_11(){

	if ( is_page_template( 'order-repeat.php') ){

		echo '<div class="row row--bg2 row--m0"><div class="wrap intro">' . do_shortcode('[contact-form-7 id="71" title="Contact form 1"]') .'</div></div>';
	}
}

//-------------- FAQs page ----------------------

add_action('genesis_entry_content', 'faqs_10', 10 );
function faqs_10(){

	if ( is_page_template( 'faqs-page.php') ){

		echo '<div class="row row--bg0"><div class="wrap"><div class="dflex dflex--space-between">
			<div class="block-1">' . do_shortcode('[wpv-view name="faqs"]') .'</div>
			<div class="block-1">' . do_shortcode('[wpv-view name="faq-right"]') .'</div>
			</div></div></div>';
	}
}

//-------------- Contact page ----------------------

add_action('genesis_entry_content', 'contact_page_10', 10 );
function contact_page_10(){

	if ( is_page_template( 'contact-page.php') ){

		echo '<div class="row row--bg3"><div class="wrap-3 intro">' . types_render_field( 'contact-content', array() ) . '</div></div>';
	}
}

add_action('genesis_header', 'output_deco_1' );
function output_deco_1(){

	echo '<span class="deco-1"></span>';

}

//* Output banner image & strapline
add_action('genesis_after_header', 'output_hero_image' );
function output_hero_image(){

	if ( !is_page_template( 'generic.php') && !is_404() ){
		echo '<div class="banner" role="banner"><p class="banner__strapline">Home visit vets <span class="banner__strapline-2">Serving Edinburgh &amp; surrounding areas</span></p></div>';
	}

}

//* Book appointment row (all pages)
add_action('genesis_before_footer', 'book_appointment_cta' );
function book_appointment_cta(){

	echo '<div class="row row--book-apt row--pt0 row--mt0 row--tac row--pb60"><div class="wrap"><a href="' . home_url() . '/book-your-appointment/"><button class="book-btn">Book your appointment</button></a></div></div>';

}

//* Output footer content
add_filter('genesis_footer_creds_text', 'sp_footer_creds_filter');
function sp_footer_creds_filter( $creds ) {
	$creds = '<p>Copyright ' . do_shortcode('[footer_copyright]') . ' Vetkind Ltd. <br />Registered office address: Vetkind Ltd, 9 Caiystane Drive, Edinburgh EH10 6SS, UK.<br /> Registered company number: SC610422<br><br><a href="' . home_url() . '/terms-conditions/" class="menu-footer__lnk">Terms &amp; conditions</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="' . home_url() . '/privacy-policy/" class="menu-footer__lnk">Privacy policy</a></p>';

	return $creds;
}


//--------------  Disable the emoji's ------------------

function disable_emojis() {
 remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
 remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
 remove_action( 'wp_print_styles', 'print_emoji_styles' );
 remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
 remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
 remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
 remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
 add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
 add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'disable_emojis' );

/**
 * Filter function used to remove the tinymce emoji plugin.
 * 
 * @param array $plugins 
 * @return array Difference betwen the two arrays
 */
function disable_emojis_tinymce( $plugins ) {
 if ( is_array( $plugins ) ) {
 return array_diff( $plugins, array( 'wpemoji' ) );
 } else {
 return array();
 }
}

/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 *
 * @param array $urls URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array Difference betwen the two arrays.
 */
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
 if ( 'dns-prefetch' == $relation_type ) {
 /** This filter is documented in wp-includes/formatting.php */
 $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );

$urls = array_diff( $urls, array( $emoji_svg_url ) );
 }

return $urls;
}