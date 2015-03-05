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
          <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' )); ?>">Fitness Cake</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
           

          </ul>

          <ul class="nav navbar-nav navbar-right hidden-xs">
            
            <li class="hidden-sm hidden-md"><a href="<?php echo esc_url( home_url( '/' )); ?>">Home</a></li>
            <li><a href="<?php echo esc_url( home_url( '/how-it-works' ) ); ?>">How it works</a></li>
            <li><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>">Contact</a></li>
            
          </ul>
        </div>
      </div>
    </div>
