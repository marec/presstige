<?php
  

/*** clean ups and enhancements, uncomment to use */
require_once('functions/wordpress_cleanup.php'); //admin cleanups 
require_once('functions/script_style_cleanups.php'); // javascript cleanups
// require_once('functions/remove-comments-absolute.php'); //to remove comments completely
require_once ( 'functions/my-theme-settings.php' );


/**
 * Make theme available for translation
 * Translations can be filed in the /languages/ directory
 */
load_theme_textdomain( 'presstige', get_template_directory() . '/languages' );

$locale = get_locale();
$locale_file = get_template_directory() . "/languages/$locale.php";
if ( is_readable( $locale_file ) )
	require_once( $locale_file );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640;


/**
 * This theme uses wp_nav_menus() for the header menu, utility menu and footer menu.
 */
register_nav_menus( array(
	'primary' => __( 'Primary Menu', 'presstige' )
) );


/**
 *	This theme supports editor styles
 */
add_editor_style("css/editor-style.css");

/**
 * Proper way to enqueue scripts and styles
 */
function presstige_styles() {
	wp_enqueue_style( 'mainstyle', get_stylesheet_uri(),  false,   0.1 );
}

add_action( 'wp_enqueue_scripts', 'presstige_styles' );


/**** Add some theme support, uncomment what you need ****/
/** 
 * Add default posts and comments RSS feed links to head
 */
add_theme_support( 'automatic-feed-links' );

/**
 * This theme uses post thumbnails
 */
 if ( function_exists( 'add_theme_support' ) ) {    
	add_theme_support( 'post-thumbnails' );  
	set_post_thumbnail_size( 250, 150, array('center', 'top')); 
}	
if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'small', 55, 55, true);
	add_image_size( 'medium', 360, 400, true);
	add_image_size( 'big', 750, 9999, true);
}

/**
 * This enables post formats. If you use this, make sure to delete any that you aren't going to use.
 */
//add_theme_support( 'post-formats', array( 'aside', 'audio', 'image', 'video', 'gallery', 'chat', 'link', 'quote', 'status' ) );


/**
 * Disable the admin bar in 3.1
 */
//show_admin_bar( false );
function scripts_styles() {
	// AJOUT DES SCRIPTS
	// paramètres => ('string:identifiant_unique', 'string:url', 'array:dépendances')
	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );	
	if (!is_admin())   
    {  
        wp_deregister_script('jquery');	  
        // Load the copy of jQuery that comes with WordPress  
        // The last parameter set to TRUE states that it should be loaded  
        // in the footer.  
        wp_register_script('jquery', '/wp-includes/js/jquery/jquery.js', FALSE, '', TRUE);  
        wp_enqueue_script('jquery');  
    }  
	// wp_enqueue_script('modernizr', get_template_directory_uri().'/js/modernizr.custom.js', array('jquery'), false, true);
	wp_enqueue_script('konami', get_template_directory_uri().'/js/konami.js', array('jquery'), false, true);
	wp_enqueue_script('general', get_template_directory_uri().'/js/general.js', array('jquery'), false, true);
}
add_action('wp_enqueue_scripts', 'scripts_styles');

/**
 * Register widgetized area and update sidebar with default widgets
 */

if( !function_exists('handcraftedwp_widgets_init'))  {

	function handcraftedwp_widgets_init() {
		register_sidebar( array (
			'name' => __( 'Sidebar', 'presstige' ),
			'id' => 'sidebar',
			'before_widget' => '<aside id="%1$s" class="widget %2$s" role="complementary">',
			'after_widget' => "</aside>",
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>',
		) );
		
			// Area 3, located in the footer. Empty by default.
		register_sidebar( array(
			'name' => __( 'Footer', 'presstige' ),
			'id' => 'footer-widget-area',
			'description' => __( 'The footer area', 'presstige' ),
			'before_widget' => '<aside id="%1$s" class="widget-container %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		) );
	}

}
add_action( 'init', 'handcraftedwp_widgets_init' );



// This theme uses wp_nav_menu() in one location.
register_nav_menu( 'primary', __( 'Primary Menu', 'presstige' ) );



/* Change the lenght of the excerpt */

if( !function_exists('twentyeleven_excerpt_length'))  {

	function twentyeleven_excerpt_length( $length ) {
		return 80;
	}
}

add_filter( 'excerpt_length', 'twentyeleven_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 */
 
if( !function_exists('twentyeleven_continue_reading_link'))  {

	function twentyeleven_continue_reading_link() {
		return ' <span class="readmore"><a title="'.get_the_title().'" href="'. esc_url( get_permalink() ) . '"><span class="icon-arrow-right-3" > </span>' . __( 'Continue reading', 'presstige' ) . '</a></span>';
	}
}
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and twentyeleven_continue_reading_link()
 */

if( !function_exists('twentyeleven_auto_excerpt_more'))  {
 
	function twentyeleven_auto_excerpt_more( $more ) {
		return ' &hellip;' . twentyeleven_continue_reading_link();
	}
}

add_filter( 'excerpt_more', 'twentyeleven_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 */
 
if( !function_exists('twentyeleven_custom_excerpt_more'))  {
 
	function twentyeleven_custom_excerpt_more( $output ) {
		if ( has_excerpt() && ! is_attachment() ) {
			$output .= twentyeleven_continue_reading_link();
		}
		return $output;
	}
}
add_filter( 'get_the_excerpt', 'twentyeleven_custom_excerpt_more' );


/**************** Adding some html5 functionnalities to comments************/

add_filter('comment_form_default_fields', 'twentytenfive_comments');
if( !function_exists('twentytenfive_comments'))  {

	function twentytenfive_comments() {

	$req = get_option('require_name_email');

	$fields =  array(
	'author' => '<p>' . '<label for="author">' . __( 'Name','presstige' ) . '</label> ' . ( $req ? '<span>*</span>' : '' ) .
	'<input id="author" name="author" type="text" value="' . '" size="30"' . ' placeholder ='.__( '"What shall we call you?"', 'presstige' ) . ( $req ? ' required' : '' ) . '/></p>',

	'email'  => '<p><label for="email">' . __( 'Email','presstige' ) . '</label> ' . ( $req ? '<span>*</span>' : '' ) .
	'<input id="email" name="email" type="email" value="' .'" size="30"' . ' placeholder ='.__( '"Leave us a valid email adress"', 'presstige' ) . ( $req ? ' required' : '' ) . ' /></p>',

	'url'    => '<p><label for="url">' . __( 'Website','presstige' ) . '</label>' .
	'<input id="url" name="url" type="url" value="' . '" size="30" placeholder='.__( '"Have you got a nice website ?"', 'presstige' ) . '/></p>'

	);
	return $fields;
	}
}

add_filter('comment_form_field_comment', 'twentytenfive_commentfield');
if( !function_exists('twentytenfive_commentfield'))  {

	function twentytenfive_commentfield() {
	$commentArea = '<p><label for="comment">' . __( 'Comment', 'presstige') . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" required placeholder ='.__( '"What\'s in your mind ?"', 'presstige').'  ></textarea></p>';
	return $commentArea;
	}
}

/** Adding html5 functionnalities to searchform ***/
if( !function_exists('html5_search_form'))  {
	function html5_search_form( $form ) {
		$form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
		<p><label class="visually-hidden" for="s">' . __('Search for:','presstige') . '</label>
		<input type="search" value="' . get_search_query() . '" name="s" id="s"  autocomplete="on" placeholder ="'.__( 'What are you looking for?', 'presstige' ) . '" />
		<input type="submit" id="searchsubmit" value="'. esc_attr__('Ok') .'" />
		</p>
		</form>';
		return $form;
	}
}

add_filter( 'get_search_form', 'html5_search_form' );

/** we need a second form not to duplicate ids on the search result page when there is no results */
if( !function_exists('get_search_form_HTML5_bis'))  {
	function get_search_form_HTML5_bis() {
		echo '<form role="search" method="get" id="searchform_bis" action="' . home_url( '/' ) . '" >
		<p><label class="visually-hidden" for="s2">' . __('Search for:','presstige') . '</label>
		<input type="search" value="' . get_search_query() . '" name="s" id="s2"  autocomplete="on" placeholder ="'.__( 'What are you looking for?', 'presstige' ) . '" />
		<input type="submit" id="searchsubmit_bis" value="'. esc_attr__('Ok','presstige') .'" />
		</p>
		</form>';
	}
}

/*** Add a login stylesheet and a wordpress specifiq stylesheet------------
Special thanks to Valentin Brandt :  
http://www.geekeries.fr/snippet/personnaliser-interface-ui-wordpress-3-2/ 
comment code if not needed -----------*/

if( !function_exists('gk_ui_wp32_login'))  {
	function gk_ui_wp32_login() {
		echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('template_directory') . '/css/custom_login.css"/>';
	}
}

if( !function_exists('gk_ui_wp32_admin'))  {
	function gk_ui_wp32_admin() {
		wp_enqueue_style( 'admin', get_bloginfo('template_directory') . '/css/custom_admin.css');
	}
}

add_action('login_head', 'gk_ui_wp32_login');
add_action('admin_enqueue_scripts', 'gk_ui_wp32_admin');



/*----------------------------------------------------------------------- **/

/*  please don't but if you need to remove width/height on template use this */
/* add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
function remove_thumbnail_dimensions( $html ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
} */

/** 
* Collects our theme options 
* 
* @return array 
*/  
function presstige_get_global_options(){  
	$options = array();  
	$options = get_option('presstige_options');
return $options;  
}  

$options = presstige_get_global_options();  

// PAGE ATTENTE
function load_page_wait() {
	$options = get_option('presstige_options');
	$maintenance = $options['presstige_maintenance'];
	if ( $maintenance == 1){
		$isLoginPage = strpos($_SERVER['REQUEST_URI'], "wp-login.php") !== false;
		$adminPage = strpos($_SERVER['REQUEST_URI'], "wp-admin") !== false;
		if($maintenance && !is_user_logged_in() && !$isLoginPage && !$adminPage) {
			include('functions/maintenance.php');
			exit();	
		}
	}
}
add_action('init','load_page_wait');

// FAVICON
function favicon() {
	$options = get_option('presstige_options');
	if ($options['presstige_favicon'] != ""){
		echo '<link rel="shortcut icon" href="'.$options['presstige_favicon'].'" type="image/vnd.microsoft.icon"/>';
		echo '<link rel="icon" href="'.$options['presstige_favicon'].'" type="image/x-ico"/>';
	} else {
		echo '<link rel="shortcut icon" href="'.get_bloginfo('template_directory').'/img/favicon.ico" type="image/vnd.microsoft.icon"/>';
		echo '<link rel="icon" href="'.get_bloginfo('template_directory').'/img/favicon.ico" type="image/x-ico"/>';
	}
}
add_action('wp_head', 'favicon');

// GOOGLE ANALYTICS
function add_google_analytics() {
	$options = get_option('presstige_options');
	if ($options['presstige_analytics'] != "")
		echo "<script type='text/javascript'>".$options['presstige_analytics']."</script>";
}
add_action('wp_footer', 'add_google_analytics');

// -----------------------------------------------------------------------------------------------------------------------------------------------------------
// breadcrumbs http://cazue.com/articles/wordpress-creating-breadcrumbs-without-a-plugin-2013 WITH SOME DEBUG
// -----------------------------------------------------------------------------------------------------------------------------------------------------------
function the_breadcrumb() {
	global $post;
	$output_array = array();

	echo '<div class="breadcrumb" itemprop="breadcrumb"><ul class="container">';
    if (!is_home()) {
        echo '<li class="no-smoothstate"><a href="';
        echo get_option('home');
        echo '">';
        echo __('Home');
        echo '</a><span class="separator">&nbsp;&gt;</span></li>';
        if (is_category()) {
            echo '<li>Catégorie<span class="separator">&nbsp;&gt;</span></li><li>';
            single_cat_title( '', true );
        	echo '</li>';
        } elseif (is_single()) {  
        	echo '<li><a href="/blog">Blog</a><span class="separator">&nbsp;&gt;</span></li><li>';
        	the_title();
        	echo '</li>';
        } elseif (is_page()) {
            if($post->post_parent){
                $anc = get_post_ancestors( $post->ID );
                foreach ($anc as $ancestor) {
                    $output_array[] = '<li><a href="'.get_permalink($ancestor).'">'.get_the_title($ancestor).'</a><span class="separator">&nbsp;&gt;</span></li>';
                }

                echo implode('', array_reverse($output_array));
                echo '<li>'.get_the_title().'</li>';
            } else {
                echo '<li>';
                echo the_title();
                echo '</li>';
            }
        }
	    elseif (is_404()) { echo "<li>Page introuvable</li>"; }
	    elseif (is_tag()) { ?><li>Tag<span class="separator">&nbsp;&gt;</span></li><li><?php echo single_tag_title() ?></li><?php }
	    elseif (is_day()) { echo "<li>".sprintf(__('Daily Archives : <span>%s</span>', 'presstige'), get_the_date())."</li>"; }
	    elseif (is_month()) { echo "<li>".sprintf(__('Monthly Archives : <span>%s</span>', 'presstige'), get_the_date('F Y'))."</li>"; }
	    elseif (is_year()) { echo "<li>".sprintf(__('Yearly Archives : <span>%s</span>', 'presstige'), get_the_date('Y'))."</li>"; }
	    elseif (is_author()) { echo "<li>Author Archive</li>"; }
	    elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { echo "<li>Blog Archives"; echo '</li>'; }
	    elseif (is_search()) {
	    	echo "<li>";
			if (have_posts()) :
				printf( __( 'Search Results for : %s', 'presstige' ), '<span>' . get_search_query() . '</span>' );
			else :
				_e( 'Nothing Found', 'presstige' );
			endif;
	    	echo "</li>";
	   	}
    }
    echo '</ul></div>';
    echo '<div class="clear"></div>';
}

//http://codex.wordpress.org/Function_Reference/wp_title
function o2_wp_title( $title, $sep ) {
	if ( is_feed() ) {
		return $title;
	}
	
	global $page, $paged;

	// Add the blog name
	$title .= get_bloginfo( 'name', 'display' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary:
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title .= " $sep " . sprintf( __( 'Page %s', '_s' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'o2_wp_title', 10, 2 );

?>