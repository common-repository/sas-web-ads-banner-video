<?php
/**
 * Plugin Name: SAS WEB ads-banner-video Plugin
 * Plugin URI: https://www.skmukhiya.com.np
 * Description: Creates Half size banner widget, full size banner widget and full size video embed widget
 * Version: 1.0.1
 * Author: Suresh Kumar Mukhiya
 * Author URI: https://www.odesk.com/users/~0182e0779315e50896
 */

//DEFINING CONSTANTS
define('VERSION', '1.0.0');
define('PLUGIN_NAME', 'sidebar-ads-banner-video');

require_once 'libs/sidebar_full_video_banner_widget.php';
require_once 'libs/sidebar_full_banner_widget.php';

/**
 * Proper way to enqueue scripts and styles
 */
function sasweb_banner_stylesheet()
{
    wp_register_style('sabv_stylesheet', plugin_dir_url(__FILE__).'css/sidebar_ads_banner_video.css');
    wp_enqueue_style('sabv_stylesheet');
}

add_action('wp_enqueue_scripts', 'sasweb_banner_stylesheet');

function sasweb_add_admin_menu()
{
    add_options_page('Sidebar Ads Banner-video', 'Sidebar Ads Banner-video', 'manage_options', __FILE__, 'sasweb_admin_help_interface');
}

add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'sasweb_add_action_links');

function sasweb_add_action_links($links)
{
    $mylinks = array(
 '<a href="' . admin_url('options-general.php?page=sidebar-full-half-ads-banner-video/sidebar-ads-banner-video.php') . '">Help</a>',
 );
    return array_merge($links, $mylinks);
}
function sasweb_admin_help_interface()
{
    require_once 'libs/sidebar_help_instruction.php';
}
// Plugin added to Wordpress plugin architecture
add_action('admin_menu', 'sasweb_add_admin_menu');

/*
@desc: initializing widget
@param:none
@returns:non
*/
add_action('widgets_init', 'sasweb_half_banner_init');
function sasweb_half_banner_init()
{
    register_widget('SASWEB_half_Banner_widget');
    register_widget('SASWEB_full_Banner_widget');
    register_widget('SASWEB_full_Video_Widget');
}

class SASWEB_half_Banner_widget extends WP_Widget
{

    // Initialize the widget
    public function SASWEB_half_Banner_widget()
    {
        parent::WP_Widget(
            'Sasweb-half-banner-widget',
            __('SAS Web Half Banner Widget', 'sasweb_back_end'),
            array('description' => __('Half size banner widget', 'sasweb_back_end'))
        );
    }

    // Output of the widget
    public function widget($args, $instance)
    {
        global $wpdb;

        extract($args);

        $title = apply_filters('widget_title', $instance['title']);
        $image = apply_filters('widget_title', $instance['image']);
        $description1 = $instance['description1'];
        $link = apply_filters('widget_title', $instance['link']);
        $image2 = apply_filters('widget_title', $instance['image2']);
        $link2 = apply_filters('widget_title', $instance['link2']);
        $description2 = $instance['description2'];
        $bottom_margin = apply_filters('widget_title', $instance['bottom_margin']);
        $bottom_link_text = apply_filters('widget_title', $instance['bottom_link_text']);
        $bottom_link = apply_filters('widget_title', $instance['bottom_link']);
        if (empty($title)) {
            echo '<div class="banner-widget1-2-outer-wrapper without-title">';
        } else {
            echo '<div class="banner-widget1-2-outer-wrapper">';
        }
        echo $before_widget;

        // Open of title tag
        if ($title) {
            echo $before_title . $title . $after_title;
        }

        echo '<div class="clear"></div>';
        echo '<div class="banner-widget1-2-wrapper mb' . $bottom_margin . '">';

        echo '<div class="banner-widget1-2" >';
        echo '<div class="left" >';
        echo '<a href="' . $link . '" target="_blank">';
        echo '<img src="' . $image . '" alt="banner" />';
        echo '</a>';
        echo '<p>'.$description1.'</p>';
        echo '</div>';
        echo '</div>';

        echo '<div class="banner-widget1-2" >';
        echo '<div class="right" >';
        echo '<a href="' . $link2 . '" target="_blank">';
        echo '<img src="' . $image2 . '" alt="banner"/>';
        echo '</a>';
        echo '<p>'.$description2.'</p>';
        echo '</div>';
        echo '</div>';

        echo '<div class="clear"></div><br/>';
        echo '<p id="banner_link"><a href="' . $bottom_link . '" target="_blank">';
        echo $bottom_link_text.'</a></p>';
        echo '</div>'; // 1-2 Banner Widget Wrapper

        echo $after_widget;
        echo '</div>';
    }

    // Widget Form
    public function form($instance)
    {
        if ($instance) {
            $title = esc_attr($instance[ 'title' ]);
            $image = esc_attr($instance[ 'image' ]);
            $link = esc_attr($instance[ 'link' ]);
            $description1 = esc_attr($instance[ 'description1' ]);
            $image2 = esc_attr($instance[ 'image2' ]);
            $link2 = esc_attr($instance[ 'link2' ]);
            $description2 = esc_attr($instance[ 'description2' ]);
            $bottom_margin = esc_attr($instance[ 'bottom_margin' ]);
            $bottom_link = esc_attr($instance[ 'bottom_link' ]);
            $bottom_link_text = esc_attr($instance[ 'bottom_link_text' ]);
        } else {
            $title = '';
            $image = '';
            $link = '';
            $description1='';
            $image2 = '';
            $link2 = '';
            $description2 ='';
            $bottom_margin = 40;
            $bottom_link = '';
            $bottom_link_text='';
        } ?>

		<!-- Title -->
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title :', 'sasweb_back_end'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<!-- Image -->
		<p>
			<label for="<?php echo $this->get_field_id('image'); ?>"><?php _e('Banner Image URL :', 'sasweb_back_end'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('image'); ?>" type="text" value="<?php echo $image; ?>" />
		</p>

		<!-- Link -->
		<p>
			<label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Banner Link :', 'sasweb_back_end'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo $link; ?>" />
		</p>

		<!-- Description1 -->
		<p>
			<label for="<?php echo $this->get_field_id('description1'); ?>"><?php _e('Description1 :', 'sasweb_back_end'); ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id('description1'); ?>" name="<?php echo $this->get_field_name('description1'); ?>" ><?php echo $description1; ?></textarea>
		</p>

		<!-- Image2 -->
		<p>
			<label for="<?php echo $this->get_field_id('image2'); ?>"><?php _e('Banner Image URL 2 :', 'sasweb_back_end'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('image2'); ?>" name="<?php echo $this->get_field_name('image2'); ?>" type="text" value="<?php echo $image2; ?>" />
		</p>

		<!-- Link2 -->
		<p>
			<label for="<?php echo $this->get_field_id('link2'); ?>"><?php _e('Banner Link 2 :', 'sasweb_back_end'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('link2'); ?>" name="<?php echo $this->get_field_name('link2'); ?>" type="text" value="<?php echo $link2; ?>" />
		</p>

		<!-- Description2 -->
		<p>
			<label for="<?php echo $this->get_field_id('description2'); ?>"><?php _e('Description2 :', 'sasweb_back_end'); ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id('description2'); ?>" name="<?php echo $this->get_field_name('description2'); ?>" ><?php echo $description2; ?></textarea>
		</p>

		<!-- Bottom Margin -->
		<p>
			<label for="<?php echo $this->get_field_id('bottom_margin'); ?>"><?php _e('Bottom Margin :', 'sasweb_back_end'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('bottom_margin'); ?>" name="<?php echo $this->get_field_name('bottom_margin'); ?>" type="text" value="<?php echo $bottom_margin; ?>" />
		</p>

		<!--Bottom Link -->
		<p>
			<label for="<?php echo $this->get_field_id('bottom_link'); ?>"><?php _e('Bottom Link :', 'sasweb_back_end'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('bottom_link'); ?>" name="<?php echo $this->get_field_name('bottom_link'); ?>" type="text" value="<?php echo $bottom_link; ?>" />
		</p>

		<!--bottom_link_text Link -->
		<p>
			<label for="<?php echo $this->get_field_id('bottom_link_text'); ?>"><?php _e('Bottom Link Text :', 'sasweb_back_end'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('bottom_link_text'); ?>" name="<?php echo $this->get_field_name('bottom_link_text'); ?>" type="text" value="<?php echo $bottom_link_text; ?>" />
		</p>
		<?php
    }

    // Update the widget
    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['image'] = strip_tags($new_instance['image']);
        $instance['link'] = strip_tags($new_instance['link']);
        $instance['description1'] = wp_kses_data($new_instance['description1']);

        $instance['image2'] = strip_tags($new_instance['image2']);
        $instance['link2'] = strip_tags($new_instance['link2']);
        $instance['description2'] = wp_kses_data($new_instance['description2']);
        $instance['bottom_margin'] = strip_tags($new_instance['bottom_margin']);
        $instance['bottom_link'] = strip_tags($new_instance['bottom_link']);
        $instance['bottom_link_text'] = strip_tags($new_instance['bottom_link_text']);
        return $instance;
    }
}

?>
