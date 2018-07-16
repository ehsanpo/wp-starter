<?php
require_once(__DIR__ . '/../../vendor/autoload.php');

define('I18N_THEME', 'theme');

// Import library functions
$libraries = array(
	'page_composer',
	'twig_extensions',
	'post',
	'default_page',
);

foreach($libraries as $library) {
	require __DIR__ . '/lib/' . $library . '.php';
}

/**
 * Class that defines the site. Use this to add define what this theme is capable of
 * and to add extra functions to the template engine.
 *
 * By default the site is exposed to templates as the property site, which means that any
 * public methods and properties of this class can be retrieved via that variable. See
 * https://github.com/jarednova/timber/wiki/TimberSite for default properties.
 *
 * Example: site.name, site.do_stuff()
 */
class Site extends TimberSite {
	function __construct() {
		add_theme_support('post-formats');
		add_theme_support('post-thumbnails');
		add_theme_support('menus');

		add_filter('timber_context', array($this, 'timber_context'));
		add_filter('twig_apply_filters', array($this, 'twig_filters'));
		//add_filter( 'tiny_mce_plugins', array($this, 'disable_emojis_tinymce')  );
		add_filter( 'upload_mimes',  array($this, 'add_svg_to_upload_mimes'), 10, 1 );
		add_action('admin_head',  array($this, 'fix_svg_thumb_display') );
		// Register actions
		// add_action('init', array($this, 'custom_init'))

		self::setup_styles_and_scripts();
		self::cleanup();


		//self::disable_blog();
		self::disable_comments();

		// Setup the page composer
		PageComposer::for_post_types(array('page'));
		//PageComposer::with_shared_content();
		PageComposer::with_blocks(array(
	
			'shared-content',
			'layout',
			'section',
			'StandardBlock',
			'ImageBlock',
			'ImageSlider',
			'ShowCategory',
			'LatestPost',
			'hero-block',
			'video-block',
			'imageAndText-block',
			'links-block'

		));


		// Register Primary Navigation
		register_nav_menu('primary', 'Primary Navigation');
		register_nav_menu('footer', 'Footer Navigation');

		//add option page
		function create_option_page(){
			if( function_exists('acf_add_options_page') ) {
				acf_add_options_page(array(
					'page_title' 	=> 'General Settings',
					'menu_title'	=> 'General Settings',
					'menu_slug' 	=> 'general-settings',
					'capability'	=> 'edit_posts',
					'redirect'		=> false
				));
			}
		}

		add_action( 'init', 'create_option_page' );

		parent::__construct();
	}
	function fix_svg_thumb_display() {
		  echo '<style type="text/css">
        .attachment-266x266, .thumbnail img {
             width: 100% !important;
             height: auto !important;
        }
        </style>';
	}
	function add_svg_to_upload_mimes( $upload_mimes ) {
		$upload_mimes['svg'] = 'image/svg+xml';
		$upload_mimes['svgz'] = 'image/svg+xml';
		return $upload_mimes;
	}
	/**
	  * Setup any extra global variables you want all templates of the
	  * theme to have access to.
	  */
	function timber_context($ctx) {
		$ctx['site'] = $this;

		$ctx['primary_menu'] = new TimberMenu('primary');
		$ctx['footer_menu'] = new TimberMenu('footer');

		// To fetch all options as an associative array
		$options = get_fields('option');


		// Get Google Analytics
		$ctx['google_analytics_id'] = get_field('google_analytics_id', 'options');


		return $ctx;
	}

	/**
	 * Setup some extra Twig filters used by the theme.
	 */
	function twig_filters($twig) {
		return $twig;
	}

	/**
	 * Perform cleanup of some WordPress features. This is used to make
	 * the site experience a bit better, customize as needed.
	 */
	private function cleanup() {
		//Register your image sizes with Timmy
		add_filter( 'timmy/sizes', function( $sizes ) {
		    return array(
		        'head' => array(
		            'resize' => array( 370 ),
		            'srcset' => array(
		                 array( 1024 ),
		                array( 480 ),
		                2, // This is the same as array(2800, 1200)
		            ),
		            'sizes' => '(min-width: 60em) 100vw, 100vw',
		            'name' => 'Width 1/4 fix',
		            'post_types' => array( 'post', 'page'  ),
		        ),
		        'body' => array(
		            'resize' => array( 370 ),
		            'srcset' => array(
		                array( 768 ),
		                array( 480 ),
		                2, // This is the same as array(2800, 1200)
		            ),
		            'sizes' => '(min-width: 62rem) 50vw, 100vw',
		            'name' => 'Width 1/4 fix',
		            'post_types' => array( 'post', 'page' ),
		        ),

		    );
		} );

		remove_action('wp_head', 'wp_generator');
		add_filter('show_admin_bar', '__return_false');

		remove_action('wp_head', 'rsd_link');
		remove_action('wp_head', 'wlwmanifest_link');
		remove_action('wp_head', 'wp_shortlink_wp_head');
		remove_action('wp_head', 'feed_links_extra', 3);
		remove_action('wp_head', 'feed_links', 2);

		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );	
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

		add_filter( 'xmlrpc_enabled', '__return_false' );



		if(WP_ENV != 'development') {
			// Remove Custom Post Types unless we are developing
			add_action('admin_menu', function() {
				remove_menu_page('edit.php?post_type=acf-field-group');
			});
		}
	}

	private function setup_styles_and_scripts() {
		add_action('wp_enqueue_scripts', function() {
			$js = get_template_directory_uri() . '/assets/js/scripts.min.js';
			$css = get_template_directory_uri() . '/assets/css/main.css';
			// $modernizr = get_template_directory_uri() . '/assets/js/modernizr.js';
			// wp_enqueue_script('modernizr', $modernizr);
			wp_enqueue_style('theme', $css,array(), '1.0.0');
			wp_enqueue_script('theme', $js, array(), '1.0.0', true);
		});
	}

	/**
	 * Disable commenting on posts and pages.
	 */
	private function disable_comments() {
		// TODO: This should do a bit more than just remove the comments page
		add_action('admin_menu', function() {
			remove_menu_page('edit-comments.php');
		});
	}

/**
 * Filter function used to remove the tinymce emoji plugin.
 * 
 * @param    array  $plugins  
 * @return   array             Difference betwen the two arrays
 */
	private function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}


}


/**
 * Layout Styles
 */
$layout_styles = function ($styles) {
	$styles['Background color'] = array(
		'bg_color_primary' => 'primary',
		'bg_color_alt_1' => 'alt color 1',
		'bg_color_alt_2' => 'alt color 2'
	);

	return $styles;
};

add_filter('acf/section/styles/imageAndText-block', $layout_styles);
add_filter('acf/section/styles/LatestPosts', $layout_styles);
add_filter('acf/section/styles/links-block', $layout_styles);
add_filter('acf/section/styles/StandardBlock', $layout_styles);

/**
 * @param \PHPMailer $phpmailer
 */
function disableTLS($phpmailer){
    // Disable the automatic TLS encryption added in PHPMailer v5.2.10 (9da56fc1328a72aa124b35b738966315c41ef5c6)
    $phpmailer->SMTPAutoTLS = false;
}
add_action( 'phpmailer_init', 'disableTLS' );


//remove wp-embed.min.js
add_action( 'init', function() {

    // Remove the REST API endpoint.
    remove_action('rest_api_init', 'wp_oembed_register_route');

    // Turn off oEmbed auto discovery.
    // Don't filter oEmbed results.
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);

    // Remove oEmbed discovery links.
    remove_action('wp_head', 'wp_oembed_add_discovery_links');

    // Remove oEmbed-specific JavaScript from the front-end and back-end.
    remove_action('wp_head', 'wp_oembed_add_host_js');
}, PHP_INT_MAX - 1 );

function the_breadcrumb() {
	global $post;
	//dont show on search page & single shops
	if (is_search() || is_front_page() ) {
		return;
	}
	if($post && get_post_meta($post->ID, 'hide_breadcrumb', true) == FALSE) {
		echo '<div class="breadcrumbs"><span>' . __('You are here', 'site') . ':</span><ul>';
		if (!is_front_page()) {
			echo '<li><a href="';
			echo get_option('home');
			echo '">';
			echo __('Home', 'site');
			echo '</a></li><li class="separator">›</li>';
			if (is_category() || is_single()) {
				echo '<li>';
				if (is_single()) {
					echo get_post_type( $post );
				}
				the_category(' </li><li class="separator">›</li><li> ');
				if (is_single()) {
					echo '</li><li class="separator">›</li><li class="active">';
					the_title();
					echo '</li>';
				}
			} elseif (is_page()) {
				if($post->post_parent){
					$anc = get_post_ancestors( $post->ID );
					$title = get_the_title();
					foreach ( $anc as $ancestor ) {
						$output = '<li><a href="'.get_permalink($ancestor).'" title="'.get_the_title($ancestor).'">'.get_the_title($ancestor).'</a></li> <li class="separator">›</li>';
					}
					echo $output;
					echo '<li class="active" title="'.$title.'"> '.$title.'</li>';
				} else {
					echo '<li class="active">'.get_the_title().'</li>';
				}
			}
		}
		elseif (is_tag()) {single_tag_title();}
		elseif (is_day()) {echo"<li>Archive for "; the_time('F jS, Y'); echo'</li>';}
		elseif (is_month()) {echo"<li>Archive for "; the_time('F, Y'); echo'</li>';}
		elseif (is_year()) {echo"<li>Archive for "; the_time('Y'); echo'</li>';}
		elseif (is_author()) {echo"<li>Author Archive"; echo'</li>';}
		elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "<li>Blog Archives"; echo'</li>';}
		elseif (is_search()) {echo"<li>Search Results"; echo'</li>';}
		elseif(is_front_page()){
			echo "<li> " . __('Home', 'site') . " </li>";
		}
		echo '</ul>';
		echo '</div>';
	}
}
new Site();




/*
	
// custom 

add_action( 'init', 'handlare_register' );   

function handlare_register() {   

    $labels = array( 
        'name' => _x('Handlare', 'post type general name'), 
        'singular_name' => _x('Handlare Item', 'post type singular name'), 
    );   

    $args = array( 
        'labels' => $labels, 
        'public' => true, 
        'publicly_queryable' => true, 
        'show_ui' => true, 
        'query_var' => true, 
        'rewrite' => array( 'slug' => 'work', 'with_front'=> false ), 
        'capability_type' => 'post', 
        'hierarchical' => true,
        'has_archive' => true,  
        'menu_position' => null, 
        'supports' => array('title','editor','thumbnail','revisions') 
    );   

    register_post_type( 'work' , $args ); 

    register_taxonomy( 'categories', array('work'), array(
        'hierarchical' => true, 
        'label' => 'Categories', 
        'singular_label' => 'Category', 
        'rewrite' => array( 'slug' => 'categories', 'with_front'=> false )
        )
    );

    register_taxonomy_for_object_type( 'categories', 'work' );

}
*/