<?php
/**
 * Education Hub functions and definitions.
 *
 * @link https://codex.wordpress.org/Functions_File_Explained
 *
 * @package Education_Hub
 */

if ( ! function_exists( 'education_hub_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function education_hub_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Education Hub, use a find and replace
		 * to change 'education-hub' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'education-hub', get_parent_theme_file_path( '/languages' ) );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'education-hub-thumb', 360, 270 );

		// This theme uses wp_nav_menu() in four location.
		register_nav_menus( array(
			'primary'     => esc_html__( 'Primary Menu', 'education-hub' ),
			'footer'      => esc_html__( 'Footer Menu', 'education-hub' ),
			'social'      => esc_html__( 'Social Menu', 'education-hub' ),
			'quick-links' => esc_html__( 'Quick Links Menu', 'education-hub' ),
			'notfound'    => esc_html__( '404 Menu', 'education-hub' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/*
		 * Enable support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'education_hub_custom_background_args', array(
			'default-color' => 'dfdfd0',
			'default-image' => '',
		) ) );

		/*
		 * Enable support for custom logo.
		 */
		add_theme_support( 'custom-logo', array(
			'flex-height' => true,
			'flex-width'  => true,
		) );

		// Load default block styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for responsive embeds.
		add_theme_support( 'responsive-embeds' );

		/*
		 * Enable support for selective refresh of widgets in Customizer.
		 */
		add_theme_support( 'customize-selective-refresh-widgets' );

		$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		// Editor style.
		add_editor_style( 'css/editor-style' . $min . '.css' );

		// Enable support for footer widgets.
		add_theme_support( 'footer-widgets', 4 );

		// Load Supports.
		require get_template_directory() . '/inc/support.php';

		global $education_hub_default_options;
		$education_hub_default_options = education_hub_get_default_theme_options();

	}
endif;

add_action( 'after_setup_theme', 'education_hub_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function education_hub_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'education_hub_content_width', 640 );
}
add_action( 'after_setup_theme', 'education_hub_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function education_hub_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Primary Sidebar', 'education-hub' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here to appear in your Primary Sidebar.', 'education-hub' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Secondary Sidebar', 'education-hub' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add widgets here to appear in your Secondary Sidebar.', 'education-hub' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'education_hub_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function education_hub_scripts() {

	$theme_version = wp_get_theme()->get( 'Version' );

	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/third-party/font-awesome/css/font-awesome' . $min . '.css', '', '4.7.0' );

	wp_enqueue_style( 'education-hub-google-fonts', education_hub_fonts_url(), array(), null );

	wp_enqueue_style( 'education-hub-style', get_stylesheet_uri(), array(), $theme_version );

	if ( has_header_image() ) {
		$custom_css = '#masthead{ background-image: url("' . esc_url( get_header_image() ) . '"); background-repeat: no-repeat; background-position: center center; }';
		$custom_css .= '@media only screen and (max-width:767px) {
		    #page #masthead {
		        background-position: center top;
		        background-size: 100% auto;
		        padding-top: 110px;
		    }
		 }';

		wp_add_inline_style( 'education-hub-style', $custom_css );
	}

	wp_enqueue_script( 'education-hub-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix' . $min . '.js', array(), '20130115', true );

	wp_enqueue_script( 'cycle2', get_template_directory_uri() . '/third-party/cycle2/js/jquery.cycle2' . $min . '.js', array( 'jquery' ), '2.1.6', true );

	wp_enqueue_script( 'education-hub-custom', get_template_directory_uri() . '/js/custom' . $min . '.js', array( 'jquery' ), '1.0', true );

	wp_register_script( 'education-hub-navigation', get_template_directory_uri() . '/js/navigation' . $min . '.js', array(), '20120206', true );
	wp_localize_script( 'education-hub-navigation', 'EducationHubScreenReaderText', array(
		'expand'   => '<span class="screen-reader-text">' . __( 'expand child menu', 'education-hub' ) . '</span>',
		'collapse' => '<span class="screen-reader-text">' . __( 'collapse child menu', 'education-hub' ) . '</span>',
	) );
	wp_enqueue_script( 'education-hub-navigation' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'education_hub_scripts' );

if ( ! function_exists( 'education_hub_fonts_url' ) ) :
	/**
	 * Register Google fonts for Education Hub
	 *
	 * Create your own education_hub_fonts_url() function to override in a child theme.
	 *
	 * @since Education Hub 2.0.1
	 *
	 * @return string Google fonts URL for the theme.
	 */
	function education_hub_fonts_url() {
		wp_enqueue_style( 'education-hub-google-fonts', '//fonts.googleapis.com/css?family=Open+Sans:600,400,400italic,300,100,700|Merriweather+Sans:400,700' );

		$fonts_url = '';

		/* Translators: If there are characters in your language that are not
		* supported by Open Sans, translate this to 'off'. Do not translate
		* into your own language.
		*/
		$open_sans = _x( 'on', 'Open Sans: on or off', 'education-hub' );

		/* Translators: If there are characters in your language that are not
		* supported by Merriweather, translate this to 'off'. Do not translate
		* into your own language.
		*/
		$merriweather = _x( 'on', 'Merriweather: on or off', 'education-hub' );

		if ( 'off' !== $open_sans || 'off' !== $merriweather ) {
			$font_families = array();

			if ( 'off' !== $open_sans ) {
			$font_families[] = 'Open Sans:300,400,600,700,800,300italic,400italic,600italic,700italic,800italic';
			}

			if ( 'off' !== $merriweather ) {
			$font_families[] = 'Source Sans Pro:300,400,700,800,300italic,400italic,700italic,800italic';
			}

			$query_args = array(
				'family' => urlencode( implode( '|', $font_families ) ),
				'subset' => urlencode( 'latin,latin-ext' ),
			);

			$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
		}

		return esc_url_raw( $fonts_url );
	}
endif;

/**
 * Load init.
 */
require get_template_directory() . '/inc/init.php';
