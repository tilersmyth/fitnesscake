<!DOCTYPE html>
<html lang="en">
  <html <?php language_attributes(); ?>>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

  </head>

 <body>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=682740565144606&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
  <!-- Navbar
    ============= -->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <?php if (!is_user_logged_in()){$link_home = esc_url( home_url( '/' ) );} else {$link_home = esc_url( home_url( '/user' ) );} ?>
          <a class="navbar-brand" href="<?php echo $link_home; ?>"><?php echo get_bloginfo( 'name' ); ?></a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right hidden-xs">
              <?php if (!is_user_logged_in()): ?>
              <li class="facebook_share_trainer"><div class="fb-like" data-href="<?php echo get_permalink(); ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div></li>
              <?php endif; ?>
          </ul>
        </div> 
      </div>
    </div>
