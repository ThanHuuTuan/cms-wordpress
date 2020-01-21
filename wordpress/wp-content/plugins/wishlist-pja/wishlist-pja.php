<?php
/*
 * Plugin Name: wishlist-pja
 * Description: Lista życzeń dla Kosiarkopolexu
 * Author: Konrad Semmler
 * Version: 0.1
 * License: GPL2+
 */
	// TODO dodaj usuwanie z listy życzeń
	// TODO zmień wyświetlanie cen w tabelce i nazwy kolumn
if ( !class_exists('PJAWishlistPlugin') ){
	class PJAWishlistPlugin{

		private static $_version = '0.0.1';
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
			register_deactivation_hook(__FILE__, array('PJAWishlistPlugin', 'deactivate_plugin'));
			register_uninstall_hook(__FILE__, array('PJAWishlistPlugin', 'uninstall_plugin'));	

			add_action('wp_enqueue_scripts', array('PJAWishlistPlugin', 'load_js_css'));
			add_action('wp_ajax_pja-wl-addtowishlist', array('PJAWishlistPlugin', 'add_to_wishlist'));	
			add_action('woocommerce_after_single_product_summary', array('PJAWishlistPlugin', 'add_button_wishlist'), 5);	
			add_action('woocommerce_after_my_account', array('PJAWishlistPlugin', 'render_wishlist'));
			add_action('wp_head', array('PJAWishlistPlugin', 'def_js_vars'));	
			add_action('delete_post', array('PJAWishlistPlugin', 'remove_from_wishlist'));
		}
 


		public static function activate_plugin() {
			global $wpdb;
			// $wpdb->query(
			// 	'CREATE TABLE `' . self::$table_name . '` (
			//   	`user_id` bigint(20) NOT NULL,
			//   	`product_id` bigint(20) NOT NULL,
			//   	PRIMARY KEY (`user_id`,`product_id`)
			// 	) ' . $charset_collate . ';' 
			// );
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
			$wpdb->query('DROP TABLE `'.self::$table_name.'');
		}
 
		public static function deactivate_plugin() {
			# On deactivation, plugins can run a routine to remove temporary data such as 
			# cache and temp files, permalinks and directories.
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
				$product_id = floatval($_POST[ 'p' ]);
				if($product_id > 0) {
					$response = self::$wishlist->add_product_to_wishlist($product_id, get_current_user_id());
				}
			}

			if($response){
				die(json_encode(array('response' => 'OK')));
			} else {
				die( son_encode(array('response' => 'KO')));
			}			
		}

		public static function add_button_wishlist() {
			if(is_user_logged_in()) {
				global $product;
				if(!self::$wishlist->product_in_wishlist($product->post->ID, get_current_user_id())) {
					self::$wishlist->show_button($product->post->ID);
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
				var pjawl_msg_ko = '<?php _e('Błąd! :(', 'PJAWishlistPlugin'); ?>';
			</script>
			<?php
		}

		public static function remove_from_wishlist($post_id) {
			self::$wishlist->remove_product_from_wishlist($post_id);
		}	
	}
}

PJAWishlistPlugin::init();
?>