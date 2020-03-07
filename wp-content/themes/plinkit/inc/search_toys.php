<?php
	
define('WP_USE_THEMES', false);
require($_SERVER["DOCUMENT_ROOT"] . '/wp-blog-header.php');
header("HTTP/1.1 200 OK");

// check url vars

if(isset($_GET['skills']) && is_array($_GET['skills'])) {
   $skills = $_GET['skills'];
}

if(isset($_GET['age']) && is_array($_GET['age'])) {
   $age = $_GET['age'];
}

if(isset($_GET['search[]']) && is_array($_GET['search[]'])) {
   $search = $_GET['search'];
}

// count

$count = 1;

global $post;

// initial args

$args = array( 
	'post_type'        => 'toys',
	'posts_per_page'   => -1,
	'post_status'      => 'publish',
	'tax_query'		   => array(
		'relation' => 'AND',
	)
);

// get tax vars

if($skills != null) {
	$tax_query[] = array(
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
	        'taxonomy' => 'age-range-toys',
	        'field' => 'id',
	        'terms' => $age,
	        'operator' => 'AND',
	    ),
	);
}

/*
$tax_query[] => array(
        array(
            'taxonomy' => 'toys-categories',
            'field'    => 'id',
            'terms'    => array(66),
            'operator' => 'NOT IN',
        ),
	);
*/

$tax_query[] = array(
	    array(
	        'taxonomy' => 'toys-categories',
	        'field' => 'id',
	        'terms' => 66,
	        'operator' => 'NOT IN',
	    ),
	);

// get search terms

if($search != null) {
	if(is_array($search)) {
 		$args['s'] = implode(',', $search);
	
		$searches = $search;
	} else {
 		$args['s'] = $search;
		$searches = explode(',', $search);
	}
}

$meta_query = array('relation' => 'OR');

$args['meta_query'] = $meta_query;

$args['tax_query'] = $tax_query;

$ageskills = [];

if($age != '') {
	$ageskills = $age;
}

if($skills != '') {
	$ageskills = array_merge($ageskills, $skills);
}

$query = new WP_Query($args);
// $query->parse_query( $args );

if($search != null) {
	relevanssi_do_query($query);
}

/*
if(is_user_logged_in()) {
	echo '<pre>';
	print_r($args);
	echo '</pre>'; 
}
*/
/*   
echo '<pre>';
print_r($query);
echo '</pre>'; 
*/  

if (!$query->have_posts() ) {
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
while ( $query->have_posts() ) {
		$query->the_post();


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
		<?php }?>
<?php
}
?>

			<div class="band-item width-25 column left">
	           	<div class="thumb width-100 column left">	
				<?php 
					$post_id = $post->ID;
					
					$image = get_field('images');
					$thumb = $image['sizes'][ 'post-thumb' ];
				?>
				<?php if(get_field('images')):?>
				<?php
				$image = get_field('images');
				$thumb = $image[0]['sizes'][ 'post-thumb' ];
				?>
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
						if (get_field('content', $post_id)) {
						?>
							<?php $excerpt = wp_trim_words( get_field('content', $post_id), $num_words = 20, $more = '...' ); ?>
							<p><?php echo $excerpt; ?></p>	
						<?php } elseif(get_field('learn')) {?>
							<?php $excerpt = wp_trim_words( get_field('learn', $post_id), $num_words = 20, $more = '...' ); ?>
							<p><?php echo $excerpt; ?></p>	
						<?php } else { ?>
							<?php $excerpt = wp_trim_words( get_field('do', $post_id), $num_words = 20, $more = '...' ); ?>
							<p><?php echo $excerpt; ?></p>	
						<?php } ?>
			<div class="age-tags">
				<div class="age">Ages</div>	
					<?php 
					$age_assigned_terms = wp_get_post_terms($post_id, 'age-range-toys', array("fields" => "all"));
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
						$age_display = array();
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
	
	}
} 
wp_reset_postdata();?>