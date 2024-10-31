<?php
/**
 * Plugin Name: PayPal Cart by Human80
 * Description: Adds a "Purchase" buttom to any post and sell things through your PayPal account.
 * Version: 1.3
 * Author: Human80, LLC
 */

// Hook for adding admin menus
add_action('admin_menu', 'h80_cart_pages');

// action function for above hook
function h80_cart_pages() {
    // Add a new submenu under Settings:
    add_options_page(__('PayPal Cart','menu-test'), __('PayPal Cart','menu-test'), 'manage_options', 'paypal-cart', 'h80_settings_page');
}

// h80_cart_page() displays the page content for the settings submenu
function h80_settings_page() {
    echo "<h2>" . __( 'PayPal Cart Settings', 'menu-test' ) . "</h2>";
if(isset($_POST['submitcartdata']))
{
	global $wpdb;
	//$shipping_Charges = $_POST['Shipping_charges'];
	//if ( ($shipping_Charges == null) || ($shipping_Charges == 0) ) {
	//$shipping_Charges = 0;
	//}
	$table_name = $wpdb->prefix . "H80cart_data"; 
	$wpdb->query("DELETE FROM $table_name");
	$wpdb->insert( $table_name, array( 'id' => 1 ,'Paypal_acc' => $_POST['paypalacc'], 'Currency' => $_POST['currency'] ,'Css' => $_POST['custom_css']) ); 
	//'Shipping_charges' => $shipping_Charges , 
}
wp_nonce_field('update-options') ?>
	<div class="version">
	<p>Plugin Version : <?php global $H80cart_version; echo $H80cart_version; ?> </p>
	</div>

<div id="wrap">
	<form action="" method="post" name="h8cartdata">
		<table class="form-table" border="0">
			<?php
			global $wpdb;
			$table_name = $wpdb->prefix . "H80cart_data"; 
			$h80_fields = $wpdb->get_row("SELECT * FROM $table_name", ARRAY_N); 
			?>
			<tr> 
			<th>Paypal Account
			<?php echo '$table_name' ?>
			</th>
			<td colspan="2"><input type="email" name="paypalacc" class="regular-text" value="<?php echo $h80_fields[1]; ?>"> Enter the email address of your PayPal Account.</td>
			</tr>
			<tr>
			<th>Select Currency</th>
			<td colspan="2"><select name="currency" value="">
			<option value="USD"<?php if($h80_fields[2] == 'USD' ): ?> selected="selected"<?php endif; ?> >U.S. Dollar</option>
			<option value="AUD"<?php if($h80_fields[2] == 'AUD'): ?> selected="selected" <?php endif; ?> >Australian Dollar</option> 	
			<option value="CAD"<?php if($h80_fields[2] == 'CAD' ): ?> selected="selected"<?php endif; ?> >Canadian Dollar</option>
			<option value="CZK"<?php if($h80_fields[2] == 'CZK' ): ?> selected="selected"<?php endif; ?> >Czech Koruna</option>  
			<option value="DKK"<?php if($h80_fields[2] == 'DKK' ): ?> selected="selected"<?php endif; ?> >Danish Krone</option>
			<option value="EUR"<?php if($h80_fields[2] == 'EUR' ): ?> selected="selected"<?php endif; ?> >Euro</option>  
			<option value="HKD"<?php if($h80_fields[2] == 'HKD' ): ?> selected="selected"<?php endif; ?> >Hong Kong Dollar</option>  
			<option value="HUF"<?php if($h80_fields[2] == 'HUF' ): ?> selected="selected"<?php endif; ?> >Hungarian Forint</option> 	
			<option value="JPY"<?php if($h80_fields[2] == 'JPY' ): ?> selected="selected"<?php endif; ?> >Japanese Yen</option>
			<option value="NOK"<?php if($h80_fields[2] == 'NOK' ): ?> selected="selected"<?php endif; ?> >Norwegian Krone</option>  
			<option value="NZD"<?php if($h80_fields[2] == 'NZD' ): ?> selected="selected"<?php endif; ?> >New Zealand Dollar</option>
			<option value="PLN"<?php if($h80_fields[2] == 'PLN' ): ?> selected="selected"<?php endif; ?> >Polish Zloty</option>  
			<option value="GBP"<?php if($h80_fields[2] == 'GBP' ): ?> selected="selected"<?php endif; ?> >Pound Sterling</option>
			<option value="SGD"<?php if($h80_fields[2] == 'SGD' ): ?> selected="selected"<?php endif; ?> >Singapore Dollar</option>  
			<option value="SEK"<?php if($h80_fields[2] == 'SEK' ): ?> selected="selected"<?php endif; ?> >Swedish Krona</option>
			<option value="CHF"<?php if($h80_fields[2] == 'CHF' ): ?> selected="selected"<?php endif; ?> >Swiss Franc</option>  
			</select> Choose your preferred currency.</td>
			</tr>
			<!--<tr>
			<th>Default Shipping Charge</th>
			<td><input type="text" name="shipping_Charges" value="<?php echo $h80_fields[3]; ?>" class="regular-text" style="width:5em;"> added to every item purchased. Can be over-ridden by a shipping charge associated with each post.</td>
		</tr>-->
			<tr>
			<th>Custom CSS</th>
			<td><textarea name="custom_css" cols="50" rows="12"><?php echo $h80_fields[4]; ?></textarea></td>
			<td align="left" valign="top">
			<!--- <pre> --->
			<strong>CSS Definitions</strong><br>
			class="h80_purchase": the purchase button that links to PayPal<br>
			class="h80_price": the price<br>
			class="h80_shipping: the shipping and handling charge<br>
			class="h80_inventory": the inventory line<br>
			class="h80_sold": the inventory number<br>
			<!--- </pre> --->
			</td>
			</tr>
		</table>
		<p class="submit">
		<input type="submit" class="button button-primary" value="Save Changes" name="submitcartdata">
		</p>
	</form>
	<div class="version">
	<!--- <p>Plugin Version : <?php global $H80cart_version; echo $H80cart_version; ?> </p> --->
	<p><a href="http://human80.com/cart/donate.cfm">Help support this plugin with your donation.</a></p>
	</div>
	
</div>
<?php
}
global $H80cart_version;
$H80cart_version = "1.3";
function h80_form_setup() {
	global $wpdb;
	global $H80cart_version;
	$table_name = $wpdb->prefix . "H80cart_data";
	$sql = "CREATE TABLE $table_name (
		id mediumint(255) NOT NULL ,
		Paypal_acc tinytext NOT NULL,
		Currency text NOT NULL,
		Shipping_charges int(255) DEFAULT '0',
		Css text(255) NOT NULL,
		UNIQUE KEY id (id)
	);";
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
	add_option( "H80cart_version",$H80cart_version );
}
register_activation_hook( __FILE__, 'h80_form_setup' );
//register_activation_hook( __FILE__, 'h80_form_setup_data' );

//<!-----metabox code------> 
$prefix = 'h80_';
$meta_box = array(
    'id' => 'my-meta-box',
    'title' => 'Paypal Cart',
    'page' => 'post',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
		array(
 			'name' => 'Item Title',
 			'desc' => '',
 			'id' => $prefix . 'item_title',
 			'type' => 'text',
			'std' => '',
			'msg' => '(Appears in Paypal cart.)'
      	),
 		array(
			'name' => 'Price',
 			'desc' => '',
 			'id' => $prefix . 'price',
 			'type' => 'text',
 			'std' => '',
			'msg' => '(Numbers only ie: 4.76.)'
 		),
 		array(
			'name' => 'Shipping and Handling Charges',
			'desc' => '',
			'id' => $prefix . 'shipping',
			'type' => 'text',
			'std' => '',
			'msg' => ''
		),
		array(
			'name' => 'Inventory',
			'desc' => '',
			'id' => $prefix . 'inventory',
			'type' => 'text',
			'std' => '',
			'msg' => '(Enter "Sold" when item is sold.)'
      )
   )
);
add_action('admin_menu', 'h80_add_box');
// Add meta box
function h80_add_box() {
    global $meta_box;
    add_meta_box($meta_box['id'], $meta_box['title'], 'h80_show_box', $meta_box['page'], $meta_box['context'], $meta_box['priority']);
}

// Callback function to show fields in meta box
function h80_show_box() {
    global $meta_box, $post;
    // Use nonce for verification
    echo '<input type="hidden" name="h80_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
    echo '';
    foreach ($meta_box['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);
        echo '',
                '<b><label for="', $field['id'], '">', $field['name'], '</label></b> <i><label for="', $field['id'], '">', $field['msg'], '</label></i><br />',
                '';
        switch ($field['type']) {
            case 'text':
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '"  />', '<br />', $field['desc'];
                break;
            }
//       echo     '<i><label for="', $field['id'], '">', $field['msg'], '</label></i><br />',
//			'';
    }
}
add_action('save_post', 'h80_save_data');
// Save data from meta box
function h80_save_data($post_id) {
    global $meta_box;
    // verify nonce
    if (!wp_verify_nonce($_POST['h80_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
    foreach ($meta_box['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}

// check autosave
if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return $post_id;
}

// Including style sheet
function h80_cart_styles()  
{  
    // Register the stylesheet h80_cart.css for a plugin:  
    wp_register_style( 'custom-style', plugins_url( '/css/h80_cart.css', __FILE__ ), array(), '20120208', 'all' );  
    wp_enqueue_style( 'custom-style' );  
}  
add_action( 'wp_enqueue_scripts', 'h80_cart_styles' );  

// front end dispay

function add_h80post_content($content) {
if(!is_feed()) {
	global $post;
	$return_link = get_permalink( $post->ID ); 
	//echo $return_link;
	$meta_inv = get_post_meta($post->ID, 'h80_inventory', true);
	$meta_pr = get_post_meta($post->ID, 'h80_price', true);
	global $wpdb;
	$table_name = $wpdb->prefix . "H80cart_data"; 
	$h80_fields = $wpdb->get_row("SELECT * FROM $table_name", ARRAY_N); 
if (is_single() ) {
	if( $post->h80_shipping > 0 ) {
		$cart_shipping = $post->h80_shipping; }
	else { $cart_shipping = $h80_fields[3]; }
	$target_link =  get_post_meta($post->ID, 'h80_downloadurl', true);
	if( $post->h80_downloadurl !== '' ) {
	//echo 'here';
		$target_link = $post->h80_downloadurl; }
	else { //	echo 'there';
		$target_link = $return_link; }
	//echo $target_link;
	if( $post->h80_item_title !== '' ) {
	//echo 'here';
		$item_title = $post->h80_item_title; }
	else { //	echo 'there';
		$item_title = $post->post_title; }

		$link = "https://www.paypal.com/cgi-bin/webscr?cmd=_cart&business=".$h80_fields[1]."&item_name=".$item_title."&amount=".$post->h80_price."&shipping=".$cart_shipping."&currency_code=".$h80_fields[2]."&button_subtype=products&no_note=0&add=1&quantity=1&return=".$target_link."&cancel_return=".$return_link."&shopping_url=".$return_link;
	$h8o_currency = array('AU$' => 'AUD', 'CA$' => 'CAD', 'Kč' => 'CZK', 'Dkr' => 'DKK', '€' => 'EUR', 'HK$' => 'HKD', 'Ft' => 'HUF',   '¥' => 'JPY', 'Nkr' => 'NOK', 'NZ$' => 'NZD', 'zł' => 'PLN', '£' => 'GBP', 'S$' => 'SGD', 'Skr' => 'SEK', 'Fr.' => 'CHF', '$' => 'USD' );
		if (strpos($meta_inv, 'Sold') !== FALSE) {
			$content .='<style>.h80_sold {color:red;}.h80_purchase {display:none;}</style>';
		}
	if( $meta_pr > 0 or (strpos($meta_inv, 'Sold') !== FALSE)) {
		$content .='<div id="h80_wp_cart">';
		$meta_pr = get_post_meta($post->ID, 'h80_price', true); 
		$content .='<div class="h80_purchase"><span class="h80_sold"><a href=" '.$link.' " target="_blank" class="button">Purchase</a></span></div>';
		while ($h80currency_name = current($h8o_currency)) {
		if ($h80currency_name == $h80_fields[2]) {
		$content .= '<div class="h80_price">Price:'.key($h8o_currency).$meta_pr.'</div>'; }
		$meta_currency = key($h8o_currency); 
		next($h8o_currency);  }
		if( $meta_inv > 0 or (strpos($meta_inv, 'Sold') !== FALSE)) {
		$content .='<div class="h80_inventory">Available: <span class="h80_sold">'.$meta_inv.'</span></div>';
		}
		if( $cart_shipping > 0 ) {
		$content .='<div class="h80_shipping">Shipping & Handling:<strong> '.$meta_currency.$cart_shipping.'</strong></div>';}
		$content .='<em>All prices in ' .$h80_fields[2]. '</em>';
		$content .='</div>';
		 } 
		
		}
	 
	}
/*	if( $meta_inv > 0 ) {
		$content .='<div id="h80_wp_cart">';
		$meta_pr = get_post_meta($post->ID, 'h80_price', true); 
		if (strpos($meta_inv, 'Sold') !== FALSE) {
			$content .='<style>.h80_sold {color:red;}</style><div class="h80_purchase">';
		else
			$content .='<style>.h80_sold {}</style><div class="h80_purchase"><a href=" '.$link.' "target="_blank" class="button">Purchase</a>';
		}
//		$content .='<div class="h80_purchase"><a href=" '.$link.' " target="_blank" class="button">Purchase</a></div>';
		while ($h80currency_name = current($h8o_currency)) {
		if ($h80currency_name == $h80_fields[2]) {
		$content .= '<div class="h80_price">Price:<strong> '.key($h8o_currency).$meta_pr.'</strong></div>'; 
		if( $cart_shipping > 0 ) {
		$content .='<div class="h80_shipping">Shipping & Handling:<strong> '.key($h8o_currency).$cart_shipping.'</strong></div>';}
		}
		next($h8o_currency);  }
		$content .='<div class="h80_inventory">Available: <span class="h80_sold"><strong>'.$meta_inv.'</strong></span></div>';
		$content .='<em>All prices in ' .$h80_fields[2]. '</em>';
		$content .='</div>';
*/
	return $content;
}

add_filter('the_content', 'add_h80post_content'); 

//custom css display
function h80_custom_colors() {
global $wpdb;
	$table_name = $wpdb->prefix . "H80cart_data";
	$css = $wpdb->get_col("select Css FROM $table_name");
	$css=implode(',',$css);
	 echo '<style type="text/css">'.$css.'</style>';
}
add_action('wp_head', 'h80_custom_colors');
?>
