<?php
/*
Plugin Name: My Widget Plugin
Plugin URI: http://www.wpexplorer.com/create-widget-plugin-wordpress/
Description: This plugin adds a custom widget.
Version: 1.0
Author: AJ Clarke
Author URI: http://www.wpexplorer.com/create-widget-plugin-wordpress/
License: GPL2
*/
// The widget class
?>
<?php
include_once('database.php');
//Include Javascript library
// including ajax script in the plugin Myajax.ajaxurl
//wp_localize_script( 'admin-ajax', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php')));
/* wp_enqueue_script( 'demo' );
wp_enqueue_script( 'admin-ajax' ); */
function createtable(){

		global $wpdb;

		$table_name = $wpdb->prefix . "custom_widget";

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
		  widget_id mediumint(9) NOT NULL AUTO_INCREMENT,
		  name tinytext NOT NULL,
		  emailaddress varchar(255) DEFAULT '' NOT NULL,
		  subject varchar(255) NOT NULL,
		  pnumber varchar(255) NOT NULL,
		  website varchar(255) NOT NULL,
		  message varchar(255) DEFAULT '' NOT NULL,
		  PRIMARY KEY  (widget_id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

register_activation_hook(__FILE__, 'createtable' );

function deletetable(){

		global $wpdb;

		$table_name = $wpdb->prefix . "custom_widget";

		$sql1 = "DROP TABLE IF EXISTS $table_name;";
		$wpdb->query($sql1);
		delete_option("my_plugin_db_version");
	}

register_deactivation_hook(__FILE__, 'deletetable' );

#Ajax action function.......

function get_my_option() {
    /* $nom = $_POST['namo'];
    $emo = $_POST['emao']; */
	$name = $_POST['name'];
	$emailaddress = $_POST['emailaddress'];
	$subject = $_POST['subject'];
	$pnumber = $_POST['pnumber'];
	$website = $_POST['website'];
	$message = $_POST['message'];

    global $wpdb;

    $wpdb -> insert( 'cw_custom_widget', array('name' => $name, 'emailaddress' => $emailaddress, 'subject' => $subject, 'pnumber' => $pnumber, 'website' => $website,'message' => $message) );
    echo 'Form Submitted Successfully';
	wp_die();
}
add_action("wp_ajax_nopriv_get_my_option", "get_my_option");
add_action("wp_ajax_get_my_option", "get_my_option");

   #Shortcode function.........................................
function html_form_code() {
	global $wpdb;
    # Input form fields.....
    echo '<form method="post" id="InsertionForm">';

    echo '<h3>Insertion Form</h3>';

    echo '<p>Your Name (required) <br/>';

    echo '<input type="text" name="name" id="name" class="name-cusstom" value="" class="required"/>';

    echo '</p>';

    echo '<p>';

    echo 'Your Email (required) <br/>';

    echo '<input type="text" name="emailaddress" id="emailaddress" class="a" value=""/>';

    echo '</p>';
	
	 echo '<p>';

    echo 'Subject <br/>';

    echo '<input type="text" name="subject" id="subject" class="custom-subject" value=""/>';

    echo '</p>';

	echo '<p>';

    echo 'Phone Number <br/>';

    echo '<input type="text" name="pnumber" id="pnumber" class="custom-number" value=""/>';

    echo '</p>';
	
	echo '<p>';

    echo 'Website <br/>';

    echo '<input name="website" id="website" class="custom-web" value=""/>';

    echo '</p>';
	
	echo '<p>';

    echo 'Message <br/>';

    echo '<textarea name="message" class="textareac" id="message" placeholder="Enter Message here..."></textarea>';

    echo '</p>';
	
	echo '<input type="hidden" name="action" value="InsertionForm_action" />';
	
	wp_nonce_field('InsertionForm_action', '_acf_nonce', true, false);
	
    echo '<p><input type="submit" class="submiutone" name="submitbtn" value="Send"> ';

    echo '</form>';
?>
<div id="users_data"></div>
<?php }

//adding script files....

wp_enqueue_script('jquery.min', plugins_url('js/jquery.min.js', __FILE__), array('jquery'), '', true);

wp_enqueue_script('jquery.validate', plugins_url('js/jquery.validate.min.js', __FILE__), array('jquery'), '', true);

wp_enqueue_script('additional-methods', plugins_url('js/additional-methods.min.js', __FILE__), array('jquery'), '', true);

wp_enqueue_script('demo', plugins_url('js/demo.js', __FILE__), array('jquery'), '', true); // ajax script file...

wp_localize_script( 'demo', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) ); //including admin-ajax.php in website html

wp_enqueue_style('site-demos', plugins_url('css/site-demos.css', __FILE__) );

    //Shortcode working here....
add_shortcode( 'My_Custom_Widget', 'html_form_code' );

?>
