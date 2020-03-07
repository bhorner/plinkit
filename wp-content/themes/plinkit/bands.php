<section id="bands">
	<?php
		
	if ( get_post_type( get_the_ID() ) == 'toys' ) {
		$bandType = 'posts';
	} 
	if ( get_post_type( get_the_ID() ) == 'post' ) {
		$bandType = 'post';
	}
	if ( get_post_type( get_the_ID() ) == 'page' ) {
		$bandType = 'items';
	}
	
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
		$post_objects = get_sub_field($bandType);
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
		        <?php $post_id = $post->ID; ?>
		        <?php if(get_post_status($post_id) == 'publish') { ?>
		        <div class="band-item width-25 column left number-<?php echo $number;?>">
		           	<div class="thumb width-100 column left">	
						<?php 
							
							if ( get_post_type( get_the_ID() ) == 'toys' ) {
								// get the assigned taxonomy terms for "property-city"
								$agecat = 'age-range-toys';
								$age_assigned_terms = wp_get_post_terms($post_id, 'age-range-toys', array("fields" => "all"));
								$toy_assigned_terms = wp_get_post_terms($post_id, 'skills-toys', array("fields" => "all"));
								$image = get_field('images');
								$thumb = $image[0]['sizes'][ 'post-thumb' ];
							} else {
								$agecat = 'age-range';
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
		        
		        <?php } ?>
		        
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