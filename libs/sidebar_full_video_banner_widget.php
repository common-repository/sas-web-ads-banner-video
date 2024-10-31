<?php

class SASWEB_full_Video_Widget extends WP_Widget{ 

	// Check if url is from which type of video
	function get_video($url, $width = 640, $height = 360){
		if( empty($width) && empty($height) ){ $width = 640; $height = 360; }
		
		if(strpos($url,'youtube')){		
			$this->get_youtube($url, $width, $height);
		}else if(strpos($url,'youtu.be')){
			$this->get_youtube($url, $width, $height, 'youtu.be');
		}else if(strpos($url,'vimeo')){
			$this->get_vimeo($url, $width, $height);
		}
	}

	// Print youtube video
	function get_youtube($url, $width = 640, $height = 360, $type = 'youtube', $return = false){
		if( $type == 'youtube' ){
			preg_match('/[\\?\\&]v=([^\\?\\&]+)/',$url,$id);
		}else{
			preg_match('/youtu.be\/([^\\?\\&]+)/', $url, $id);
		}
		
		$attr = "";
		if( strpos($url, 'autoplay=1') > 0 ) $attr = "&autoplay=1";		
		if( strpos($url, 'rel=0') > 0 ) $attr = $attr . "&rel=0";		
		
		if( !$return ){
			echo '<iframe src="http://www.youtube.com/embed/' . $id[1] . '?wmode=transparent' . $attr . '" width="' . $width . '" height="' . $height . '" ></iframe>';
		}else{
			return '<iframe src="http://www.youtube.com/embed/' . $id[1] . '?wmode=transparent' . $attr . '" width="' . $width . '" height="' . $height . '" ></iframe>';
		}
	}
	
	// Print vimeo video
	function get_vimeo($url, $width = 640, $height = 360, $return = false){
		preg_match('/https?:\/\/vimeo.com\/(\d+)$/', $url, $id);
		
		if( !$return ){
			echo '<iframe src="http://player.vimeo.com/video/' . $id[1] . '?title=0&amp;byline=0&amp;portrait=0" width="' . $width . '" height="' . $height . '"></iframe>';
		}else{
			return '<iframe src="http://player.vimeo.com/video/' . $id[1] . '?title=0&amp;byline=0&amp;portrait=0" width="' . $width . '" height="' . $height . '"></iframe>';
		}
	}

	// Initialize the widget
    function SASWEB_full_Video_Widget() {
        parent::WP_Widget('Sasweb-full-video-widget', __('SAS WEB Full Video Widget','sasweb_back_end'), 
			array('description' => __('Full size video widget', 'sasweb_back_end')));  
    }  
	
	// Output of the widget
	function widget($args, $instance) {  
		global $wpdb;
	
		extract( $args );
		
		$title = apply_filters( 'widget_title', $instance['title'] );
		$source = apply_filters( 'widget_title', $instance['source'] );
		$height = apply_filters( 'widget_title', $instance['height'] );
		$description1 = $instance['description1'];
		echo $before_widget;
		
		
		// Widget Title
		echo $before_title . $title . $after_title; 
		
		echo '<div class="video-widget1-1">';
		$this->get_video($source, 300, $height);
		echo '</div>'; // 1-1 Video Widget
		echo '<p>'.$description1.'</p>';
		echo $after_widget;		
	
    }  	
	
	// Widget Form
	function form($instance) {  
		if ( $instance ) {
			$title = esc_attr( $instance[ 'title' ] );
			$source = esc_attr( $instance[ 'source' ] );
			$height = esc_attr( $instance[ 'height' ] );
			$description1 = esc_attr( $instance[ 'description1' ] );
		} else {
			$title = '';
			$source = '';
			$height = 266;
			$description1 ='';
		}
		?>
		
		<!-- Title --> 
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title :', 'sasweb_back_end' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<!-- Source --> 
		<p>
			<label for="<?php echo $this->get_field_id('source'); ?>"><?php _e( 'Video URL( Vimeo/Youtube ) :', 'sasweb_back_end' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('source'); ?>" name="<?php echo $this->get_field_name('source'); ?>" type="text" value="<?php echo $source; ?>" />
		</p>				
		
		<!-- Height --> 
		<p>
			<label for="<?php echo $this->get_field_id('height'); ?>"><?php _e( 'Video Height :', 'sasweb_back_end' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo $height; ?>" />
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
		$instance['source'] = strip_tags($new_instance['source']);
		$instance['height'] = strip_tags($new_instance['height']);
		$instance['description1'] = wp_kses_data($new_instance['description1']);
		return $instance;
    }
	
}  
