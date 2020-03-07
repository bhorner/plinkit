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
		<section id="banner">
			<div class="container">
				<div class="content">	
		<?php
		
		// check if the flexible content field has rows of data
		if( have_rows('content') ):
		
		     // loop through the rows of data
		    while ( have_rows('content') ) : the_row();
		
		        if( get_row_layout() == 'header' ):
		
		        	the_sub_field('text');
		
		        elseif( get_row_layout() == 'content' ): 
		
		        	the_sub_field('content');
		
		        endif;
		
		    endwhile;
		
		else :
		
		    // no layouts found
		
		endif;
		
		?>	
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


