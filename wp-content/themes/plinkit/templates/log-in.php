<?php
/*
 * Template Name: login
 * Description: A page template with a default design.
 */
?>

<?php get_header(); ?>
<?php
if (have_posts()) :
   while (have_posts()) : the_post();
?>

		<div id="wrapper">
			<section id="banner" class="login" style="margin: 0 auto; float: none;">
				<div class="container">
					<h2 class="color-teal text-center">Welcome Back!</h2>
		<?php the_content();?>
		<?php echo do_shortcode('[wppb-login redirect_url="/my-favorites"]'); ?>
		
		<div class="text-center">
		<?php
		if ( is_user_logged_in() ) {
		?>
		<div class="view">
			<a style="margin-top: 30px; margin-right:5px; margin-left:5px;" class="btn inline-block" href="/my-favorites">View your Favorites</a>	
			<a style="margin-top: 30px; margin-right:5px; margin-left:5px;" class="btn inline-block" href="javascript:history.go(-2)">Back to Post</a>	
		</div>	
		<?php
		} else {
		?>
			<p><a href="<?php echo site_url(); ?>/recover-password">Forgot your password?</a></p>
			
			<p><a href="<?php echo get_page_link('101');?>">Create an account</a></p>	
		<?php
		}
		?>
		
		<div class="ball-bounce">
			<img class="bb" src="<?php bloginfo('template_url'); ?>/img/ball_bounce.gif">
			<img class="bb-bg" src="<?php bloginfo('template_url'); ?>/img/ball_bounce.png">
		</div>

		</div>	
		
	</div>
</section>
<?php
endwhile;
endif;
wp_reset_postdata();
?>	
<script type="text/javascript" charset="utf-8">
	$(window).load(function() {
		height();
		$('.flexslider').flexslider({
			animation: "fade"
		});

		$width = $(window).width();
		
		if($width > 990) {
			owl();
		}		
		
		$sheight = $('.sidebar-inner').height();
		$('.sheight').height($sheight);
	});
	
	function owl() {
		$(".owl-carousel").owlCarousel({
		  items: 4,
		  nav: true,
		  loop: true
		});
	}
</script>
<?php get_footer(); ?>


