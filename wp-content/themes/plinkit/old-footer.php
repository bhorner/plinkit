<?php wp_footer(); ?>

<style>
	#mc_embed_signup form {
		padding-left: 0 !important;
		padding-bottom: 0 !important;
	}
	#mc_embed_signup .mc-field-group input {
		border: none !important;
		padding: 10px !important;
		font-size: 1.2em;
		color: #46b8ba !important;
		background: #ceecec !important;
		-webkit-border-radius: 0px !important;
		-moz-border-radius:  0px !important;
		border-radius:  0px !important;
	}
	#mc_embed_signup .button {
		border: none !important;
		-webkit-border-radius: 0px !important;
		-moz-border-radius:  0px !important;
		border-radius:  0px !important;
		background: #429a9b !important;
		-webkit-appearance: none;
		-webkit-border-radius: 0;
		-moz-border-radius: 0;
		border-radius: 0;
	}
	.submit-container {
		position: absolute;
	    right: 0;
	    top: 10px;
	}
	#mc_embed_signup .button {
		height: 40px !important;
	}
	
	footer ::-webkit-input-placeholder { /* Chrome/Opera/Safari */
	  color: #429a9b !important;
	}
	footer ::-moz-placeholder { /* Firefox 19+ */
	  color: #429a9b !important;
	}
	footer :-ms-input-placeholder { /* IE 10+ */
	  color: #429a9b !important;
	}
	footer :-moz-placeholder { /* Firefox 18- */
	  color: #429a9b !important;
	}
	
	
</style>	

	
	<div class="remodal" data-remodal-id="log-in" id="login-modal">
	  <button data-remodal-action="close" class="remodal-close"></button>
	  	  <h3 class="color-teal"><?php the_field('sign_in_title', 'option');?></h3>
		
		<div id="wppb-login-wrap" class="wppb-user-forms">

			<form name="loginform" id="login" action="login" method="post">
			    <p class="status"></p>
			    <p class="error"></p>
				<p class="login-username">
					<label for="username">Username or Email</label>
					<input id="username" type="text" name="username">
				</p>
				<p class="login-password">
					<label for="password">Password</label>
					<input id="password" type="password" name="password">
				</p>
				
				<p class="login-remember"><label><input name="rememberme" type="checkbox" id="rememberme" value="forever"> Remember Me</label></p>
				<p class="login-submit">
					<input class="submit_button" type="submit" value="Login" name="submit">
					<?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
				</p>
			</form>
		
		</div>
	  	
		<?php // echo do_shortcode('[wppb-login]'); ?>
		
		<?php
		if ( is_user_logged_in() ) {
		?>
		<div class="view">
			<a style="margin-top: 30px" class="btn" href="/my-favorites">View your Favorites</a>	
		</div>	
		<?php
		} else {
		?>
			<p><a href="<?php echo site_url(); ?>/recover-password">Forgot your password?</a></p>
			
			<p><a href="#sign-up">Create an account</a></p>	
		<?php
		}
		?>
		<?php
		if ( !is_user_logged_in() ) {
		?>
			<p> 
				<label class="showpass-login">
					<input id="show_password" name="showpass" type="checkbox"> Show
				</label>
			</p>
		<?php } ?>
		<div class="ball-bounce">
			<img class="bb" src="<?php bloginfo('template_url'); ?>/img/ball_bounce.gif">
			<img class="bb-bg" src="<?php bloginfo('template_url'); ?>/img/ball_bounce.png">
		</div>

		
	</div>
	
	<div class="remodal text-center" data-remodal-id="sign-up" id="signup-modal">
	  <button data-remodal-action="close" class="remodal-close"></button>
	  	  <h3 class="color-teal"><?php the_field('sign_up_title', 'option');?></h3>
				<?php 				
				$link = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
				$redirect = strtok($link, '#');				
				?>
				<?php echo do_shortcode('[wppb-register form_name="new-user" redirect_url="' . $redirect . '"]'); ?>

		  	<p>Already have an account? <a href="<?php echo site_url();?>/log-in">Log in here</a></p>	
		  	<p> 
				<label class="showpass2">
					<input id="show_password" name="showpass" type="checkbox"> Show
				</label>
			</p>
			<div class="ball-bounce">
				<img class="bb" src="<?php bloginfo('template_url'); ?>/img/ball_bounce.gif">
				<img class="bb-bg" src="<?php bloginfo('template_url'); ?>/img/ball_bounce.png">
			</div>

	</div>
	
	
	<?php if (!is_user_logged_in() ) { ?>
	<div class="footer-bar">
		<?php the_field('footer_alert', 'option');?>	
	</div>	
	<?php } ?>
	<footer class="">
		<div class="container">
			<div class="join">
				<p><?php the_field('email_sign_up', 'option'); ?></p>
				
				
				<!-- Begin MailChimp Signup Form -->
				<link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
				<style type="text/css">
					#mc_embed_signup{width:100%;}
					/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
					   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
				</style>
				<div id="mc_embed_signup">
				<form action="https://myplinkit.us13.list-manage.com/subscribe/post?u=b29dca6d0c3fc97de60061081&amp;id=71f943d47e" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
				    <div id="mc_embed_signup_scroll">
					
				<div class="mc-field-group">
					<div class="hide"><label for="mce-EMAIL"></label></div>
					<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
				</div>
					<div id="mce-responses" class="clear">
						<div class="response" id="mce-error-response" style="display:none"></div>
						<div class="response" id="mce-success-response" style="display:none"></div>
					</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
				    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_b29dca6d0c3fc97de60061081_71f943d47e" tabindex="-1" value=""></div>
				    <div class="submit-container"><input type="submit" value=" " name="subscribe" id="mc-embedded-subscribe" class="button"></div>
				    </div>
				</form>
				</div>
				<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';fnames[3]='TEXTYUI_3';ftypes[3]='text';fnames[4]='TEXTAREAY';ftypes[4]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
				<!--End mc_embed_signup-->

				<p><a href="https://myplinkit.com/newsletter-archive/" target="_blank">Explore our Newsletter Archive</a></p>	
				
			</div>	
			<div class="footer-center">
				<a id="footer-logo" href="/">
					<p class="registered">®</p>	

					<?php include get_template_directory() . '/img/footer-logo.svg'; ?>
				</a>	
				<p>Learn better. Play smarter.</p>
				<p class="small">© Plinkit <?php echo date('Y'); ?>. Website by <a href="http://deicreative.com" target="_blank">DEI Creative</a>.</p>	
				
				<div class="pp-bottom small">
					<a target="_blank" href="<?php the_permalink('2452'); ?>">Privacy Policy</a>
					<div class="divider">|</div>	
					<a target="_blank" href="<?php the_permalink('2454'); ?>">Terms of Service</a>
				</div>
				
			</div>	
			<div class="social right column">
				<?php if(get_field('facebook', 'options')) { ?><a target="_blank" href="<?php the_field('facebook', 'options');?>" class="fa fa-facebook"></a><?php } ?>
				<?php if(get_field('twitter', 'options')) { ?><a target="_blank" href="<?php the_field('twitter', 'options');?>" class="fa fa-twitter"></a><?php } ?>
				<?php if(get_field('pinterest', 'options')) { ?><a target="_blank" href="<?php the_field('pinterest', 'options');?>" class="fa fa-pinterest-p"></a><?php } ?>
				<?php if(get_field('instagram', 'options')) { ?><a target="_blank" href="<?php the_field('instagram', 'options');?>" class="fa fa-instagram"></a><?php } ?>
				<div class="social-bottom">
					<a target="_blank" href="<?php the_permalink('2428'); ?>">Browse All Articles - by Skill</a>
					<div class="divider">|</div>	
					<a target="_blank" href="<?php the_permalink('10632'); ?>">Browse All Articles - by Age</a>
				</div>	
			</div>
		</div>	
		<div class="bottom">
			<div class="container">
				<p><i><?php the_field('bottom', 'option'); ?></i></p>	
			</div>	
		</div>	
	</footer>	

	<script>
		$(window).load(function(){
			dotAnimation();
		})
		$('.showpass #show_password').click(function functionName() {
				if($(this).hasClass('active')) {
					$(this).removeClass('active');
					$('input[name="pwd"]').attr('type', 'password');
				} else {
					$(this).addClass('active');
					$('input[name="pwd"]').attr('type', 'text');
				}
			}
		);
		$('.showpass2 #show_password').click(function functionName() {
				if($(this).hasClass('active')) {
					$(this).removeClass('active');
					$('input[name="passw1"]').attr('type', 'password');
				} else {
					$(this).addClass('active');
					$('input[name="passw1"]').attr('type', 'text');
				}
			}
		);
		$('.showpass-login #show_password').click(function functionName() {
				if($(this).hasClass('active')) {
					$(this).removeClass('active');
					$('input[name="password"]').attr('type', 'password');
				} else {
					$(this).addClass('active');
					$('input[name="password"]').attr('type', 'text');
				}
			}
		);
		
		<?php if (!is_user_logged_in()) { ?>
		
			<?php if (!is_page('log-in') ) { ?>
				$(function(){
					cookie();
				});
			<?php } ?>
		<?php } ?>
		
	</script>	
	
</body>
</html>