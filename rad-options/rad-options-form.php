<div class="wrap">
	
	<form method="post" action="options.php">
		<?php 
		// connect this form to the registered group of settings from the plugin file
		settings_fields( 'rad_options_group' ); 
		//get the current values so we can make the form "sticky"
		$value = get_option( 'rad_options' );
		?>

		<?php screen_icon(); ?>
		<h2>Company Information</h2>

		<label>Company Phone Number</label> <br />
		<input type="tel" name="rad_options[phone]" class="regular-text" value="<?php  echo $value['phone'] ?>" /> <br />

		<label>Company Address</label> <br />
		<textarea name="rad_options[address]" rows="5" cols="50" ><?php  
		echo $value['address'] ?></textarea> <br />

		<label>Customer Support Email</label> <br />
		<input type="email" name="rad_options[email]" class="regular-text" value="<?php  echo $value['email'] ?>" />

		<?php submit_button(); ?>
 

		<hr />
		<?php screen_icon( 'index' ); ?>
		<h2>Home Page Settings</h2>

		<label>Home page Quote:</label><br />
		<textarea name="rad_options[quote]"  cols="40" rows="5"><?php echo $value['quote']; ?></textarea><br /><br />
		
		<label>Quote Source:</label><br /> 
		<input type="text" class="regular-text" name="rad_options[quote-source]" value="<?php echo $value['quote-source']; ?>" /><br /><br />


		<input type="checkbox" name="rad_options[show-quote]" value="1" 
			<?php checked( '1', $value['show-quote'] ); ?> />

		<label>Display the quote on the Home Page?</label>

		<?php submit_button(); ?>
	</form>


</div>