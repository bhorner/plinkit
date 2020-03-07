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

	<?php wp_head(); ?>
	
	<link rel="stylesheet" href="https://use.typekit.net/pod4brf.css">
	
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



<?php if( (get_field('alert', 'options') ) && ( is_page( array( '27', '67', '8298', '4595', '4927', '33') ) ) ) { ?>
	<body <?php body_class('alert-body'); ?>>
<?php } else { ?>
	<body <?php body_class(); ?>>
<?php } ?>

<?php
$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri_segments = explode('/', $uri_path);
?>

	<header class="<?php echo $uri_segments[0]; ?>">
		<div class="header-inner"></div>	

		<?php if(get_field('alert', 'options')) { ?>
			<?php if( is_page( array( '27', '67', '8298' ) ) ) { ?>
				<div class="alert"><?php the_field('alert', 'options');?> <a class="alert-close" href="#"></a></div>	
			<?php } ?>
			
			<?php if( is_page( array( '4595' ) ) ) { ?>
				<?php if( get_field('alert', '4595') ){ ?>				
					<div class="alert"><?php the_field('alert', 'options');?> <a class="alert-close" href="#"></a></div>	
				<?php } ?>
			<?php } ?>
			
			<?php if( is_page( array( '4927' ) ) ) { ?>
				<div class="alert"><?php the_field('alert', 'options');?> <a class="alert-close" href="#"></a></div>	
			<?php } ?>

			<?php if( is_page( array( '33' ) ) ) { ?>
				<?php if( get_field('alert', '33') ){ ?>				
					<div class="alert"><?php the_field('alert', 'options');?> <a class="alert-close" href="#"></a></div>	
				<?php } ?>
			<?php } ?>
			
		<?php } ?>
		
		<?php 
		if(is_page_template('templates/gift.php')) {
		?>
		<div class="alert nl-alert"><?php the_field('gift_guide_alert', 'options');?><a class="alert-close" href="#"></a></div>
		<?php
		}
        // Display post content
?>
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
						    <li>
								<a class="nav-link" href="<?php the_sub_field('button_link'); ?>"><?php the_sub_field('button_text'); ?></a>	
								<div class="sub-sub-menu">
									<?php the_sub_field('text'); ?>
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
	