<?php
/*
 * Plugin Name: wishlist-pja
 * Description: Lista życzeń dla Kosiarkopolexu
 * Author: Konrad Semmler
 * Version: 0.2
 * License: GPL2+
 */
	// TODO zmień wyświetlanie cen w tabelce i nazwy kolumn

error_reporting(E_ALL); 
ini_set("display_errors", 1);

if ( !class_exists('PJAWishlistPlugin') ){
	class PJAWishlistPlugin{

		private static $_version = '0.2';
		private static $scripts_version;
		private static $wishlist;
		public static $table_name;
 
		static function init(){
			global $table_prefix, $wpdb;

			if(isset($this) && get_class($this) == __CLASS__)
				wp_die();

			self::$table_name = $table_prefix.'pja_wishlists';

			require('wishlist-pja-class.php');
		 
			self::$wishlist = new PJAWishlistPlugin_Wishlist();

			register_activation_hook(__FILE__, array('PJAWishlistPlugin', 'activate_plugin'));
			register_uninstall_hook(__FILE__, array('PJAWishlistPlugin', 'uninstall_plugin'));	

			add_action('wp_enqueue_scripts', array('PJAWishlistPlugin', 'load_js_css'));
			add_action('wp_ajax_pja-wl-addtowishlist', array('PJAWishlistPlugin', 'add_to_wishlist'));	
			add_action('woocommerce_after_single_product_summary', array('PJAWishlistPlugin', 'add_button_wishlist'), 5);	
			add_action('woocommerce_after_my_account', array('PJAWishlistPlugin', 'render_wishlist'));
			add_action('wp_head', array('PJAWishlistPlugin', 'def_js_vars'));	
			add_action('delete_post', array('PJAWishlistPlugin', 'remove_from_wishlist'));
			add_action('wp_ajax_pja-wl-removefromuserwishlist', array('PJAWishlistPlugin', 'remove_from_user_wishlist'));	
		}

		public static function activate_plugin() {
			global $wpdb;
			$sql = "CREATE TABLE `" . self::$table_name . "` ( ";
			$sql .= " `user_id` bigint(20) NOT NULL, ";
			$sql .= " `product_id` bigint(20) NOT NULL, ";
			$sql .= " PRIMARY KEY (`user_id`,`product_id`) ";
			$sql .= ") ENGINE=MyISAM DEFAULT CHARSET=utf-8; ";
			require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
			dbDelta($sql);
		}
 
		public static function uninstall_plugin() {
			global $wpdb;
			$sql = "DROP TABLE `" . self::$table_name . "`;";
			require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
			dbDelta($sql);
		}

		public static function load_js_css() {
			wp_register_script(
				'pja-main', 
				plugins_url('assets/js/main.js', __FILE__), 
				array('jquery'), 
				self::$scripts_version, true 
			);
			wp_enqueue_script('pja-main');

			wp_register_style(
				'pja-css', 
				plugins_url('assets/css/styles.css', __FILE__), 
				array(), 
				self::$scripts_version, 
				false 
			);
			wp_enqueue_style('pja-css');
		}

		public static function add_to_wishlist() {
			$response = false;
			if(is_user_logged_in()) {
				$product_id = floatval($_POST['p']);
				if($product_id > 0) {
					$response = self::$wishlist->add_product_to_wishlist($product_id, get_current_user_id());
				}
			}

			if($response){
				die(json_encode(array('response' => 'OK')));
			} else {
				die(json_encode(array('response' => 'KO')));
			}			
		}

		public static function add_button_wishlist() {
			if(is_user_logged_in()) {
				global $product;
				if(!self::$wishlist->product_in_wishlist($product->post->ID, get_current_user_id())) {
					self::$wishlist->show_button($product->post->ID);
				}
				else {
					self::$wishlist->show_delete_button($product->post->ID);
				}
			}		
		}		

		public static function render_wishlist() {
			if(is_user_logged_in()) {
				echo '<div class="pja-wl-wishlist"><h2>'.__( 'Lista życzeń', 'PJAWishlistPlugin');
				self::$wishlist->render_list(get_current_user_id());
				echo '</div>';
			}
				
		}

		public static function def_js_vars() {
			?>
			<script type="text/javascript">
				var pjawl_ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
				var pjawl_msg_ok = '<?php _e('Dodano do listy życzeń!', 'PJAWishlistPlugin'); ?>';
				var pjawl_msg_drop = '<?php _e('Usunięto z listy życzeń!', 'PJAWishlistPlugin'); ?>';
				var pjawl_msg_ko = '<?php _e('Błąd! :(', 'PJAWishlistPlugin'); ?>';
			</script>
			<?php
		}

		public static function remove_from_wishlist($post_id) {
			self::$wishlist->remove_product_from_wishlist($post_id);
		}	

		public static function remove_from_user_wishlist() {
			$response = false;
			if(is_user_logged_in()) {
				$product_id = floatval($_POST['p']);
				if($product_id > 0) {
					$response = self::$wishlist->remove_from_user_wishlist($product_id, get_current_user_id());
				}
			}

			if($response){
				die(json_encode(array('response' => 'OK')));
			} else {
				die( son_encode(array('response' => 'KO')));
			}	
		}	


	}
}

PJAWishlistPlugin::init();
?>