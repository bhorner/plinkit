<?php
/*
 * Template Name: Temp Shop + Play Page
 * Description: A page template with a default design.
 */
?>

<?php get_header(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.1/TweenMax.min.js"></script>

<?php $searches[] = array(); ?>
<div id="page-title">
	<div class="container text-center">
		<h1><span class="icon"><?php include get_template_directory() . '/img/icons/shopping.svg'; ?></span> <span class="icon"><?php include get_template_directory() . '/img/icons/play.svg'; ?></span> Shop + Play<br><?php the_field('page_title');?></h1>
	</div>	
</div>	

<div class="container small-container">
	<div class="intro-text color-coral text-center">
		<p><?php the_field('intro');?></p>	
	</div>	
</div>	
<div id="wrapper">
	<div class="container text-center">
		<section style="margin-bottom: 60px">
		<h2 class="color-teal"><?php the_field('sorry');?></h2>	
		<div class="mailchimp-form">
			<!-- Begin MailChimp Signup Form -->
			<link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
			<style type="text/css">
				#mc_embed_signup{width:100%;}
				/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
				   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
			</style>
			<div id="mc_embed_signup">
			<form action="//myplinkit.us13.list-manage.com/subscribe/post?u=50e0d852c18386a044c441e8d&amp;id=dd16910907" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
			    <div id="mc_embed_signup_scroll">
				
			<div class="mc-field-group">
<!-- 					<label for="mce-EMAIL">Email Address </label> -->
				<input type="email" placeholder="email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'email'" value="" name="EMAIL" class="required email" id="mce-EMAIL">
			</div>
				<div id="mce-responses" class="clear">
					<div class="response" id="mce-error-response" style="display:none"></div>
					<div class="response" id="mce-success-response" style="display:none"></div>
				</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
			    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_50e0d852c18386a044c441e8d_dd16910907" tabindex="-1" value=""></div>
			    <div class="submit-container"><input type="submit" value=" " name="subscribe" id="mc-embedded-subscribe" class="button">	</div>
			    </div>
			</form>
			</div>
			<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
			<!--End mc_embed_signup-->
			<div id="filters">
				<a class="link" href="http://myplinkit.com/sneak-peek-holiday-gift-guide/" target="_blank"><?php the_field('tagline');?></a>			
			</div>	
		</div>	
	</section>	
	</div>	
</div>
<?php get_footer(); ?>


