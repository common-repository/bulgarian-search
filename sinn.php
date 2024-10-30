<?php
/*
Plugin Name: Bulgarian search
Plugin URI: http://coffebreak.info
Description: Widget for searching with the Bulgarian search engine Napred.bg
Version: 1.0
Author: Andon Ivanov
Author URI: http://coffebreak.info
*/

define('SINN_PLUGIN_PATH', plugin_dir_url( __FILE__ ));

class SearchInNapred extends WP_Widget
{

	/** 
	 * Main Widget 
	 */
	function SearchInNapred()
	{
		wp_register_style('sinn-style', SINN_PLUGIN_PATH . 'css/sinn.css');
		wp_register_script('sinn-js-core', SINN_PLUGIN_PATH . 'js/sinn-core.js');
		wp_enqueue_style('sinn-style');
		wp_enqueue_script('sinn-js-core');
		
		$widget_opt = array( 'classname' => 'searching-in-napred', 'description' => __('Widget for searching with the Bulgarian search engine Napred.bg', 'seaching-in-napred'));
		
		$this->WP_Widget('SeachInNapredWidget', __('Search in Napred.BG', 'searching-in-napred'), $widget_opt);
	}
	
	/** 
	 * Widget Admin Options 
	 */
	function form($instance)
	{
		$defaults = array('title' => __('Sarching in Napred.BG', 'searching-in-napred'),
						  'show_poweredby' => 0);
		
		$instance = wp_parse_args((array) $instance, $defaults);
		?>
		
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:'); ?></label>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" type='input' />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('show_poweredby'); ?>"><input type="checkbox" <?php checked($instance['show_poweredby'], true) ?> id="<?php echo $this->get_field_id( 'show_poweredby' ); ?>" name="<?php echo $this->get_field_name( 'show_poweredby' ); ?>" /> <?php _e('Show "Powered by" link in widget.'); ?></label>

			</p>
		<?php
	}
	
	/** 
	 * Update Widget options 
	 */
	function update($new_instance, $old_instance)
	{
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['show_poweredby'] = ( isset( $new_instance['show_poweredby'] ) ? 1 : 0 );
			
			return $instance;
	}
	
	/** 
	 * Instance 
	 */
	function widget($args, $instance)
	{
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$show_poweredby = $instance['show_poweredby'];
		
		echo $before_widget;
		
		if($title)
		{
			echo $before_title . $title . $after_title;
		}
		?>
		<div class="searchwrapperx250">
		<form action="http://napred.bg/search" method="POST" name="search_eng">
						<input type="text" class="inputfieldx250" id="search" name="search" value="" autocomplete="off" onfocus="this.value = this.value;">
						<input	type="hidden" id="search_in" name="search_in" value="">
						<p>
						Search in: <input type="submit" value="Napred.BG" class="inputsbmtx250" id="napred">
						<input type="submit" value="Google.BG" class="inputsbmtx250" onclick="google_search($('#search').val());">
						</p>
					</form>
		
		<?php 
		if($show_poweredby)
		{
			echo '<a href="http://napred.bg" target="_blank">Powered by Napred.BG</a>';
		}
		?>
		</div>
		<?php
		
		echo $after_widget;
	}
	
}
add_action( 'widgets_init', create_function('', 'return register_widget("SearchInNapred");') );?>