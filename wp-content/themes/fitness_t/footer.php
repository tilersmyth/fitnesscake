<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
<!-- Foooter
================== -->
  <footer>
    <div class="container">
      <div class="row">
        <!-- Contact Us 
        =================  -->
        <div class="col-sm-4">
          <div class="headline"><h3>Feedback</h3></div>
          <div class="content">
            <p>We love receiving feedback from our visitors! Comments/critiques from a different perspective is invaluable to us. <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>">Let us know your thoughts!</a>
            </p>
          </div>
        </div>
        <!-- Social icons 
        ===================== -->
        <div class="col-sm-4">
          <div class="headline"><h3>Connect</h3></div>
          <div class="content social">
            <ul>
                <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>"><i class="fa fa-envelope-o"></i></a></li>
            </ul>
            <div class="clearfix"></div>
          </div>
        </div>
        <!-- Subscribe 
        =============== -->
        <div class="col-sm-4">
          <div class="headline"><h3>Subscribe</h3></div>
          <div class="content">
            <p>Sign up for the latest fitness insights and other interesting tidbits! We promise not to bother you too often!</p>
              <div class="row">
                <div class="col-sm-8">
                 <?php echo do_shortcode("[sp-signup listids='8']");?>  
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- Legal 
  ============= -->
  <div class="legal">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <p>&copy; Fitness Cake. <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
        </div>
      </div>
    </div>
  </div>	

<?php wp_footer(); ?>
</body>
</html>