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
include_once('database.php'); /* Without include db file then run our program right way */
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

/* Setting Field Section */

add_action('admin_menu', function() {
    add_options_page( 'My awesome plugin settings', 'User Form Data', 'manage_options', 'user-form-data', 'my_awesome_plugin_page' );
});

function my_awesome_plugin_page(){
	global $wpdb;
	$sql1 = $wpdb->get_results("select * from cw_custom_widget"); ?>
	<div class="user-data">
	<h1>User Information Data</h1>
	<table>
	<tr>
		<th>Name</th>
		<th>Email</th>
		<th>Subject</th>
		<th>Phone Number</th>
		<th>Website</th>
		<th>Message</th>
	</tr>
	<?php foreach($sql1 as $result_row){ ?>
	<tr>
		<td><?php echo $result_row -> name; ?></td>
		<td><?php echo $result_row -> emailaddress; ?></td>
		<td><?php echo $result_row -> subject; ?></td>
		<td><?php echo $result_row -> pnumber; ?></td>
		<td><?php echo $result_row -> website; ?></td>
		<td><?php echo $result_row -> message; ?></td>
	</tr>
	<?php } ?>
	</table>
	</div>
<?php	//print_r($sql1);
}

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
	
    echo '<p><input type="submit" class="submiutone" name="submitbtn" value="Send">';

    echo '</form>';
?>
<div id="users_data"></div>
<?php } ?>

<?php

class My_Custom_Widget_New extends WP_Widget {
	// Main constructor
	public function __construct() {
		parent::__construct(
			'my_custom_widget_new',
			__( 'My Custom Widget New', 'text_domain' ),
			array(
				'customize_selective_refresh' => true,
			)
		);
		/* wp_enqueue_script('demo', plugins_url( '/js/demo.js' , __FILE__ ) , array( 'jquery' ));
		wp_enqueue_script( 'wpas-admin-ajax', admin_url( 'admin-ajax.php' ), array(), '1', false );
		wp_localize_script( 'wpas-admin-ajax', 'WPAS_Ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		add_action('wp_ajax_newfunctioncu', 'newfunctioncu');
		add_action('wp_ajax_nopriv_newfunctioncu', 'newfunctioncu'); */
	}

	// The widget form (for the backend )
	public function form( $instance ) {
		global $wpdb;
		$name = esc_attr($instance['name']);
		$emailadd = esc_attr($instance['emailaddress']);
		$subject = esc_attr($instance['subject']);
		$pnumber = esc_attr($instance['pnumber']);
		$website = esc_attr($instance['website']);
		$message = esc_attr($instance['message']);
		
		if($instance){
	?>
		<form method="post">
			Name: <input type="text" name="<?php echo $this->get_field_name( 'name' ); ?>" id="<?php echo $this->get_field_id( 'name' ); ?>" class="widefat" value=""/><br/>
			Email Address :<input type="text" name="<?php echo $this->get_field_name( 'emailaddress' ); ?>" id="<?php echo $this->get_field_id( 'emailaddress' ); ?>" class="widefat" value=""/><br/>
			Subject: <input type="text" name="<?php echo $this->get_field_name( 'subject' ); ?>" id="<?php echo $this->get_field_id( 'subject' ); ?>" class="widefat" value=""/><br/>
			Phone Number: <input type="text" name="<?php echo $this->get_field_name( 'pnumber' ); ?>" id="<?php echo $this->get_field_id( 'pnumber' ); ?>" class="widefat" value=""/><br/>
			Website: <input name="<?php echo $this->get_field_name( 'website' ); ?>" id="<?php echo $this->get_field_id( 'website' ); ?>" class="widefat" value=""/><br/>
			Message: <textarea name="<?php echo $this->get_field_name( 'message' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'message' ); ?>" placeholder="Enter Message here..."></textarea><br/>
			<input type="submit" value="Submit" name="" id="" class="widefat" />
        </form>
		
		<?php } else {
			$name = '';
			$emailadd = '';
			$subject = '';
			$pnumber = '';
			$website = '';
			$message = '';
		}
	}

	// The widget form (for the frontend )
	public function widget( $args, $instance ) {

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
	
    echo '<p><input type="submit" class="submiutone" name="submitbtn" value="Send"> ';

    echo '</form>'; ?>
	
	<div id="users_data"></div>
<?php

}
	 function update( $new_instance, $old_instance ) {
        // processes widget options to be saved
        return $new_instance;
    }
}
// Register the widget
function my_register_custom_widget() {
	register_widget( 'My_Custom_Widget_New' );
}
add_action( 'widgets_init', 'my_register_custom_widget' );

//adding script files....

//wp_enqueue_script('jquery.min', plugins_url('js/jquery.min.js', __FILE__), array('jquery'), '', true);

wp_enqueue_script('jquery.validate', plugins_url('js/jquery.validate.min.js', __FILE__), array('jquery'), '', true);

//wp_enqueue_script('additional-methods', plugins_url('js/additional-methods.min.js', __FILE__), array('jquery'), '', true);

wp_enqueue_script('demo', plugins_url('js/demo.js', __FILE__), array('jquery'), '', true); // ajax script file...

wp_localize_script( 'demo', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) ); //including admin-ajax.php in website html

wp_enqueue_style('site-demos', plugins_url('css/site-demos.css', __FILE__) );

wp_enqueue_style('style', plugins_url('css/style.css', __FILE__) );

    //Shortcode working here....
add_shortcode( 'My_Custom_Widget', 'html_form_code' );

?>
