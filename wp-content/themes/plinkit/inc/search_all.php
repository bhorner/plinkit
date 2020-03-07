<?php
	
define('WP_USE_THEMES', false);
require($_SERVER["DOCUMENT_ROOT"] . '/wp-blog-header.php');
header("HTTP/1.1 200 OK");

if(isset($_GET['skills']) && is_array($_GET['skills'])) {
   $skills = $_GET['skills'];
}

if(isset($_GET['age']) && is_array($_GET['age'])) {
   $age = $_GET['age'];
}

if(isset($_GET['search[]']) && is_array($_GET['search[]'])) {
   $search = $_GET['search'];
}

$count = 1;

global $post;

$args = array( 
	'post_type'        => 'post',
	'posts_per_page'   => -1,
	'tax_query'		   => array(
		'relation' => 'AND',
	)
);

$toy_args = array( 
	'post_type'        => 'toys',
	'posts_per_page'   => -1,
	'tax_query'		   => array(
		'relation' => 'AND',
	)
);

if($skills != null) {
	$tax_query[] = array(
	    array(
	        'taxonomy' => 'skills',
	        'field' => 'id',
	        'terms' => $skills,
	        'operator' => 'AND',
	    ),
	);
	$toy_tax_query[] = array(
	    array(
	        'taxonomy' => 'skills-toys',
	        'field' => 'id',
	        'terms' => $skills,
	        'operator' => 'AND',
	    ),
	);
}

if($age != null) {
	$tax_query[] = array(
	    array(
	        'taxonomy' => 'age-range',
	        'field' => 'id',
	        'terms' => $age,
	        'operator' => 'AND',
	    ),
	);
	$toy_tax_query[] = array(
	    array(
	        'taxonomy' => 'age-range-toys',
	        'field' => 'id',
	        'terms' => $age,
	        'operator' => 'AND',
	    ),
	);
}


if($search != null) {
	if(is_array($search)) {
		$args['s'] = implode(',', $search);
		$toy_args['s'] = implode(',', $search);
		$searches = $search;
	} else {
		$args['s'] = $search;
		$toy_args['s'] = $search;
		$searches = explode(',', $search);
	}
	
}

$args['tax_query'] = $tax_query;
$toy_args['tax_query'] = $toy_tax_query;

$ageskills = [];

if($age != '') {
	$ageskills = $age;
}

if($skills != '') {
	$ageskills = array_merge($ageskills, $skills);
}

/*
print_r($tags);

echo '<pre>';
print_r($args);
echo '</pre>';
*/

$myposts = get_posts( $args );
if( empty ( $myposts ) ) {
?>
	<div class="band odd">
		<div class="container">
			<div class="header bg-teal">Your Results:</div>
				<div class="tags">
				<?php
					
					if($ageskills != '') {
						foreach($ageskills as $item){
							$term = get_term($item);
							echo "<a href='#' class='search-term term-click' data-search='" . $item . "'><span class='fa fa-times'></span>" . $term->name . "</a>";
						}
					}
					
					if($searches != '') {
						foreach($searches as $search){
							echo "<a href='#' class='search-term' data-search='" . $search . "'><span class='fa fa-times'></span>" . $search . "</a>";
						}
					}
				?>
	    		</div>
		</div>	
	</div>	
<?php
} else {
foreach ( $myposts as $post ) : setup_postdata( $post ); ?>

<?php
if ($count%4 == 1)
{  
?>
<div class="band <?php if($count == 1){ echo "odd"; }?>">
    <div class="container">
		<?php if($count == 1){ ?>
			<div class="header bg-teal">Your Results:</div>
			<div class="tags">
			<?php
				
				if($ageskills != '') {
					foreach($ageskills as $item){
						echo "<a href='#' class='search-term term-click' data-search='" . $item . "'><span class='fa fa-times'></span>" . get_cat_name($item) . "</a>";
					}
				}
				
				if($searches != '') {
					foreach($searches as $search){
						echo "<a href='#' class='search-term' data-search='" . $search . "'><span class='fa fa-times'></span>" . $search . "</a>";
					}
				}
			?>
    		</div>
		<?php }?>
<?php
}
?>

			<div class="band-item width-25 column left">
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
					
					<?php
						$post_id = $post->ID;
						$assigned_terms = wp_get_post_terms($post_id, 'age-range', array("fields" => "all"));
					?>

					<div class="age-tags">
						<div class="age">Ages</div>	
						<?php
							$post_id = $post->ID;
		
							// loop through the term objects
							$icount = 0;
							$len = count($assigned_terms);
							foreach($assigned_terms as $term){
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
						// get the assigned taxonomy terms for "property-city"
						$assigned_terms = wp_get_post_terms($post_id, 'skills', array("fields" => "all"));
						// loop through the term objects
						foreach($assigned_terms as $term){
						
						    echo $term->slug . ' ';

						}
					?>
					">
					
					<div class="icon-tag imagination-creativity"><span class="tooltip">Creativity + Imagination<span></span></span></div>	
					<div class="icon-tag critical-thinking"><span class="tooltip">Critical Thinking<span></span></span></div>	
					<div class="icon-tag language-literacy"><span class="tooltip">Language + Literacy<span></span></span></div>	
					<div class="icon-tag fine-motor-gross-motor"><span class="tooltip">Fine + Gross Motor Skills<span></span></span></div>	
					<div class="icon-tag play"><span class="tooltip">Play<span></span></span></div>	
					<div class="icon-tag social-emotional"><span class="tooltip">Social + Emotional<span></span></span></div>	
					
					</div>
				</div>
	        </div>
	        
<?php
if ($count%4 == 0)
{  
?>
    	</div>
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
<?php endforeach;
} 
wp_reset_postdata();

$myposts = get_posts( $toy_args );
if( empty ( $myposts ) ) {
?>
<?php
} else {
foreach ( $myposts as $post ) : setup_postdata( $post ); ?>

<?php
if ($count%4 == 1)
{  
?>
<div class="band <?php if($count == 1){ echo "odd"; }?>">
    <div class="container">
		<?php if($count == 1){ ?>
			<div class="header bg-teal">Your Results:</div>
			<div class="tags">
			<?php
				
				if($ageskills != '') {
					foreach($ageskills as $item){
						echo "<a href='#' class='search-term term-click' data-search='" . $item . "'><span class='fa fa-times'></span>" . get_cat_name($item) . "</a>";
					}
				}
				
				if($searches != '') {
					foreach($searches as $search){
						echo "<a href='#' class='search-term' data-search='" . $search . "'><span class='fa fa-times'></span>" . $search . "</a>";
					}
				}
			?>
    		</div>
		<?php }?>
<?php
}
?>

			<div class="band-item width-25 column left">
	           	<div class="thumb width-100 column left">	
				<?php 
						$gallery = get_field('images');
						$thumb = $gallery['sizes'][ 'post-thumb' ];
						
					?>
					
					<?php if(get_field('images')):?>
						<a href="<?php the_permalink(); ?>">
							<img src="<?php echo $gallery[0]['sizes'][ 'post-thumb' ] ?>">
						</a>
					<?php else:?>
						<img src="http://placehold.it/320x220">
					<?php endif;?>
				</div>
				<div class="excerpt width-100 column left">	
					<a class="title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						<?php
						if ($post->post_content == '') {
						?>
						
						<?php $excerpt = wp_trim_words( get_field('why_we_love_it' ), $num_words = 20, $more = '...' ); ?>
						<p><?php echo $excerpt; ?></p>	
						
						<?php } else {?>
						<?php $excerpt = wp_trim_words( get_field('content' ), $num_words = 20, $more = '...' ); ?>
						<p><?php echo $excerpt; ?></p>	
						<?php } ?>
					
					<?php
						$post_id = $post->ID;
						$assigned_terms = wp_get_post_terms($post_id, 'age-range-toys', array("fields" => "all"));
					?>
					
					
					<div class="age-tags">
						<div class="age">Ages</div>	
						<?php
							$post_id = $post->ID;
		
							// loop through the term objects
							$icount = 0;
							$len = count($assigned_terms);
							foreach($assigned_terms as $term){
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
						// get the assigned taxonomy terms for "property-city"
						$assigned_terms = wp_get_post_terms($post_id, 'skills-toys', array("fields" => "all"));
						// loop through the term objects
						foreach($assigned_terms as $term){
						
						    echo $term->slug . ' ';

						}
					?>
					">
					
					<div class="icon-tag imagination-creativity"><span class="tooltip">Creativity + Imagination<span></span></span></div>	
					<div class="icon-tag critical-thinking"><span class="tooltip">Critical Thinking<span></span></span></div>	
					<div class="icon-tag language-literacy"><span class="tooltip">Language + Literacy<span></span></span></div>	
					<div class="icon-tag fine-motor-gross-motor"><span class="tooltip">Fine + Gross Motor Skills<span></span></span></div>	
					<div class="icon-tag play"><span class="tooltip">Play<span></span></span></div>	
					<div class="icon-tag social-emotional"><span class="tooltip">Social + Emotional<span></span></span></div>	
					
					</div>
				</div>
	        </div>
	        
<?php
if ($count%4 == 0)
{  
?>
    	</div>
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
<?php endforeach;
} 
wp_reset_postdata();?>