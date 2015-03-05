<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<div class="wrapper">
    <div class="not-found">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="digits">
              4<i class="fa fa-meh-o animated flipInX" id="smile"></i>4
            </div>
            <h1>The page you are trying to reach cannot be found</h1>
            <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Back to Home</a></h1>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php get_footer(); ?>