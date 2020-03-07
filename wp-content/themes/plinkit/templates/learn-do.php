<?php
/*
 * Template Name: Learn + Do Page
 * Description: A page template with a default design.
 */
?>

<?php get_header(); ?>
<div class="back-top text-right">
	<a class="linkscroll" href="#page-title"> Back to Top</a>	
</div>	

<?php $searches[] = array(); ?>

<div id="page-title">
	<div class="container text-center">
		<h1><span class="icon"><?php include get_template_directory() . '/img/light.svg'; ?></span> <span class="icon"><?php include get_template_directory() . '/img/crayon.svg'; ?></span> Learn + Do<br><?php the_field('page_title');?></h1>
	</div>	
</div>	

<div class="container small-container" id="top-part">
	<div class="intro-text color-coral text-center">
		<p><?php the_field('intro');?></p>	
		<br>
		<a class="linkscroll" href="#critical-thinking">Critical Thinking</a>	
		<a class="linkscroll" href="#social-emotional">Social + Emotional</a>	
		<a class="linkscroll" href="#language-literacy">Language + Literacy</a>	
		<a class="linkscroll" href="#creativity-imagination">Creativity + Imagination</a>	
		<a class="linkscroll" href="#fine-motor-gross-motor">Fine Motor + Gross Motor</a>	
		<?php if( get_field('tag_link') ) {?><a class="link" href="<?php the_field('tag_link');?>" target="_blank"><?php the_field('tagline');?></a><?php } ?>
	</div>	
</div>	

<div id="wrapper">
	
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
	
				
				<?php $post_id = $post->ID; ?>
			    <?php if(get_post_status($post_id) == 'publish') { ?>		
					<div class="band-item width-25 column left">
			       		<?php get_template_part('band-item'); ?>
			    	</div>
				<?php } ?>

	
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
	
				
				<?php $post_id = $post->ID; ?>
			    <?php if(get_post_status($post_id) == 'publish') { ?>		
					<div class="band-item width-25 column left">
			       		<?php get_template_part('band-item'); ?>
			    	</div>
				<?php } ?>

	
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
	
				
				<?php $post_id = $post->ID; ?>
			    <?php if(get_post_status($post_id) == 'publish') { ?>		
					<div class="band-item width-25 column left">
			       		<?php get_template_part('band-item'); ?>
			    	</div>
				<?php } ?>

	
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
	
				
				<?php $post_id = $post->ID; ?>
			    <?php if(get_post_status($post_id) == 'publish') { ?>		
					<div class="band-item width-25 column left">
			       		<?php get_template_part('band-item'); ?>
			    	</div>
				<?php } ?>

	
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
	
				
				<?php $post_id = $post->ID; ?>
			    <?php if(get_post_status($post_id) == 'publish') { ?>		
					<div class="band-item width-25 column left">
			       		<?php get_template_part('band-item'); ?>
			    	</div>
				<?php } ?>

	
		<?php endforeach; ?>
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
	});
	
	function owl() {
		$(".owl-carousel").owlCarousel({
		  items: 4,
		  nav: true,
		  loop: true,
		});
	}
	
	$(document).ready(function(){
	    $( "a.linkscroll" ).click(function( event ) {
	        event.preventDefault();
	        $("html, body").animate({ scrollTop: ($($(this).attr("href")).offset().top - 160) }, 500);
	    });
	});

	var $topofDiv = $("#top-part").offset().top; //gets offset of header
	var $height = $("#top-part").outerHeight(); //gets height of header

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


