<?php
/*
 * Template Name: Toolkit Page
 * Description: A page template with a default design.
 */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    
    <link rel='shortcut icon' type='image/x-icon' href='<?php bloginfo('template_url'); ?>/favicon.png' />
    <meta name="author" content="DEI Creative in Seattle, WA" />
  	<meta name="keywords" content="" />
  	<meta name="robots" content="all" />
  	
    <meta name="viewport" content="width=device-width, initial-scale=1" />

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php wp_get_archives(array('type' => 'monthly', 'format' => 'link')); ?>
	
	<script type="text/javascript">
		var theme = '<?php echo get_template_directory_uri(); ?>';
	</script>

	<script src="https://use.fontawesome.com/cdf75c20cb.js"></script>

	<?php wp_head(); ?>
	
	<script src="https://use.typekit.net/pod4brf.js"></script>
	<script>try{Typekit.load({ async: true });}catch(e){}</script>
	
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
	
	  ga('create', 'UA-80662866-1', 'auto');
	  ga('send', 'pageview');
	
	</script>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	
	<?php if(get_field('post_image')) { ?>
	<meta property="og:image" content="<?php $post_image = get_field('post_image'); echo $post_image['url']; ?>" />
	<?php } ?>
</head>

<?php 
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
?>
	<?php 
	$bodyClass = array();
if(get_field('alert', 'options')) {
	$bodyClass[] = 'alert-body';
} 
if(get_field('subscriber')) {
	$bodyClass[] = 'subscriber';
} 
// print_r($bodyClass);
?>
<body <?php body_class($bodyClass);?>>
<?php
$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri_path = preg_replace('/\\\\/', '', $uri_path);
?>

<script>
	$(document).ready(function(){
		var linkClass = '.<?php echo str_replace("/","", $uri_path); ?>';
		$('.sub-menu ' + linkClass).addClass('active');
	});
</script>	

	<header class="">
	<div class="header-inner"></div>	

		<?php if(get_field('alert', 'options')) { ?>
			<?php if( is_page( array( '27', '67' ) ) ) { ?>
				<div class="alert"><?php the_field('alert', 'options');?> <a class="alert-close" href="#"></a></div>	
			<?php } ?>
			
			<?php if( is_page( array( '4595' ) ) ) { ?>
				<?php if( get_field('alert', '4595') ){ ?>				
					<div class="alert"><?php the_field('alert', 'options');?> <a class="alert-close" href="#"></a></div>	
				<?php } ?>
			<?php } ?>

			<?php if( is_page( array( '33' ) ) ) { ?>
				<?php if( get_field('alert', '33') ){ ?>				
					<div class="alert"><?php the_field('alert', 'options');?> <a class="alert-close" href="#"></a></div>	
				<?php } ?>
			<?php } ?>
			
		<?php } ?>
		
		<div class="">
			<a id="logo" href="/">
				<div id="plinks">
					<?php include get_template_directory() . '/img/plinks.svg'; ?>
				</div>	
				<?php include get_template_directory() . '/img/header-logo.svg'; ?>
				<p class="registered">®</p>	
				<p class="tagline">Learn better. Play smarter.</p>	
			</a>	
			
			<div id="nav">
				<?php $post = get_post(); ?>
				<ul id="main-nav" class="nav">
					<li><a href="<?php echo site_url(); ?>/learn-do" class="<?php if( is_page(33) ) { echo 'active';}?>" >Learn + Do</a></li>	
					<li><a href="<?php echo site_url(); ?>/shop-play" class="<?php if( is_page(4595) ) { echo 'active';}?>">Shop + Play</a></li>	
				</ul>
				<ul id="second-nav" class="nav">
					<li class="has-drop">
						<a href="#">Explore Our Topics</a>	
					</li>
				</ul>
				
				<div class="drop-down">
					<ul class="sub-menu">
						
						<?php
						
						// check if the repeater field has rows of data
						if( have_rows('dropdown', 'options') ):
						
						 	// loop through the rows of data
						    while ( have_rows('dropdown', 'options') ) : the_row();
						?>
						<?php
						$uri_path = parse_url(get_sub_field('button_link'), PHP_URL_PATH);
						$uri_path = preg_replace('/\\\\/', '', $uri_path);
						?>
						    <li class="<?php echo str_replace("/","", $uri_path); ?>">
								<a class="nav-link" href="<?php the_sub_field('button_link'); ?>"><?php the_sub_field('button_text'); ?></a>	
								<div class="sub-sub-menu">
									<p><?php the_sub_field('text'); ?></p>	
								</div>	
							</li>
						<?php
						    endwhile;
						
						else :
						
						    // no rows found
						
						endif;
						
						?>
						
					</ul>	
				</div>
				
				<div id="right-nav">
					<ul id="options" class="nav">
						<li class="searchbtn">	
							<a href="#">
								<?php include get_template_directory() . '/img/search.svg'; ?>
								<div class="search-inner"></div>
								<span>Search</span>	
							</a>
						</li>	
						<li class="favorites <?php if(is_page(106)) { echo 'active'; }?><?php if(is_page(123)) { echo 'active'; }?>">
							
							<?php $favorites = get_user_favorites(); ?>
							
							<?php if ( is_user_logged_in() ) { ?>
								<a href="/my-favorites"><?php include get_template_directory() . '/img/favorites.svg'; ?><span>Favorites</span></a>
							<?php } else { ?>
								<a href="<?php echo get_page_link('104');?>"><?php include get_template_directory() . '/img/favorites.svg'; ?><span>Favorites</span></a>
							<?php } ?>
							
							<?php if ( isset($favorites) && !empty($favorites) ) : ?><div class="fave-count"><?php the_user_favorites_count(); ?></div>	<?php endif;?>
							<div class="sub-favorites" style="display: none">
							
							<?php
							if ( $favorites ) : // This is important: if an empty array is passed into the WP_Query parameters, all posts will be returned
							$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1; // If you want to include pagination
							$favorites_query = new WP_Query(array(
								'post_type' => 'post', // If you have multiple post types, pass an array
								'posts_per_page' => -1,
								'ignore_sticky_posts' => true,
								'post__in' => $favorites,
								'paged' => $paged // If you want to include pagination, and have a specific posts_per_page set
							));
							if ( $favorites_query->have_posts() ) : while ( $favorites_query->have_posts() ) : $favorites_query->the_post();
							?>
								<a href="<?php the_permalink(); ?>"><?php the_title($favorite->ID); ?> <?php echo $favorite->ID; ?></a>
							<?php
							endwhile; 
							endif; wp_reset_postdata();
							else :
								echo 'You have no favorites';
							endif;
							?>
							</div>	
						</li>	
					</ul>
					
					<div id="search-box" class="mobile-search">
						<div class="container relative">
<!-- 							<input type="text" class="search-text" placeholder="What are you looking for?"> -->
							<?php get_search_form(); ?>
							<a id="search" href="#"><?php include get_template_directory() . '/img/search.svg'; ?></a>
						</div>	
					</div>	
					
					<ul id="secondary" class="nav">
						<li <?php if(is_page(69)) { echo 'class="active"'; }?>><a href="/our-story">Our Story</a></li>
						<li></li>	
						<li <?php if(is_page(99)) { echo 'class="active"'; }?>><a href="/write-for-us">Write for Us</a></li>
						<li>
							<?php
								if ( is_user_logged_in() ) {
							?>
							<a href="<?php echo wp_logout_url( home_url() ); ?>">Log Out</a>
							<?php
								} else {
							?>
							<a href="<?php echo get_page_link('104');?>">Sign In / Sign Up</a>
							<?php
								}
							?>
<!-- 							<a href="#info">Optional</a> -->
						</li>
					</ul>	
				</div>	
								
			</div>
	
		</div>	
	
		<a id="toggle" href="#">
			<span class="toggle-top"></span>
			<span class="toggle-middle"></span>
			<span class="toggle-bottom"></span>
		</a>

		<div id="search-box">
			<div class="container relative">
			<?php get_search_form(); ?>
				<a id="search" href="#"><?php include get_template_directory() . '/img/search.svg'; ?></a>
			</div>	
		</div>	
	
		
	</header>	
	
	<div id="megawrapper">
<div class="back-top text-right">
	<a class="linkscroll" href="#intro-top"> Back to Top</a>	
</div>	

<div id="intro-top" class="big-text text-center">
	<div class="container relative">
		<h2><?php the_field('title');?></h2>	
	</div>	
	<div class="container small-container">
		<div class="intro-text color-coral text-center">
			<p><?php the_field('intro');?></p>	
			
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

<section id="bands" class="tk-bands">
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
			<div id="<?php echo $link;?>" class="scroller">
				<div class="header"><?php the_sub_field('header'); ?></div>
			</div>	
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
			<?php $post_id = $post->ID; ?>
	        <?php if(get_post_status($post_id) == 'publish') { ?>
	        
	        <div class="band-item width-25 column left number-<?php echo $number;?>">
	           	<?php get_template_part('band-item'); ?>
	        </div>
	        
	        <?php $number++;?>
	        <?php } ?>
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


</section>

<?php
	} // end while
} // end if
?>
</div>	

<?php if(get_field('subscriber')) { ?>
	<div class="subscribe text-center">
		<h2><?php the_field('subscribe_title');?></h2>
		<?php the_field('subscribe_text');?>	
		<a href="/sign-up" class="btn btn-teal inline-block"><?php the_field('subscribe_link_text');?></a>
	</div>	
<?php } ?>

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
		
		$('#register').click(function(){
			console.log('reg');
		});
			
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
	        $("html, body").animate({ scrollTop: ($($(this).attr("href")).offset().top) }, 500);
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


