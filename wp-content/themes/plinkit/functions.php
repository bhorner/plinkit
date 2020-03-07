<?php

/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/

/**
 *  Initialize Scripts + Stylesheets
 */

function my_init() {
	
	if (!is_admin()) {
		
		// jQuery
		wp_deregister_script('jquery'); 
		wp_register_script('jquery', 'https://code.jquery.com/jquery-latest.min.js'); 
		wp_enqueue_script('jquery');
		
		// Stylesheet
		wp_enqueue_style('stylesheet-main', get_bloginfo('template_url') . '/style.css', '', false);
		
		// Flexslider
		wp_enqueue_script('flexslider', get_bloginfo('template_url') . '/js/jquery.flexslider-min.js', array('jquery'), '', true);

		// Owl
		wp_enqueue_script('owl', get_bloginfo('template_url') . '/js/owl.carousel.min.js', array('jquery'), '', true);

		// sticky
		wp_enqueue_script('sticky', get_bloginfo('template_url') . '/js/sticky-kit.js', array('jquery'), '', true);

		// matchheight
// 		wp_enqueue_script('matchheight', get_bloginfo('template_url') . '/js/jquery.matchHeight-min.js', array('jquery'), true);

		// remodal
		wp_enqueue_script('remodal', get_bloginfo('template_url') . '/js/remodal.min.js', array('jquery'), '', true);

		// cookie
		wp_enqueue_script('cookie', get_bloginfo('template_url') . '/js/jquery.cookie.js', array('jquery'), '', true);

		// Initialize Everything
		wp_enqueue_script('initialize', get_bloginfo('template_url') . '/js/init.js', array('jquery'), '', true);
		
	} else {
		
		// Administration Stylesheet
		wp_enqueue_style('style-admin', get_bloginfo('template_url') . '/css/style-admin.css', '', false);
		
	}
	
}

add_action('wp_enqueue_scripts', 'my_init');

/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/

/**
 * Add Theme Suport: Thumbnails
 */

if ( function_exists( 'add_theme_support' ) ) { 
    add_theme_support( 'post-thumbnails' );

    // additional image sizes
    // delete the next line if you do not need additional image sizes
    add_image_size( 'post-thumb', 320, 220, true ); //300 pixels wide (and unlimited height)
    add_image_size( 'featured-thumb', 900, 450, true ); //300 pixels wide (and unlimited height)
}

/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/

/**
 * Add Theme Suport: Title tags
 */

add_theme_support( 'title-tag' );

/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/

/**
 * Add Theme Suport: Menus
 */

add_theme_support('menus');

/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/

/**
 * Add Theme Suport: Profile Field
 */
 
function modify_contact_methods($profile_fields) {

	// Add new fields
	$profile_fields['title'] = 'Title';

	return $profile_fields;
}
add_filter('user_contactmethods', 'modify_contact_methods');

/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/

/**
 * Remove Main Stylesheet From Login Page
 */
 
function login_styles() {
	wp_deregister_style('stylesheet-main');
}

add_action('login_init', 'login_styles');

/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/

/**
 * Add Styles to Wysiwyg Editor 
 */

function add_editor_stylesheet() {
	add_editor_style('css/style-editor.css');
}

add_action('after_setup_theme', 'add_editor_stylesheet');

/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/

function age_range_init() {
	// create a new taxonomy
	register_taxonomy(
		'age-range',
		'post',
		array(  
            'hierarchical' => true,  
            'label' => 'Age Range',  //Display name
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'age-range', // This controls the base slug that will display before each term
                'with_front' => false // Don't display the category base before 
            )
        )
	);
}
add_action( 'init', 'age_range_init' );

/**
* mt_profile_img
* 
* Adds a profile image
*
@param $user_id INT - The user ID for the user to retrieve the image for
@ param $args mixed
    size - string || array (see get_the_post_thumbnail)
    attr - string || array (see get_the_post_thumbnail)
    echo - bool (true or false) - whether to echo the image or return it
*/

/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/

function skills_init() {
	// create a new taxonomy
	register_taxonomy(
		'skills',
		'post',
		array(  
            'hierarchical' => true,  
            'label' => 'Skills',  //Display name
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'skills', // This controls the base slug that will display before each term
                'with_front' => false // Don't display the category base before 
            )
        ) 
	);
}
add_action( 'init', 'skills_init' );

/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/

function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }	
  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
  return $excerpt;
}
 
function content($limit) {
  $content = explode(' ', get_the_content(), $limit);
  if (count($content)>=$limit) {
    array_pop($content);
    $content = implode(" ",$content).'...';
  } else {
    $content = implode(" ",$content);
  }	
  $content = preg_replace('/\[.+\]/','', $content);
  $content = apply_filters('the_content', $content); 
  $content = str_replace(']]>', ']]&gt;', $content);
  return $content;
}

function revcon_change_post_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'Learn / Do';
    $submenu['edit.php'][5][0] = 'Learn / Do';
}

 
add_action( 'admin_menu', 'revcon_change_post_label' );

function callout_func( $atts, $content = null ) {
	return '<div class="callout-box">' . $content . '</div>';
}
add_shortcode( 'callout', 'callout_func' );

function yellow_box_func( $atts, $content = null ) {
	return '<div class="yellow-box">' . $content . '</div>';
}
add_shortcode( 'yellow_box', 'yellow_box_func' );

function red_box_func( $atts, $content = null ) {
	return '<div class="red-box">' . $content . '</div>';
}
add_shortcode( 'red_box', 'red_box_func' );

/**
	Full start
**/

function signature_func( $atts, $content = null ) {
	return '<div class="signature">' . $content . '</div>';
}
add_shortcode( 'signature', 'signature_func' );


function callout_full_func( $atts, $content = null ) {
	return '<div class="callout-box full">' . $content . '</div>';
}
add_shortcode( 'callout_full', 'callout_full_func' );

function yellow_box_full_func( $atts, $content = null ) {
	return '<div class="yellow-box full">' . $content . '</div>';
}
add_shortcode( 'yellow_box_full', 'yellow_box_full_func' );

function red_box_full_func( $atts, $content = null ) {
	return '<div class="red-box full">' . $content . '</div>';
}
add_shortcode( 'red_box_full', 'red_box_full_func' );

/**
	Full End
**/

function quote_func( $atts, $content = null ) {
	return '<div class="quote">' . $content . '</div>';
}
add_shortcode( 'quote', 'quote_func' );

function accordion_outer_func( $atts, $content = null ) {
	return '<div class="accordion">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'accordion', 'accordion_outer_func' );

function accordion_title_func( $atts, $content = null ) {
	return '<div class="accordion-title color-coral"><h6>' . $content . '</h6><span></span></div>';
}
add_shortcode( 'accordion_title', 'accordion_title_func' );

function accordion_inner_func( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			'title' => 'title',
		), $atts );
	
	return '<div class="accordion-title color-coral"><h6>' . $atts['title'] . '</h6><span></span></div><div class="accordion-inner">' . $content . '</div>';
}
add_shortcode( 'accordion_item', 'accordion_inner_func' );

function half_img_func( $atts, $content = null ) {
	return '<div class="half-img">' . $content . '</div>';
}
add_shortcode( 'half_img', 'half_img_func' );

function block_func( $atts, $content = null ) {
	return '<div class="block">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'block', 'block_func' );

function blockquote_func( $atts, $content = null ) {
	return '<div class="blockquote">&ldquo;' . do_shortcode($content) . '&rdquo;</div>';
}
add_shortcode( 'blockquote', 'blockquote_func' );

function quote_intro_func( $atts, $content = null ) {
	return '<div class="quote-intro">' . $content . '</div>';
}
add_shortcode( 'quote_intro', 'quote_intro_func' );


/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/

/**
 * Add Options Panels
*/

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Header',
		'menu_title'	=> 'Header',
		'parent_slug'	=> 'theme-general-settings',
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Footer',
		'menu_title'	=> 'Footer',
		'parent_slug'	=> 'theme-general-settings',
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Popups',
		'menu_title'	=> 'Popups',
		'parent_slug'	=> 'theme-general-settings',
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Options',
		'menu_title'	=> 'Options',
		'parent_slug'	=> 'theme-general-settings',
	));
	
}
 
 
/******************************************************************************************************/
/******************************************************************************************************/

/**
 * Update The WYSIWYG Editor


function my_toolbars( $toolbars ){ 
	$toolbars['Very Basic'][1] = array('bold', 'italic', 'underline', 'bullist', 'numlist', 'link', 'unlink');
	return $toolbars;
}

add_filter('acf/fields/wysiwyg/toolbars', 'my_toolbars');
 */

/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/

/**
 * Create Custom Post Type: Toys
 * Create Taxonomies: Toys Categories
 * Create Columns: Toys
 * Manage Columns: Toys
 */
function create_toys() {
	register_post_type(
		'toys',
		array(
			'labels' => array(
				'name' => __("Toys"),
				'singular_name' => __("Toys"),
				'add_new' => __("Add New"),
				'add_new_item' => __("Add New Toy"),
				'edit_item' => __("Edit Toy"),
				'new_item' => __("New Toy"),
				'view_item' => __("View Toy"),
				'search_items' => __("Search Toys"),
				'not_found' => __("No Toys found."),
				'not_found_in_trash' => __("No Toys found in trash."),
				'edit' => __("Edit Toy"),
				'view' => __("View Toy")
			),
			'exclude_from_search' => false,
			'menu_icon' => 'dashicons-admin-customizer',
			'public' => true,
			'rewrite' => array('slug' => 'toys'),
			'supports' => array('title','editor','author','excerpt','comments','revisions')
		)
	);
	flush_rewrite_rules();
}

function create_toys_taxonomies() {
	register_taxonomy(
		'toys-categories',
		'toys',
		array(
			'hierarchical' => true,
			'label' => 'Categories',
			'query_var' => true,
			'rewrite' => array('slug' => 'toys-categories')
		)
	);
	register_taxonomy(
		'age-range-toys',
		'toys',
		array(
			'hierarchical' => true,
			'label' => 'Age Range',
			'query_var' => true,
			'rewrite' => array('slug' => 'age-range-toys')
		)
	);
	register_taxonomy(
		'skills-toys',
		'toys',
		array(
			'hierarchical' => true,
			'label' => 'Skills',
			'query_var' => true,
			'rewrite' => array('slug' => 'skills-toys')
		)
	);
}

function create_toys_columns($columns) {
    $columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __('Name'),
		'taxonomy' => __('Taxonomy'),
		'acf-field' => __('Advanced Custom Field'),
	);
	return $columns;
}

function manage_toys_columns($column, $post_id) {
	global $post;
	switch($column) {
		case 'taxonomy':
			$test = get_post_meta($post_id, 'toys', true);
			if(!empty($test)) echo $test;
			break;
		case 'acf-field':
			$field = get_post_meta($post_id, 'acf-field', true);
			if(!empty($field)) echo $field;
			break;
		default : break;
	}
}

add_action('init', 'create_toys');
add_action('init', 'create_toys_taxonomies');
add_filter('manage_edit-toys_columns', 'create_toys_columns' ) ;
add_action('manage_toys_posts_custom_column', 'manage_toys_columns', 10, 2 );

/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/

/**
 * Create Custom Post Type: PlinkitParents
 * Create Taxonomies: PlinkitParents Categories
 * Create Columns: PlinkitParents
 * Manage Columns: PlinkitParents
 */
function create_plinkitparents() {
	register_post_type(
		'plinkitparents',
		array(
			'labels' => array(
				'name' => __("PlinkitParents"),
				'singular_name' => __("PlinkitParents"),
				'add_new' => __("Add New"),
				'add_new_item' => __("Add New PlinkitParent"),
				'edit_item' => __("Edit PlinkitParent"),
				'new_item' => __("New PlinkitParent"),
				'view_item' => __("View PlinkitParent"),
				'search_items' => __("Search PlinkitParents"),
				'not_found' => __("No PlinkitParents found."),
				'not_found_in_trash' => __("No PlinkitParents found in trash."),
				'edit' => __("Edit PlinkitParent"),
				'view' => __("View PlinkitParent")
			),
			'exclude_from_search' => false,
			'menu_icon' => 'dashicons-groups',
			'public' => true,
			'rewrite' => array('slug' => 'plinkitparents'),
			'supports' => array('title','editor','author','excerpt','comments','revisions')
		)
	);
	flush_rewrite_rules();
}

function create_plinkitparents_taxonomies() {
	register_taxonomy(
		'plinkitparents-categories',
		'plinkitparents',
		array(
			'hierarchical' => true,
			'label' => 'Categories',
			'query_var' => true,
			'rewrite' => array('slug' => 'plinkitparents-categories')
		)
	);
}

function create_plinkitparents_columns($columns) {
    $columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __('Name'),
		'taxonomy' => __('Taxonomy'),
		'acf-field' => __('Advanced Custom Field'),
	);
	return $columns;
}

function manage_plinkitparents_columns($column, $post_id) {
	global $post;
	switch($column) {
		case 'taxonomy':
			$test = get_post_meta($post_id, 'plinkitparents', true);
			if(!empty($test)) echo $test;
			break;
		case 'acf-field':
			$field = get_post_meta($post_id, 'acf-field', true);
			if(!empty($field)) echo $field;
			break;
		default : break;
	}
}

add_action('init', 'create_plinkitparents');
add_action('init', 'create_plinkitparents_taxonomies');
add_filter('manage_edit-plinkitparents_columns', 'create_plinkitparents_columns' ) ;
add_action('manage_plinkitparents_posts_custom_column', 'manage_plinkitparents_columns', 10, 2 );

/**
 * Exclude 'Holiday' from search
 */

add_filter('relevanssi_do_not_index', 'rlv_exclude_cat', 10, 2);
function rlv_exclude_cat($exclude, $post_id) {
    if (has_term( 'holiday', 'toys-categories', $post_id )) $exclude = true;
    return $exclude;
}
 
function seoUrl($string) {
    //Lower case everything
    $string = strtolower($string);
    //Make alphanumeric (removes all other characters)
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    //Clean up multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);
    //Convert whitespaces and underscore to dash
    $string = preg_replace("/[\s_]/", "-", $string);
    return $string;
}

/**
 * Extend WordPress search to include custom fields
 *
 * http://adambalee.com
 */

/**
 * Join posts and postmeta tables
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_join
 */
/*
function cf_search_join( $join ) {
    global $wpdb;

    if ( is_search() ) {    
        $join .=' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
    }
    
    return $join;
}
add_filter('posts_join', 'cf_search_join' );
*/

/**
 * Modify the search query with posts_where
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_where
 */
/*
function cf_search_where( $where ) {
    global $wpdb;
   
    if ( is_search() ) {
        $where = preg_replace(
            "/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
            "(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );
    }

    return $where;
}
add_filter( 'posts_where', 'cf_search_where' );
*/

/**
 * Prevent duplicates
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_distinct
 */
/*
function cf_search_distinct( $where ) {
    global $wpdb;

    if ( is_search() ) {
        return "DISTINCT";
    }

    return $where;
}
add_filter( 'posts_distinct', 'cf_search_distinct' ); 
*/

/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/

function add_the_table_button( $buttons ) {
   array_push( $buttons, 'separator', 'table' );
   return $buttons;
}
add_filter( 'mce_buttons', 'add_the_table_button' );

function add_the_table_plugin( $plugins ) {
    $plugins['table'] = content_url() . '/tinymceplugins/table/plugin.min.js';
    return $plugins;
}
add_filter( 'mce_external_plugins', 'add_the_table_plugin' );

/**
 *  Plugin Name:   Meta OR Title query in WP_Query
 *  Description:   Activated through the '_meta_or_title' argument of WP_Query 
 *  Plugin URI:    http://wordpress.stackexchange.com/a/178492/26350
 *  Plugin Author: Birgir Erlendsson (birgire)
 *  Version:       0.0.1
 */

add_action( 'pre_get_posts', function( $q )
{
    if( $title = $q->get( '_meta_or_title' ) )
    {
        add_filter( 'get_meta_sql', function( $sql ) use ( $title )
        {
            global $wpdb;

            // Only run once:
            static $nr = 0; 
            if( 0 != $nr++ ) return $sql;

            // Modify WHERE part:
            $sql['where'] = sprintf(
                " AND ( %s OR %s ) ",
                $wpdb->prepare( "{$wpdb->posts}.post_title like '%%%s%%'", $title ),
                mb_substr( $sql['where'], 5, mb_strlen( $sql['where'] ) )
            );
            return $sql;
        });
    }
});

function mytheme_change_tinymce_colors( $init ) {
    $default_colours = '
        "56575b", "Text",
        "46b8ba", "Teal",
        "e7664d", "Coral",
        ';
    $custom_colours = '
        "e14d43", "Color 1 Name",
        "d83131", "Color 2 Name",
        "ed1c24", "Color 3 Name",
        "f99b1c", "Color 4 Name",
        "50b848", "Color 5 Name",
        "00a859", "Color 6 Name",
        "00aae7", "Color 7 Name",
        "282828", "Color 8 Name"
        ';
    $init['textcolor_map'] = '['.$default_colours.','.$custom_colours.']';
    $init['textcolor_rows'] = 6; // expand colour grid to 6 rows
    return $init;
}
add_filter('tiny_mce_before_init', 'mytheme_change_tinymce_colors');


/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/


add_filter( 'the_posts', function( $posts, $q ) 
{
    if( $q->is_main_query() && $q->is_search() ) 
    {
        usort( $posts, function( $a, $b ){
            /**
             * Sort by post type. If the post type between two posts are the same
             * sort by post date. Make sure you change your post types according to 
             * your specific post types. This is my post types on my test site
             */
            $post_types = [
                'post'       => 1,
                'toys'       => 2
            ];              
            if ( $post_types[$a->post_type] != $post_types[$b->post_type] ) {
                return $post_types[$a->post_type] - $post_types[$b->post_type];
            } else {
                return $a->post_date < $b->post_date; // Change to > if you need oldest posts first
            }
        });
    }
    return $posts;
}, 10, 2 );

add_filter(  'gettext',  'register_text'  );
add_filter(  'ngettext',  'register_text'  );
function register_text( $translated ) {
     $translated = str_ireplace(  'Register',  'Get Started Now!',  $translated );
     return $translated;
}

/*
 * Change Send Credentials via Email text. Tags: send credentials, email
 */
add_filter('wppb_send_credentials_checkbox_logic', 'wppbc_send_credentials_checkbox', 10, 2);
function wppbc_send_credentials_checkbox($requestdata, $form){
   return '<li class="wppb-form-field wppb-send-credentials-checkbox"><label for="send_credentials_via_email"><input id="send_credentials_via_email" type="checkbox" name="send_credentials_via_email" value="sending"'.( ( isset( $request_data['send_credentials_via_email'] ) && ( $request_data['send_credentials_via_email'] == 'sending' ) ) ? ' checked' : '' ).'/>'.
   __( 'Send me an email confirmation.', 'profilebuilder').'</label></li>';
}

/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/

function ajax_login_init(){

    wp_register_script('ajax-login-script', get_template_directory_uri() . '/js/ajax-login-script.js', array('jquery') ); 
    wp_enqueue_script('ajax-login-script');

    wp_localize_script( 'ajax-login-script', 'ajax_login_object', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'redirecturl' => home_url(),
        'loadingmessage' => __('Sending user info, please wait...')
    ));

    // Enable the user with no privileges to run ajax_login() in AJAX
    add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );
}

// Execute the action only if the user isn't logged in
if (!is_user_logged_in()) {
    add_action('init', 'ajax_login_init');
}

function ajax_login(){

    // First check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-login-nonce', 'security' );

    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;

    $user_signon = wp_signon( $info, false );
    if ( is_wp_error($user_signon)){
        echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.')));
    } else {
        echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, redirecting...')));
    }

    die();
}

/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/

add_action('pre_get_posts','change_numberposts_for_author');

function change_numberposts_for_author( $query ) {
  if ( ! is_admin() && $query->is_main_query() && is_author() ) {
    $query->set('posts_per_page', -1); // 30 is the number of posts
  }
}

/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/


function change_wp_search_size($query) {
    if ( $query->is_search ) // Make sure it is a search page
        $query->query_vars['posts_per_page'] = -1; // Change 10 to the number of posts you would like to show
    return $query; // Return our modified query variables
}
add_filter('pre_get_posts', 'change_wp_search_size'); // Hook our custom function onto the request filter

/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/


function update_price_cf( $value, $post_id, $field ) {
 
   $excerpt = get_post_meta( $post_id, 'excerpt', true );
   $content = get_post_meta( $post_id, 'content', true );
   $content = wp_trim_words( $content, $num_words = 20, $more = '...' );

   
   $value = $content;
   

   return $value;

}
add_filter('acf/update_value/name=excerpt', 'update_price_cf', 10, 3);



/**
 * Display a custom taxonomy dropdown in admin
 * @author Mike Hemberger
 * @link http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
 */
add_action('restrict_manage_posts', 'tsm_filter_post_type_by_taxonomy');
function tsm_filter_post_type_by_taxonomy() {
	global $typenow;
	$post_type = 'post'; // change to your post type
	$taxonomy  = 'skills'; // change to your taxonomy
	if ($typenow == $post_type) {
		$selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
		$info_taxonomy = get_taxonomy($taxonomy);
		wp_dropdown_categories(array(
			'show_option_all' => __("Show All {$info_taxonomy->label}"),
			'taxonomy'        => $taxonomy,
			'name'            => $taxonomy,
			'orderby'         => 'name',
			'selected'        => $selected,
			'show_count'      => true,
			'hide_empty'      => true,
		));
	};
}

add_action('restrict_manage_posts', 'tsm_filter_post_type_by_taxonomy_toys');
function tsm_filter_post_type_by_taxonomy_toys() {
	global $typenow;
	$post_type = 'toys'; // change to your post type
	$taxonomy  = 'skills-toys'; // change to your taxonomy
	if ($typenow == $post_type) {
		$selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
		$info_taxonomy = get_taxonomy($taxonomy);
		wp_dropdown_categories(array(
			'show_option_all' => __("Show All {$info_taxonomy->label}"),
			'taxonomy'        => $taxonomy,
			'name'            => $taxonomy,
			'orderby'         => 'name',
			'selected'        => $selected,
			'show_count'      => true,
			'hide_empty'      => true,
		));
	};
}

add_action('restrict_manage_posts', 'tsm_filter_post_type_by_taxonomy_toys_age');
function tsm_filter_post_type_by_taxonomy_toys_age() {
	global $typenow;
	$post_type = 'toys'; // change to your post type
	$taxonomy  = 'age-range-toys'; // change to your taxonomy
	if ($typenow == $post_type) {
		$selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
		$info_taxonomy = get_taxonomy($taxonomy);
		wp_dropdown_categories(array(
			'show_option_all' => __("Show All {$info_taxonomy->label}"),
			'taxonomy'        => $taxonomy,
			'name'            => $taxonomy,
			'orderby'         => 'name',
			'selected'        => $selected,
			'show_count'      => true,
			'hide_empty'      => true,
		));
	};
}

/**
 * Filter posts by taxonomy in admin
 * @author  Mike Hemberger
 * @link http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
 */
add_filter('parse_query', 'tsm_convert_id_to_term_in_query');
function tsm_convert_id_to_term_in_query($query) {
	global $pagenow;
	$post_type = 'post'; // change to your post type
	$taxonomy  = 'skills'; // change to your taxonomy
	$q_vars    = &$query->query_vars;
	if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
		$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
		$q_vars[$taxonomy] = $term->slug;
	}
}

add_filter('parse_query', 'tsm_convert_id_to_term_in_query_toys');
function tsm_convert_id_to_term_in_query_toys($query) {
	global $pagenow;
	$post_type = 'toys'; // change to your post type
	$taxonomy  = 'skills-toys'; // change to your taxonomy
	$q_vars    = &$query->query_vars;
	if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
		$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
		$q_vars[$taxonomy] = $term->slug;
	}
}


add_action('restrict_manage_posts', 'tsm_filter_post_type_by_age');
function tsm_filter_post_type_by_age() {
	global $typenow;
	$post_type = 'post'; // change to your post type
	$taxonomy  = 'age-range'; // change to your taxonomy
	if ($typenow == $post_type) {
		$selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
		$info_taxonomy = get_taxonomy($taxonomy);
		wp_dropdown_categories(array(
			'show_option_all' => __("Show All {$info_taxonomy->label}s"),
			'taxonomy'        => $taxonomy,
			'name'            => $taxonomy,
			'orderby'         => 'name',
			'selected'        => $selected,
			'show_count'      => true,
			'hide_empty'      => true,
		));
	};
}
/**
 * Filter posts by taxonomy in admin
 * @author  Mike Hemberger
 * @link http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
 */
add_filter('parse_query', 'tsm_convert_id_to_age_in_query');
function tsm_convert_id_to_age_in_query($query) {
	global $pagenow;
	$post_type = 'post'; // change to your post type
	$taxonomy  = 'age-range'; // change to your taxonomy
	$q_vars    = &$query->query_vars;
	if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
		$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
		$q_vars[$taxonomy] = $term->slug;
	}
}

add_filter('parse_query', 'tsm_convert_id_to_age_in_query_toys');
function tsm_convert_id_to_age_in_query_toys($query) {
	global $pagenow;
	$post_type = 'toys'; // change to your post type
	$taxonomy  = 'age-range-toys'; // change to your taxonomy
	$q_vars    = &$query->query_vars;
	if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
		$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
		$q_vars[$taxonomy] = $term->slug;
	}
}

/*
function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/img/site-login-logo.png);
		height:79px;
		width:237px;
		background-size: 237px 79px;
		background-repeat: no-repeat;
        	padding-bottom: 30px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );
*/


/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/


add_filter('relevanssi_modify_wp_query', 'rlv_meta_fix', 99);
function rlv_meta_fix($q) {
	$q->set('meta_query', '');
	return $q;
}

function reindex_relevanssi () {
    relevanssi_build_index(false, false, 300);
} add_action('reindex_relevanssi', 'reindex_relevanssi');

add_filter('relevanssi_do_not_index', 'rlv_exclude_protected', 10, 2);
function rlv_exclude_protected($exclude, $post_id) {
	$post = get_post($post_id);
	if (!empty($post->post_password)) $exclude = true;
	return $exclude;
}

add_filter('pms_register_form_submit_text', 'pmsc_change_register_submit_text');
function pmsc_change_register_submit_text() {
	return 'Sign Up Now!';
}

/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/

/**
 * Disable The Stupid Block Editor
 */

add_filter('use_block_editor_for_post', '__return_false', 10);

function remove_block_css(){
wp_dequeue_style( 'wp-block-library' );
}
add_action( 'wp_enqueue_scripts', 'remove_block_css', 100 );


/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/

/**
 * Remove private from ACF POST OBJECT
 */
 

function my_post_object_query($args, $field, $post_id) {
	
	$args['post_status'] = array('publish');
	
	return $args;
}

// filter for every field
add_filter('acf/fields/post_object/query/name=field_5937991577b01', 'my_post_object_query', 10, 3);


/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/

/**
 * Move Yoast To Bottom Of Pages

 
function yoasttobottom() {
	return 'low';
}

add_filter('wpseo_metabox_prio', 'yoasttobottom');
 */


?>
