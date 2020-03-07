<?php
/*
 * Template Name: Browse Toys
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
						<?php the_field('content');?>
						
						<?php the_field('critical_thinking_header');?>
						
						<?php
						$args = array(
							'post_type' => 'toys',
							'orderby' => 'title',
							'order' => 'ASC',
							'posts_per_page' => -1,
							'meta_key' => '_yoast_wpseo_primary_skills-toys',
							'meta_value' => '25'
						);
						$query = new WP_Query( $args );
						
						// The Loop
						if ( $query->have_posts() ) {
							echo '<ul>';
							while ( $query->have_posts() ) {
								$query->the_post();
								echo '<li><a target="_blank" href="' . get_the_permalink() . '">' . get_the_title() . '</a></li>';
							}
							echo '</ul>';
							/* Restore original Post Data */
							wp_reset_postdata();
						} else {
							// no posts found
						}
						?>
						
						<?php the_field('social_emotional_header');?>
						
						<?php
						$args = array(
							'post_type' => 'toys',
							'orderby' => 'title',
							'order' => 'ASC',
							'posts_per_page' => -1,
							'meta_key' => '_yoast_wpseo_primary_skills-toys',
							'meta_value' => '29'
						);
						$query = new WP_Query( $args );
						
						// The Loop
						if ( $query->have_posts() ) {
							echo '<ul>';
							while ( $query->have_posts() ) {
								$query->the_post();
								echo '<li><a target="_blank" href="' . get_the_permalink() . '">' . get_the_title() . '</a></li>';
							}
							echo '</ul>';
							/* Restore original Post Data */
							wp_reset_postdata();
						} else {
							// no posts found
						}
						?>

						<?php the_field('language_literacty_header');?>
						
						<?php
						$args = array(
							'post_type' => 'toys',
							'orderby' => 'title',
							'order' => 'ASC',
							'posts_per_page' => -1,
							'meta_key' => '_yoast_wpseo_primary_skills-toys',
							'meta_value' => '28'
						);
						$query = new WP_Query( $args );
						
						// The Loop
						if ( $query->have_posts() ) {
							echo '<ul>';
							while ( $query->have_posts() ) {
								$query->the_post();
								echo '<li><a target="_blank" href="' . get_the_permalink() . '">' . get_the_title() . '</a></li>';
							}
							echo '</ul>';
							/* Restore original Post Data */
							wp_reset_postdata();
						} else {
							// no posts found
						}
						?>
						
						<?php the_field('creativity_imagination_header');?>
						
						<?php
						$args = array(
							'post_type' => 'toys',
							'orderby' => 'title',
							'order' => 'ASC',
							'posts_per_page' => -1,
							'meta_key' => '_yoast_wpseo_primary_skills-toys',
							'meta_value' => '27'
						);
						$query = new WP_Query( $args );
						
						// The Loop
						if ( $query->have_posts() ) {
							echo '<ul>';
							while ( $query->have_posts() ) {
								$query->the_post();
								echo '<li><a target="_blank" href="' . get_the_permalink() . '">' . get_the_title() . '</a></li>';
							}
							echo '</ul>';
							/* Restore original Post Data */
							wp_reset_postdata();
						} else {
							// no posts found
						}
						?>
																		
						<?php the_field('fine_gross_motor_header');?>
						
						<?php
						$args = array(
							'post_type' => 'toys',
							'orderby' => 'title',
							'order' => 'ASC',
							'posts_per_page' => -1,
							'meta_key' => '_yoast_wpseo_primary_skills-toys',
							'meta_value' => '26'
						);
						$query = new WP_Query( $args );
						
						// The Loop
						if ( $query->have_posts() ) {
							echo '<ul>';
							while ( $query->have_posts() ) {
								$query->the_post();
								echo '<li><a target="_blank" href="' . get_the_permalink() . '">' . get_the_title() . '</a></li>';
							}
							echo '</ul>';
							/* Restore original Post Data */
							wp_reset_postdata();
						} else {
							// no posts found
						}
						?>

						<?php the_field('wow_factor_header');?>
						
						<?php
						$args = array(
							'post_type' => 'toys',
							'orderby' => 'title',
							'order' => 'ASC',
							'posts_per_page' => -1,
							'meta_key' => '_yoast_wpseo_primary_skills-toys',
							'meta_value' => '44'
						);
						$query = new WP_Query( $args );
						
						// The Loop
						if ( $query->have_posts() ) {
							echo '<ul>';
							while ( $query->have_posts() ) {
								$query->the_post();
								echo '<li><a target="_blank" href="' . get_the_permalink() . '">' . get_the_title() . '</a></li>';
							}
							echo '</ul>';
							/* Restore original Post Data */
							wp_reset_postdata();
						} else {
							// no posts found
						}
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

