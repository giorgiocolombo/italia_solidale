<?php
  /**
  * Admin View: Page - Recommendations
  */
  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }
  ?>	

  <div class="fta_wrap z-depth-1 fl-recomend-tab-holder">
    <div class="fta_wrap_inner">
      <div class="fl-recomend-plugins-holder">
        <div class="fl-recomend-head">
          <h4><?php esc_html_e("Love this plugin?", 'easy-facebook-likebox');?></h4>
          <p><?php esc_html_e("Then why not try our other awesome and FREE plugins.", 'easy-facebook-likebox');?></p> 
        </div>  
        <div class="row">

          <div class="col s3 fl-recomend-wraper">
            <h4><?php esc_html_e("WPOptin", 'easy-facebook-likebox');?></h4>
            <p><?php esc_html_e("The easiest and beginner friendly opt-in plugin to grow email subscribers list, sell more, get more phone calls, increase Facebook fan page likes and get more leads faster than ever.", 'easy-facebook-likebox');?></p>
            <div class="fl-recomend-meta-wraper">
              <p><?php esc_html_e("Just Released", 'easy-facebook-likebox');?></p>
              <p><span title="<?php esc_html_e("5-Star Rating", 'easy-facebook-likebox');?>" style="color: #ffb900;" class="stars">&#9733; &#9733; &#9733; &#9733; &#9733; </span></p>
            </div>  
            <div class="fl-recomends-action">
              <a  href="<?php echo $this->esf_get_plugin_install_link('wpoptin') ?>"><?php esc_html_e("Install now", 'easy-facebook-likebox');?></a>
              <a class="right" href="https://wordpress.org/plugins/wpoptin/" target="_blank"><?php esc_html_e("More Info", 'easy-facebook-likebox');?></a>
            </div>
          </div>

          <div class="col s3 fl-recomend-wraper">
           <h4><?php esc_html_e("Floating Links", 'easy-facebook-likebox');?></h4>
            <p><?php esc_html_e("Displays Fancy Floating Back To Top And Go To Bottom Links Along With Go To Next Post, Previous Post, Home Icon And Random Post Links On Post Detail Pages.", 'easy-facebook-likebox');?></p>
            <div class="fl-recomend-meta-wraper">
             <p><?php esc_html_e("Active Installs: 800+", 'easy-facebook-likebox');?></p>
              <p><span title="<?php esc_html_e("5-Star Rating", 'easy-facebook-likebox');?>" style="color: #ffb900;" class="stars">&#9733; &#9733; &#9733; &#9733; &#9733; </span></p>
            </div>  
            <div class="fl-recomends-action">
              <a  href="<?php echo $this->esf_get_plugin_install_link('floating-links') ?>" ><?php esc_html_e("Install now", 'easy-facebook-likebox');?></a>
              <a class="right" href="https://wordpress.org/plugins/floating-links/" target="_blank"><?php esc_html_e("More Info", 'easy-facebook-likebox');?></a>
            </div>
          </div>
        </div>  
        <div class="row">
          <div class="col s3 fl-recomend-wraper">
            <h4><?php esc_html_e("Easy Social Photos Gallery", 'easy-facebook-likebox');?></h4>
            <p><?php esc_html_e("Display photos and videos from a non-private Instagram account in responsive and customizable layout.", 'easy-facebook-likebox');?></p>
            <div class="fl-recomend-meta-wraper">
             <p><?php esc_html_e("Active Installs: 100+", 'easy-facebook-likebox');?></p>
              <p><span title="<?php esc_html_e("5-Star Rating", 'easy-facebook-likebox');?>" style="color: #ffb900;" class="stars">&#9733; &#9733; &#9733; &#9733; &#9733; </span></p>
            </div>  
            <div class="fl-recomends-action">
              <a  href="<?php echo $this->esf_get_plugin_install_link('my-instagram-feed') ?>"><?php esc_html_e("Install now", 'easy-facebook-likebox');?></a>
              <a class="right" href="https://wordpress.org/plugins/my-instagram-feed/" target="_blank"><?php esc_html_e("More Info", 'easy-facebook-likebox');?></a>
            </div>
          </div>
        </div>
      </div>
      <div class="fl-recomend-partner">
        <div class="fl-recomend-head">
         <h4><?php esc_html_e("Our Partners", 'easy-facebook-likebox');?></h4>
        </div>
        <div class="row">
          <div class="col s3 fl-recomend-wraper">
            <img src="<?php echo FTA_PLUGIN_URL ?>/admin/assets/images/cloudways-logo.png" />
            <p><?php esc_html_e("We simplify hosting experiences because we believe in empowering individuals, teams and businesses. We set high standards of performance, commit to complete freedom of choice coupled with simplicity and agility in every process.", 'easy-facebook-likebox');?></p>
              <p><?php esc_html_e("Backed by an innovative approach, our platform is built on best-of-breed technologies and industry-leading infrastructure providers that creates smooth managed cloud hosting experiences. And, we do this by investing in the right talent and by organizing the perfect teams.", 'easy-facebook-likebox');?></p>
            <div class="fl-recomends-action">
              <a href="https://www.cloudways.com/en/?id=571774" rel="noopener noreferrer" target="_blank"><?php esc_html_e("More Info", 'easy-facebook-likebox');?></a>
            </div>
          </div>
        </div>  
      </div>
    </div>
  </div>