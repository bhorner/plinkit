<div class="thumb width-100 column left">	
	<?php 
		$post_id = $post->ID;
		if ( get_post_type( get_the_ID() ) == 'toys' ) {
			// get the assigned taxonomy terms for "property-city"
			$agecat = 'age-range-toys';
			$skillcat = 'skills-toys';
			$age_assigned_terms = wp_get_post_terms($post_id, 'age-range-toys', array("fields" => "all"));
			$toy_assigned_terms = wp_get_post_terms($post_id, 'skills-toys', array("fields" => "all"));
			$image = get_field('images');
			$thumb = $image[0]['sizes'][ 'post-thumb' ];
		} else {
			$agecat = 'age-range';
			$skillcat = 'skills';
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
	$toy_assigned_terms = wp_get_post_terms($id, $skillcat, array("fields" => "all"));
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
	
		       