<?php
/*
 * Template Name: Single PlinkitParents 
 * Description: A page template with a default design.
 */
?>

<?php get_header(); ?>

<div id="wrapper">
<section id="banner" class="sidebar-container">
	<div class="container">
		<div class="container-inner" sticky_parent>
		<?php
			
		global $post; 
		if ( ! post_password_required( $post ) ) {
		while ( have_posts() ) { the_post(); }
		
		?>
		
			<?php // print_r(get_post_meta(get_the_ID())); ?>

			<?php 
				$image = get_field('post_image');
				$thumb = $image['sizes'][ 'post-thumb' ];
				
			?>
				<div class="remodal text-center" data-remodal-id="share-post">
				  <button data-remodal-action="close" class="remodal-close"></button>
				  <h2 class="color-teal">Spread the Love!</h1>
					  
				  <div class="social-share">
						<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" class="fa fa-facebook"></a>
<!-- 						<a target="_blank" href="https://www.instagram.com/myplinkit/" class="fa fa-instagram"></a> -->
<!--
						<a target="_blank" href="https://twitter.com/home?status=Check this out - <?php echo get_the_title() . ' • ' . get_bloginfo('name'); ?> • <?php the_permalink(); ?>" class="fa fa-twitter"></a>
						<a target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php echo $image['url'];?>&description=<?php echo get_the_title(); ?>" class="fa fa-pinterest-p"></a>
-->
				  </div>	
				  <br>
				</div>

				<div id="featured" class="width-65 column left" data-sticky_column>
					
					<div class="featured-item">
						<div class="main-title">#PlinkitParents</div>
						
						<div class="author-div">
							<h2 class="color-teal"><?php the_field('title');?></h2>	
							<p class="upper"><b><?php the_field('tagline');?></b></p>
						</div>	
						
						<div class="clearfix"></div>	
						</div>	
						
						<div class="image">	
						
						<?php if(get_field('post_image')):?>
							<a href="<?php the_permalink(); ?>">
								<img src="<?php echo $image['url'];?>">
							</a>
						<?php endif;?>
						</div>
						<div class="content">	
							
							<?php the_field('content');?>

							<?php if (get_field('learn')) {?>
							<div class="learn-content">
								<h3 class="color-yellow"><span class="icon"><?php include get_template_directory() . '/img/light.svg'; ?></span> Learn</h3>	
								<?php the_field('learn');?>
							</div>	
							<?php } ?>
							<?php if (get_field('do')) {?>
							<div class="do-content">
								<h3 class="color-yellow"><span class="icon"><?php include get_template_directory() . '/img/crayon.svg'; ?></span> Do</h3>	
								<?php the_field('do');?>
							</div>	
							<?php } ?>
							<?php if (get_field('our_favorite_books_on_this_topic')) {?>
							<div class="do-content">
								<h3 class="color-yellow">Our Favorite Books on this Topic</h3>	
								<?php the_field('our_favorite_books_on_this_topic');?>
							</div>	
							<?php } ?>
							
						</div>
					
					<div class="post-footer">
						<div class="buttons">
							<a class="btn" href="#share-post"><span class="fa fa-share-square-o"></span> Share</a>	
							
							<?php
							if ( is_user_logged_in() ) {
								echo do_shortcode('[favorite_button post_id="" site_id=""]');
							} else {
							?>
								<a class="fave-btn" href="#log-in">Favorite <i class="sf-icon-heart-empty"></i></a>
							<?php
							}
							?>
							
							<a class="btn mleft" href="javascript:window.print()" ><span class="fa fa-print"></span> Print</a>	
						</div>	
					
					<div class="have"><?php the_field('post_footer_text');?></div>	

					<div class="clearfix"></div>	
				</div>	
	<?php
	} else {
	?>
		<div id="featured" class="width-65 column left text-left" data-sticky_column>
			<?php echo get_the_password_form(); ?>
		</div>
	<?php
	}
	wp_reset_postdata();
	?>		
	<?php
		$post_objects = get_field('works_well_with');
		if( $post_objects ): ?>
	<div id="sticky" class="must-read-list width-35 column left sheight sticky">
		<div id="sidebar" data-sticky_column>
			<div class="sidebar-inner">
			<div class="header bg-teal">
				Works Well With
			</div>	
			
			
			<?php foreach( $post_objects as $post): // variable must be called $post (IMPORTANT) ?>
	        <?php setup_postdata($post); ?>
	        
	        		<?php 
						
						if ( get_post_type( get_the_ID() ) == 'toys' ) {
							$image = get_field('images');
							$thumb = $image[0]['sizes'][ 'post-thumb' ];
						} else {
							$image = get_field('post_image');
							$thumb = $image['sizes'][ 'post-thumb' ];
						}
					?>

	        
				<div class="mr-item">
					<div class="thumb width-40 column left">	
					<?php 
						$post_id = $post->ID;
					
						if ( get_post_type( get_the_ID() ) == 'toys' ) {
							// get the assigned taxonomy terms for "property-city"
							$age_assigned_terms = wp_get_post_terms($post_id, 'age-range-toys', array("fields" => "all"));
							$toy_assigned_terms = wp_get_post_terms($post_id, 'skills-toys', array("fields" => "all"));
							$image = get_field('images');
							$thumb = $image[0]['sizes'][ 'post-thumb' ];
						} else {
							$age_assigned_terms = wp_get_post_terms($post_id, 'age-range', array("fields" => "all"));
							$toy_assigned_terms = wp_get_post_terms($post_id, 'skills', array("fields" => "all"));
							$image = get_field('post_image');
							$thumb = $image['sizes'][ 'post-thumb' ];
						}

					?>
					
					<?php if($image != 0):?>
						<a href="<?php the_permalink(); ?>">
							<img src="<?php echo $thumb;?>">
						</a>
					<?php else:?>
						<img src="http://placehold.it/320x220">
					<?php endif;?>
					</div>
					<div class="excerpt width-60 column left">	
						<a class="title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						<?php $excerpt = wp_trim_words( get_field('content' ), $num_words = 20, $more = '...' ); ?>
						<p><?php echo $excerpt; ?></p>	
					</div>


					<div class="age-tags">
						<div class="age">Ages</div>	
					<?php 
					// SHOW YOAST PRIMARY CATEGORY, OR FIRST CATEGORY
					$categories = get_the_terms(get_the_id(), 'age-range');
					// If post has a category assigned.
					if ($categories){
						if ( class_exists('WPSEO_Primary_Term') )
						{
							// Show the post's 'Primary' category, if this Yoast feature is available, & one is set
							$wpseo_primary_term = new WPSEO_Primary_Term( 'age-range', get_the_id() );
							$wpseo_primary_term = $wpseo_primary_term->get_primary_term();
							$term = get_term( $wpseo_primary_term );
							
							// Yoast Primary category
							$age_display[$term->slug] = array($term->name, $term->slug);
						} 
						
						foreach($categories as $category){
							$age_display[$category->slug] = array($category->name);
						}
						// $category_display = array_unique($category_display);
						
						// loop through the term objects
						$icount = 0;
						$len = count($age_assigned_terms);
						foreach($age_display as $key => $value) {
						    if ($icount == $len - 1) {
						   		echo '<div class="age"> ' . $value[0] . ' </div>';
						    } else {
						   		echo '<div class="age"> ' . $value[0] . ', </div>';
						    }
						    $icount++;
						}
						$age_display = array();
					}
					?>
					</div>	


					<div class="cat-tags
					<?php
						$toy_assigned_terms = wp_get_post_terms($id, 'skills', array("fields" => "all"));
						foreach($toy_assigned_terms as $term){
						    echo $term->slug . ' ';
						}
					?>
					">
					
					<?php 
					// SHOW YOAST PRIMARY CATEGORY, OR FIRST CATEGORY
					$categories = get_the_terms(get_the_id(), 'skills');
					// If post has a category assigned.
					if ($categories){
						if ( class_exists('WPSEO_Primary_Term') )
						{
							// Show the post's 'Primary' category, if this Yoast feature is available, & one is set
							$wpseo_primary_term = new WPSEO_Primary_Term( 'skills', get_the_id() );
							$wpseo_primary_term = $wpseo_primary_term->get_primary_term();
							$term = get_term( $wpseo_primary_term );
							
							// Yoast Primary category
							$category_display[$term->slug] = array($term->name, $term->slug);
						} 
						
						foreach($categories as $category){
							$category_display[$category->slug] = array($category->name, $category->slug);
						}
						// $category_display = array_unique($category_display);
						
						$category_display = array_reverse($category_display);
						
						foreach($category_display as $key => $value) {
						?>
							<div class="icon-tag <?php echo $value[1] . ' ';?>"><span class="tooltip"><?php echo $value[0] . ' ';?><span></span></span></div>
						<?php
						}
						$category_display = array();					
					}
					?>
					
					</div>

				</div>
			<?php endforeach; ?>
			</div>	
			</div>
		</div>	
		<?php
		wp_reset_postdata();?>
		<?php endif;?>

	</div>	
</section>	

<section id="bands">
	<?php
	$oddcount = 1;
	// check if the repeater field has rows of data
	if( have_rows('bands') ):
	
	 	// loop through the rows of data
	    while ( have_rows('bands') ) : the_row();
	?>
	
	<div class="band <?php if($oddcount == 1){ echo "odd"; }?>">
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
	
	$post_objects = get_sub_field('post');
	if( $post_objects ): ?>
	    <?php foreach( $post_objects as $post): // variable must be called $post (IMPORTANT) ?>
	        <?php $count++;?>
	    <?php endforeach; ?>
	    
	    <?php if($count > 4) { ?>
	    	<div class="owl-carousel">
	    <?php } else {?>
	    	<div class="no-owl">
	    <?php }?>
	    <?php $number = 1;?>
	    <?php foreach( $post_objects as $post): // variable must be called $post (IMPORTANT) ?>
	        <?php setup_postdata($post); ?>
	        <div class="band-item width-25 column left number-<?php echo $number;?>">
	           	<div class="thumb width-100 column left">	
					<?php 
						$post_id = $post->ID;
						if ( get_post_type( get_the_ID() ) == 'toys' ) {
							// get the assigned taxonomy terms for "property-city"
							$age_assigned_terms = wp_get_post_terms($post_id, 'age-range-toys', array("fields" => "all"));
							$toy_assigned_terms = wp_get_post_terms($post_id, 'skills-toys', array("fields" => "all"));
							$image = get_field('images');
							$thumb = $image[0]['sizes'][ 'post-thumb' ];
						} else {
							$age_assigned_terms = wp_get_post_terms($post_id, 'age-range', array("fields" => "all"));
							$toy_assigned_terms = wp_get_post_terms($post_id, 'skills', array("fields" => "all"));
							$image = get_field('post_image');
							$thumb = $image['sizes'][ 'post-thumb' ];
						}
						
					?>
					<?php if($image != 0):?>
						<a href="<?php the_permalink(); ?>">
							<img src="<?php echo $thumb;?>">
						</a>
					<?php else:?>
						<img src="http://placehold.it/320x220">
					<?php endif;?>
				</div>
				<div class="excerpt width-100 column left">	
					<a class="title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					<?php $excerpt = wp_trim_words( get_field('content' ), $num_words = 20, $more = '...' ); ?>
					<p><?php echo $excerpt; ?></p>	
				</div>
					<div class="age-tags">
						<div class="age">Ages</div>	
					<?php 
					// SHOW YOAST PRIMARY CATEGORY, OR FIRST CATEGORY
					$categories = get_the_terms(get_the_id(), 'age-range');
					// If post has a category assigned.
					if ($categories){
						if ( class_exists('WPSEO_Primary_Term') )
						{
							// Show the post's 'Primary' category, if this Yoast feature is available, & one is set
							$wpseo_primary_term = new WPSEO_Primary_Term( 'age-range', get_the_id() );
							$wpseo_primary_term = $wpseo_primary_term->get_primary_term();
							$term = get_term( $wpseo_primary_term );
							
							// Yoast Primary category
							$age_display[$term->slug] = array($term->name, $term->slug);
						} 
						
						foreach($categories as $category){
							$age_display[$category->slug] = array($category->name);
						}
						// $category_display = array_unique($category_display);
						
						// loop through the term objects
						$icount = 0;
						$len = count($age_assigned_terms);
						foreach($age_display as $key => $value) {
						    if ($icount == $len - 1) {
						   		echo '<div class="age"> ' . $value[0] . ' </div>';
						    } else {
						   		echo '<div class="age"> ' . $value[0] . ', </div>';
						    }
						    $icount++;
						}
						$age_display = array();
					}
					?>
					</div>	


					<div class="cat-tags
					<?php
						$toy_assigned_terms = wp_get_post_terms($id, 'skills', array("fields" => "all"));
						foreach($toy_assigned_terms as $term){
						    echo $term->slug . ' ';
						}
					?>
					">
					
					<?php 
					// SHOW YOAST PRIMARY CATEGORY, OR FIRST CATEGORY
					$categories = get_the_terms(get_the_id(), 'skills');
					// If post has a category assigned.
					if ($categories){
						if ( class_exists('WPSEO_Primary_Term') )
						{
							// Show the post's 'Primary' category, if this Yoast feature is available, & one is set
							$wpseo_primary_term = new WPSEO_Primary_Term( 'skills', get_the_id() );
							$wpseo_primary_term = $wpseo_primary_term->get_primary_term();
							$term = get_term( $wpseo_primary_term );
							
							// Yoast Primary category
							$category_display[$term->slug] = array($term->name, $term->slug);
						} 
						
						foreach($categories as $category){
							$category_display[$category->slug] = array($category->name, $category->slug);
						}
						// $category_display = array_unique($category_display);
						
						$category_display = array_reverse($category_display);
						
						foreach($category_display as $key => $value) {
						?>
							<div class="icon-tag <?php echo $value[1] . ' ';?>"><span class="tooltip"><?php echo $value[0] . ' ';?><span></span></span></div>
						<?php
						}
						$category_display = array();					
					}
					?>
					
					</div>

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
</div>

<script type="text/javascript" charset="utf-8">
	$(window).load(function() {
		height();

		$width = $(window).width();
		
		if($width > 990) {
			owl();
		}		
		
		$sheight = $('.sidebar-inner').height();
		$('.sheight').height($sheight);

		$("#sticky").stick_in_parent();
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


