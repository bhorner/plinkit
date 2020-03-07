<?php
/*
 * Template Name:  Author
 * Description: A page template with a default design.
 */
?>

<?php get_header(); ?>

<div id="fave-title">
	<h2 class="color-teal">
		<div class="jar">
			<div class="jar-balls">
				<div class="ball ball-1"></div>	
				<div class="ball ball-2"></div>	
				<div class="ball ball-3"></div>	
				<div class="ball ball-4"></div>	
			</div>	
			<?php include get_template_directory() . '/img/jar.svg'; ?>
		</div>Posts by <?php echo get_the_author_meta( 'first_name' ); ?></h2>
</div>	

<div id="wrapper">
	
<section id="bands" class="fave-bands learn-do-bands">
						
<?php

$author = get_queried_object();
$author_id = $author->ID;

$count = 1;
	
if (have_posts()) :
   while (have_posts()) : the_post();
?>
	
	<?php
	if ($count%4 == 1)
    {  
    ?>
    <div class="band">
	    <div class="container">
    <?php
    }
    ?>
    
		<div class="band-item width-25 column left number-<?php echo $number;?>">
           	<div class="thumb width-100 column left">	
				<?php 
					$image = get_field('post_image');
					$thumb = $image['sizes'][ 'post-thumb' ];
				?>
				<?php if(get_field('post_image')):?>
					<a href="<?php the_permalink(); ?>">
						<img src="<?php echo $thumb;?>">
					</a>
				<?php else:?>
					<img src="http://placehold.it/320x220">
				<?php endif;?>
				</div>
				<div class="excerpt width-100 column left">	
					<a class="title" href="<?php the_permalink($favorite->ID); ?>"><?php the_title($favorite->ID); ?></a>
					<?php
					if (get_field('content' )) {
					?>
						<?php $excerpt = wp_trim_words( get_field('content' ), $num_words = 20, $more = '...' ); ?>
						<p><?php echo $excerpt; ?></p>	
					<?php } elseif(get_field('learn')) {?>
						<?php $excerpt = wp_trim_words( get_field('learn' ), $num_words = 20, $more = '...' ); ?>
						<p><?php echo $excerpt; ?></p>	
					<?php } else { ?>
						<?php $excerpt = wp_trim_words( get_field('do' ), $num_words = 20, $more = '...' ); ?>
						<p><?php echo $excerpt; ?></p>	
					<?php } ?>
					
					<div class="age-tags">
						<div class="age">Ages</div>	
							<?php
							$post_id = $post->ID;
					
							// get the assigned taxonomy terms for "property-city"
							$age_assigned_terms = wp_get_post_terms($post_id, 'age-range', array("fields" => "all"));
			
								// loop through the term objects
								$icount = 0;
								$len = count($age_assigned_terms);
								foreach($age_assigned_terms as $term){
								    if ($icount == $len - 1) {
								   		echo '<div class="age"> ' . $term->name . ' </div>';
								    } else {
								   		echo '<div class="age"> ' . $term->name . ', </div>';
								    }
								    $icount++;
								}
								
							?>
						</div>	

					<div class="cat-tags
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
							
							foreach($category_display as $key => $value) {
								echo $value[1] . ' ';
							}
							$category_display = array();					
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
        
	<?php 
	    if($i > 1){
	        $count = 1;
	    } else {
	        $count++;
	    }
	?>
	
	<?php
	endwhile;
	endif;
	wp_reset_postdata();
	?>	
	</div>
	</div>	
</section>





<script type="text/javascript" charset="utf-8">
	$(window).load(function() {
		height();
		
		$("input.fave-link").click(function () {
		   $(this).select();
		});
		
		$("#copy-link").click(function (e) {
			e.preventDefault();
		   $('input.fave-link').select();
		});
		
		document.getElementById("copy-link").addEventListener("click", function() {
	    copyToClipboard(document.getElementById("fave-input"));
	});
		
		function copyToClipboard(elem) {
			  // create hidden text element, if it doesn't already exist
		    var targetId = "_hiddenCopyText_";
		    var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
		    var origSelectionStart, origSelectionEnd;
		    if (isInput) {
		        // can just use the original source element for the selection and copy
		        target = elem;
		        origSelectionStart = elem.selectionStart;
		        origSelectionEnd = elem.selectionEnd;
		    } else {
		        // must use a temporary form element for the selection and copy
		        target = document.getElementById(targetId);
		        if (!target) {
		            var target = document.createElement("textarea");
		            target.style.position = "absolute";
		            target.style.left = "-9999px";
		            target.style.top = "0";
		            target.id = targetId;
		            document.body.appendChild(target);
		        }
		        target.textContent = elem.textContent;
		    }
		    // select the content
		    var currentFocus = document.activeElement;
		    target.focus();
		    target.setSelectionRange(0, target.value.length);
		    
		    // copy the selection
		    var succeed;
		    try {
		    	  succeed = document.execCommand("copy");
		    } catch(e) {
		        succeed = false;
		    }
		    // restore original focus
		    if (currentFocus && typeof currentFocus.focus === "function") {
		        currentFocus.focus();
		    }
		    
		    if (isInput) {
		        // restore prior selection
		        elem.setSelectionRange(origSelectionStart, origSelectionEnd);
		    } else {
		        // clear temporary content
		        target.textContent = "";
		    }
		    return succeed;
		}

		
		$('.flexslider').flexslider({
			animation: "fade"
		});

		$width = $(window).width();
		
		if($width > 990) {
			owl();
		}		
		
		$sheight = $('.sidebar-inner').height();
		$('.sheight').height($sheight);

	});
	
	
	function owl() {
		$(".owl-carousel").owlCarousel({
		  items: 4,
		  nav: true,
		  loop: true
		});
	}
</script>
<?php get_footer(); ?>


