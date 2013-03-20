<?php
/*
Plugin Name: HeadsUp! User Engagement
Plugin URI: http://www.headsupuserengagement.com/
Description: HeadsUp! User Engagement for WordPress enables users to place web forms on their WordPress pages. HeadsUp! web forms allow WordPress users to collect structured feedback from their visitors, including the navigation history through their site, page load times delivered on their visitor's devices and HTML5 screenshots of their visitors web browser window.<br /><br />Use this feedback to engage with your visitors and to build better web sites.<br /><br />As a next step you might want to route this feedback data as feature requests or defects to a Scrum project manager, as service requests to a ticketing system or as sales leads to a CRM.
Version: 13.2.1
Requires at least: 3.2
Author: HeadsUp! User Engagement
Author URI: http://www.headsupuserengagement.com/
License: GPL2

Copyright 2013  HeadsUp! User Engagement headsup@fabasoft.com

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function headsup_activate() {
	$APMCFG = get_option( 'headsup_cfg', false );
	if ( false === $APMCFG ) {
		add_option( 'headsup_cfg', array(), '', 'yes' );
	}
}

function headsup_head() {
	$APMCFG = get_option( 'headsup_cfg', array() );
	if ( false === $APMCFG || ! isset( $APMCFG['id'] ) || ! $APMCFG['id'] ) {
		return;
	}
	$headsupURL = '//headsup.fabasoft.com';
	echo "<!-- HeadsUp! User Engagement start -->\n";
	echo '<script type="text/javascript">/*<![CDATA[*/__apmcfg={id:"' . $APMCFG['id'] . '",ts:new Date(),base:"' . $headsupURL . '/hu/",url:"' . $headsupURL . '",apptype:"html"';
	echo ",timing:true,resources:true};\n";
?>
(function(d, t, c) {var s, scr, id = '__apm_script';if (!d.getElementById(id)) {s = d.createElement(t);s.async = true;s.src = 'http' + ('https:' == d.location.protocol ? 's' : '') + ':' + c.base + 'apm.js';s.id = id;scr = d.getElementsByTagName(t)[0];scr.parentNode.insertBefore(s, scr);
}}(document, 'script', __apmcfg));/*]]>*/</script>
<?php
	echo "<!-- HeadsUp! User Engagement end -->\n";
}


function headsup_footer() {
	$APMCFG = get_option( 'headsup_cfg', array() );
	if ( false === $APMCFG || ! isset( $APMCFG['id'] ) || ! $APMCFG['id'] ) {
		return;
	}
	if ( ! isset( $APMCFG['button'] ) || ! $APMCFG['button'] ) {
		return;
	}
	echo "<!-- HeadsUp! User Engagement start -->\n";
	echo html_entity_decode( $APMCFG['button'] ) . "\n";
	echo "<!-- HeadsUp! User Engagement end -->\n";
}
add_action( 'wp_footer', 'headsup_footer' );

register_activation_hook( __FILE__, 'headsup_activate' );
add_action( 'wp_head', 'headsup_head' );

function headsup_options() {
	if ( ! current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	$headsup_cfg = get_option( 'headsup_cfg' );
	// See if the user has posted us some information
	if( isset( $_POST['headsup_apmid'] ) ) {
		// Read their posted value
		$id = trim( $_POST['headsup_apmid'] );
		if ( preg_match( '/^APM\d{5,}$/', $id ) ) {
			$oldid = isset( $headsup_cfg["id"] ) ? $headsup_cfg["id"] : '';
			$headsup_cfg["id"] = $id;
			// Save the posted value in the database
			update_option( 'headsup_cfg', $headsup_cfg );
			// Put an settings updated message on the screen
			if ( $oldid !== $id ) {
				echo '<div class="updated"><p><strong>Website settings saved.</strong></p></div>';
			}
		}
		else {
			echo '<div class="error settings-error"><p><strong>The entered HeadsUp! Website ID appears to be invalid. Please enter a valid HeadsUp! Website ID.</strong></p></div>';
		}
	}
	if ( isset( $headsup_cfg["id"] ) ) {
		$headsup_apmid = $headsup_cfg["id"];
	}
	else {
		$headsup_apmid = "";
	}
	if( isset( $_POST['headsup_button'] ) ) {
		// Read their posted value
		$button = htmlentities( trim( stripslashes( $_POST['headsup_button'] ) ) );
		$oldcfg = isset( $headsup_cfg["button"] ) ? $headsup_cfg["button"] : '';
		$headsup_cfg["button"] = $button;
		// Save the posted value in the database
		update_option( 'headsup_cfg', $headsup_cfg );
		// Put an settings updated message on the screen
		if ( $oldcfg !== $button ) {
			echo '<div class="updated"><p><strong>HeadsUp! button settings saved.</strong></p></div>';
		}
	}
	if ( isset( $headsup_cfg["button"] ) ) {
		$headsup_button = html_entity_decode( $headsup_cfg["button"] );
	}
	else {
		$headsup_button = "";
	}
?>
	<div class="wrap" style="max-width:700px;">
		<script type="text/javascript">/*<![CDATA[*/__apmcfg={id:"APM86402",ts:new Date(),base:"//headsup.fabasoft.com/hu/",apptype:"html",timing:false};
			(function(d, t, c) {var s, scr, id = '__apm_script';if (!d.getElementById(id)) {s = d.createElement(t);s.async = true;
				s.src = 'http' + ('https:' == d.location.protocol ? 's' : '') + ':' + c.base + 'apm.js';s.id = id;scr = d.getElementsByTagName(t)[0];
				scr.parentNode.insertBefore(s, scr);
			}}(document, 'script', __apmcfg));/*]]>*/
		</script>

		<div class="icon32" id="icon-options-general"><br /></div>
		<h2>HeadsUp! User Engagement for WordPress</h2>
		<p>Configure this WordPress site for HeadsUp! User Engagement. 
			Get your APM-ID and HeadsUp! button HTML from your HeadsUp! client and paste it in the fields below.<br />
			<a style="margin-top: .5em;" class="button-primary" href="https://headsup.fabasoft.com/headsup/?websites-view" target="_blank">Open HeadsUp! client</a>
			<button class="button button-primary apm-feedback-button" data-formid="FORM14543" style="float: right;margin-top: .5em;">Give us a shout!</button>
		</p>

		<form method="post" action=""> 
			<div class="metabox-holder">
				<div class="postbox">
					<h3 class="hndle"><span>Website Settings</span></h3>
					<div class="inside">
						<table class="form-table">  
							<tr valign="top">
								<th scope="row"><label for="headsup_apmid">HeadsUp! Website ID</label></th>
								<td>
									<input type="text" name="headsup_apmid" id="headsup_apmid" value="<?php echo esc_attr( $headsup_apmid ); ?>" size="14" placeholder="APM*****" />
								</td>
							</tr>
						</table>
					</div>
				</div>

				<div class="postbox" style="margin-bottom:0;">
					<h3 class="hndle"><span>HeadsUp! button Settings</span></h3>
					<div class="inside">
						<table class="form-table">  
							<tr valign="top">
								<th scope="row"><label for="headsup_button">HeadsUp! button HTML</label></th>
								<td><textarea name="headsup_button" id="headsup_button" rows="3" style="width:100%;"><?php echo esc_textarea( $headsup_button ); ?></textarea></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div style="text-align: right;">
				<?php @submit_button(); ?>
			</div>
		</form>
	</div>
<?php
}

function headsup_menu() {
	add_options_page( 'HeadsUp! User Engagement for WordPress', 'HeadsUp!', 'manage_options', 'headsup-options-page', 'headsup_options' );
}

add_action( 'admin_menu', 'headsup_menu' );

function headsup_get_settings_link() {
	return '<a href="' . admin_url( 'options-general.php?page=headsup-options-page' ) . '">';
}

// add a Settings link to the plugin entry in the Plugins page
function headsup_add_action_link($links, $file) {
	if ( $file == basename( dirname( __FILE__ ) ) . '/' . basename( __FILE__ ) ) {
		$settings_link = headsup_get_settings_link() . 'Settings</a>';
		array_unshift( $links, $settings_link );
	}
	return $links;
}
add_filter( 'plugin_action_links', 'headsup_add_action_link', 10, 2 );
