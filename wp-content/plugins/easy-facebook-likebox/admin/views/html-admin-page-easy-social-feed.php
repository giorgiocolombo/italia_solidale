<?php
  /**
  * Admin View: Page - Easy Social Feed
  */
  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }

  $FTA = new Feed_Them_All();

  $fta_all_plugs = $FTA->fta_plugins();

  ?>	
  <div class="esf_loader_wrap">
    <div class="esf_loader_inner">
      <div class="loader"></div>
    </div>
  </div>
  <h1 class="esf-main-heading"><?php esc_html_e("Easy Social Feed (Previously Easy Facebook Likebox)", 'easy-facebook-likebox');?></h1>
  <div class="fta_wrap z-depth-1">
    <div class="fta_wrap_inner">
      <div class="fta_tabs_holder">
        <div class="fta_tabs_header">
          <div class="fta_sliders_wrap">
           <div id="fta_sliders">
            <span>
              <div class="box"></div>
            </span>
            <span>
              <div class="box"></div>
            </span>
            <span>
              <div class="box"></div>
            </span>
          </div>

        </div>
      </div>
      <div class="fta_tab_c_holder">
        <div class="row">
         <h5><?php esc_html_e("Welcome to the modules management page.", 'easy-facebook-likebox');?></h5>
         <p><?php esc_html_e("You can disable or enable the modules you are not using to only include resources you need. If you are using all features, then keep these active.", 'easy-facebook-likebox');?></p>    

         <?php if( $fta_all_plugs ) : ?>

          <div class="fta_all_plugs col s12">

            <?php foreach( $fta_all_plugs as $fta_plug) : 


              if( $fta_plug['img_name'] ) {

               $img_url = FTA_PLUGIN_URL . 'assets/images/'.$fta_plug['img_name'].'';

             } else{
              $img_url = '';
            }

            if( $fta_plug['activate_slug'] ) {

              $slug = $fta_plug['activate_slug'];

            } else{

              $slug = '';
            }

            if( $fta_plug['status'] ) {

              $status = $fta_plug['status'];

            } else{

              $status = '';
            }

            if( ( $fta_plug['status'] ) && ( $fta_plug['status'] == 'activated') ){

              $btn = __( 'Deactivate', $FTA->fta_slug ); 

            }else{

              $btn = __( 'Activate',$FTA->fta_slug ); 
            }



            ?>     
            <div class="card col fta_single_plug s5 fta_plug_<?php echo $slug ?>  fta_plug_<?php echo $status; ?>">
              <div class="card-image waves-effect waves-block waves-light">

                <?php if( $fta_plug['img_name'] ) { ?>

                  <img src="<?php echo FTA_PLUGIN_URL ?>/admin/assets/images/<?php echo $fta_plug['img_name']; ?>">

                <?php } ?>  

              </div>
              <div class="card-content">

                <?php if( $fta_plug['name'] ) { ?>

                 <span class="card-title  grey-text text-darken-4"><?php echo $fta_plug['name'] ?></span>

               <?php } ?> 

             </div>
             <hr>
             <div class="fta_cta_holder">

               <?php if( $fta_plug['description'] ) { ?>

                 <?php echo $fta_plug['description'] ?>

               <?php } ?> 

               <a class="btn waves-effect fta_plug_activate waves-light" data-status="<?php echo $status; ?>" data-plug="<?php echo $slug ?>" href="#"><?php echo $btn; ?></a>

               <?php if( $fta_plug['slug'] ) { ?>

                <a class="btn waves-effect fta_setting_btn right waves-light" href="<?php echo esc_url( admin_url('admin.php?page='.$fta_plug['slug'])); ?>"><?php esc_html_e("Settings", 'easy-facebook-likebox');?></a>

              <?php } ?>    

            </div>

         </div>
       <?php endforeach;
     endif;
     ?> 
   </div>
 </div>  
</div>  
</div>
</div>

<?php if( efl_fs()->is_free_plan() ){ ?>

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