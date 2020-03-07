<?php
/*
 * Template Name: Home Page
 * Description: A page template with a default design.
 */
?>

<?php get_header(); ?>

<div class="big-text text-center">
	<div class="container">
		<h2><?php the_field('intro');?></h2>			
	</div>	
</div>	

<div id="banner">
</div>	

<section id="banner" class="">
	<div class="container">
		<div id="featured" class="width-65 column left">
			<?php
			if(!get_field('featured')) {
			global $post;
			$args = array( 
				'post_type'        => 'post',
				'posts_per_page'   => 1,
				'category_name'    => 'featured',
				'has_password'	   => false,
				'orderby'		   => 'rand'
			);
			
			$myposts = new WP_Query( $args );
			while ( $myposts->have_posts() ) { $myposts->the_post(); ?>
				<div class="featured-item">
					<div class="image">	
					<?php 
						$image = get_field('post_image');
						$thumb = $image['sizes'][ 'post-thumb' ];
					?>
					<?php if(get_field('post_image')):?>
						<a href="<?php the_permalink(); ?>">
							<img src="<?php echo $image['url'];?>">
						</a>
					<?php endif;?>
					<a class="featured-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</div>
					<div class="content">	
						<?php the_field('content');?>
						<a class="btn" href="<?php the_permalink(); ?>">Read More</a>	
						
						<?php
							$post_id = $post->ID;
							$age_assigned_terms = wp_get_post_terms($post_id, 'age-range', array("fields" => "all"));
							$toy_assigned_terms = wp_get_post_terms($post_id, 'skills', array("fields" => "all"));
						?>
						
						
						<div class="featured-icons">
						
						<?php
		
							// loop through the term objects
							foreach($age_assigned_terms as $term){
							    echo '<span class="icon age-icon"><span class="age-text">' . $term->name . '</span><span class="tooltip">Age</span></span>';
							}
							
						?>
									
							<?php
								foreach($toy_assigned_terms as $term){
									echo '<span class="icon">';
									include get_template_directory() . '/img/icons/' . $term->slug . '.svg';
									echo '<span class="tooltip">' . $term->name . '</span></span></span>';
								}
							?>
			
				        </div>

						
					</div>
				</div>
			<?php }; 
			wp_reset_postdata();
			} else {
			?>
			<?php
			
			$post_object = get_field('featured');
			
			if( $post_object ): 
			
				// override $post
				$post = $post_object;
				setup_postdata( $post ); 
			
				?>
			<div class="featured-item
					<?php if ( get_post_type( get_the_ID() ) == 'page' ) { echo 'type-page'; } ?>
						">
				<div class="image">	
				<?php 
					$image = get_field('post_image');
					$thumb = $image['sizes'][ 'post-thumb' ];
				?>
				<?php if(get_field('post_image')):?>
					<a href="<?php the_permalink(); ?>">
						<img src="<?php echo $image['url'];?>">
					</a>
				<?php endif;?>
				<a class="featured-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</div>
				<div class="content">
						<p>	
						<?php if ( get_post_type( get_the_ID() ) == 'page' ) {
							$content = get_field('intro');
						} else {
							$content = get_field('content');
						}
						echo $content;
						?>
						</p>	
					<a class="btn" href="<?php the_permalink(); ?>">Read More</a>	
					
					<?php
						$post_id = $post->ID;
						$age_assigned_terms = wp_get_post_terms($post_id, 'age-range', array("fields" => "all"));
						$toy_assigned_terms = wp_get_post_terms($post_id, 'skills', array("fields" => "all"));
					?>
					
					
					<div class="featured-icons">
					
					<?php
	
						// loop through the term objects
						foreach($age_assigned_terms as $term){
						    echo '<span class="icon age-icon"><span class="age-text">' . $term->name . '</span><span class="tooltip">Age</span></span>';
						}
						
					?>
								
						<?php
							foreach($toy_assigned_terms as $term){
								echo '<span class="icon">';
								include get_template_directory() . '/img/icons/' . $term->slug . '.svg';
								echo '<span class="tooltip">' . $term->name . '</span></span></span>';
							}
						?>
		
			        </div>

					
				</div>
			</div>
			<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
			<?php endif; ?>
			<?php } ?>

		</div>	
		
		<div class="must-read-list width-35 column left">
			<div class="header bg-teal">
				<?php the_field('editors_picks_title');?>
			</div>	
			<?php
			
			$post_objects = get_field('must_reads');
	    	foreach( $post_objects as $post): // variable must be called $post (IMPORTANT) ?>
				<div class="mr-item">
					<div class="thumb width-40 column left">	
					<?php 
						$post_id = $post->ID;
						if ( get_post_type( get_the_ID() ) == 'toys' ) {
							// get the assigned taxonomy terms for "property-city"
							$age_assigned_terms = wp_get_post_terms($post_id, 'age-range-toys', array("fields" => "all"));
							$toy_assigned_terms = wp_get_post_terms($post_id, 'skills-toys', array("fields" => "all"));
							
							$skillcat = 'skills-toys';
							$agecat = 'age-range-toys';
							
							$image = get_field('images');
							$thumb = $image[0]['sizes'][ 'post-thumb' ];
						} else {
							$age_assigned_terms = wp_get_post_terms($post_id, 'age-range', array("fields" => "all"));
							$toy_assigned_terms = wp_get_post_terms($post_id, 'skills', array("fields" => "all"));
							
							$skillcat = 'skills';
							$agecat = 'age-range';
							
							$image = get_field('post_image');
							$thumb = $image['sizes'][ 'post-thumb' ];
						}
					?>
					<?php if(get_field('images')):?>
					<?php
						$image = get_field('images');
						$thumb = $image[0]['sizes'][ 'post-thumb' ];
					?>
					<?php else:?>
						<?php
						$image = get_field('post_image');
						$thumb = $image['sizes'][ 'post-thumb' ];
						?>
					<?php endif;?>

						<a href="<?php the_permalink(); ?>">
							<img lsrc="<?php echo $thumb;?>">
						</a>
					
					</div>
					<div class="excerpt width-60 column left">	
						<a class="title" href="<?php the_permalink(); ?>"><?php the_title();?></a>
						<?php $excerpt = wp_trim_words( get_field('content' ), $num_words = 20, $more = '...' ); ?>
						<p><?php echo $excerpt; ?></p>	
						<?php echo do_shortcode("[favorite_button post_id='" . $id . "']");?>
					</div>
					
					
				<div class="age-tags">
					<div class="age">Ages</div>	
					<?php 
					// SHOW YOAST PRIMARY CATEGORY, OR FIRST CATEGORY
					$categories = get_the_terms(get_the_id(), $agecat);
					// If post has a category assigned.
						
						// loop through the term objects
						$icount = 0;
						$len = count($age_assigned_terms);
						foreach($categories as $category) {
						    if ($icount == $len - 1) {
						   		echo '<div class="age"> ' . $category->slug . ' </div>';
						    } else {
						   		echo '<div class="age"> ' . $category->slug . ', </div>';
						    }
						    $icount++;
						}
					?>
				</div>
				<div class="cat-tags
				<?php
					foreach($toy_assigned_terms as $term){
					    echo $term->slug . ' ';
					}
				?>
				">
				
					<?php 
					// SHOW YOAST PRIMARY CATEGORY, OR FIRST CATEGORY
					$categories = get_the_terms(get_the_id(), $skillcat);
					// If post has a category assigned.
					if ($categories){
						if ( class_exists('WPSEO_Primary_Term') )
						{
							// Show the post's 'Primary' category, if this Yoast feature is available, & one is set
							$wpseo_primary_term = new WPSEO_Primary_Term( $skillcat, get_the_id() );
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
			<?php endforeach; 
			wp_reset_postdata();?>
		</div>
	</div>	
</section>	

<section id="bands">
	<?php
	// check if the repeater field has rows of data
	if( have_rows('bands') ):
	
	 	// loop through the rows of data
	    while ( have_rows('bands') ) : the_row();
	?>
	
	
		<?php if(get_sub_field('header')) { ?>
		<div class="band">
	    <div class="container">
			<div class="header"><?php the_sub_field('header'); ?></div>	
		<?php } ?>
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
	        <div class="band-item width-25 column left number-<?php echo $number;?>">
	           	<div class="thumb width-100 column left">	
					<?php 
						$post_id = $post->ID;
						if ( get_post_type( get_the_ID() ) == 'toys' ) {
							// get the assigned taxonomy terms for "property-city"
							$age_assigned_terms = wp_get_post_terms($post_id, 'age-range-toys', array("fields" => "all"));
							$toy_assigned_terms = wp_get_post_terms($post_id, 'skills-toys', array("fields" => "all"));
							
							$skillcat = 'skills-toys';
							$agecat = 'age-range-toys';
							
							$image = get_field('images');
							$thumb = $image[0]['sizes'][ 'post-thumb' ];
						} else {
							$age_assigned_terms = wp_get_post_terms($post_id, 'age-range', array("fields" => "all"));
							$toy_assigned_terms = wp_get_post_terms($post_id, 'skills', array("fields" => "all"));
							
							$skillcat = 'skills';
							$agecat = 'age-range';
							
							$image = get_field('post_image');
							$thumb = $image['sizes'][ 'post-thumb' ];
						}
					?>
					<?php if($image != 0):?>
						<a href="<?php the_permalink(); ?>">
							<img lsrc="<?php echo $thumb;?>">
						</a>
					<?php else:?>
						<img lsrc="http://placehold.it/320x220">
					<?php endif;?>
				</div>
				<div class="excerpt width-100 column left">	
					<a class="title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					<?php
					if (get_field('content' )) {
					?>
					
						<?php $excerpt = wp_trim_words( get_field('content' ), $num_words = 20, $more = '...' ); ?>
						<p><?php echo $excerpt; ?></p>	
						
					<?php } else {?>
						<?php $excerpt = wp_trim_words( get_field('content' ), $num_words = 20, $more = '...' ); ?>
						<p><?php echo $excerpt; ?></p>	
					<?php } ?>
				</div>
				
				<div class="age-tags">
					<div class="age">Ages</div>	
					<?php 
					// SHOW YOAST PRIMARY CATEGORY, OR FIRST CATEGORY
					$categories = get_the_terms(get_the_id(), $agecat);
					// If post has a category assigned.
						
						// loop through the term objects
						$icount = 0;
						$len = count($age_assigned_terms);
						foreach($categories as $category) {
						    if ($icount == $len - 1) {
						   		echo '<div class="age"> ' . $category->slug . ' </div>';
						    } else {
						   		echo '<div class="age"> ' . $category->slug . ', </div>';
						    }
						    $icount++;
						}
					?>
				</div>
				<div class="cat-tags
				<?php
					foreach($toy_assigned_terms as $term){
					    echo $term->slug . ' ';
					}
				?>
				">
				
					<?php 
					// SHOW YOAST PRIMARY CATEGORY, OR FIRST CATEGORY
					$categories = get_the_terms(get_the_id(), $skillcat);
					// If post has a category assigned.
					if ($categories){
						if ( class_exists('WPSEO_Primary_Term') )
						{
							// Show the post's 'Primary' category, if this Yoast feature is available, & one is set
							$wpseo_primary_term = new WPSEO_Primary_Term( $skillcat, get_the_id() );
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

	<?php
	// check if the repeater field has rows of data
	global $post;
	$args = array( 
		'post_type'        => 'post',
		'posts_per_page'   => 8,
		'has_password'	   => false,
		'orderby'		   => 'rand'
	);
			
	$myposts = new WP_Query( $args );
	?>
	<div class="band ">
	    <div class="container">
			<div class="header" class="">Learn + Do</div>
	<?php $count = 1;?>
	    <?php $number = 1;?>
	    <div class="owl-carousel">
		
		<?php while ( $myposts->have_posts() ) { $myposts->the_post(); ?>
			<?php $post_id = $myposts->ID; ?>
	        <?php if(get_post_status($post_id) == 'publish') { ?>
	        
	        <div class="band-item width-25 column left number-<?php echo $number;?>">
	           	<?php get_template_part('band-item'); ?>
	        </div>
	        <?php $number++;?>
	        
			<?php } ?>
	    <?php } ?>
	    	</div>
	    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
	    </div>
	</div>
	
	
		<?php
	// check if the repeater field has rows of data
	global $post;
	$args = array( 
		'post_type'        => 'toys',
		'posts_per_page'   => 8,
		'has_password'	   => false,
		'orderby'		   => 'rand',
		'tax_query' => array(
			array(
				'taxonomy' => 'toys-categories',
				'terms' => array('holiday'),
		        'field' => 'slug',
		        'operator' => 'NOT IN',
			),
		),
	);
			
	$myposts = new WP_Query( $args );
	?>
	<div class="band ">
	    <div class="container">
			<div class="header" >Shop + Play</div>	
	<?php $count = 1;?>
	    <?php $number = 1;?>
	    <div class="owl-carousel">
		
		<?php while ( $myposts->have_posts() ) { $myposts->the_post(); ?>
			<?php $post_id = $myposts->ID; ?>
	        <?php if(get_post_status($post_id) == 'publish') { ?>
	        
	        <div class="band-item width-25 column left number-<?php echo $number;?>">
	           	<?php get_template_part('band-item'); ?>
	        </div>
	        <?php $number++;?>
	        
			<?php } ?>
	    <?php }; ?>
	    	</div>
	    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
	    </div>
	</div>

	    </div>	
	</div>	
</section>	


<script type="text/javascript" charset="utf-8">
	$(window).load(function() {

		$width = $(window).width();
		
		if($width > 990) {
			owl();
		}		
	});
	
	
	function owl() {
		var owl = $('.owl-carousel');
		owl.owlCarousel({
		  items: 4,
		  nav: true,
		  loop: true,
		  lazyLoad:true,
		});
	}
	

</script>
<?php get_footer(); ?>