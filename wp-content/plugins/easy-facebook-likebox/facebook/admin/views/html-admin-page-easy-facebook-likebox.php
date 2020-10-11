<?php
  /**
  * Admin View: Page - Facebook
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
    'scope' => 'manage_pages',
    'state' => admin_url('admin.php?page=easy-facebook-likebox'),
), 'https://www.facebook.com/dialog/oauth' ) );

?>	
<div class="esf_loader_wrap">
    <div class="esf_loader_inner">
        <div class="loader efbl_loader"></div>
    </div>
</div><div class="efbl_wrap z-depth-1">
    <div class="efbl_wrap_inner">

        <div class="efbl_tabs_holder">
        <div class="efbl_tabs_header">    
          <ul id="efbl_tabs" class="tabs">
              <li class="tab col s3">
                  <a class="active" href="#efbl-authentication">
                    <span><?php esc_html_e("1", 'easy-facebook-likebox');?>. <?php esc_html_e("Authenticate", 'easy-facebook-likebox');?></span>
                </a>
            </li>
            <li class="tab col s3">
              <a class="active" href="#efbl-general">
                  <span><?php esc_html_e("2", 'easy-facebook-likebox');?>. <?php esc_html_e("Use (Display)", 'easy-facebook-likebox');?></span>
              </a>
          </li>
          <li class="tab col s3">
              <a class="active" href="#efbl-skins">
                <span><?php esc_html_e("3", 'easy-facebook-likebox');?>. <?php esc_html_e("Customize (skins)", 'easy-facebook-likebox');?></span>
            </a>
        </li><li class="tab col s3">
          <a class="active" href="#efbl-auto-popup">
            <span><?php esc_html_e("Auto PopUp", 'easy-facebook-likebox');?></span>
        </a>
    </li><li class="tab col s3">
      <a class="active" href="#efbl-cached">
       <span><?php esc_html_e("Clear Cache", 'easy-facebook-likebox');?></span>
   </a>
</li> 
<li class="indicator" ></li>
</ul>

<?php  if( ($fta_settings['plugins']['instagram']['status'] ) && ( 'activated' == $fta_settings['plugins']['instagram']['status'])){ ?>

  <div class="efbl_tabs_right">
    <a class="" href="<?php echo esc_url( admin_url('admin.php?page=mif') ) ?>"><?php esc_html_e("Instagram", 'easy-facebook-likebox');?></a>
</div>  

<?php } ?>  
</div>
</div>
<div class="efbl_tab_c_holder">
    <?php include_once EFBL_PLUGIN_DIR . 'admin/views/html-authenticate-tab.php'; ?>
    <?php include_once EFBL_PLUGIN_DIR . 'admin/views/html-how-to-use-tab.php'; ?>
    <?php include_once EFBL_PLUGIN_DIR . 'admin/views/html-skins-tab.php'; ?>
    <?php include_once EFBL_PLUGIN_DIR . 'admin/views/html-auto-popup-tab.php'; ?>
    <?php include_once EFBL_PLUGIN_DIR . 'admin/views/html-clear-cache-tab.php'; ?>
</div>
</div>  
</div>  
</div>  

<!-- Popup starts<!-->
<div id="fta-auth-error" class="modal">
    <div class="modal-content">
        <span class="mif-close-modal modal-close"><i class="material-icons dp48">close</i></span>
        <div class="mif-modal-content"> <span class="mif-lock-icon"><i class="material-icons dp48">error_outline</i> </span>
            <p><?php esc_html_e("Sorry, Plugin is unable to get the pages data. Please delete the access token and select pages in the second step of authentication to give the permission.", 'easy-facebook-likebox');?></p>

            <a class="waves-effect waves-light efbl_authentication_btn btn" href="<?php echo $auth_url ?>"><img class="efb_icon left" src="<?php echo EFBL_PLUGIN_URL ?>/admin/assets/images/facebook-icon.png"/><?php esc_html_e("Connect My Facebook Pages", 'easy-facebook-likebox');?></a>

        </div>
    </div>

</div>
<!-- Popup ends<!-->

<!-- Popup starts<!-->
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
<!-- Popup ends<!-->  

<!-- Remove Skin Popup starts<!-->
<div id="efbl-remove-skin" class="modal efbl-remove-skin efbl-confirm-modal">
    <div class="modal-content">
        <span class="mif-close-modal modal-close"><i class="material-icons dp48">close</i></span>
        <div class="mif-modal-content"> <span class="mif-lock-icon"><i class="material-icons dp48">error_outline</i> </span>
            <h5><?php esc_html_e("Are you sure?", 'easy-facebook-likebox');?></h5>
            <p><?php esc_html_e("Do you really want to delete the skin? It will delete all the settings values of the skin.", 'easy-facebook-likebox');?></p>
            <a class="waves-effect waves-light btn modal-close" href="javascript:void(0)"><?php esc_html_e("Cancel", 'easy-facebook-likebox');?></a>
            <a class="waves-effect waves-light btn efbl_skin_delete modal-close" href="javascript:void(0)"><?php esc_html_e("Delete", 'easy-facebook-likebox');?></a>
        </div>
    </div>

</div>
<!-- Remove Skin Popup ends<!-->  

<!-- Filter Modal Structure -->
<div id="efbl-filter-upgrade" class="fta-upgrade-modal modal">
    <div class="modal-content">

        <div class="mif-modal-content"> <span class="mif-lock-icon"><i class="material-icons dp48">lock_outline</i> </span>
            <h5><?php esc_html_e("Premium Feature", 'easy-facebook-likebox');?></h5>
            <p><?php esc_html_e("We're sorry, posts filter is not included in your plan. Please upgrade to premium version to unlock this and all other cool features.", 'easy-facebook-likebox');?><a target="_blank" href="https://easysocialfeed.com/custom-facebook-feed"><?php esc_html_e("Check out the demo", 'easy-facebook-likebox');?></a></p>
            <p><?php esc_html_e('Upgrade today and get a 10% discount! On the checkout click on "Have a promotional code?', 'easy-facebook-likebox');?></p>
            <hr />
            <a href="<?php echo efl_fs()->get_upgrade_url() ?>" class="waves-effect waves-light btn"><i class="material-icons right">lock_open</i><?php esc_html_e("Upgrade to pro", 'easy-facebook-likebox');?></a>

        </div>
    </div>

</div> 

<!-- Filter Modal Structure Ends--> 

<!-- Grid Layout Modal Structure -->
<div id="efbl-free-grid-upgrade" class="fta-upgrade-modal modal">
    <div class="modal-content">

        <div class="mif-modal-content"> <span class="mif-lock-icon"><i class="material-icons dp48">lock_outline</i> </span>
            <h5><?php esc_html_e("Premium Feature", 'easy-facebook-likebox');?></h5>
            <p><?php esc_html_e("We are sorry grid layout is not included in your plan. Please upgrade to premium version to unlock this and all other cool features.", 'easy-facebook-likebox');?><a target="_blank" href="https://easysocialfeed.com/custom-facebook-feed/grid"><?php esc_html_e("Check out the demo", 'easy-facebook-likebox');?></a></p>
            <p><?php esc_html_e('Upgrade today and get a 10% discount! On the checkout click on "Have a promotional code?', 'easy-facebook-likebox');?></p>
            <hr />
            <a href="<?php echo efl_fs()->get_upgrade_url() ?>" class="waves-effect waves-light btn"><i class="material-icons right">lock_open</i><?php esc_html_e("Upgrade to pro", 'easy-facebook-likebox');?></a>

        </div>
    </div>

</div> 

<!-- Grid Layout Structure Ends--> 

<!-- Grid Layout Modal Structure -->
<div id="efbl-free-masonry-upgrade" class="fta-upgrade-modal modal">
    <div class="modal-content">

        <div class="mif-modal-content"> <span class="mif-lock-icon"><i class="material-icons dp48">lock_outline</i> </span>
            <h5><?php esc_html_e("Premium Feature", 'easy-facebook-likebox');?></h5>
            <p><?php esc_html_e("We are sorry masonry layout is not included in your plan. Please upgrade to premium version to unlock this and all other cool features.", 'easy-facebook-likebox');?><a target="_blank" href="https://easysocialfeed.com/custom-facebook-feed/masonry"><?php esc_html_e("Check out the demo", 'easy-facebook-likebox');?></a></p>
            <p><?php esc_html_e('Upgrade today and get a 10% discount! On the checkout click on "Have a promotional code?', 'easy-facebook-likebox');?></p>
            <hr />
            <a href="<?php echo efl_fs()->get_upgrade_url() ?>" class="waves-effect waves-light btn"><i class="material-icons right">lock_open</i><?php esc_html_e("Upgrade to pro", 'easy-facebook-likebox');?></a>

        </div>
    </div>

</div> 

<!-- Grid Layout Structure Ends--> 

<!-- Carousel Layout Modal Structure -->
<div id="efbl-free-carousel-upgrade" class="fta-upgrade-modal modal">
    <div class="modal-content">

        <div class="mif-modal-content"> <span class="mif-lock-icon"><i class="material-icons dp48">lock_outline</i> </span>
            <h5><?php esc_html_e("Premium Feature", 'easy-facebook-likebox');?></h5>
            <p><?php esc_html_e("We are sorry carousel layout is not included in your plan. Please upgrade to premium version to unlock this and all other cool features.", 'easy-facebook-likebox');?><a target="_blank" href="https://easysocialfeed.com/custom-facebook-feed/carousel"><?php esc_html_e("Check out the demo", 'easy-facebook-likebox');?></a></p>
            <p><?php esc_html_e('Upgrade today and get a 10% discount! On the checkout click on "Have a promotional code?', 'easy-facebook-likebox');?></p>
            <hr />
            <a href="<?php echo efl_fs()->get_upgrade_url() ?>" class="waves-effect waves-light btn"><i class="material-icons right">lock_open</i><?php esc_html_e("Upgrade to pro", 'easy-facebook-likebox');?></a>

        </div>
    </div>

</div> 

<!-- Carousel Layout Structure Ends--> 

<!-- Other page Modal Structure -->
<div id="efbl-other-pages-upgrade" class="fta-upgrade-modal modal">
    <div class="modal-content">

        <div class="mif-modal-content"> <span class="mif-lock-icon"><i class="material-icons dp48">lock_outline</i> </span>
            <h5><?php esc_html_e("Premium Feature", 'easy-facebook-likebox');?></h5>
            <p><?php esc_html_e("We're sorry, ability to display posts from other pages not managed by you is not included in your plan. Please upgrade to premium version to unlock this and all other cool features.", 'easy-facebook-likebox');?></p>
            <p><?php esc_html_e('Upgrade today and get a 10% discount! On the checkout click on "Have a promotional code?', 'easy-facebook-likebox');?></p>
            <hr />
            <a href="<?php echo efl_fs()->get_upgrade_url() ?>" class="waves-effect waves-light btn"><i class="material-icons right">lock_open</i><?php esc_html_e("Upgrade to pro", 'easy-facebook-likebox');?></a>

        </div>
    </div>

</div> 

<!-- Other page Modal Structure Ends--> 

<!-- Tabs Modal Structure -->
<div id="efbl-tabs-upgrade" class="fta-upgrade-modal modal">
    <div class="modal-content">

        <div class="mif-modal-content"> <span class="mif-lock-icon"><i class="material-icons dp48">lock_outline</i> </span>
            <h5><?php esc_html_e("Premium Feature", 'easy-facebook-likebox');?></h5>
            <p><?php esc_html_e("We are sorry showing tabs in likebox feature is not included in your plan. Please upgrade to premium version to unlock this and all other cool features.", 'easy-facebook-likebox');?></p>
            <p><?php esc_html_e('Upgrade today and get a 10% discount! On the checkout click on "Have a promotional code?', 'easy-facebook-likebox');?></p>
            <hr />
            <a href="<?php echo efl_fs()->get_upgrade_url() ?>" class="waves-effect waves-light btn"><i class="material-icons right">lock_open</i><?php esc_html_e("Upgrade to pro", 'easy-facebook-likebox');?></a>

        </div>
    </div>

</div> 

<!-- Filter Tabs Structure Ends--> 

<!-- Select pages Modal Structure -->
<div id="efbl-pages-enable" class="fta-upgrade-modal modal">
    <div class="modal-content">

        <div class="mif-modal-content"> <span class="mif-lock-icon"><i class="material-icons dp48">lock_outline</i> </span>
            <h5><?php esc_html_e("Premium Feature", 'easy-facebook-likebox');?></h5>
            <p><?php esc_html_e("We are sorry showing popup on specific pages feature is not included in your plan. Please upgrade to premium version to unlock this and all other cool features.", 'easy-facebook-likebox');?></p>
            <p><?php esc_html_e('Upgrade today and get a 10% discount! On the checkout click on "Have a promotional code?', 'easy-facebook-likebox');?></p>
            <hr />
            <a href="<?php echo efl_fs()->get_upgrade_url() ?>" class="waves-effect waves-light btn"><i class="material-icons right">lock_open</i><?php esc_html_e("Upgrade to pro", 'easy-facebook-likebox');?></a>

        </div>
    </div>

</div> 

<!-- Select pages Structure Ends--> 

<!-- Select posts Structure -->
<div id="efbl-posts-enable" class="fta-upgrade-modal modal">
    <div class="modal-content">

        <div class="mif-modal-content"> <span class="mif-lock-icon"><i class="material-icons dp48">lock_outline</i> </span>
            <h5><?php esc_html_e("Premium Feature", 'easy-facebook-likebox');?></h5>
            <p><?php esc_html_e("We're sorry, ability to display posts from other pages not managed by you is not included in your plan. Please upgrade to premium version to unlock this and all other cool features.", 'easy-facebook-likebox');?></p>
            <p><?php esc_html_e('Upgrade today and get a 10% discount! On the checkout click on "Have a promotional code?', 'easy-facebook-likebox');?></p>
            <hr />
            <a href="<?php echo efl_fs()->get_upgrade_url() ?>" class="waves-effect waves-light btn"><i class="material-icons right">lock_open</i><?php esc_html_e("Upgrade to pro", 'easy-facebook-likebox');?></a>

        </div>
    </div>

</div> 

<!-- Select posts Structure Ends--> 

<!-- exit intent  Structure -->
<div id="efbl-exit-intent" class="fta-upgrade-modal modal">
    <div class="modal-content">

        <div class="mif-modal-content"> <span class="mif-lock-icon"><i class="material-icons dp48">lock_outline</i> </span>
            <h5><?php esc_html_e("Premium Feature", 'easy-facebook-likebox');?></h5>
            <p><?php esc_html_e("We are sorry showing popup on exit intent feature is not included in your plan. Please upgrade to premium version to unlock this and all other cool features.", 'easy-facebook-likebox');?></p>
            <p><?php esc_html_e('Upgrade today and get a 10% discount! On the checkout click on "Have a promotional code?', 'easy-facebook-likebox');?></p>  
            <hr />
            <a href="<?php echo efl_fs()->get_upgrade_url() ?>" class="waves-effect waves-light btn"><i class="material-icons right">lock_open</i><?php esc_html_e("Upgrade to pro", 'easy-facebook-likebox');?></a>

        </div>
    </div>

</div> 

<?php if ( efl_fs()->is_free_plan()  ||  efl_fs()->is_plan('instagram_premium', true) ) { ?>

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