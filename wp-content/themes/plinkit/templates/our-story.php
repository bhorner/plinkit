<?php
/*
 * Template Name: Our Story Page
 * Description: A page template with a default design.
 */
?>

<?php get_header(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.1/TweenMax.min.js"></script>

<div id="wrapper">
<section id="banner" class="our-story ball">
	<div class="container">
		
	<?php
	
/*
	$args = array( 
		'post_type'        => 'post',
		'posts_per_page'   => -1,
		's'				   => 'share',
		'meta_query' => array(
		     array(
		       'key' => 'learn',
		       'value' => 'read',
		       'compare' => 'LIKE'
		     )
		   )
		
	);

	// The Query
	$the_query = new WP_Query( $args );
	
	// The Loop
	if ( $the_query->have_posts() ) :

		$count = 1;
		$toycount = 1;
	    $number = 1;

		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			echo '<a href="' . get_permalink() . '">';			
			the_title();
			echo '</a><br>';			
		}
	endif;
*/
	?>
		
		<?php
		if (have_posts()) :
		   while (have_posts()) : the_post();
		?>

		<h2 class="color-teal text-center"><?php the_field('headline');?></h2>	
		
		<div class="chat-boxes no-pic">
			
			<?php
			
			// check if the repeater field has rows of data
			if( have_rows('text_boxes') ):
			
			 	// loop through the rows of data
			    while ( have_rows('text_boxes') ) : the_row();
			    $image = get_sub_field('image');
			?>
			    <div class="chat-box ">
					<div class="cover chat-img" style="background-image: url(<?php echo $image['url'] ?>);"></div>
					<div class="chat-text">
						<h3 class="color-coral"><?php the_sub_field('title'); ?></h3>	
						<p><?php the_sub_field('text'); ?></p>	
					</div>	
				</div>
			<?php
			    endwhile;
			
			else :
			
			    // no rows found
			
			endif;
			
			?>
			
		</div>	
		
		<section class="content-box ">
			<h2 class="color-teal text-center"><?php the_field('section_2_headline');?></h2>	
			<div class="main-title"><?php the_field('basics_title');?></div>	
			<div class="big color-coral"><?php the_field('back_to_basics_intro');?></div>	
			<div class="basics ">
				<div class="width-50 column left">
					<div class="basic">
						<div class="icon">
							<?php include get_template_directory() . '/img/icons/critical-thinking.svg'; ?>
						</div>	
						<p><span class="color-coral">Critical Thinking:</span>	<?php the_field('critical_thinking');?></p>	
					</div>	
					<div class="basic">
						<div class="icon">
							<?php include get_template_directory() . '/img/icons/social.svg'; ?>
						</div>	
						<p><span class="color-coral">Social + Emotional:</span>	<?php the_field('social_emotional');?></p>	
					</div>	
					<div class="basic">
						<div class="icon">
							<?php include get_template_directory() . '/img/icons/language.svg'; ?>
						</div>	
						<p><span class="color-coral">Language + Literacy:</span>	<?php the_field('language_literacy');?></p>	
					</div>	
				</div>	
				<div class="width-50 column left">
					<div class="basic">
						<div class="icon">
							<?php include get_template_directory() . '/img/icons/creativity.svg'; ?>
						</div>	
						<p><span class="color-coral">Creativity + Imagination:</span>	<?php the_field('creativity_imagination');?></p>	
					</div>	
					<div class="basic">
						<div class="icon">
							<?php include get_template_directory() . '/img/icons/motor-skills.svg'; ?>
						</div>	
						<p><span class="color-coral">Fine Motor + Gross Motor:</span>	<?php the_field('fine_motor_gross_motor');?></p>	
					</div>	
				</div>	
			</div>	
			
			<div class="">
			
				<div class="main-title bg-teal"><?php the_field('one_stop_title');?></div>	
				<div class="big color-teal"><?php the_field('one_stop_discovery_zone_headline');?></div>	
				
				<div class="discovery">
					<div class="width-50 column left">
						<div class="basic">
							<div class="double-icon">
								<div class="icon">
									<?php include get_template_directory() . '/img/light.svg'; ?>
								</div>	
								<div class="icon">
									<?php include get_template_directory() . '/img/crayon.svg'; ?>
								</div>		
							</div>	
							
							<p><span class="color-coral">Learn + Do:</span>	<?php the_field('learn_do');?></p>	
						</div>	
					</div>	
					<div class="width-50 column left">
						<div class="basic">
							<div class="double-icon">
								<div class="icon">
									<?php include get_template_directory() . '/img/icons/shopping.svg'; ?>
								</div>	
								<div class="icon">
									<?php include get_template_directory() . '/img/icons/play.svg'; ?>
								</div>		
							</div>	
							<p><span class="color-coral">Shop + Play: </span><?php the_field('shop_&_play');?></p>	
						</div>	
					</div>	
				</div>
			</div>
		</section>	
		
		<?php
			
			// check if the repeater field has rows of data
			if( have_rows('content') ):
			
			 	// loop through the rows of data
			    while ( have_rows('content') ) : the_row();
			?>
				<section class="content-box hide">
					<h2 class="color-teal"><?php the_sub_field('headline'); ?></h2>
					<?php the_sub_field('text'); ?>
				</section>	
			<?php
			    endwhile;
			
			else :
			
			    // no rows found
			
			endif;
			
			?>
		
		<?php
	   endwhile;
		endif;
		wp_reset_postdata();
		?>				
		
		<div class="ball-bounce">
			<img class="bb" src="<?php bloginfo('template_url'); ?>/img/ball_bounce.gif">
			<img class="bb-bg" src="<?php bloginfo('template_url'); ?>/img/ball_bounce.png">
		</div>	
		
	</div>
</section>



<script type="text/javascript" charset="utf-8">
	$(window).load(function() {
		height();
		$('.flexslider').flexslider({
			animation: "fade"
		});

		$width = $(window).width();
				
	});
	
	function owl() {
		$(".owl-carousel").owlCarousel({
		  items: 4,
		  nav: true,
		  loop: true
		});
	}
	
	dotAnimation();
</script>
<?php get_footer(); ?>


