<?php

/*
* Stop execution if someone tried to get file directly.
*/
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if( !class_exists('ESF_Admin') ) {

    class ESF_Admin{

        function __construct(){
          
            add_action( 'admin_menu', array( $this, 'esf_menu' ) );

            add_action( 'admin_head', array( $this, 'esf_debug_token' ) );

            add_action( 'admin_enqueue_scripts', array( $this, 'esf_admin_assets' ) );

            add_action( 'wp_ajax_esf_change_module_status', array( $this, 'esf_change_module_status' ) );

            add_action( 'wp_ajax_esf_remove_access_token', array( $this, 'esf_remove_access_token' ) );

            add_action( 'admin_notices', array( $this, 'esf_admin_notice' ) );

            add_filter('admin_footer_text', array($this, 'esf_admin_footer_text'));

            add_action( 'wp_ajax_esf_hide_rating_notice', array( $this, 'esf_hide_rating_notice' ) );

            add_action( 'admin_head',  array( $this, 'esf_hide_notices'));

            add_action( 'pre_get_posts' ,  array( $this, 'esf_exclude_demo_pages' ), 1 );            
            
        }

        public function esf_hide_notices(){

            $screen = get_current_screen();

            if($screen->base == 'admin_page_esf_welcome'):
                remove_all_actions( 'admin_notices' );
            endif;    

            echo "<style>.toplevel_page_feed-them-all .wp-menu-image img{padding-top: 4px!important;}</style>";
            
        }


    /*
     * Includes common admin scripts and styles for FB and Insta.
     */
    public function esf_admin_assets( $hook ){


        /*
         * Loading plugin assets only on it's own pages
         */
        if ( 'toplevel_page_feed-them-all' !== $hook && 'easy-social-feed_page_mif' !== $hook && 'easy-social-feed_page_easy-facebook-likebox' !== $hook && 'admin_page_esf_welcome' !== $hook && 'easy-social-feed_page_esf_recommendations' !== $hook) return;

        wp_deregister_script( 'bootstrap.min');

        wp_deregister_script( 'bootstrap');

        wp_deregister_script( 'jquery-ui-tabs');

        
        wp_enqueue_style( 'materialize.min', FTA_PLUGIN_URL . 'admin/assets/css/materialize.min.css' );
        
        wp_enqueue_style( 'esf-animations', FTA_PLUGIN_URL . 'admin/assets/css/esf-animations.css' );

        wp_enqueue_style( 'esf-admin', FTA_PLUGIN_URL . 'admin/assets/css/esf-admin.css' );

        wp_enqueue_script( 'materialize.min', FTA_PLUGIN_URL . 'admin/assets/js/materialize.min.js', array( 'jquery' ) );
        
        wp_enqueue_script( 'jquery-effects-slide' );
        
        wp_enqueue_script( 'clipboard' );
        
        wp_enqueue_script( 'esf-admin', FTA_PLUGIN_URL . 'admin/assets/js/esf-admin.js', array( 'jquery' ) );
        
        wp_localize_script( 'esf-admin', 'fta', array(
            'ajax_url'     => admin_url( 'admin-ajax.php' ),
            'nonce' => wp_create_nonce('fta-ajax-nonce')
        ) );

        wp_enqueue_script( 'media-upload' );

        wp_enqueue_media();
    }
    
    
    /*
     * Adds plugin menus in dashboard
     */
    public function esf_menu(){
        
        add_menu_page(
            __('Easy Social Feed', 'easy-facebook-likebox'),
            __('Easy Social Feed', 'easy-facebook-likebox'),
            'administrator',
            'feed-them-all',
            array( $this, 'esf_page' ),
            FTA_PLUGIN_URL . 'admin/assets/images/plugin_icon.png'
        );

        add_submenu_page(
            null,
            __( 'Welcome', 'easy-facebook-likebox' ),
            __( 'Welcome', 'easy-facebook-likebox' ),
            'administrator',
            'esf_welcome',
            array( $this, 'esf_welcome_page' )
        );

         if(efl_fs()->is_free_plan()){

            add_submenu_page(
                'feed-them-all',
                __( 'Recommendations', 'easy-facebook-likebox' ),
                __( 'Recommendations', 'easy-facebook-likebox' ),
                'administrator',
                'esf_recommendations',
                array( $this, 'esf_recommendations_page' ),
                4
            );
         }

        $token_valid = $this->esf_access_token_valid();

        /* If access token is inavlid show the notification counter */
        if( !$token_valid['is_valid'] ) {

            global $menu;
            
            $menu_item = wp_list_filter(
                $menu,
                array( 2 => 'feed-them-all' )
            );
            
            if ( ! empty( $menu_item )  ) {
                $menu_item_position = key( $menu_item );
                $menu[ $menu_item_position ][0] .= ' <span class="awaiting-mod">1</span>';
            }
        }
        
    }


   /*
    * Includes view of welcome page
    * Returns HTML.
    */
   function esf_welcome_page(){

    include_once FTA_PLUGIN_DIR . 'admin/views/html-admin-page-wellcome.php';

}

    /*
    * Includes view of recommendations page
    * Returns HTML.
    */
    function esf_recommendations_page(){

        include_once FTA_PLUGIN_DIR . 'admin/views/html-admin-page-recommendations.php';

    }
    
    
   /*
    * Includes view of Easy Soical Feed page
    * Returns HTML.
    */
   function esf_page(){

    include_once FTA_PLUGIN_DIR . 'admin/views/html-admin-page-easy-social-feed.php';


}/* fta_page method ends here. */



    /*
     * Changes the module status like enable or disable Facebook/Instagram modules
     */
    function esf_change_module_status(){

        $module_name = sanitize_text_field($_POST['plugin']);

        $module_status = sanitize_text_field($_POST['status']);

        $Feed_Them_All = new Feed_Them_All();

        $esf_settings = $Feed_Them_All->fta_get_settings();

        $esf_settings['plugins'][$module_name]['status'] = $module_status;

        if(wp_verify_nonce( $_POST['fta_nonce'], 'fta-ajax-nonce' )):

         if(current_user_can('editor') || current_user_can('administrator')):

            
            $status_updated = update_option( 'fta_settings', $esf_settings );
            endif;
        endif;

        if($module_status == 'activated'){

         $status = __( ' Activated', $Feed_Them_All->fta_slug ); 

        }else{

            $status = __( ' Deactivated', $Feed_Them_All->fta_slug ); 
        }


        if ( isset( $status_updated ) ) {

            echo  wp_send_json_success( __( ucfirst($module_name) . $status . ' Successfully', $Feed_Them_All->fta_slug ) ); wp_die();

        } else {

            echo  wp_send_json_error( __( 'Something Went Wrong! Please try again.', $Feed_Them_All->fta_slug ) ) ; wp_die();

        }
        exit;

        }


    /*
     * Removes the access token and deletes users access to the app.
     */
    function esf_remove_access_token(){

        $Feed_Them_All = new Feed_Them_All();

        $esf_settings = $Feed_Them_All->fta_get_settings();


        if(wp_verify_nonce( $_POST['fta_nonce'], 'fta-ajax-nonce' )):

         if(current_user_can('editor') || current_user_can('administrator')):

            $access_token = $esf_settings['plugins']['facebook']['access_token'];

        unset($esf_settings['plugins']['facebook']['approved_pages']);

        unset($esf_settings['plugins']['facebook']['access_token']);

        $esf_settings['plugins']['instagram']['selected_type'] = 'personal';
        
        $delted_data = update_option( 'fta_settings', $esf_settings );

        $response = wp_remote_request( 'https://graph.facebook.com/v4.0/me/permissions?access_token='.$access_token.'',
            array(
                'method'     => 'DELETE'
            )
        );
        
        $body = wp_remote_retrieve_body($response);

    endif;

endif;

if ( $delted_data ) {

    echo  wp_send_json_success( __( 'Deleted', $Feed_Them_All->fta_slug ) ); wp_die();

}else{
    
    echo  wp_send_json_error( __( 'Something Went Wrong! Please try again.', $Feed_Them_All->fta_slug ) ); wp_die();
}
exit;

}

    /**
    * Displays the admin notices
    */
    public function esf_admin_notice(){  

        if ( !current_user_can( 'install_plugins' ) ) { return; }

        global $pagenow;

        $Feed_Them_All = new Feed_Them_All();

        $install_date = $Feed_Them_All->fta_get_settings( 'installDate' );

        $fta_settings = $Feed_Them_All->fta_get_settings();

        $display_date = date( 'Y-m-d h:i:s' );

        $datetime1 = new DateTime( $install_date );

        $datetime2 = new DateTime( $display_date );

        $diff_intrval = round( ($datetime2->format( 'U' ) - $datetime1->format( 'U' )) / (60 * 60 * 24) );


        if ( $diff_intrval >= 6 && get_site_option( 'fta_supported' ) != "yes" ) { ?>

            <div style="position:relative;padding-right:80px;background: #fff;" class="update-nag fta_msg fta_review">
                
                <p><?php esc_html_e("Awesome, you have been using", 'easy-facebook-likebox');?><b><?php esc_html_e("Easy Social Feed", 'easy-facebook-likebox');?></b>
                    <?php esc_html_e("for more than 1 week.", 'easy-facebook-likebox');?>
                </p>

                <p><?php esc_html_e("May I ask you to give it a ", 'easy-facebook-likebox');?>
                <b><?php esc_html_e("5-star", 'easy-facebook-likebox');?></b>
                <?php esc_html_e("rating on Wordpress?", 'easy-facebook-likebox');?>
            </p>

            <p><?php esc_html_e("This will help to spread its popularity and to make this plugin a better one.", 'easy-facebook-likebox');?></p>

            <p><?php esc_html_e("Your help is much appreciated. Thank you very much.", 'easy-facebook-likebox');?></p>

            <p style="margin-left:5px;">~<?php esc_html_e("Danish Ali Malik (@danish-ali)", 'easy-facebook-likebox');?></p>
            
            <div class="fl_support_btns">

                <a href="https://wordpress.org/support/plugin/easy-facebook-likebox/reviews/?filter=5#new-post" class="esf_HideRating button button-primary" target="_blank">
                    <?php esc_html_e("I Like Easy Social Feed - It increased engagement on my site", 'easy-facebook-likebox');?>
                </a>

                <a href="javascript:void(0);" class="esf_HideRating button" >
                    <?php esc_html_e("I already rated it", 'easy-facebook-likebox');?>
                </a>

                <br>
                <a style="margin-top:5px;float:left;" href="javascript:void(0);" class="esf_HideRating" >
                    <?php esc_html_e("No, not good enough, I do not like to rate it", 'easy-facebook-likebox');?>
                </a>

                <div class="esf_HideRating" style="position:absolute;right:10px;cursor:pointer;top:4px;color: #029be4;"> <div style="font-weight:bold;" class="dashicons dashicons-no-alt"></div><span style="margin-left: 2px;"><?php esc_html_e("Dismiss", 'easy-facebook-likebox');?></span></div>
            </div>
        </div>

    <?php  }

    $screen = get_current_screen();

    $arr = array('easy-social-feed_page_mif', 'toplevel_page_feed-them-all', 'easy-social-feed_page_easy-facebook-likebox');
    
             
         $insta_selected_type = '';

            /**
             * Display notification if access token is not valid
             */
            $token_valid = $this->esf_access_token_valid();

            if( isset($fta_settings['plugins']['instagram']['selected_type']) ){

                $insta_selected_type = $fta_settings['plugins']['instagram']['selected_type'];

            }
            

            if( $insta_selected_type == 'personal'){

                unset($arr[0]);

            } 

            if( !$token_valid['is_valid'] && in_array($screen->id, $arr) ) { ?>

                <div class="update-nag fta_upgraded_msg" style="border-color: #ed6d62;">
                    <p><?php echo $token_valid['error_message']; ?></p>
                </div>

                

            <?php  }    
        }     

    /**
    * Hide rating notice permenately
    */
    public function esf_hide_rating_notice(){

        update_site_option( 'fta_supported', 'yes' );

        echo  json_encode( array( "success" ) ); wp_die();
    } 

    
     /**
       * Add powered by text in admin footer
    */
     function esf_admin_footer_text($text){

        $screen = get_current_screen();

        $arr = array('easy-social-feed_page_mif', 'toplevel_page_feed-them-all', 'easy-social-feed_page_feed-them-all-account', 'easy-social-feed_page_feed-them-all-contact', 'easy-social-feed_page_feed-them-all-pricing', 'easy-social-feed_page_easy-facebook-likebox', 'easy-social-feed_page_esf_recommendations');

        if( in_array($screen->id, $arr) ){

           $fta_class = new Feed_Them_All();
           $text = '<i><a href="' . admin_url( '?page=feed-them-all' ) . '" title="' . __( 'Visit Easy Social Feed page for more info', 'easy-facebook-likebox' ) . '">ESPF</a> v' . $fta_class->version . '. Please <a target="_blank" href="https://wordpress.org/support/plugin/easy-facebook-likebox/reviews/?filter=5#new-post" title="Rate the plugin">rate the plugin <span style="color: #ffb900;" class="stars">&#9733; &#9733; &#9733; &#9733; &#9733; </span></a> to help us spread the word. Thank you from the Easy Social Feed team!</i><div style="margin-left:5px;top: 1px;" class="fb-like" data-href="https://www.facebook.com/easysocialfeed" data-width="" data-layout="button" data-action="like" data-size="small" data-share="false"></div><div id="fb-root"></div><script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v6.0&appId=1983264355330375&autoLogAppEvents=1"></script><style>#wpfooter{ bottom: auto;background-color: #fff;padding: 15px 20px;-webkit-box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.12), 0 1px 5px 0 rgba(0,0,0,.2);box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.12), 0 1px 5px 0 rgba(0,0,0,.2);}.fb_iframe_widget{float:left;}#wpfooter a{text-decoration:none;}</style>';
        }

        return $text;  
        
    } 

    function esf_get_plugin_install_link($slug){

     $action = 'install-plugin';
     $esf_wpoptin_install = wp_nonce_url(
        add_query_arg(
            array(
                'action' => $action,
                'plugin' => $slug
            ),
            admin_url( 'update.php' )
        ),
        $action.'_'.$slug
    );
     return  $esf_wpoptin_install;    
 }  

 function esf_exclude_demo_pages( $query ) {
    if( !is_admin() )
        return $query;
    global $pagenow;
    
    if( 'edit.php' == $pagenow && ( get_query_var('post_type') && 'page' == get_query_var('post_type') ) ){
        $fta_class = new Feed_Them_All();

        $fta_settings = $fta_class->fta_get_settings();

        if(isset($fta_settings['plugins']['facebook']['default_page_id'])) $fb_id = $fta_settings['plugins']['facebook']['default_page_id'];

        if(isset($fta_settings['plugins']['instagram']['default_page_id'])) $insta_id = $fta_settings['plugins']['instagram']['default_page_id'];

             if( $fb_id || $insta_id ) $query->set( 'post__not_in', array($fb_id, $insta_id ) ); // array page ids
         }


         
         return $query;
     }

    /**
     * Debug the token and save info in DB
     */ 
    public function esf_debug_token(){


        if( class_exists('Feed_Them_All') ) {

            $FTA = new Feed_Them_All();

            $fta_settings = $FTA->fta_get_settings();

            $access_token = '';

            $access_token_info = '';

            if( isset($fta_settings['plugins']['facebook']['access_token']) ){

                 $access_token = $fta_settings['plugins']['facebook']['access_token'];
            }

            if( isset($fta_settings['plugins']['facebook']['access_token_info']) ){

                $access_token_info = $fta_settings['plugins']['facebook']['access_token_info'];
            }
        

        }

        if( !$access_token ) return;

        if( $access_token_info ) return;


        /*
         * Access token debug API endpoint
         */
        $fb_token_debug_url =  add_query_arg( array(
            'input_token' => $access_token,
            'access_token' => $access_token,
        ), 'https://graph.facebook.com/v6.0/debug_token' ) ;


        $fb_token_info = wp_remote_get( $fb_token_debug_url );

        if ( is_array( $fb_token_info ) && ! is_wp_error( $fb_token_info ) ) {

            $fb_token_info = json_decode( $fb_token_info['body'] ); 

            if( isset( $fb_token_info->error ) ) return;

            if( isset( $fb_token_info->data ) ){

                $fta_settings['plugins']['facebook']['access_token_info']['data_access_expires_at'] = $fb_token_info->data->data_access_expires_at;

                $fta_settings['plugins']['facebook']['access_token_info']['expires_at'] = $fb_token_info->data->expires_at;

                $fta_settings['plugins']['facebook']['access_token_info']['is_valid'] = $fb_token_info->data->is_valid;

                $fta_settings['plugins']['facebook']['access_token_info']['issued_at'] = $fb_token_info->data->issued_at;

                update_option( 'fta_settings', $fta_settings ); return;

            }

        }   

    }

    /**
     * Check the access token validity if exists.
     * @return is_valid and reason
     */ 
    public function esf_access_token_valid(){


        if( class_exists('Feed_Them_All') ) {

            $FTA = new Feed_Them_All();

            $fta_settings = $FTA->fta_get_settings();

            $access_token_info = '';

            if( isset($fta_settings['plugins']['facebook']['access_token_info'] ) ) {

                $access_token_info = $fta_settings['plugins']['facebook']['access_token_info'];

                $data_access_expires_at = $access_token_info['data_access_expires_at'];

                $expires_at = $access_token_info['expires_at'];

                $is_valid = $access_token_info['is_valid'];
            }
         

        }

        if( !$access_token_info ){

            return array( 'is_valid' => true );
        } 

        $return_arr = array( 'is_valid' => true );

        $current_timestamp = time();

        if(  $data_access_expires_at <=  $current_timestamp ) {

            $return_arr =  array( 'is_valid' => false, 'reason' => 'data_access_expired', 'error_message' => __( "Attention! Data access to the current access token in expired. Please reauthenticate the app.", 'easy-facebook-likebox' ) );

        }

        if( ( $expires_at > 0 ) && (  $expires_at <=  $current_timestamp  ) ){

            $return_arr =  array( 'is_valid' => false, 'reason' => 'token_expired', 'error_message' => __( "Attention! Access token in expired. Please reauthenticate the app.", 'easy-facebook-likebox' ) );

        }


        return $return_arr;

    }
}

$ESF_Admin = new ESF_Admin();

}