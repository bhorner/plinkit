<?php
/*
 * Template Name: Search Page Template
 * Description: A page template with a default design.
 */
?>

<?php get_header(); ?>

<?php
	
	$nope = 0;
	$dope = 0;
	
	if(isset($_GET['search'])) {
	   $search = $_GET['search'];
	}
	
	$args = array( 
		'post_type'        => 'post',
		'posts_per_page'   => -1,
		's'				   => $search,
		'meta_query' => array(
		       array(
		           'key' => 'tags',
		           'value' => $search,
		           'compare' => 'LIKE',
		       )
		   )
	);
	
	
	
?>

	<div id="wrapper">
		<div id="content">
		<div id="page-title">
			<div class="container">
				<h1><?php printf( __( 'Search Results for: %s', 'shape' ), '<span>' . $search . '</span>' ); ?></h1>	
			</div>	
		</div>	
		
		<section id="bands" class="search-bands">
	
	<?php
	$count = 1;
	$fullcount = 0;
	$toycount = 1;
    $number = 1;

	// The Query
	$the_query = new WP_Query( $args );
	
	// The Loop
	if ( $the_query->have_posts() ) {


		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$post_id = $post->ID;
			$exclude[] = $post_id;
	
	/*
	*  Loop through post objects (assuming this is a multi-select field) ( setup postdata )
	*  Using this method, you can use all the normal WP functions as the $post object is temporarily initialized within the loop
	*  Read more: http://codex.wordpress.org/Template_Tags/get_posts#Reset_after_Postlists_with_offset
	*/	
	
	    	
				if ($count%4 == 1)
			    {  
			    ?>
			    <div class="band">
				    <div class="container">
			    <?php
			    }
			    ?>
			    <?php
				if ($count == 1)
			    {  
			    ?>
						<div class="header bg-coral">Learn + Do</div>
			    <?php
			    }
			    ?>

		        <?php setup_postdata($post); ?>
		        <div class="band-item width-25 column left number-<?php echo $number;?> number-<?php echo $count;?>">
		           	<div class="thumb width-100 column left">	
						<?php 
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
							
		
							// loop through the term objects
							$i = 0;
							$len = count($age_assigned_terms);
							foreach($age_assigned_terms as $term){
							    if ($i == $len - 1) {
							   		echo '<div class="age"> ' . $term->name . ' </div>';
							    } else {
							   		echo '<div class="age"> ' . $term->name . ', </div>';
							    }
							    $i++;
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
					
						<div class="icon-tag creativity"><span class="tooltip">Creativity & Imagination<span></span></span></div>	
						<div class="icon-tag critical-thinking"><span class="tooltip">Critical Thinking<span></span></span></div>	
						<div class="icon-tag language"><span class="tooltip">Language & Literacy<span></span></span></div>	
						<div class="icon-tag motor-skills"><span class="tooltip">Fine & Gross Motor Skills<span></span></span></div>	
						<div class="icon-tag play"><span class="tooltip">Play<span></span></span></div>	
						<div class="icon-tag social"><span class="tooltip">Social & Emotional<span></span></span></div>	
					
					</div>
	
		        </div>
		        
		        <?php
				if ($count%4 == 0)
			    {  
			    ?>
				    </div>
				</div>
			    <?php
			    }
			    ?>
		        <?php $count++;?>
		        <?php $fullcount++;?>
		        <?php $number++;?>
		        
<?php			
	
		} // End of the loop.
		
		wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly

		} else {
			$nope = 1; 
		} 

		if ($fullcount%4 == 1)
	    {  
	?>
	    </div>	
	</div>
	<?php } ?>	
	
<!-- Secondary LOOP -->
		
	<?php

	$newargs = array( 
		'post_type'        => 'post',
		'posts_per_page'   => -1,
		's'				   => $search,
		'post__not_in' 	   => $exclude
	);

	// The Query
	$the_query = new WP_Query( $newargs );
	
	// The Loop
	if ( $the_query->have_posts() ) {

	    $number = 1;

		while ( $the_query->have_posts() ) {
			$the_query->the_post();

	
	/*
	*  Loop through post objects (assuming this is a multi-select field) ( setup postdata )
	*  Using this method, you can use all the normal WP functions as the $post object is temporarily initialized within the loop
	*  Read more: http://codex.wordpress.org/Template_Tags/get_posts#Reset_after_Postlists_with_offset
	*/	
	
	    	
					if ($count%4 == 1)
				    {  
				    ?>
				    <div class="band">
					    <div class="container">
				    <?php
				    }
				    ?>
				    <?php
					if ($count == 1)
				    {  
				    ?>
						<div class="header bg-coral">Learn + Do bottom</div>
				    <?php
				    }
				    ?>

		        <?php setup_postdata($post); ?>
		        <div class="band-item width-25 column left number-<?php echo $number;?> count-<?php echo $count;?>">
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
							
		
							// loop through the term objects
							$i = 0;
							$len = count($age_assigned_terms);
							foreach($age_assigned_terms as $term){
							    if ($i == $len - 1) {
							   		echo '<div class="age"> ' . $term->name . ' </div>';
							    } else {
							   		echo '<div class="age"> ' . $term->name . ', </div>';
							    }
							    $i++;
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
					
						<div class="icon-tag creativity"><span class="tooltip">Creativity & Imagination<span></span></span></div>	
						<div class="icon-tag critical-thinking"><span class="tooltip">Critical Thinking<span></span></span></div>	
						<div class="icon-tag language"><span class="tooltip">Language & Literacy<span></span></span></div>	
						<div class="icon-tag motor-skills"><span class="tooltip">Fine & Gross Motor Skills<span></span></span></div>	
						<div class="icon-tag play"><span class="tooltip">Play<span></span></span></div>	
						<div class="icon-tag social"><span class="tooltip">Social & Emotional<span></span></span></div>	
					
					</div>
	
		        </div>
		        
		        <?php
				if ($count%4 == 0)
			    {  
			    ?>
				    </div>
				</div>
			    <?php
			    }
			    ?>
		        <?php $count++;?>
		        <?php $number++;?>

	        <?php $number++;
		        
		    
			} // End of the loop.
		?>
			 </div>
			</div>
	    	</div>
	    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
	<?php  
		
	} else {
		$dope = 1; 
	} 		
	?>
	<?php if($nope == 1 && $dope == 1) {
	?>
		<div class="container">
			<div class="no-results" style="margin: 30px 0 60px 0; text-align: center; float: left; width:100%;"> 
				<p>Sorry your search returned no results</p>	
			</div>	
		</div>	
	<?php
	} ?>
	    </div>	
	</div>	

	
	
</section>	

<?php get_footer(); ?>


