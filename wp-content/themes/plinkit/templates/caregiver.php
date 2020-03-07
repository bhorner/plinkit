<?php
/*
 * Template Name: Caregiver Page
 * Description: A page template with a default design.
 */
?>

<?php get_header(); ?>
<?php
	if (have_posts()) :
	   while (have_posts()) : the_post();
	?>
	<div id="wrapper" class="caregiver">
	<section id="banner">
		<div class="container">
			<div class="content">	
				<h2 class="header bg-coral top-header"><?php the_field('title');?></h2>	
				<h3 class="text-center color-teal"><?php the_field('intro');?></h3>	
				
				<div class="three-col text-center">
					<div class="col">
						<div class="col-icon">
							<?php include get_template_directory() . '/img/caregiver3.svg'; ?>
						</div>	
						<h3 class="color-yellow"><?php the_field('left_column_title');?></h3>	
						<p><?php the_field('left_column_text');?></p>	
					</div>	
					<div class="col mid-col">
						<div class="col-icon">
							<?php include get_template_directory() . '/img/caregiver2.svg'; ?>
						</div>	
						<h3 class="color-teal"><?php the_field('middle_column_title');?></h3>	
						<p><?php the_field('middle_column_text');?></p>	
					</div>	
					<div class="col">
						<div class="col-icon">
							<?php include get_template_directory() . '/img/caregiver1.svg'; ?>
						</div>	
						<h3 class="color-coral"><?php the_field('right_column_title');?></h3>	
						<p><?php the_field('right_column_text');?></p>	
					</div>	
				</div>
				
				<div class="text-center">
					<div class="get-started">
						<a class="btn scroll" href="#join-us"><?php the_field('button_text');?></a>	
						<?php the_field('button_copy');?>	
					</div>
				</div>	
			</div>		
			<div class="text-left classes content">
				<?php
				
				// check if the repeater field has rows of data
				if( have_rows('content') ):
				
				 	// loop through the rows of data
				    while ( have_rows('content') ) : the_row();
				?>
				    <h2 class="header inline-block"><?php the_sub_field('title'); ?></h2>	
				    <?php the_sub_field('text'); ?>
				    <hr class="bigger">
				<?php
				    endwhile;
				
				else :
				
				    // no rows found
				
				endif;
				
				?>
				<br>
				<br>
				<div class="text-center">
					<a class="btn inline-block" href="#share-post" style="margin-bottom: 50px;"><span class="fa fa-share-square-o"></span> Share this Course</a>	
				</div>
			</div>	
			
			<hr class="bigger" id="join-us"></hr>
			<div class="register-now text-center login" >
				<h2 class="color-teal">Register Now</h2>
				<p>Create your Plinkit account to get started</p>	
				<?php echo do_shortcode('[wppb-register form_name="caregiver"]'); ?>	
			</div>
			
			<div class="text-center">
				<div class="get-started">
					<?php the_field('disclaimer');?>
				</div>
			</div>
					
		</div>
	</section>
	</div>
	
	<div class="remodal text-center" data-remodal-id="share-post">
		  <button data-remodal-action="close" class="remodal-close"></button>
		  <h2 class="color-teal">Spread the Love!</h1>
			  
		  <div class="social-share">
				<a target="_blank" href="mailto:?subject=<?php the_title();?>" class="fa fa-envelope"></a>
				<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" class="fa fa-facebook"></a>
				<a target="_blank" href="https://www.instagram.com/myplinkit/" class="fa fa-instagram"></a>
<!-- 				<a target="_blank" href="https://twitter.com/home?status=Check this out - <?php echo get_the_title() . ' • ' . get_bloginfo('name'); ?> • <?php the_permalink(); ?>" class="fa fa-twitter"></a> -->
<!--
				<a target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php echo $image['url'];?>&description=<?php echo get_the_title(); ?>" class="fa fa-pinterest-p"></a>
-->
		  </div>	
		  <br>
	</div>

	<div class="ball-bounce">
		<img class="bb" src="<?php bloginfo('template_url'); ?>/img/ball_bounce.gif">
		<img class="bb-bg" src="<?php bloginfo('template_url'); ?>/img/ball_bounce.png">
	</div>
		
	<?php
	endwhile;
	endif;
	wp_reset_postdata();
	?>	
<?php get_footer(); ?>


