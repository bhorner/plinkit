<?php
/*
 * Template Name: Sign Up
 * Description: A page template with a default design.
 */
?>

<?php get_header(); ?>
<?php
if (have_posts()) :
   while (have_posts()) : the_post();
   $user = wp_get_current_user();
?>

<section id="banner" class="login">
	<div class="bl-inner pull-left">
		<h2 class="color-teal text-center">Create a Plinkit account to save your favorite toys and parenting tips.</h2>
		<?php the_content();?>
		<?php echo do_shortcode('[wppb-register form_name="new-user"]'); ?>
		<p> 
		<label class="showpass2">
			<input id="show_password" name="showpass" type="checkbox"> Show
		</label>
	<!-- 			<a style="margin-top: 30px; margin-right:5px; margin-left:5px;" class="btn inline-block" href="javascript:history.go(-2)">Back to Post</a>	 -->
		</p>
		<div class="ball-bounce">
			<img class="bb" src="<?php bloginfo('template_url'); ?>/img/ball_bounce.gif">
			<img class="bb-bg" src="<?php bloginfo('template_url'); ?>/img/ball_bounce.png">
		</div>
	</div>	
</section>



<section id="su-left">
	<div class="su-inner">
		<h3 class="color-teal"><?php the_field('title');?></h3>
		
		<?php
		
		// check if the repeater field has rows of data
		if( have_rows('testimonials') ):
		
		 	// loop through the rows of data
		    while ( have_rows('testimonials') ) : the_row();
		?>
			
			<div class="bubble">
				<div class="bubble-inner">
					<p><?php the_sub_field('quote'); ?></p>	
					<p class="name">
						<?php if(get_sub_field('link')) { ?>
						<a href="<?php the_sub_field('link'); ?>" target="_blank"><?php the_sub_field('quoted_by'); ?></a>
						<?php } else { ?>
						<?php the_sub_field('quoted_by'); ?>
						<?php } ?>
					</p>			
				</div>	
			</div>
			
		<?php
		    endwhile;
		
		else :
		
		    // no rows found
		
		endif;
		
		?>
		
	</div>	
		
</section>	

<?php
endwhile;
endif;
wp_reset_postdata();
?>	
<script type="text/javascript" charset="utf-8">
	console.log(document.referrer);
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


