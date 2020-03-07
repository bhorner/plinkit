<?php
/*
 * Template Name: My Favorites
 * Description: A page template with a default design.
 */
?>

<?php get_header(); ?>
<?php
if (have_posts()) :
   while (have_posts()) : the_post();
?>

<div class="remodal text-center" data-remodal-id="share-faves">
  <button data-remodal-action="close" class="remodal-close"></button>
  <h2 class="color-teal">Spread the Love!</h1>
  <p>
    Share your favorites with family and friends.
  </p>
  <p>Copy this sharable link: <input class="fave-link" id="fave-input" type="text" value="<?php echo site_url();?>/user-favorites?user=<?php echo get_current_user_id(); ?>" readonly="readonly"/> <a href="#" id="copy-link" class="fa fa-files-o"></a></p>	
  <br>
</div>

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
		</div> My Favorites</h2>
	<?php the_content();?>
	<a class="btn btn-inline" href="#share-faves"><span class="fa fa-share-square-o"></span> Share Favorites</a>
	<a class="btn btn-inline btn-teal" href="#profile"><span class="fa fa-user-circle"></span> My Profile</a>
		
</div>	

<div id="wrapper">
	
<section id="bands" class="fave-bands learn-do-bands" style="margin-top: 0;">
					
	<?php $favorites = get_user_favorites(); ?>
	
	<?php
	$count = 1;
		
	if ( $favorites ) : // This is important: if an empty array is passed into the WP_Query parameters, all posts will be returned
	$favorites_query = new WP_Query(array(
		'posts_per_page' => -1,
		'ignore_sticky_posts' => true,
		'post__in' => $favorites,
		'paged' => $paged // If you want to include pagination, and have a specific posts_per_page set
	));
	if ( $favorites_query->have_posts() ) : while ( $favorites_query->have_posts() ) : $favorites_query->the_post();
	?>
	
	<?php
	if ($count%4 == 1)
    {  
    ?>
    <div class="band even">
	    <div class="container">
    <?php
    }
    ?>
    <?php
	if ($count == 1)
    {  
    ?>
			<div class="header bg-teal"><span class="icon"><?php include get_template_directory() . '/img/light.svg'; ?></span><span class="icon"><?php include get_template_directory() . '/img/crayon.svg'; ?></span> 	Learn + Do</div>
    <?php
    }
    ?>
    
		<div class="band-item width-25 column left number-<?php echo $number;?>">
           	<div class="thumb width-100 column left">	
				<?php 
					$image = get_field('post_image');
					$thumb = $image['sizes'][ 'post-thumb' ];
					$post_id = $post->ID;
				?>
				<?php if(get_field('post_image', $favorite->ID)):?>
					<a href="<?php the_permalink($favorite->ID); ?>">
						<img src="<?php echo $thumb;?>">
					</a>
				<?php else:?>
					<img src="http://placehold.it/320x220">
				<?php endif;?>
				</div>
				<div class="excerpt width-100 column left">	
					<a class="title" href="<?php the_permalink($favorite->ID); ?>"><?php the_title($favorite->ID); ?></a>
					<?php
					if ($post->post_content == '') {
					?>
					
					<?php $excerpt = wp_trim_words( get_field('content' ), $num_words = 20, $more = '...' ); ?>
					<p><?php echo $excerpt; ?></p>	
					
					<?php } else {?>
					<p><?php echo excerpt('20', $favorite->ID);?></p>
					<?php } ?>
				</div>
			<?php
			$age_assigned_terms = wp_get_post_terms($post_id, 'age-range', array("fields" => "all"));
			$toy_assigned_terms = wp_get_post_terms($post_id, 'skills', array("fields" => "all"));
			?>
			<div class="age-tags">
				<div class="age">Ages</div>	
				<?php

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
				foreach($toy_assigned_terms as $term){
				    echo $term->slug . ' ';
				}
			?>
			">
			
							<div class="icon-tag creativity"><span class="tooltip">Creativity + Imagination<span></span></span></div>	
							<div class="icon-tag critical-thinking"><span class="tooltip">Critical Thinking<span></span></span></div>	
							<div class="icon-tag language"><span class="tooltip">Language + Literacy<span></span></span></div>	
							<div class="icon-tag motor-skills"><span class="tooltip">Fine + Gross Motor Skills<span></span></span></div>	
							<div class="icon-tag play"><span class="tooltip">Play<span></span></span></div>	
							<div class="icon-tag social"><span class="tooltip">Social + Emotional<span></span></span></div>	
			
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
	endif; wp_reset_postdata();
	else :
	endif;
	?>

</section>


<section id="bands" class="fave-bands" style="margin-top: 0;">				
	
	<?php
	$count = 1;
		
	if ( $favorites ) : // This is important: if an empty array is passed into the WP_Query parameters, all posts will be returned
	$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1; // If you want to include pagination
	$favorites_query = new WP_Query(array(
		'post_type' => 'toys', // If you have multiple post types, pass an array
		'posts_per_page' => -1,
		'ignore_sticky_posts' => true,
		'post__in' => $favorites,
		'paged' => $paged // If you want to include pagination, and have a specific posts_per_page set
	));
	if ( $favorites_query->have_posts() ) : while ( $favorites_query->have_posts() ) : $favorites_query->the_post();
	?>
	
	<?php
	if ($count%4 == 1)
    {  
    ?>
    <div class="band even">
	    <div class="container">
    <?php
    }
    ?>
    <?php
	if ($count == 1)
    {  
    ?>
			<div class="header bg-coral"><span class="icon"><?php include get_template_directory() . '/img/icons/shopping.svg'; ?></span><span class="icon"><?php include get_template_directory() . '/img/icons/play.svg'; ?></span> 	Shop + Play</div>
    <?php
    }
    ?>
    
		<div class="band-item width-25 column left number-<?php echo $number;?>">
           	<div class="thumb width-100 column left">	
				<?php 
						$image = get_field('images', $favorite->ID);
						$thumb = $image[0]['sizes'][ 'post-thumb' ];
						$post_id = $post->ID;
				?>
				<?php if(get_field('images', $favorite->ID)):?>
					<a href="<?php the_permalink($favorite->ID); ?>">
						<img src="<?php echo $thumb;?>">
					</a>
				<?php else:?>
					<img src="http://placehold.it/320x220">
				<?php endif;?>
				</div>
				<div class="excerpt width-100 column left">	
					<a class="title" href="<?php the_permalink($favorite->ID); ?>"><?php the_title($favorite->ID); ?></a>
					<?php
					if ($post->post_content == '') {
					?>
					
					<?php $excerpt = wp_trim_words( get_field('content' ), $num_words = 20, $more = '...' ); ?>
					<p><?php echo $excerpt; ?></p>	
					
					<?php } else {?>
					<p><?php echo excerpt('20', $favorite->ID);?></p>
					<?php } ?>
				</div>
			<?php
			$age_assigned_terms = wp_get_post_terms($post_id, 'age-range-toys', array("fields" => "all"));
			$toy_assigned_terms = wp_get_post_terms($post_id, 'skills-toys', array("fields" => "all"));
			?>
			<div class="age-tags">
				<div class="age">Ages</div>	
				<?php

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
				foreach($toy_assigned_terms as $term){
				    echo $term->slug . ' ';
				}
			?>
			">
			
							<div class="icon-tag creativity"><span class="tooltip">Creativity + Imagination<span></span></span></div>	
							<div class="icon-tag critical-thinking"><span class="tooltip">Critical Thinking<span></span></span></div>	
							<div class="icon-tag language"><span class="tooltip">Language + Literacy<span></span></span></div>	
							<div class="icon-tag motor-skills"><span class="tooltip">Fine + Gross Motor Skills<span></span></span></div>	
							<div class="icon-tag play"><span class="tooltip">Play<span></span></span></div>	
							<div class="icon-tag social"><span class="tooltip">Social + Emotional<span></span></span></div>		
			
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
	endif; wp_reset_postdata();
	else :
	endif;
	?>

</section>


<?php
endwhile;
endif;
wp_reset_postdata();
?>	

	<div class="remodal" id="personal-info" data-remodal-id="profile">
	  <button data-remodal-action="close" class="remodal-close"></button>
	  <h3 class="color-teal"><?php the_field('edit_profile_title', 'option');?></h3>
	  <?php echo do_shortcode('[wppb-edit-profile form_name="profile-form"]');?>
	  	<p> 
			<label class="showpass2">
				<input id="show_password" name="showpass" type="checkbox"> Show
			</label>
		</p>
	</div>
	
	<div class="remodal" data-remodal-id="info">
	  <button data-remodal-action="close" class="remodal-close"></button>
	  	  <h3 class="color-teal">Optional Info</h3>
		  <p>This information is optional, but we’d love to get to know you so we keep developing the right content for you!</p>	
		  <hr>
		  <?php echo do_shortcode('[wppb-edit-profile form_name="optional"]');?>	
		  <p>Thanks! And don't be shy to tell us what you want more of. Email us at <a href="mailto:hello@myplinkit.com">hello@myplinkit.com</a> any time.</p>	
	  <br>
	  <hr>
	</div>


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

		$width = $(window).width();
		

	});

</script>
<?php get_footer(); ?>


