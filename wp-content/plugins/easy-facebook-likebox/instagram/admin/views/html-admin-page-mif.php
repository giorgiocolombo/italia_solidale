<?php
  /**
  * Admin View: Page - Instagram
  */
  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }

  $FTA = new Feed_Them_All();

  $fta_settings = $FTA->fta_get_settings();

  $app_ID = array('405460652816219','222116127877068');

  $rand_app_ID = array_rand($app_ID, '1');

  $u_app_ID = $app_ID[$rand_app_ID]; 

  $auth_url =  esc_url( add_query_arg( array(
    'client_id' => $u_app_ID,
    'redirect_uri' => 'https://maltathemes.com/efbl/app-'.$u_app_ID.'/index.php',
    'scope' => 'pages_read_engagement,pages_manage_metadata,pages_read_user_content,instagram_basic',
    'state' => admin_url('admin.php?page=mif'),
  ), 'https://www.facebook.com/dialog/oauth' ) );

  $mif_personal_clients = array('2478794912435887', '494132551291859');

  $mif_personal_app_ID = $mif_personal_clients[array_rand($mif_personal_clients, '1')];

  $personal_auth_url =  esc_url( add_query_arg( array(
    'client_id' => $mif_personal_app_ID,
    'redirect_uri' => 'https://easysocialfeed.com/efbl/app-'.$mif_personal_app_ID.'/index.php',
    'scope' => 'user_profile,user_media',
    'response_type' => 'code',
    'state' => admin_url('admin.php?page=mif'),
  ), 'https://api.instagram.com/oauth/authorize' ) );

 ?>

              <div class="esf_loader_wrap">
                <div class="esf_loader_inner">
                  <div class="loader mif_loader"></div>
                </div>
              </div> <div class="mif_wrap z-depth-1">     
                <div class="mif_wrap_inner">
                  
                  <div class="mif_loader_wrap">
                   <i class=" fa fa-spinner fa-spin"></i>
                 </div>  
                 <div class="mif_tabs_holder">
                  <div class="mif_tabs_header">
                    <ul id="mif_tabs" class="tabs">
                      <li class="tab col s3">
                        <a class="active mif-general" href="#mif-general">
                          <span><?php esc_html_e("1", 'easy-facebook-likebox');?>. <?php esc_html_e("Authenticate", 'easy-facebook-likebox');?></span>
                        </a></li>

                        <li class="tab col s3"><a class=" mif_for_disable mif-shortcode" href="#mif-shortcode">
                          <span><?php esc_html_e("2", 'easy-facebook-likebox');?>. <?php esc_html_e("Use", 'easy-facebook-likebox');?></span>
                        </a>
                      </li>

                      <li class="tab col s3"><a class="mif_for_disable mif-skins" href="#mif-skins">
                        <span><?php esc_html_e("3", 'easy-facebook-likebox');?>. <?php esc_html_e("Customize (skins)", 'easy-facebook-likebox');?></span>
                      </a>
                    </li>   

                    <li class="tab col s3"><a class=" mif_for_disable mif-cache"  href="#mif-cache">
                      <span><?php esc_html_e("Clear Cache", 'easy-facebook-likebox');?></span>
                    </a>
                  </li>

                </ul>
                <?php  

                if( $fta_settings['plugins']['facebook']['status'] && 'activated' == $fta_settings['plugins']['facebook']['status'] ){ ?>
                 
                 <div class="mif_tabs_right">
                  <a class="" href="<?php echo esc_url( admin_url('admin.php?page=easy-facebook-likebox') ); ?>"><?php esc_html_e("Facebook", 'easy-facebook-likebox');?></a>
                </div>  
                
              <?php  } ?>
            </div>
            <div class="mif_tab_c_holder">
             <?php include_once ESF_INSTA_PLUGIN_DIR . 'admin/views/html-autenticate-tab.php'; ?>
             <?php include_once ESF_INSTA_PLUGIN_DIR . 'admin/views/html-how-to-use-tab.php'; ?>
             <?php include_once ESF_INSTA_PLUGIN_DIR . 'admin/views/html-skins-tab.php'; ?>
             <?php include_once ESF_INSTA_PLUGIN_DIR . 'admin/views/html-clear-cache-tab.php'; ?>
           </div>
         </div>  
       </div>  

       
       <div id="fta-remove-at" class="modal">
        <div class="modal-content">
          <span class="mif-close-modal modal-close"><i class="material-icons dp48">close</i></span>
          <div class="mif-modal-content"> <span class="mif-lock-icon"><i class="material-icons dp48">error_outline</i> </span>
            <h5><?php esc_html_e("Are you sure?", 'easy-facebook-likebox');?></h5>
            <p><?php esc_html_e("Do you really want to delete the access token? It will delete all the pages data, access tokens and premissions given to the app.", 'easy-facebook-likebox');?></p>
            <a class="waves-effect waves-light btn modal-close" href="javascript:void(0)"><?php esc_html_e("Cancel", 'easy-facebook-likebox');?></a>
            <a class="waves-effect waves-light btn efbl_delete_at_confirmed modal-close" href="javascript:void(0)"><?php esc_html_e("Delete", 'easy-facebook-likebox');?></a>
          </div>
        </div>

      </div>
      
      <div id="mif-remove-at" class="modal">
        <div class="modal-content">
          <span class="mif-close-modal modal-close"><i class="material-icons dp48">close</i></span>
          <div class="mif-modal-content"> <span class="mif-lock-icon"><i class="material-icons dp48">error_outline</i> </span>
            <h5><?php esc_html_e("Are you sure?", 'easy-facebook-likebox');?></h5>
            <p><?php esc_html_e("Do you really want to delete the access token? It will delete the access token saved in your website databse.", 'easy-facebook-likebox');?></p>
            <a class="waves-effect waves-light btn modal-close" href="javascript:void(0)"><?php esc_html_e("Cancel", 'easy-facebook-likebox');?></a>
            <a class="waves-effect waves-light btn mif_delete_at_confirmed" href="#"><?php esc_html_e("Delete", 'easy-facebook-likebox');?></a>
            <div class="mif-revoke-access-steps">
              <p><?php esc_html_e("If you want to disconnect plugin app also follow the steps below:", 'easy-facebook-likebox');?></p>
              <ol>
                <li><?php esc_html_e("Go to ", 'easy-facebook-likebox');?><a target="_blank" href="<?php echo esc_url('https://www.instagram.com/') ?>">instagram.com</a> <?php esc_html_e("Log in with your username and password", 'easy-facebook-likebox');?> </li>
                <li><?php esc_html_e("Click on the user icon located on the top right of your screen.", 'easy-facebook-likebox');?></li>
                <li><?php esc_html_e("Go in your Instagram Settings and select “Authorized Apps”", 'easy-facebook-likebox');?></li>
                <li><?php esc_html_e("You will see a list of the apps & websites that are linked to your Instagram account. Click “Revoke Access” and “Yes” on the button below which you authenticated", 'easy-facebook-likebox');?></li>
              </ol>    
            </div>
          </div>
        </div>

      </div>
      
      
      <div id="fta-auth-error" class="modal">
        <div class="modal-content">
          <span class="mif-close-modal modal-close"><i class="material-icons dp48">close</i></span>
          <div class="mif-modal-content"> <span class="mif-lock-icon"><i class="material-icons dp48">error_outline</i> </span>
            <p><?php esc_html_e("Sorry, Plugin is unable to get the accounts data. Please delete the access token and select accounts in the second step of authentication to give the permission.", 'easy-facebook-likebox');?></p>
            
            <a class="waves-effect waves-light efbl_authentication_btn btn" href="<?php echo $auth_url ; ?>"><i class="material-icons right">camera_enhance</i><?php esc_html_e("Connect My Instagram Account", 'easy-facebook-likebox');?></a>
          </div>
        </div>

      </div>
      
      <div id="mif-free-masonry-upgrade" class="fta-upgrade-modal modal">
       <div class="modal-content">
         
        <div class="mif-modal-content"> <span class="mif-lock-icon"><i class="material-icons dp48">lock_outline</i> </span>
          <h5><?php esc_html_e("Premium Feature", 'easy-facebook-likebox');?></h5>
          <p><?php esc_html_e("We're sorry, Masonry layout is not included in your plan. Please upgrade to premium version to unlock this and all other cool features.", 'easy-facebook-likebox');?> 
          <a target="_blank" href="<?php echo esc_url( 'https://easysocialfeed.com/my-instagram-feed-demo/masonary'); ?>"><?php esc_html_e("Check out the demo", 'easy-facebook-likebox');?></a> </p>
          <p><?php esc_html_e('Upgrade today and get a 10% discount! On the checkout click on "Have a promotional code?" and enter ', 'easy-facebook-likebox');?><code>espf10</code></p>
          <hr />
          <a href="<?php echo esc_url( efl_fs()->get_upgrade_url() ); ?>" class="waves-effect waves-light btn"><i class="material-icons right">lock_open</i><?php esc_html_e("Upgrade to pro", 'easy-facebook-likebox');?></a>
          
        </div>
      </div>
      
    </div> 

    
    <div id="mif-free-carousel-upgrade" class="fta-upgrade-modal modal">
     <div class="modal-content">
       
      <div class="mif-modal-content"> <span class="mif-lock-icon"><i class="material-icons dp48">lock_outline</i> </span>
        <h5><?php esc_html_e("Premium Feature", 'easy-facebook-likebox');?></h5>
        <p><?php esc_html_e("We're sorry, Carousel layout is not included in your plan. Please upgrade to premium version to unlock this and all other cool features.", 'easy-facebook-likebox');?> 
        <a target="_blank" href="<?php echo esc_url( 'https://easysocialfeed.com/my-instagram-feed-demo/carousel'); ?>"><?php esc_html_e("Check out the demo", 'easy-facebook-likebox');?></a> </p>
        <p><?php esc_html_e('Upgrade today and get a 10% discount! On the checkout click on "Have a promotional code?" and enter ', 'easy-facebook-likebox');?><code>espf10</code></p>
        <hr />
        <a href="<?php echo esc_url( efl_fs()->get_upgrade_url() ); ?>" class="waves-effect waves-light btn"><i class="material-icons right">lock_open</i><?php esc_html_e("Upgrade to pro", 'easy-facebook-likebox');?></a>
        
      </div>
    </div>
    
  </div> 

  
  <div id="mif-free-half_width-upgrade" class="fta-upgrade-modal modal">
   <div class="modal-content">
     
    <div class="mif-modal-content"> <span class="mif-lock-icon"><i class="material-icons dp48">lock_outline</i> </span>
      <h5><?php esc_html_e("Premium Feature", 'easy-facebook-likebox');?></h5>
      <p><?php esc_html_e("We're sorry, Half Width layout is not included in your plan. Please upgrade to premium version to unlock this and all other cool features.", 'easy-facebook-likebox');?> 
      <a target="_blank" href="<?php echo esc_url( 'https://easysocialfeed.com/my-instagram-feed-demo/blog-layout'); ?>"><?php esc_html_e("Check out the demo", 'easy-facebook-likebox');?></a> </p>
      <p><?php esc_html_e('Upgrade today and get a 10% discount! On the checkout click on "Have a promotional code?" and enter ', 'easy-facebook-likebox');?><code>espf10</code></p>
      <hr />
      <a href="<?php echo esc_url( efl_fs()->get_upgrade_url() ); ?>" class="waves-effect waves-light btn"><i class="material-icons right">lock_open</i><?php esc_html_e("Upgrade to pro", 'easy-facebook-likebox');?></a>
      
    </div>
  </div>
  
</div> 


<div id="mif-free-full_width-upgrade" class="fta-upgrade-modal modal">
 <div class="modal-content">
   
  <div class="mif-modal-content"> <span class="mif-lock-icon"><i class="material-icons dp48">lock_outline</i> </span>
    <h5><?php esc_html_e("Premium Feature", 'easy-facebook-likebox');?></h5>
    <p><?php esc_html_e("We're sorry, Full Width layout is not included in your plan. Please upgrade to premium version to unlock this and all other cool features.", 'easy-facebook-likebox');?> 
    <a target="_blank" href="<?php echo esc_url( 'https://easysocialfeed.com/my-instagram-feed-demo/full-width'); ?>"><?php esc_html_e("Check out the demo", 'easy-facebook-likebox');?></a> </p>
    <p><?php esc_html_e('Upgrade today and get a 10% discount! On the checkout click on "Have a promotional code?" and enter ', 'easy-facebook-likebox');?><code>espf10</code></p>
    <hr />
    <a href="<?php echo esc_url( efl_fs()->get_upgrade_url() ); ?>" class="waves-effect waves-light btn"><i class="material-icons right">lock_open</i><?php esc_html_e("Upgrade to pro", 'easy-facebook-likebox');?></a>
    
  </div>
</div>

</div> 

</div>

<?php if ( efl_fs()->is_free_plan()  ||  efl_fs()->is_plan('facebook_premium', true) ) {?>

 <div class="espf-upgrade">
  <h2><?php esc_html_e("Easy Social Feed", 'easy-facebook-likebox');?> <b><?php esc_html_e("Pro", 'easy-facebook-likebox');?></b></h2>
  <p><?php esc_html_e("Unlock all premium features such as Advanced PopUp, More Fancy Layouts, Post filters like events, images, videos, and albums, gallery in the PopUp and above all top notch priority support.", 'easy-facebook-likebox');?>
</p>
<p><?php esc_html_e('Upgrade today and get a 10% discount! On the checkout click on "Have a promotional code?" and enter ', 'easy-facebook-likebox');?>
<code><?php esc_html_e("espf10", 'easy-facebook-likebox');?></code>
</p>
<a href="<?php echo esc_url( efl_fs()->get_upgrade_url() ) ?>" class="waves-effect waves-light btn"><i class="material-icons right">lock_open</i><?php esc_html_e("Upgrade To Pro", 'easy-facebook-likebox');?></a>
</div>

<?php } ?>