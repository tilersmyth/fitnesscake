<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo get_bloginfo('template_url') ?>/img/favicon.ico">

    <title><?php wp_title( '|', true, 'right' ); ?></title>

    <!-- Load Google Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Bree+Serif' rel='stylesheet' type='text/css'>
    
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <?php wp_head(); ?>

    <?php $id = get_the_ID(); global $exercises; $meta_header = $exercises->the_meta($id); ?>

    <meta property="og:title" content="<?php echo the_title(); ?>" />
    <meta property="og:description" content="<?php echo $meta_header['description']; ?>" />
    <meta property="og:image" content="<?php echo $meta_header['vidthumb']; ?>" />
  </head>

 <body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=1491207917782535&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
  <!-- Navbar
    ============= -->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo esc_url( home_url( '/user' ) ); ?>">Fitness Cake</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">   
            <li class="hidden-sm hidden-md"><a href="<?php echo esc_url( home_url( '/user' ) ); ?>">Home</a></li>
            <li><a href="<?php echo esc_url( home_url( '/exercises' ) ); ?>">Exercises</a></li> 
            <li class="visible-xs"><a href="<?php echo esc_url( home_url( '/settings' ) ); ?>">Settings</a></li>
            <li class="visible-xs"><a href="<?php echo wp_logout_url( home_url() ); ?>" id="sign-out">Sign out</a></li>
          </ul>

          <ul class="nav navbar-nav navbar-right hidden-xs">
            <?php $current_user = wp_get_current_user();?>
              <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $current_user->user_firstname; ?><b class="caret"></b></a>
              <ul class="dropdown-menu user_menu">
                <li><a href="<?php echo esc_url( home_url( '/settings' ) ); ?>"><span class="glyphicon glyphicon-cog user_menu_icon"></span> Settings</a></li>
                <li><a href="<?php echo wp_logout_url( home_url() ); ?>" id="sign-out"><span class="glyphicon glyphicon-log-out user_menu_icon"></span> Sign out</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>
