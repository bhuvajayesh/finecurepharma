<?php 
/*
 Plugin Name: TS Search Slug
 Plugin URI: https://www.spiess-informatik.de/wordpress-plugins/
 License: GPLv3
 Description: Search for Slug in Admin Post/Page Overview and add Slug Column to Post/Page Overview
 Author: Tobias Spiess
 Author URI: https://www.spiess-informatik.de
 Version: 1.0.7
 Text-Domain: ts-search-slug
 Domain Path: /languages
*/

if(!defined('TS_Search_Slug_Version'))
{
    define('TS_Search_Slug_Version', '1.0.6');
}

if(!defined('TS_Search_Slug'))
{
	class TS_Search_Slug
	{
		function __construct()
		{
			add_action('admin_menu', array('TS_Search_Slug', 'add_options_page'));
			add_action('admin_init', array('TS_Search_Slug', 'establish_options_page'));

            add_action('admin_enqueue_scripts', array('TS_Search_Slug', 'load_scripts_and_styles'));

			add_filter('manage_post_posts_columns', array('TS_Search_Slug', 'append_admin_columns'));
            add_action('manage_post_posts_custom_column',  array('TS_Search_Slug', 'append_admin_columns_data'), 10, 2);
            add_filter('manage_edit-post_sortable_columns', array('TS_Search_Slug', 'make_custom_columns_sortable'));

            add_filter('manage_page_posts_columns', array('TS_Search_Slug', 'append_admin_columns'));
            add_action('manage_page_posts_custom_column',  array('TS_Search_Slug', 'append_admin_columns_data'), 10, 2);
            add_filter('manage_edit-page_sortable_columns', array('TS_Search_Slug', 'make_custom_columns_sortable'));
			
			$all_options = get_option('ts_search_slug_settings');
			$activated_cpts = array();
			if(isset($all_options['post_types']))
			{
				$activated_cpts = $all_options['post_types'];
			}
			
			if(is_array($activated_cpts) && count($activated_cpts) > 0)
			{
				foreach($activated_cpts as $post_type)
				{
					add_filter('manage_' . $post_type . '_posts_columns', array('TS_Search_Slug', 'append_admin_columns'));
					add_action('manage_' . $post_type . '_posts_custom_column',  array('TS_Search_Slug', 'append_admin_columns_data'), 10, 2);
					add_filter('manage_edit-' . $post_type . '_sortable_columns', array('TS_Search_Slug', 'make_custom_columns_sortable'));
				}
			}
			
			add_filter('posts_where' , array('TS_Search_Slug', 'posts_where'), 10, 2);

            $settings = get_option('ts_search_slug_settings');
            $post_states_list = isset($settings['post_states_list']) ? $settings['post_states_list'] : '';
            if((int) $post_states_list === 1) {
                add_action('manage_posts_extra_tablenav', array('TS_Search_Slug', 'add_page_states_list_to_backend'), 1, 999);
                add_action('admin_footer', array('TS_Search_Slug', 'add_page_states_list_markup_to_backend'));
            }

            add_action('wp_ajax_tsinf_get_state_list', array('TS_Search_Slug', 'ajax_get_state_list'));
            add_action('wp_ajax_nopriv_tsinf_get_state_list', array('TS_Search_Slug', 'ajax_get_state_list'));


		}

        public static function load_scripts_and_styles() {
            wp_enqueue_style('ts-search-slug-style', plugins_url('css/backend.css', __FILE__), array(), TS_Search_Slug_Version);
            wp_enqueue_script('ts-search-slug-script', plugins_url('js/backend.js', __FILE__), array('jquery'), TS_Search_Slug_Version, array('in_footer' => true));

            wp_localize_script('ts-search-slug-script', 'TS_Search_Slug_JS_Obj', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('6PPBo?7cKN8f4=evtaRE%rPN;L{5dg5')
            ));
        }

        public static function add_options_page() {
			add_submenu_page(
				'options-general.php',
				'TS Search Slug',
				'TS Search Slug',
				'manage_options',
				'ts_search_slug',
				array('TS_Search_Slug', 'render_main_page')
			);
		}
		
		public static function render_main_page() {
			if ( !current_user_can( 'edit_posts' ) )  {
				wp_die( esc_html__('You do not have sufficient permissions to access this page.', 'ts-search-slug'));
			}
				
			?>
			<h1><?php esc_html_e('TS Search Slug', 'ts-search-slug'); ?></h1>
			
			<form method="POST" action="options.php">
			<?php 
			settings_fields('ts_search_slug');
			do_settings_sections('ts_search_slug');
			submit_button();
			?>
			</form>
            <style type="text/css">
                .settings_page_ts_search_slug .activate_features_for_cpt_wrap {
                    padding: 5px 0;
                }

                .settings_page_ts_search_slug .tsinf_search_slug_line {
                    margin: 5px 0 10px 0;
                }
            </style>
			<?php
		}
		
		public static function establish_options_page()
		{
			add_settings_section(
					'ts_search_slug_plugin_main_section',
					__('Allgemein', 'ts-search-slug'),
					array('TS_Search_Slug', 'render_options_page_main_section'),
					'ts_search_slug'
					);
				
			add_settings_field(
					'ts_search_slug_post_types',
					__('Enable Post Slug Functionality for additional Custom Post Types', 'ts-search-slug'),
					array('TS_Search_Slug', 'render_options_page_field_post_types'),
					'ts_search_slug',
					'ts_search_slug_plugin_main_section'
            );

            add_settings_field(
                'ts_search_slug_post_types_id',
                __('Enable Post ID Functionality for Post Types', 'ts-search-slug'),
                array('TS_Search_Slug', 'render_options_page_field_post_types_id'),
                'ts_search_slug',
                'ts_search_slug_plugin_main_section'
            );

            add_settings_field(
                'ts_search_slug_post_states_list',
                __('Enable Post States List in Page Overview', 'ts-search-slug'),
                array('TS_Search_Slug', 'render_options_page_field_post_states_list'),
                'ts_search_slug',
                'ts_search_slug_plugin_main_section'
            );
			
			register_setting('ts_search_slug', 'ts_search_slug_settings', 'post_types');
            register_setting('ts_search_slug', 'ts_search_slug_settings', 'post_types_id');
            register_setting('ts_search_slug', 'ts_search_slug_settings', 'post_states_list');
		}
		
		public static function render_options_page_main_section()
		{
			
		}
		
		public static function render_options_page_field_post_types()
		{
			$args = array(
				'public'   => true,
                '_builtin' => false,
				'show_ui' => true
			);
			$post_types = get_post_types($args, 'object');

			if(is_array($post_types) && count($post_types) > 0)
			{
				?>
				<div class="activate_features_for_cpt_wrap">
				<?php
				$all_options = get_option('ts_search_slug_settings');
				$activated_cpts = array();
				if(is_array($all_options) && isset($all_options['post_types']))
				{
					$activated_cpts = $all_options['post_types'];
				}
				
				foreach($post_types as $post_type)
				{
					?>
                        <div class="tsinf_search_slug_line">
                            <input type="checkbox" name="ts_search_slug_settings[post_types][]" <?php checked(in_array($post_type->name, $activated_cpts), true); ?> value="<?php echo esc_attr($post_type->name); ?>" />
                            <span class="label"><?php echo esc_html($post_type->label); ?> (<?php echo esc_attr($post_type->name); ?>)</span>
                        </div>
                    <?php
				}
				?>
                    <strong><small><?php esc_html_e('For compatibility with previous versions, the built-in post types (Post, Page) are always enabled for the slug functionality. Therefore, they do not appear in the settings here.', 'ts-search-slug'); ?></small></strong>
				</div>
				<?php 
			}
		}

        public static function render_options_page_field_post_types_id() {
            $args = array(
                'public'   => true,
                'show_ui' => true
            );
            $post_types = get_post_types($args, 'object');
            if(is_array($post_types) && count($post_types) > 0)
            {
                ?>
                <div class="activate_features_for_cpt_wrap">
                    <?php
                    $all_options = get_option('ts_search_slug_settings');
                    $activated_cpts = array();
                    if(is_array($all_options) && isset($all_options['post_types_id']))
                    {
                        $activated_cpts = $all_options['post_types_id'];
                    }

                    foreach($post_types as $post_type)
                    {
                        ?>
                        <div class="tsinf_search_slug_line">
                            <input type="checkbox" name="ts_search_slug_settings[post_types_id][]" <?php checked(in_array($post_type->name, $activated_cpts), true); ?> value="<?php echo esc_attr($post_type->name); ?>" />
                            <span class="label"><?php echo esc_html($post_type->label); ?> (<?php echo esc_attr($post_type->name); ?>)</span>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <?php
            }
        }

        public static function render_options_page_field_post_states_list() {
            $settings = get_option('ts_search_slug_settings');
            $post_states_list = isset($settings['post_states_list']) ? $settings['post_states_list'] : '';
            ?>
            <div class="tsinf_search_slug_line">
                <input type="checkbox" name="ts_search_slug_settings[post_states_list]" <?php checked($post_states_list, 1); ?> value="1" />
            </div>
            <?php
        }
		
		/**
		 * Append Admin Columns to WordPress Backend Posts Overview
		 * @param array $columns
		 * @return array
		 */
		public static function append_admin_columns($columns) {
			$columns['ts_search_slug_post_name'] = __('Postname/Slug', 'ts-search-slug');

            $all_options = get_option('ts_search_slug_settings');
            if(is_array($all_options) && isset($all_options['post_types_id'])) {
                $post_type_ids = $all_options['post_types_id'];
                if(is_array($post_type_ids) && in_array(get_post_type(), $post_type_ids)) {
                    $columns['ts_search_slug_post_id'] = __('ID', 'ts-search-slug');
                }
            }
		
			return $columns;
		}
		
		/**
		 * Fill additional Admin columns in WordPress Backend Posts Overview
		 * @param string $column
		 * @param int $post_id
		 */
		public static function append_admin_columns_data($column, $post_id) {
			
			switch ( $column ) {
		
				case 'ts_search_slug_post_name':
					echo esc_attr(basename(get_permalink()));
					break;

                case 'ts_search_slug_post_id':
                    echo (int) get_the_ID();
                    break;

			}
		}
		
		/**
		 * Make additional course status column in WordPress Backend Posts Overview sortable
		 * @param array $columns
		 * @return array
		 */
		public static function make_custom_columns_sortable($columns) {
			$columns['ts_search_slug_post_name'] = 'post_name';
            
            $all_options = get_option('ts_search_slug_settings');
            if(is_array($all_options) && isset($all_options['post_types_id'])) {
                $post_type_ids = $all_options['post_types_id'];
                if(is_array($post_type_ids) && in_array(get_post_type(), $post_type_ids)) {
                    $columns['ts_search_slug_post_id'] = 'ID';
                }
            }

			return $columns;
		}
		
		/**
		 * Modify Admin Post Overview WHERE-Part of SQL
		 * @param string $where
		 * @return string
		 */
		public static function posts_where($where, $wp_query) {
			global $pagenow;

			$post_type = '';
			if(isset($_GET['post_type']))
			{
				$post_type = wp_strip_all_tags(wp_unslash($_GET['post_type']));
			}

            if(!is_string($post_type) || (is_string($post_type) && strlen($post_type) < 1)) {
                $post_type = (isset($wp_query->query['post_type'])) ? $wp_query->query['post_type'] : '';
            }

            $search = "";
            if(isset($_GET['s']) && is_string($_GET['s']) && strlen($_GET['s']) > 1) {
                $search = sanitize_text_field(wp_unslash($_GET['s']));
            } else if(isset($wp_query->query['s']) && is_string($wp_query->query['s']) && strlen($wp_query->query['s']) > 1) {
                $search = sanitize_text_field(wp_unslash($wp_query->query['s']));
            };


            if(is_admin() && 'edit.php' === $pagenow && is_string($search) && strlen($search) > 0) {

                $all_options = get_option('ts_search_slug_settings');
                $activated_cpts = array();
                $activated_cpts_id = array();
                $all_options_is_array = is_array($all_options);
                if($all_options_is_array && isset($all_options['post_types']))
                {
                    $activated_cpts = $all_options['post_types'];
                }

                if($all_options_is_array && isset($all_options['post_types_id']))
                {
                    $activated_cpts_id = $all_options['post_types_id'];
                }

                global $wpdb;
                if ((is_array($activated_cpts) && in_array($post_type, $activated_cpts)) || ($post_type === 'post') || ($post_type === 'page')) {
                    $like = '%' . $wpdb->esc_like($search) . '%';
                    $like_term = $wpdb->prepare("({$wpdb->posts}.post_name LIKE %s)", $like);

                    $like_search_pattern = $wpdb->prepare("({$wpdb->posts}.post_title LIKE %s)", $like);
                    $like_search_replace = " " . $like_search_pattern . " OR " . $like_term . " ";

                    $where = str_replace($like_search_pattern, $like_search_replace, $where);
                }


                if (is_array($activated_cpts_id) && in_array($post_type, $activated_cpts_id)) {

                    // WordPress trennt komma-separierte Suchbergiffe schon in OR Teile
                    $search_ids = array();
                    if (preg_match('/^(\d+)(,\d+)*$/', $search, $matches)) {
                        $search_ids = explode(',', $search);
                        $search_ids = array_map('intval', $search_ids);
                    }

                    if (!empty($search_ids)) {
                        $id_where = " OR {$wpdb->posts}.ID IN (" . implode(',', $search_ids) . ")";
                        $where .= $id_where;
                    }

                }

            }

            
			
			return $where;
		}

        /**
         * Add Button for page states list to page overview
         * 
         * @return void
         */
        public static function add_page_states_list_to_backend() {
            global $typenow;
            if ( $typenow == 'page' ) {
                echo '<input type="button" class="button button-primary" id="ts-search-slug-open-state-list" value="' . esc_attr('Open "Pages with States" List', 'ts-search-slug') . '" style="margin-left:10px;" />';
            }
        }

        /**
         * Add markup for page states list
         * 
         * @return void
         */
        public static function add_page_states_list_markup_to_backend() {
            global $typenow;
            if ( $typenow == 'page' ) {
                echo '<div id="ts-search-slug-page-state-menu" class="list-empty" style="display: none;">
                        <button id="ts-search-slug-page-state-menu-close-button" class="button button-secondary" type="button">' . esc_html__('Close', 'ts-search-slug') . '</button>
                        <div class="ts-search-slug-page-state-menu-inner">' .
                            esc_html__('Loading ...', 'ts-search-slug') .
                        '</div>
                </div>';
            }
        }

        /**
         * Return data for page states list
         */
        public static function ajax_get_state_list() {
            check_ajax_referer('6PPBo?7cKN8f4=evtaRE%rPN;L{5dg5', 'security');

            $pages_with_states = array();

            $pages = get_pages(
                    array(
                        'sort_order' => 'ASC',
                        'sort_column' => 'post_title',
                        'hierarchical' => 0
                    )
            );
            foreach ( $pages as $page ) {
                $states = apply_filters( 'display_post_states', [], $page );

                if ( !empty( $states ) ) {
                    $pages_with_states[$page->ID] = array(
                            'states' => array_map('esc_html', $states),
                            'title' => $page->post_title,
                            'link' => get_permalink($page->ID),
                            'backend_link' => admin_url(sprintf('/post.php?post=%d&action=edit', (int) $page->ID)),
                    );
                }
            }

            $response = array(
                'pages_with_states' => $pages_with_states,
            );

            wp_send_json($response);
        }




    }
	
	
	new TS_Search_Slug();
}
?>