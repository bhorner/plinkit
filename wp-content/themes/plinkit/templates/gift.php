<?php
/*
 * Template Name: Gift Guide Page
 * Description: A page template with a default design.
 */
?>

<?php get_header(); ?>

<div class="back-top text-right">
	<a class="linkscroll" href="#intro-top"> Back to Top</a>	
</div>	

<div id="intro-top" class="big-text text-center">
	<div class="container relative">
		<h2><?php the_field('title');?></h2>	
		<div class="sparkles-left">
			<img src="<?php bloginfo('template_url'); ?>/img/sparkles-left.png">
		</div>	
		<div class="sparkles-right">
			<img src="<?php bloginfo('template_url'); ?>/img/sparkles-right.png">
		</div>	
	</div>	
	<div class="container small-container">
		<div class="intro-text color-coral text-center">
			<?php the_field('intro');?>
			
			<?php
			// check if the repeater field has rows of data
			if( have_rows('bands') ):
			
			 	// loop through the rows of data
			    while ( have_rows('bands') ) : the_row();
			?>
			
				<?php if(get_sub_field('header')) { ?>
					<?php 
						$link = get_sub_field('header'); 
						$link = seoUrl($link);
					?>
					<a class="linkscroll" href="#<?php echo $link;?>"><?php the_sub_field('header'); ?></a>	
				<?php } ?>
			
			<?php
			    endwhile;
			
			else :
			
			    // no rows found
			
			endif;
			
			?>
			
		</div>	
	</div>	
</div>	

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
		<?php 
			$link = get_sub_field('header'); 
			$link = seoUrl($link);
		?>
			<div id="<?php echo $link;?>" class="header"><?php the_sub_field('header'); ?></div>	
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
	    
	    
		<div class="no-owl">
	   
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
						<a href="<?php the_field('link'); ?>" target="_blank">
							<img src="<?php echo $thumb;?>">
						</a>
					<?php else:?>
						<img src="http://placehold.it/320x220">
					<?php endif;?>
				</div>
				<div class="excerpt width-100 column left">	
					<a class="title" href="<?php the_field('link');?>" target="_blank"><?php the_title(); ?></a>
					<?php the_field('content');?>

					<a class="btn btn-teal" href="<?php the_field('link');?>" target="_blank">Buy Now</a>
				</div>
				
				<div class="age-tags">
					<div class="age">Ages</div>	
					
					<?php 
					// SHOW YOAST PRIMARY CATEGORY, OR FIRST CATEGORY
					$categories = get_the_terms(get_the_id(), 'age-range-toys');
					// If post has a category assigned.
					if ($categories){
						if ( class_exists('WPSEO_Primary_Term') )
						{
							// Show the post's 'Primary' category, if this Yoast feature is available, & one is set
							$wpseo_primary_term = new WPSEO_Primary_Term( 'age-range-toys', get_the_id() );
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
						$age_display = array();					}
					?>
					
					<?php
						
	
						// loop through the term objects
/*
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
*/
						
					?>
				</div>	
				<div class="cat-tags
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
							echo $value[1] . ' ';
						}
						$category_display = array();					
					}
					?>
				">
					
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
	});
	
	
	function owl() {
		var owl = $('.owl-carousel');
		owl.owlCarousel({
		  items: 4,
		  nav: true,
		  loop: true
		});
		owl.on('onInitialized.owl.carousel', function(event) {
			$('.band-item').matchHeight();
		})
	}
	$(document).ready(function(){
	    $( "a.linkscroll" ).click(function( event ) {
	        event.preventDefault();
	        $("html, body").animate({ scrollTop: ($($(this).attr("href")).offset().top - 120) }, 500);
	    });
	});
	
var $topofDiv = $("#intro-top").offset().top; //gets offset of header
var $height = $("#intro-top").outerHeight(); //gets height of header

$(window).scroll(function(){
    if($(window).scrollTop() > ($topofDiv + $height)){
       $("body").addClass('show-btn');
    }
    else{
       $("body").removeClass('show-btn');
    }
});
</script>
<?php get_footer(); ?>


