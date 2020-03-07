<?php
/*
 * Template Name: Single Page for toys
 * Description: A page template with a default design.
 */
?>

<?php get_header(); ?>

<div id="wrapper">
<section id="banner" class="sidebar-container">
	<div class="container toy-container">
		<?php
		if (have_posts()) :
		   while (have_posts()) : the_post();
		?>
		<div id="featured" class="width-65 column left">
			
			<div class="featured-item single-toy-top">
				<div class="header-container">
					<div class="header bg-coral text-left"><?php the_title(); ?></div>
				</div>	
				
				
				<div class="width-60 column left">
					<div class="flexslider">
						<?php 
	
						$images = get_field('images');
						
						if( $images ): ?>
							<ul class="slides">
						        <?php foreach( $images as $image ): ?>
						            <li>
						                <a target="_blank" href="<?php the_field('link');?>">
						                     <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
						                </a>
						            </li>
						        <?php endforeach; ?>
						    </ul>
						<?php endif; ?>
					</div>	
				</div>	
				
				<div class="width-15 column left">
					<div class="thumb-nav">
						<?php 
	
						$images = get_field('images');
						
						if( $images ): ?>
							<ul class="slides">
						        <?php foreach( $images as $image ): ?>
					                <a href="#">
					                     <img src="<?php echo $image['sizes']['thumbnail']; ?>" alt="<?php echo $image['alt']; ?>" />
					                </a>
						        <?php endforeach; ?>
						    </ul>
						<?php endif; ?>
					</div>	
				</div>	
				
				<div class="width-25 column left">
					<div class="toy-cats">
						<div class="toy-cats-inner">
							<div class="age-ranges">
							
							<?php 
							$post_id = get_the_ID();
							$age_assigned_terms = wp_get_post_terms($post_id, 'age-range-toys', array("fields" => "all"));
							// SHOW YOAST PRIMARY CATEGORY, OR FIRST CATEGORY
							$categories = get_the_terms(get_the_id(), 'age-range-toys');
							// If post has a category assigned.
								
								// loop through the term objects
								$icount = 0;
								$len = count($age_assigned_terms);
								foreach($categories as $category) {
								    echo '<div class="age">Age ' . $category->slug . '</div>';
								    $icount++;
								}
							?>
														
							</div>
							<div class="skills">
							
							<?php 
							// SHOW YOAST PRIMARY CATEGORY, OR FIRST CATEGORY
							$categories = get_the_terms(get_the_id(), 'skills-toys');
							// If post has a category assigned.
							if ($categories){
								if ( class_exists('WPSEO_Primary_Term') )
								{
									// Show the post's 'Primary' category, if this Yoast feature is available, & one is set
									$wpseo_primary_term = new WPSEO_Primary_Term( 'skills-toys', get_the_id() );
									$wpseo_primary_term = $wpseo_primary_term->get_primary_term();
									$term = get_term( $wpseo_primary_term );
									
									// Yoast Primary category
									$category_display[$term->slug] = array($term->name, $term->slug);
								} 
								
								foreach($categories as $category){
									$category_display[$category->slug] = array($category->name, $category->slug);
								}
								// $category_display = array_unique($category_display);
								
								foreach($category_display as $key => $value) {
								?>
								<div class="skill <?php echo $value[1] . ' ';?>"><?php echo $value[0] . ' ';?></div>
								<?php
								}
								
							}
							?>
							
							</div>	
							<div class="link-out">
								<div class="buttons">
									<a class="btn" href="<?php the_field('link');?>" target="_blank">
										<span class="price">Buy Now</span>	 <br>
										<span class="store"><?php the_field('store');?></span>	
										<span class="fa fa-share"></span>
									</a>	
								</div>	
							</div>	
						</div>	
					</div>	
					
				</div>	
				
			</div>
			

		</div>	
		<?php
	   endwhile;
		endif;
		wp_reset_postdata();
		?>		
	</div>
	<div class="container">
	<div class="must-read-list width-35 column left">
		<div id="sidebar-rel">
			<div class="header bg-teal text-left no-margin">
				Why We Love It
			</div>	
			<div class="love">
				
				<?php the_field('content');?>
				
				<div class="tellus"><?php the_field('footer_text');?></div>	
				
				<div class="btn-group">
					<a class="btn share-btn" href="#share-post"><span class="fa fa-share-square-o"></span> Share</a>	
					
					<?php
					if ( is_user_logged_in() ) {
						echo do_shortcode('[favorite_button post_id="" site_id=""]');
					} else {
					?>
						<a class="fave-btn" href="<?php echo site_url(); ?>/log-in">Favorite <i class="sf-icon-heart-empty"></i></a>
					<?php
					}
					?>
					
				</div>	

			</div>	
		</div>
	</div>	
</section>	

<section id="bands">
	
	<div class="container">
	</div>	
	
	<?php
	$oddcount = 1;
	// check if the repeater field has rows of data
	if( have_rows('bands') ):
	
	 	// loop through the rows of data
	    while ( have_rows('bands') ) : the_row();
	?>
	
	<div class="band  <?php if($oddcount == 1){ echo "odd"; }?>">
	    <div class="container">
		<?php if(get_sub_field('header')) { ?>
			<div class="header"><?php the_sub_field('header'); ?></div>	
		<?php } ?>
	<?php 
	    if($oddcount > 1){
	        $oddcount = 1;
	    } else {
	        $oddcount++;
	    }
	?>
	<?php $count = 1;?>
	<?php
	
	/*
	*  Loop through post objects (assuming this is a multi-select field) ( setup postdata )
	*  Using this method, you can use all the normal WP functions as the $post object is temporarily initialized within the loop
	*  Read more: http://codex.wordpress.org/Template_Tags/get_posts#Reset_after_Postlists_with_offset
	*/
	
	$post_objects = get_sub_field('posts');
	if( $post_objects ): ?>
	    <?php foreach( $post_objects as $post): // variable must be called $post (IMPORTANT) ?>
	        <?php $count++;?>
	    <?php endforeach; ?>
	    
	    <?php if($count > 6) { ?>
	    	<div class="owl-carousel">
	    <?php } else {?>
	    	<div class="no-owl">
	    <?php }?>
	    <?php $number = 1;?>
	    <?php foreach( $post_objects as $post): // variable must be called $post (IMPORTANT) ?>
	        <?php setup_postdata($post); ?>
	        <?php $post_id = $post->ID; ?>
	        <div class="band-item width-25 column left number-<?php echo $number;?> <?php echo get_post_status($post_id); ?>">
	           	<?php get_template_part('band-item'); ?>
	        </div>
	        <?php $number++;?>
	    <?php endforeach; ?>
	    	</div>
	    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
	<?php endif;?>

	    </div>	
	</div>		
	<?php
	    endwhile;
	
	else :
	
	    // no rows found
	
	endif;
	
	?>	
</section>	

</div>

	<div class="remodal text-center" data-remodal-id="share-post">
	  <button data-remodal-action="close" class="remodal-close"></button>
	  <h2 class="color-teal">Spread the Love!</h1>
		  
	  <div class="social-share">
			<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" class="fa fa-facebook"></a>
	  </div>	
	  <br>
	</div>


<script type="text/javascript" charset="utf-8">
	$(window).load(function() {
		height();
		$('.flexslider').flexslider({
			animation: "slide",
			directionNav: false,
			manualControls: ".thumb-nav a",
			start: function(){
			}, 
		});

		$width = $(window).width();
		
		if($width > 990) {
			owl();
		}		
		
		$sheight = $('.sidebar-inner').height();
		$('.sheight').height($sheight);
	});
	
	function thumbHeight() {
		var height = $('.love').height();
		
		var count = $('.thumb-nav a').length;
		
		var newCount = (height -30) / count;
		
		$('.thumb-nav a').height(newCount);
		$('.thumb-nav').height(height - 10);
		$('.flexslider').outerHeight(height- 10);
		$('.toy-cats').height(height - 10);
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


