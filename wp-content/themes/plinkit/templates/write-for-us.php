<?php
/*
 * Template Name: Write For Us
 * Description: A page template with a default design.
 */
?>

<?php get_header(); ?>

<div id="wrapper">
<section id="banner" class="our-story ball">
	<div class="container container-880">
		<?php
		if (have_posts()) :
		   while (have_posts()) : the_post();
		?>

		<h2 class="color-teal text-center"><?php the_field('headline');?></h2>	
		
		<div class="chat-boxes">
			
			<?php
			
			// check if the repeater field has rows of data
			if( have_rows('text_boxes') ):
			
			 	// loop through the rows of data
			    while ( have_rows('text_boxes') ) : the_row();
			    $image = get_sub_field('image');
			?>
			    <div class="chat-box">
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
		
		<section class="content-box">
			<h2 class="color-teal text-center"><?php the_field('section_2_headline');?></h2>	
			<div class="main-title">Back to Basics</div>	
			<div class="big color-coral"><?php the_field('back_to_basics_intro');?></div>	
			<div class="basics">
				<div class="width-50 column left">
					<div class="basic">
						<p><span class="color-coral">Critical Thinking:</span>	<?php the_field('critical_thinking');?></p>	
					</div>	
					<div class="basic">
						<p><span class="color-coral">Creativity & Imagination:</span>	<?php the_field('creativity_imagination');?></p>	
					</div>	
					<div class="basic">
						<p><span class="color-coral">Language & Literacty:</span>	<?php the_field('language_literacy');?></p>	
					</div>	
				</div>	
				<div class="width-50 column left">
					<div class="basic">
						<p><span class="color-coral">Social & Emotional:</span>	<?php the_field('social_emotional');?></p>	
					</div>	
					<div class="basic">
						<p><span class="color-coral">Fine Motor & Gross Motor:</span>	<?php the_field('fine_motor_gross_motor');?></p>	
					</div>	
				</div>	
			</div>	
			
			<div class="main-title bg-teal">All you Need - In one Place</div>	
			<div class="big color-teal"><?php the_field('All you Need - In one Place');?></div>	
			
			<div class="discovery">
				<div class="width-50 column left">
					<div class="basic">
						<p><span class="color-coral">Learn & Do:</span>	<?php the_field('learn_do');?></p>	
					</div>	
				</div>	
				<div class="width-50 column left">
					<div class="basic">
						<p><span class="color-coral">Shop & Play:</span><?php the_field('shop_&_play');?></p>	
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
				<section class="content-box text-center">
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
		
		if($width > 990) {
			owl();
		}		
		
		$sheight = $('.sidebar-inner').height();
		$('.sheight').height($sheight);
// 		scroll();
	});
	
	function scroll() {
		$(window).scroll(function(){
			
			var a = $(".sidebar-container").offset().top;
			
			var b = $(".sidebar-container").height();
			
			var c = $(window).height();
			var d = $(window).scrollTop();
			
			if (scroll ) {
				$('#sidebar').addClass('unstuck');
			} else {
				$('#sidebar').removeClass('unstuck');
			}
		});
	}
	
	function owl() {
		$(".owl-carousel").owlCarousel({
		  items: 4,
		  nav: true,
		  loop: true
		});
	}
</script>
<?php get_footer(); ?>


