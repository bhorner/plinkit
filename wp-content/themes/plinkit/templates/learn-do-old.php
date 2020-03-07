<?php
/*
 * Template Name: OLD Learn + Do Page
 * Description: A page template with a default design.
 */
?>

<?php get_header(); ?>

<?php $searches[] = array(); ?>

<div id="page-title">
	<div class="container text-center">
		<h1><span class="icon"><?php include get_template_directory() . '/img/light.svg'; ?></span> <span class="icon"><?php include get_template_directory() . '/img/crayon.svg'; ?></span> Learn + Do<br><?php the_field('page_title');?></h1>
	</div>	
</div>	

<div class="container small-container">
	<div class="intro-text color-coral text-center">
		<p><?php the_field('intro');?></p>	
	</div>	
</div>	


<div id="wrapper">
	<section id="filters">
		<div class="container text-center">
			
<!--
			<div class="intro-text">
				<p><?php the_field('intro');?></p>	
			</div>	
-->
			
			<div class="search-box bg-teal">
				<h2><span class="little"><?php the_field('find_the_perfect_toy');?></span><span><?php the_field('button_text');?></span></h2>	
				<div class="parent float">
					
					<div class="width-33 column left box-1 match-height">	
						<h4>Ages</h4>	
						<form id="ages-form">	
							<?php 
								$args = array(
									'taxonomy' => 'age-range',
									'hide_empty' => true
								); 
							?>
							<?php $terms = get_terms($args); ?>
							<?php foreach($terms as $term) { ?>
								<label class="checkbox"><input class="age-box" type="checkbox" name="age[]" value="<?php echo $term->term_id; ?>" /><?php echo $term->name; ?></label><br>
							<?php } ?>
						</form>
					</div>
					<div class="width-33 column left box-2 match-height match-this">	
						<h4>Skills</h4>	
						<form id="skills-form">	
							<?php 
								$args = array(
									'taxonomy' => 'skills',
									'hide_empty' => true
								); 
							?>
							<?php $terms = get_terms($args); ?>
							<?php foreach($terms as $term) { ?>
								<label class="checkbox"><input class="skill" type="checkbox" name="skills[]" value="<?php echo $term->term_id; ?>" /><?php echo $term->name; ?></label><br>
							<?php } ?>
						</form>
					</div>
					<div class="width-33 column left box-3 match-height">	
						<h4>Keyword</h4>	
						<input class="keyword" type="text" name="keyword" placeholder=" Add a keyword to your search" value="" />
						<form id="keywords-form">	
							
							
							
							<?php if($_GET['search']) { ?>
								<input type="hidden" name="search[]" value="<?php
								foreach ($search as $s) {
								  	echo $s . ' ';
								}
								?>" />		
							<?php } ?>
							
											
						</form>
					</div>
				</div>	
								
			</div>
			
			<div class="clearfix"></div>	
			<div class="ball-bounce">
				<img class="bb" src="<?php bloginfo('template_url'); ?>/img/ball_bounce.gif">
				<img class="bb-bg" src="<?php bloginfo('template_url'); ?>/img/ball_bounce.png">
			</div>	
			<a class="submit btn" href="#">Let's Go!</a>	
			<?php if( get_field('tag_link') ) {?><a class="link" href="<?php the_field('tag_link');?>" target="_blank"><?php the_field('tagline');?></a><?php } ?>
		</div>	
	</section>	
	
<section id="bands">
<?php
	$count = 1;
	
	$args = array( 
		'post_type'        => 'post',
		'posts_per_page'   => 6,
		'post_status'	   => 'publish',
		'orderby'		   => 'rand',
		'has_password'	   => false,
		'tax_query' => array(
			array(
				'taxonomy' => 'skills',
				'field'    => 'slug',
				'terms'    => 'critical-thinking',
			),
		),
	);	
	$myposts = get_posts( $args );
	?>

<div class="band ">
    <div class="container">
		<div class="header bg-coral" id="critical-thinking">Critical Thinking</div>
		
	<div class="owl-carousel">
	<?php foreach ( $myposts as $post ) : setup_postdata( $post );?>

	<div class="band-item width-25 column left">
       	<div class="thumb width-100 column left">	
			<?php 
				$post_id = $post->ID;
				
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
			<a class="title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
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
					$age_assigned_terms = wp_get_post_terms($post_id, 'age-range', array("fields" => "all"));
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
				// get the assigned taxonomy terms for "property-city"
				$assigned_terms = wp_get_post_terms($post_id, 'skills', array("fields" => "all"));
				// loop through the term objects
				foreach($assigned_terms as $term){
				
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
    	</div>

		<?php endforeach; ?>
		</div>
	</div>
</div>

<?php wp_reset_postdata();?>

<?php
	$count = 1;
	
	$args = array( 
		'post_type'        => 'post',
		'posts_per_page'   => 6,
		'post_status'		   => 'publish',
		'orderby'		   => 'rand',
		'has_password'	   => false,
		'tax_query' => array(
			array(
				'taxonomy' => 'skills',
				'field'    => 'slug',
				'terms'    => 'social-emotional',
			),
		),
	);	
	$myposts = get_posts( $args );
	?>

<div class="band ">
    <div class="container">
		<div class="header bg-teal" id="social-emotional">Social + Emotional</div>
	<div class="owl-carousel">
	<?php foreach ( $myposts as $post ) : setup_postdata( $post );?>

	<div class="band-item width-25 column left">
       	<div class="thumb width-100 column left">	
			<?php 
				$post_id = $post->ID;
				
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
			<a class="title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
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
				// get the assigned taxonomy terms for "property-city"
				$assigned_terms = wp_get_post_terms($post_id, 'skills', array("fields" => "all"));
				// loop through the term objects
				foreach($assigned_terms as $term){
				
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
    	</div>

		<?php endforeach; ?>
	</div>
	</div>
</div>

<?php wp_reset_postdata();?>

<?php
	$count = 1;
	
	$args = array( 
		'post_type'        => 'post',
		'posts_per_page'   => 6,
		'post_status'		   => 'publish',
		'orderby'		   => 'rand',
		'has_password'	   => false,
		'tax_query' => array(
			array(
				'taxonomy' => 'skills',
				'field'    => 'slug',
				'terms'    => 'language-literacy',
			),
		),
	);	
	$myposts = get_posts( $args );
	?>

<div class="band ">
    <div class="container">
		<div class="header bg-coral" id="language-literacy">Language + Literacy</div>
<div class="owl-carousel">
	<?php foreach ( $myposts as $post ) : setup_postdata( $post );?>

	<div class="band-item width-25 column left">
       	<div class="thumb width-100 column left">	
			<?php 
				$post_id = $post->ID;
				
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
			<a class="title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
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
				// get the assigned taxonomy terms for "property-city"
				$assigned_terms = wp_get_post_terms($post_id, 'skills', array("fields" => "all"));
				// loop through the term objects
				foreach($assigned_terms as $term){
				
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
    	</div>

		<?php endforeach; ?>
</div>
	</div>
</div>

<?php wp_reset_postdata();?>

<?php
	$count = 1;
	
	$args = array( 
		'post_type'        => 'post',
		'posts_per_page'   => 6,
		'post_status'	   => 'publish',
		'orderby'		   => 'rand',
		'has_password'	   => false,
		'tax_query' => array(
			array(
				'taxonomy' => 'skills',
				'field'    => 'slug',
				'terms'    => 'imagination-creativity',
			),
		),
	);	
	$myposts = get_posts( $args );
	?>

<div class="band ">
    <div class="container">
		<div class="header bg-teal" id="creativity-imagination">Creativity + Imagination</div>
<div class="owl-carousel">
	<?php foreach ( $myposts as $post ) : setup_postdata( $post );?>

	<div class="band-item width-25 column left">
       	<div class="thumb width-100 column left">	
			<?php 
				$post_id = $post->ID;
				
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
			<a class="title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
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
				// get the assigned taxonomy terms for "property-city"
				$assigned_terms = wp_get_post_terms($post_id, 'skills', array("fields" => "all"));
				// loop through the term objects
				foreach($assigned_terms as $term){
				
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
    	</div>

		<?php endforeach; ?>
</div>
	</div>
</div>

<?php wp_reset_postdata();?>

<?php
	$count = 1;
	
	$args = array( 
		'post_type'        => 'post',
		'posts_per_page'   => 6,
		'post_status'		   => 'publish',
		'orderby'		   => 'rand',
		'has_password'	   => false,
		'tax_query' => array(
			array(
				'taxonomy' => 'skills',
				'field'    => 'slug',
				'terms'    => 'fine-motor-gross-motor',
			),
		),
	);	
	$myposts = get_posts( $args );
	?>

<div class="band ">
    <div class="container">
		<div class="header bg-coral" id="fine-motor-gross-motor">Fine Motor + Gross Motor</div>
<div class="owl-carousel">
	<?php foreach ( $myposts as $post ) : setup_postdata( $post );?>

	<div class="band-item width-25 column left">
       	<div class="thumb width-100 column left">	
			<?php 
				$post_id = $post->ID;
				
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
			<a class="title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
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
				// get the assigned taxonomy terms for "property-city"
				$assigned_terms = wp_get_post_terms($post_id, 'skills', array("fields" => "all"));
				// loop through the term objects
				foreach($assigned_terms as $term){
				
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
    	</div>

		<?php endforeach; ?>
</div>
	</div>
</div>

<?php wp_reset_postdata();?>

<?php wp_reset_postdata();?>


</section>	

</div>	


<script type="text/javascript" charset="utf-8">
	$(window).load(function() {
		$width = $(window).width();
		
		if($width > 990) {
			owl();
		}	
		
		
		if (typeof allKeywords === 'undefined') {
			var allKeywords = new Array();
		}
		
		$(function(){
		    $('input.keyword').keyup(function(event) {
		        if (event.which == 13) {
			        event.preventDefault();
		            $('a.submit.btn').trigger('click');
		        }
		    });
		})
		
		
		<?php if(isset($_GET['skills']) && is_array($_GET['skills'])) { $skills = $_GET['skills'];?>
			$skills = <?php echo json_encode($skills);?>;
			$.each($skills, function( index, value ) {
			  $("input[value='" + value + "']").trigger('click').closest('.icheckbox').addClass('checked');
			  console.log(value);

			});
		<?php }?>
		
		<?php if(isset($_GET['age']) && is_array($_GET['age'])) { $age = $_GET['age'];?>
			$age = <?php echo json_encode($age);?>;
			$.each($age, function( index, value ) {
				console.log(value);
			  $("input[value='" + value + "']").trigger('click').closest('.icheckbox').addClass('checked');
			});
		<?php }?>
		
		var data = $('#filters #ages-form, #filters #skills-form').serializeArray();

		<?php if(isset($_GET['search'])) { ?>
			<?php $search = $_GET['search'];?>
	
			$search = <?php echo json_encode($search);?>;
			allKeywords.push($search);
	
			data.push({
			    name: "search",
			    value: allKeywords
			});
			
			console.log(allKeywords);
		<?php } ?>
			
 		var result = $.param(data);

/*
    	$.ajax({
			type: "GET",
			data: data,
			url: theme + "/inc/search_posts.php",
			beforeSend: function() {
	           $('#bands').html('<div class="loading" />');
	        },
			success: function(data) {
				$('#bands').html(data);
 				window.history.pushState("object or string", "Title", "?" + result);
 	        },
	        complete: function() {
		        searchClick();
		        $("input.keyword").val("");
	        },
			async: false
		});
*/
		
		searchPosts();
		
	    function searchClick() {
		    $(".search-term").click(function(e) {
				e.preventDefault();
				var removeKeyword = $(this).data('search');
							
		    	var data = $('#filters #ages-form, #filters #skills-form').serializeArray();		
	
				allKeywords = jQuery.grep(allKeywords, function(value) {
					return value != removeKeyword;
				});
	
 				var result = $.param(data);
				
		    	$.ajax({
					type: "GET",
					data: data,
					url: theme + "/inc/search_posts.php",
					beforeSend: function() {
			           $('#bands').html('<div class="loading" />');
			        },
					success: function(data) {
						$('#bands').html(data);
 						window.history.pushState("object or string", "Title", "?" + result);
		 	        },
			        complete: function() {
			        	searchClick();
			        	$("input.keyword").val("");
			        },
					async: false
				});
		    });
	
			$(".term-click").click(function(e) {
				e.preventDefault();
				var removeKeyword = $(this).data('search');
				
				$('input[value="' + removeKeyword + '"]').closest('label').trigger('click');
							
		    	var data = $('#filters #ages-form, #filters #skills-form').serializeArray();		
				
				var arr = Object.keys(data).map(function (key) { return data[key]; });
				
				data.push({
				    name: "search",
				    value: allKeywords
				});
				
				console.log(data);
					
// 				var result = $.param(data);
	
							
		    	$.ajax({
					type: "GET",
					data: data,
					url: theme + "/inc/search_posts.php",
					beforeSend: function() {
			           $('#bands').html('<div class="loading" />');
			        },
					success: function(data) {
						$('#bands').html(data);
// 					window.history.pushState("object or string", "Title", "?" + result);
		 	        },
			        complete: function() {
			        	searchClick();
			        	$("input.keyword").val("");
			        },
					async: false
				});
		    });
	
	
		}

		
		height();	
		
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


