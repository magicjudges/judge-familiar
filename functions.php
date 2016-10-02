<?php
/**
 * Judge Familiar functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Judge_Familiar
 */

if ( ! function_exists( 'judge_familiar_setup' ) ) :

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function judge_familiar_setup() {
	load_theme_textdomain( 'judge-familiar', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );

	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 125, 125 );

	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'judge-familiar' ),
		'footer' => esc_html__( 'Footer Menu', 'judge-familiar' ),
		'language' => esc_html__( 'Language Navigation', 'judge-familiar' ),
		'language-single' => esc_html__( 'Language Navigation Single', 'judge-familiar' )
	) );

	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	add_theme_support( 'custom-background', apply_filters( 'judge_familiar_custom_background_args', array(
		'default-color' => 'f1f1f1',
		'default-image' => '',
	) ) );

	add_theme_support( 'custom-header', array(
		'width'					=>	980,
		'height'				=>	190
	) );

	if ( ! get_theme_mod( 'show_excerpts' ) ) {
		set_theme_mod( 'show_excerpts', 'excerpts' );
	}

	add_filter( 'get_the_excerpt', 'do_shortcode' );
}
endif; // judge_familiar_setup
add_action( 'after_setup_theme', 'judge_familiar_setup' );

if ( ! function_exists( 'judge_familiar_page_navigation_box' ) ) :
	function judge_familiar_page_navigation_box( $page ) {
		wp_enqueue_style(
			'judge-familiar-stacked-pills',
   			get_template_directory_uri().'/css/page-navigation.css'
   		);

		wp_nonce_field(
			'judge_familiar_page_navigation_box',
			'judge_familiar_page_navigation_box_nonce'
		);

		$prev = get_post_meta( $page->ID, '_previous_page', true );
		$next = get_post_meta( $page->ID, '_next_page', true );
		$prev_title = get_post_meta( $page->ID, '_previous_page_title', true );
		$next_title = get_post_meta( $page->ID, '_next_page_title', true );
?>
		<div class="page_navigation_input">
			<label for="page_navigation_input_prev">Previous Page</label>
			<input id="page_navigation_input_prev" name="page_navigation_input_prev" type="number" value="<?= $prev ?>" placeholder="Page ID"/><input
				id="page_navigation_input_prev_title" name="page_navigation_input_prev_title" type="text" value="<?= $prev_title ?>" placeholder="Page Title" />
		</div>

		<div class="page_navigation_input">
			<label for="page_navigation_input_next">Next Page</label>
			<input id="page_navigation_input_next" name="page_navigation_input_next" type="number" value="<?= $next ?>" placeholder="Page ID"/><input
				id="page_navigation_input_next_title" name="page_navigation_input_next_title" type="text" value="<?= $next_title ?>" placeholder="Page Title" />
		</div>
<?php
	}

	function judge_familiar_register_meta_boxes_save( $page_id ) {
		if ( ! isset( $_POST['judge_familiar_page_navigation_box_nonce'] ) ) {
			return $page_id;
		}

		if ( ! wp_verify_nonce(
			$_POST['judge_familiar_page_navigation_box_nonce'],
			'judge_familiar_page_navigation_box' )
		) {
			return $page_id;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $page_id;
		}

		if ( ! current_user_can( 'edit_post', $page_id ) ) {
			return $page_id;
		}

		if ( isset( $_POST['page_navigation_input_prev'] ) &&
				 strlen( $_POST['page_navigation_input_prev']) > 0
		) {
			update_post_meta(
				$page_id,
				'_previous_page',
				intval( $_POST['page_navigation_input_prev'] )
			);
			update_post_meta(
				$page_id,
				'_previous_page_title',
				strip_tags( $_POST['page_navigation_input_prev_title'] )
			);
		} else {
			delete_post_meta( $page_id, '_previous_page' );
			delete_post_meta( $page_id, '_previous_page_title' );
		}

		if ( isset( $_POST['page_navigation_input_next'] ) &&
				 strlen( $_POST['page_navigation_input_next']) > 0
		) {
			update_post_meta(
				$page_id,
				'_next_page',
				intval( $_POST['page_navigation_input_next'] )
			);
			update_post_meta(
				$page_id,
				'_next_page_title',
				strip_tags( $_POST['page_navigation_input_next_title'] )
			);
		} else {
			delete_post_meta( $page_id, '_next_page' );
			delete_post_meta( $page_id, '_next_page_title' );
		}

		return $page_id;
	}
endif;

function judge_familiar_register_meta_boxes() {
	add_meta_box(
		'page_navigation',
		__('Page Navigation', 'judge_familiar'),
		'judge_familiar_page_navigation_box',
		'page',
		'side'
	);
}
add_action( 'add_meta_boxes_page', 'judge_familiar_register_meta_boxes' );
add_action( 'save_post', 'judge_familiar_register_meta_boxes_save' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function judge_familiar_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'judge_familiar_content_width', 980 );
}
add_action( 'after_setup_theme', 'judge_familiar_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
if ( ! function_exists('judge_familiar_widgets_init') ) :
function judge_familiar_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'judge-familiar' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
endif;
add_action( 'widgets_init', 'judge_familiar_widgets_init' );

if ( ! function_exists('judge_familiar_read_more') ) :
function judge_familiar_read_more() {
	return sprintf('<p class="readmore"><a href="%s">Read more.</a></p>',
		esc_url( get_permalink() )
	);
}
endif;

/**
 * Enqueue scripts and styles.
 */
if ( ! function_exists('judge_familiar_scripts') ) :
function judge_familiar_scripts() {
	wp_enqueue_style( 'bootstrap-v4', get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css', array(), '20151026' );
	wp_enqueue_style( 'judge-familiar-style', get_stylesheet_uri() );

	wp_enqueue_script( 'bootstrap-v4', get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js', array( 'jquery' ), '20151026', true );
	wp_enqueue_script( 'judge-familiar-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
	wp_enqueue_script( 'judge-familiar-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() ) {
		wp_enqueue_style( 'dashicons' );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
endif;
add_action( 'wp_enqueue_scripts', 'judge_familiar_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

if ( !function_exists('shortcode_error')) :

function shortcode_error($code, $msg) {
  return sprintf(
    "<strong>Shortcode Error:</strong> <code>%s</code> %s.",
    $code,
    $msg
  );
}

endif;

/**
 * This magically loads all files in the shortcodes folder.
 */
foreach (glob(get_template_directory() . '/shortcodes/*.php') as $file) {
  include $file;
}
