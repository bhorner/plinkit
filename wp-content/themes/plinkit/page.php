<?php
/*
 * Template Name: Default Page
 * Description: A page template with a default design.
 */
?>
<?php get_header(); ?>

<?php
	if (have_posts()) :
	   while (have_posts()) : the_post();
	?>
		<div id="wrapper">
			<section id="banner" class="ball">
				<div class="container">
					<h2 class="color-teal text-center"><?php the_field('headline');?></h2>
				</div>
				<div class="container container-880">
					<div class="content-container">
						<div class="post-content content">
						
						<?php
						// check if the flexible content field has rows of data
						if( have_rows('add_content') ):
						
						     // loop through the rows of data
						    while ( have_rows('add_content') ) : the_row();
						
						        if( get_row_layout() == 'header' ):
						?>
						
						<?php
	
						// vars
						$field = get_sub_field_object('color');
						$value = $field['value'];
						
						?>
						
						<div class="main-title" style="background: #<?php echo $value?>"><?php the_sub_field('text');?></div>
						
						<?php
						        elseif( get_row_layout() == 'content' ): 
						?>
						<div class="post-content">  
						    <?php the_sub_field('content');?>
						</div>	
						<?php
						        endif;
						
						    endwhile;
						
						else :
						
						    // no layouts found
						
						endif;
						
						?>
					
						</div>	
					</div>	
					
					<div class="ball-bounce">
						<img class="bb" src="<?php bloginfo('template_url'); ?>/img/ball_bounce.gif">
						<img class="bb-bg" src="<?php bloginfo('template_url'); ?>/img/ball_bounce.png">
					</div>
				
				</div>
			</section>
		</div>
		
	<?php
	endwhile;
	endif;
	wp_reset_postdata();
	?>	
<?php get_footer(); ?>

