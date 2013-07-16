<?php /*
Plugin Name: Rad News Widget with Thumbnails
Description: Shows a list of posts with customizable output
Author: Melissa Cabral
Version: 0.1
*/

/**
 * Attach the stylesheet for the widget
 * @since 0.1
 */
add_action( 'wp_enqueue_scripts', 'rad_news_style' );
function rad_news_style(){
	$style_path = plugins_url( 'style.css', __FILE__ );
	wp_register_style( 'rad-news-css', $style_path );
	wp_enqueue_style( 'rad-news-css' );
}

/**
 * Add an image size for the thumbnails
 */
add_action( 'admin_init', 'rad_news_image');
function rad_news_image(){
	add_image_size( 'rad-news-thumb', 94, 70, true );
}

/**
 * register the widget so wordpress knows it exists
 * @since 0.1
 */
add_action( 'widgets_init', 'rad_register_news_widget' );
function rad_register_news_widget(){
	register_widget('Rad_News_Widget');
}

/**
 * Set up the Rad_News_Widget class 
 * @since 0.1
 */
class Rad_News_Widget extends WP_Widget{
	//required - widget settings
	function Rad_News_Widget(){
		$widget_settings = array(
			'classname' => 'news-widget',
			'description' => 'Latest posts with thumbnail images.',
		);
		$control_settings = array(
			'id-base' => 'news-widget',
			//'width' => 300, //width of admin form
		);
		//apply the settings to our widget
		//id-base, title, widget settings, control settings
		$this->WP_Widget( 'news-widget', 'news Widget', $widget_settings, 
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
		$number = $instance['number'];
		$show_excerpt = $instance['show_excerpt'];

		//BEGIN OUTPUT
		echo $before_widget;

		echo $before_title;
		echo $title;
		echo $after_title;

		//custom query to get latest posts
		$news_query = new WP_Query( array(
			'showposts' => $number,
			'ignore_sticky_posts' => 1,
		) );

		//custom loop
		if( $news_query->have_posts() ): ?>
			<ul>
			<?php while( $news_query->have_posts() ): 
				$news_query->the_post();
			?>
			<li>
				<a href="<?php the_permalink(); ?>" class="thumbnail-link">
					<?php the_post_thumbnail( 'rad-news-thumb' ); ?>
				</a>
				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<?php //show the excerpt only if $show_excerpt is true 
				if( true == $show_excerpt ):?>
					<p><?php the_excerpt(); ?></p>
				<?php endif; ?>
			</li>
			<?php endwhile; ?>
			</ul>
		<?php endif;

		//clean up
		wp_reset_query();	

		echo $after_widget;
	}
	//required - sanitize and update
	// $new_instance: array Values just sent to be saved.
	// $old_instance: array Previously saved values from database.
	function update( $new_instance, $old_instance ){
		$instance = array();

		//go through each field and sanitize
		$instance['title'] = wp_filter_nohtml_kses( $new_instance['title'] );
		$instance['number'] = wp_filter_nohtml_kses( $new_instance['number'] );
		$instance['show_excerpt'] = wp_filter_nohtml_kses( $new_instance['show_excerpt'] );
		//add more fields here

		//return the cleaned data
		return $instance;
	}
	//optional - form for admin panel
	// $instance: array. current values of all fields for this instance
	function form( $instance ){
		//set defaults for each field
		$defaults = array(
			'title' => 'Latest Posts',
			'number' => 5,
			'show_excerpt' => true,
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
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>">Number of posts:</label>
			<input type="number"
			name="<?php echo $this->get_field_name('number'); ?>" 
			id="<?php echo $this->get_field_id('number'); ?>" 
			value="<?php echo $instance['number']; ?>" />
		</p>
		<p>
			<input type="checkbox" 
			name="<?php echo $this->get_field_name('show_excerpt'); ?>" 
			id="<?php echo $this->get_field_id('show_excerpt'); ?>" 
			value="true"  
			<?php checked( $instance['show_excerpt'], 'true' ); ?> />

			<label for="<?php echo $this->get_field_id('show_excerpt'); ?>">
				Show an excerpt of each post?</label>
		</p>
		<?php 	
	}
}