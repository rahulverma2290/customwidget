<?php
function otherfunctionone(){
 global $wpdb;
			$name = $_POST['name'];
			$emailaddress = $_POST['emailaddress'];
			$subject = $_POST['subject'];
			$pnumber = $_POST['pnumber'];
			$website = $_POST['website'];
			$message = $_POST['message'];

			global $wpdb;

			$table = 'cw_custom_widget';

			$data1 = array(   
			  'name' => $name,
			  'emailaddress' => $emailaddress,
			  'subject' => $subject,
			  'pnumber' => $pnumber,
			  'website' => $website,
			  'message' => $message,
			);

			$updated = $wpdb->insert( $table, $data1 );
			
			print_r($updated);
			
			/* print_r($post);
			$wpdb->insert(
				'cw_custom_widget',
				array( 
					'name' => $name,
					'emailaddress' => $emailaddress,
					'subject' => $subject,
					'pnumber' => $pnumber,
					'website' => $website,
					'message' => $message
				), 
				array( 
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s'
				) 
			);
			return true; */
aadd_action('wp_ajax_newfunctioncu', 'newfunctioncu');
add_action('wp_ajax_nopriv_newfunctioncu', 'newfunctioncu');
}
?>