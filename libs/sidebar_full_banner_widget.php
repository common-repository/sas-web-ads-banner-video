<?php

class SASWEB_full_Banner_widget extends WP_Widget{ 

	// Initialize the widget
    function SASWEB_full_Banner_widget(){
        parent::WP_Widget('Sasweb-full-banner-widget', __('SAS Web Full Banner Widget','sasweb_back_end'), 
			array('description' => __('Full size banner widget', 'sasweb_back_end')));  
    }  
	
	// Output of the widget
	function widget($args, $instance) {  
		global $wpdb;
	
		extract( $args );
		
		$title = apply_filters( 'widget_title', $instance['title'] );
		$image = apply_filters( 'widget_title', $instance['image'] );
		$link = apply_filters( 'widget_title', $instance['link'] );
		$description1 = $instance['description1'];

		echo $before_widget;
		
		// Open of title tag
		if ( $title ){ 
			echo $before_title . $title . $after_title; 
			echo '<div class="under-banner-title"></div>';
		}

		echo '<div class="banner-widget1-1">';
		
		echo '<a href="' . $link . '" target="_blank">';
		echo '<img src="' . $image . '" alt="banner" />';
		echo '</a>';
		echo '<p>'.$description1.'</p>';
		echo '</div>'; // 1-1 Banner Widget
		
		echo $after_widget;		
	
    }  	
	
	// Widget Form
	function form($instance) {  
		if ( $instance ) {
			$title = esc_attr( $instance[ 'title' ] );
			$image = esc_attr( $instance[ 'image' ] );
			$link = esc_attr( $instance[ 'link' ] );
			$description1 = esc_attr( $instance[ 'description1' ] );
		} else {
			$title = '';
			$image = '';
			$link = '';
			$description1 ='';
		}
		?>
		
		<!-- Title --> 
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title :', 'sasweb_back_end' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<!-- Image --> 
		<p>
			<label for="<?php echo $this->get_field_id('image'); ?>"><?php _e( 'Banner Image URL :', 'sasweb_back_end' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('image'); ?>" type="text" value="<?php echo $image; ?>" />
		</p>		
		
		<!-- Link --> 
		<p>
			<label for="<?php echo $this->get_field_id('link'); ?>"><?php _e( 'Banner Link :', 'sasweb_back_end' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo $link; ?>" />
		</p>		
		
		<!-- Description1 --> 
		<p>
			<label for="<?php echo $this->get_field_id('description1'); ?>"><?php _e( 'Description1 :', 'sasweb_back_end' ); ?></label> 
			<textarea class="widefat" id="<?php echo $this->get_field_id('description1'); ?>" name="<?php echo $this->get_field_name('description1'); ?>" ><?php echo $description1; ?></textarea>
		</p>	
		<?php
    }  
	
	// Update the widget
	function update($new_instance, $old_instance){  
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['image'] = strip_tags($new_instance['image']);
		$instance['link'] = strip_tags($new_instance['link']);
		$instance['description1'] = wp_kses_data($new_instance['description1']);
		return $instance;
    }
	
}  
