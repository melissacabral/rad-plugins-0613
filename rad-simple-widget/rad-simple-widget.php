<?php /*
Plugin Name: Simplest Widget
Description: Framework for future widget development
Author: Melissa Cabral
Version: 0.1
*/

/**
 * register the widget so wordpress knows it exists
 * @since 0.1
 */
add_action( 'widgets_init', 'rad_register_simple_widget' );
function rad_register_simple_widget(){
	register_widget('Rad_Simple_Widget');
}

/**
 * Set up the Rad_Simple_Widget class 
 * @since 0.1
 */
class Rad_Simple_Widget extends WP_Widget{
	//required - widget settings
	function Rad_Simple_Widget(){
		$widget_settings = array(
			'classname' => 'simple-widget',
			'description' => 'The simplest widget ever with just a title field.',
		);
		$control_settings = array(
			'id-base' => 'simple-widget',
			//'width' => 300, //width of admin form
		);
		//apply the settings to our widget
		//id-base, title, widget settings, control settings
		$this->WP_Widget( 'simple-widget', 'Simple Widget', $widget_settings, 
			$control_settings  );
	}
	//required - widget display output
	// $args: array. arguments from register_sidebar
	// $instance: array. current values of all fields for this instance
	function widget( $args, $instance ){
		//pull out all the args from the theme
		extract($args);
		//get all the data from this instance
		$title = $instance['title'];

		//BEGIN OUTPUT
		echo $before_widget;

		echo $before_title;
		echo $title;
		echo $after_title;

		echo 'This is where you put the content of the widget. do whatever you want.';

		echo $after_widget;
	}
	//required - sanitize and update
	// $new_instance: array Values just sent to be saved.
	// $old_instance: array Previously saved values from database.
	function update( $new_instance, $old_instance ){
		$instance = array();

		//go through each field and sanitize
		$instance['title'] = wp_filter_nohtml_kses( $new_instance['title'] );
		//add more fields here

		//return the cleaned data
		return $instance;
	}
	//optional - form for admin panel
	// $instance: array. current values of all fields for this instance
	function form( $instance ){
		//set defaults for each field
		$defaults = array(
			'title' => 'The default title!!!',
			//add other fields here
		);
		//merge the defaults with the actual values from the fields
		$instance = wp_parse_args( (array) $instance, $defaults );

		//HTML for the form fields
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title</label>
			<input type="text" 
			name="<?php echo $this->get_field_name('title'); ?>" 
			id="<?php echo $this->get_field_id('title'); ?>" 
			value="<?php echo $instance['title']; ?>" />
		</p>
		<?php 	
	}
}