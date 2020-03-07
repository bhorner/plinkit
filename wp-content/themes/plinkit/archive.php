<?php
/*
 * Template Name: Single Page
 * Description: A page template with a default design.
 */
?>

<?php get_header(); ?>
<div id="wrapper">
	<div class="container">
		<?php
		$year     = get_query_var('year');
		$month = get_query_var('month');
		$day      = get_query_var('day');
		?>
		<h2 class="text-center color-teal">Archive for <?php echo $month . ' ' . $year;?></h2>
	</div>	
	<div class="container container-880">	
		<div class="content-container">
			<div class="post-content content">
					
				<ul>
	<?php
	if ( have_posts() ) : ?>
		<?php
	
		while ( have_posts() ) : the_post();
	?>
			<li><a href="<?php the_permalink();?>"><?php the_title();?></a></li>	
	<?php
		endwhile;
	
	endif; ?>
				</ul>	
			</div>
		</div>
	</div>
</div>	
<?php get_footer(); ?>
