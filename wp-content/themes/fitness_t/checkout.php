<?php
/*
Template Name: checkout
*/
get_header(); ?>

<!-- Main body
================== -->
  <div class="wrapper">
    <div class="section-header">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <!-- Remove the .animated class if you don't want things to move -->
            <h1 class="animated slideInLeft"><span>Exercises</span></h1>
          </div>
        </div>
      </div>
    </div>
    <div class="container">

     <?php echo do_shortcode('[woocommerce_checkout]'); ?>
    </div>
  </div>

<?php get_footer(); ?>