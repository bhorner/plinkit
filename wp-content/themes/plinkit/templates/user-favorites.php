<?php
/*
 * Template Name: User Favorites
 * Description: A page template with a default design.
 */
?>

<?php get_header(); ?>
<?php
if (have_posts()) :
   while (have_posts()) : the_post();
   
   if(isset($_GET['user'])) {
   		$user = $_GET['user'];
   }
?>

<?php 
	$user_info = get_userdata($user);
	$firstname = $user_info->first_name;
?>

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
		</div> <?php if($firstname != '') { echo $firstname; } else { echo 'User';}?>'s Favorites</h2>
	<?php the_content();?>
</div>	

<div id="wrapper">
	
<section id="bands" class="fave-bands learn-do-bands" style="margin-top: 0;">
					
	<?php			
	if(isset($_GET['user'])) {
			
		$favorites = get_user_favorites($user_id = $user, $site_id = null, $filters = null);
	
	}	else {	
		
		$favorites = get_user_favorites();
	}
	?>	
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


