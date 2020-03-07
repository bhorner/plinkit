<?php
/*
 * Template Name: Search Page
 * Description: A page template with a default design.
 */
?>

<?php get_header(); ?>
	<div id="wrapper">
		<div id="content">
		<div id="page-title">
			<div class="container">
				<h1>		<?php printf( __( 'Search Results for: %s', 'shape' ), '<span>' . get_search_query() . '</span>' ); ?>
</h1>	
			
			</div>	
		</div>	
		
<section id="bands" class="search-bands">
	<div class="band">
	<div class="container">	
	<?php
        if ( have_posts() ) { 
	        $count = 1;
			$toycount = 1;
		    $number = 1;
	        while ( have_posts() ) { the_post(); ?>

			
	    	

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
								$skillcat = 'skills-toys';
								$agecat = 'age-range-toys';
							} else {
								$age_assigned_terms = wp_get_post_terms($post_id, 'age-range', array("fields" => "all"));
								$toy_assigned_terms = wp_get_post_terms($post_id, 'skills', array("fields" => "all"));
								$image = get_field('post_image');
								$thumb = $image['sizes'][ 'post-thumb' ];
								$skillcat = 'skills';
								$agecat = 'age-range';
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
						<a class="title" href="<?php the_permalink(); ?>"><?php the_title(); ?> <?php // echo "Score: $post->relevance_score"; ?></a>
						
							<?php $excerpt = wp_trim_words( get_field('content' ), $num_words = 20, $more = '...' ); ?>
							<p><?php echo $excerpt; ?></p>	
					</div>
					
					<div class="age-tags">
					<div class="age">Ages</div>	
					<?php 
					// SHOW YOAST PRIMARY CATEGORY, OR FIRST CATEGORY
					$categories = get_the_terms(get_the_id(), $agecat);
					// If post has a category assigned.
						$age_assigned_terms = wp_get_post_terms($post_id, $agecat, array("fields" => "all"));
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
		        
		        <?php
				if ($count%4 == 0)
			    {  
			    ?>
				    </div>
				</div>
			    <div class="band">
				    <div class="container">
			    <?php
			    }
			    ?>
		        
		        <?php $count++;?>
		        <?php $number++;?>
		<?php
			} // End of the loop.
		?>
			 </div>
			</div>
	    	</div>
	    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
	<?php  }?>
		
	    </div>	
	</div>	
</section>	

<script>
	$(document).ready(function() {
        $("input#s").val('');
	})
</script>	

<?php get_footer(); ?>


