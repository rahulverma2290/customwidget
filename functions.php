<?php

add_action( 'widgets_init', 'customwidget_init' );
function customwidget_init() {
    register_sidebar( array(
        'name' => __( 'Custom User Detail Sidebar', 'customwidget' ),
        'id' => 'sidebar-5',
        'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'customwidget' ),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
	'after_widget'  => '</li>',
	'before_title'  => '<h2 class="widgettitle">',
	'after_title'   => '</h2>',
    ) );
}

/* add_action('wp_head', 'plugin_set_ajax_url');
function plugin_set_ajax_url() {
?>
    <script type="text/javascript">
        var ajax_object = {};
        ajax_object.ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    </script>
<?php
}
?> */


/* Es action ko plugin ki file me bhi likh sakte he */

/* #Ajax action function.......

function get_my_option() {

    /* $nom = $_POST['namo'];
    $emo = $_POST['emao']; */
	/* $name = $_POST['name'];
	$emailaddress = $_POST['emailaddress'];
	$subject = $_POST['subject'];
	$pnumber = $_POST['pnumber'];
	$website = $_POST['website'];
	$message = $_POST['message'];

    global $wpdb;

    $wpdb -> insert( 'cw_custom_widget', array('name' => $name, 'emailaddress' => $emailaddress, 'subject' => $subject, 'pnumber' => $pnumber, 'website' => $website,'message' => $message) );
    echo 'Submitted';
	wp_die();
}
add_action("wp_ajax_nopriv_get_my_option", "get_my_option");
add_action("wp_ajax_get_my_option", "get_my_option"); */

/** WP_Widget_Recent_Posts class */
require_once( ABSPATH . WPINC . '/widgets/class-wp-widget-recent-posts.php' );


//add new menu for theme-options page with page callback theme-options-page.
add_action('admin_menu', 'my_plugin_menu');

function my_plugin_menu() {
	add_theme_page('My Plugin Theme', 'Theme Options', 'edit_theme_options', 'my-unique-identifier2', 'my_plugin_function'); /* This can add page into Appeareance Menus section */
}

/* function my_plugin_function(){
	echo "This is Theme Options Page.";
} */

add_action('admin_menu', 'my_plugin_menu_one');

function my_plugin_menu_one() {
	add_plugins_page('My Plugin Page', 'Custom My Plugin', 'read', 'my-unique-identifier1', 'my_plugin_function_plugin'); /* This can add page into plugins section or Add sub menu page to the Plugins menu. */
}

function my_plugin_function_plugin(){
	echo "This is Plugin Page.";
}

add_action('admin_menu', 'my_plugin_menu_two');

function my_plugin_menu_two() {
	add_dashboard_page('My Plugin Dashboard', 'Custom Dashboard Page', 'read', 'my-unique-identifier3', 'my_plugin_menu_three');
}

function my_plugin_menu_three(){
	echo "This is Dashboard Page.";
}

add_action('admin_menu', 'my_plugin_menu_four');

function my_plugin_menu_four() {
	add_posts_page('My Plugin Posts Page', 'Custom Posts Page', 'read', 'my-unique-identifier4', 'my_plugin_function_four');
}

function my_plugin_function_four(){
	echo "This is Posts Page.";
}

add_action('admin_menu', 'my_plugin_menu_five');

function my_plugin_menu_five() {
	add_media_page('My Plugin Media', 'Custom Media Page', 'read', 'my-unique-identifier5', 'my_plugin_function_five');
}

function my_plugin_function_five(){
	echo "This is Media Page.";
}

add_action( 'admin_menu', 'my_plugin_menu_six' );

function my_plugin_menu_six() {
	add_options_page( 'My Options', 'Custom Setting Page', 'manage_options', 'my-plugin.php', 'my_plugin_page_six');
}

function my_plugin_page_six(){
	echo "This is Setting Page.";
}

add_action( 'admin_menu', 'my_plugin_menu_seven' );

function my_plugin_menu_seven() {
	add_management_page( 'Custom Permalinks', 'Custom Permalinks', 'manage_options', 'my-unique-identifier7', 'custom_permalinks_options_page' );
}

function custom_permalinks_options_page(){
	echo "This is under tool page or Management Page";
}

add_action('admin_menu', 'my_users_menu_eight');

function my_users_menu_eight() {
	add_users_page('My Plugin Users', 'Custom Users', 'read', 'my-unique-identifier8', 'my_plugin_function_eight');
}

function my_plugin_function_eight(){
	echo "This is custom users page.";
}

add_action('admin_menu', 'my_users_menu_nine');

function my_users_menu_nine() {
	add_menu_page('My Plugin Custom Pages', 'Custom Users', 'read', 'my-unique-identifier9', 'my_plugin_function_nine');
	add_submenu_page('my-unique-identifier9','My Plugin Custom Sub Page', 'Custom Users SubMenu', 'read', 'my-unique-identifier10', 'my_plugin_function_ten');
}

function my_plugin_function_nine(){
	echo "This is pages Menu";
}

function my_plugin_function_ten(){
	echo "This is pages Submenu";
}

/* Remove Submenu https://developer.wordpress.org/reference/functions/register_setting/ */

add_action( 'admin_menu', 'nstrm_remove_admin_submenus', 999 );

function nstrm_remove_admin_submenus() {
	remove_submenu_page( 'edit.php', 'my-unique-identifier4' );
}

/* Add Seting Field and Setting Sections https://codex.wordpress.org/Settings_API */

function custom_section(){
	add_option('first_field_option',1);// add theme option to database
	
	add_settings_section( 'custom_user_section', 'Users Info Section', 'user_section_function', 'theme-options' );
	
	add_settings_field('custom_user_field','Users Fiels','user_field_function','theme-options','custom_user_section');
	
	register_setting( 'theme-options-rahul', 'first_field_option');
}

add_action('admin_init','custom_section');

function my_plugin_function(){
	?>
<div class="wrap">
<h1>Custom Theme Options Page</h1>
<form method="post" action="options.php">
<?php
// display settings field on theme-option page
settings_fields("theme-options-rahul");
// display all sections for theme-options page
do_settings_sections("theme-options");
submit_button();
?>
</form>
</div>
<?php }


function user_section_function(){
	echo "this is section testing.";
}

function user_field_function(){
	echo "this is field testing.";
}

/* Remove Menu */

/* function remove_menus(){
  
  remove_menu_page( 'index.php' );                  //Dashboard
  remove_menu_page( 'jetpack' );                    //Jetpack* 
  remove_menu_page( 'edit.php' );                   //Posts
  remove_menu_page( 'upload.php' );                 //Media
  remove_menu_page( 'edit.php?post_type=page' );    //Pages
  remove_menu_page( 'edit-comments.php' );          //Comments
  remove_menu_page( 'themes.php' );                 //Appearance
  remove_menu_page( 'plugins.php' );                //Plugins
  remove_menu_page( 'users.php' );                  //Users
  remove_menu_page( 'tools.php' );                  //Tools
  remove_menu_page( 'options-general.php' );        //Settings
  
}
add_action( 'admin_menu', 'remove_menus' );

add_action('admin_menu', 'my_plugin_menu');

function my_plugin_menu() {
	add_links_page('My Plugin Links', 'My Plugin', 'read', 'my-unique-identifier', 'my_plugin_function');
}

add_action('admin_menu', 'my_plugin_menu');

function my_plugin_menu() {
	add_pages_page('My Plugin Pages', 'My Plugin', 'read', 'my-unique-identifier', 'my_plugin_function');
}

add_action('admin_menu', 'my_plugin_menu');

function my_plugin_menu() {
	add_comments_page('My Plugin Comments', 'My Plugin', 'read', 'my-unique-identifier', 'my_plugin_function');
}



*/