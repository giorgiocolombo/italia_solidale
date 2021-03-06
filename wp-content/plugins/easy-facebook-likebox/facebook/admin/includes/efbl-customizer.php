<?php

/*
* Stop execution if someone tried to get file directly.
*/
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
//======================================================================
// Customizer code Of My Instagram Feeds
//======================================================================

if ( !class_exists( 'EFBL_Cuustomizer' ) ) {
    class EFBL_Cuustomizer
    {
        /*
         * __construct initialize all function of this class.
         * Returns nothing. 
         * Used action_hooks to get things sequentially.
         */
        function __construct()
        {
            /*
             * customize_register hook will add custom files in customizer.
             */
            add_action( 'customize_register', array( $this, 'efbl_customizer' ) );
            /*
             * customize_preview_init hook will add our js file in customizer.
             */
            add_action( 'customize_preview_init', array( $this, 'efbl_live_preview' ) );
            /*
             * customize_preview_init hook will add our js file in customizer.
             */
            add_action( 'customize_controls_enqueue_scripts', array( $this, 'efbl_customizer_scripts' ) );
            /*
             * wp_head hooks fires when page head is load.
             * Css file will be added in head.
             */
            // add_action( 'wp_head', array( $this, 'efbl_customize_css' ) );
        }
        
        /* __construct Method ends here. */
        /*
         * efbl_customizer holds cutomizer files.
         */
        function efbl_customizer_scripts()
        {
            /*
             * Enqueing customizer style file.
             */
            wp_enqueue_style( 'efbl_customizer_style', EFBL_PLUGIN_URL . 'admin/assets/css/efbl-customizer.css' );
        }
        
        /* efbl_customizer_scripts Method ends here. */
        /*
         * efbl_customizer holds code for customizer area.
         */
        public function efbl_customizer( $wp_customize )
        {
            $Feed_Them_All = new Feed_Them_All();
            /* Getting the skin id from URL and saving in option for confliction.*/
            
            if ( isset( $_GET['efbl_skin_id'] ) ) {
                $skin_id = $_GET['efbl_skin_id'];
                update_option( 'efbl_skin_id', $skin_id );
            }
            
            
            if ( isset( $_GET['efbl_account_id'] ) ) {
                $efbl_account_id = $_GET['efbl_account_id'];
                update_option( 'efbl_account_id', $efbl_account_id );
            }
            
            /* Getting back the skin saved ID.*/
            $skin_id = get_option( 'efbl_skin_id', false );
            /* Getting the saved values.*/
            $skin_values = get_option( 'efbl_skin_' . $skin_id, false );
            $selected_layout = get_post_meta( $skin_id, 'layout', true );
            if ( !$selected_layout ) {
                $selected_layout = $skin_values['layout_option'];
            }
            global  $EFBL_SKINS ;
            //======================================================================
            // Easy Facebook Likebox Section
            //======================================================================
            /* Adding our efbl panel in customizer.*/
            $wp_customize->add_panel( 'efbl_customize_panel', array(
                'title' => __( 'Easy Facebook Feed', $Feed_Them_All->plug_slug ),
            ) );
            //======================================================================
            // Layout section
            //======================================================================
            /* Adding layout section in customizer under efbl panel.*/
            $wp_customize->add_section( 'efbl_layout', array(
                'title'       => __( 'Layout Settings', $Feed_Them_All->plug_slug ),
                'description' => __( 'Select the layout settings in real-time.', $Feed_Them_All->plug_slug ),
                'priority'    => 35,
                'panel'       => 'efbl_customize_panel',
            ) );
            
            if ( 'grid' == $selected_layout ) {
                $efbl_cols_transport = 'postMessage';
            } else {
                $efbl_cols_transport = 'refresh';
            }
            
            
            if ( efl_fs()->is_plan( 'facebook_premium', true ) or efl_fs()->is_plan( 'combo_premium', true ) ) {
            } else {
                $wp_customize->add_control( new Customize_EFBL_PopUp( $wp_customize, 'efbl_layout_upgrade', array(
                    'settings'    => array(),
                    'label'       => __( 'Layout Settings', $Feed_Them_All->plug_slug ),
                    'section'     => 'efbl_layout',
                    'description' => __( 'We are sorry, Layout settings are not included in your plan. Please upgrade to premium version to unlock following settings<ul>
                					 <li>Number Of Columns</li>
                					 <li>Show Or Hide Load More Button</li>
                					 <li>Load More Background Color</li>
                					 <li>Load More Color</li>
                					 <li>Load More Hover Background Color</li>
                					 <li>Load More Hover Color</li>
                					 </ul>', $Feed_Them_All->plug_slug ),
                    'popup_id'    => 'efbl_layout_upgrade',
                ) ) );
            }
            
            //======================================================================
            // Header section
            //======================================================================
            $wp_customize->add_section( 'efbl_header', array(
                'title'       => __( 'Header', $Feed_Them_All->plug_slug ),
                'description' => __( 'Customize the Header In Real Time', $Feed_Them_All->plug_slug ),
                'priority'    => 35,
                'panel'       => 'efbl_customize_panel',
            ) );
            $setting = 'efbl_skin_' . $skin_id . '[show_header]';
            $wp_customize->add_setting( $setting, array(
                'default'   => false,
                'transport' => 'refresh',
                'type'      => 'option',
            ) );
            $wp_customize->add_control( $setting, array(
                'label'       => __( 'Show Or Hide Header', $Feed_Them_All->plug_slug ),
                'section'     => 'efbl_header',
                'settings'    => $setting,
                'description' => __( 'Show or hide page header.', $Feed_Them_All->plug_slug ),
                'type'        => 'checkbox',
            ) );
            $setting = 'efbl_skin_' . $skin_id . '[header_background_color]';
            $wp_customize->add_setting( $setting, array(
                'default'   => '#fff',
                'transport' => 'postMessage',
                'type'      => 'option',
            ) );
            $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $setting, array(
                'label'       => __( 'Header Background Color', $Feed_Them_All->plug_slug ),
                'section'     => 'efbl_header',
                'settings'    => $setting,
                'description' => __( 'Select the background color of header.', $Feed_Them_All->plug_slug ),
            ) ) );
            $setting = 'efbl_skin_' . $skin_id . '[header_text_color]';
            $wp_customize->add_setting( $setting, array(
                'default'   => '#000',
                'transport' => 'postMessage',
                'type'      => 'option',
            ) );
            $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $setting, array(
                'label'       => __( 'Header Text Color', $Feed_Them_All->plug_slug ),
                'section'     => 'efbl_header',
                'settings'    => $setting,
                'description' => __( 'Select the content color in header.', $Feed_Them_All->plug_slug ),
            ) ) );
            $setting = 'efbl_skin_' . $skin_id . '[title_size]';
            $wp_customize->add_setting( $setting, array(
                'default'   => 16,
                'transport' => 'postMessage',
                'type'      => 'option',
            ) );
            $wp_customize->add_control( $setting, array(
                'label'       => __( 'Title Size', $Feed_Them_All->plug_slug ),
                'section'     => 'efbl_header',
                'settings'    => $setting,
                'description' => __( 'Select the text size of profile name.', $Feed_Them_All->plug_slug ),
                'type'        => 'number',
                'input_attrs' => array(
                'min' => 0,
                'max' => 100,
            ),
            ) );
            $setting = 'efbl_skin_' . $skin_id . '[header_shadow]';
            $wp_customize->add_setting( $setting, array(
                'default'   => false,
                'transport' => 'postMessage',
                'type'      => 'option',
            ) );
            $wp_customize->add_control( $setting, array(
                'label'       => __( 'Show Or Hide Box Shadow', $Feed_Them_All->plug_slug ),
                'section'     => 'efbl_header',
                'settings'    => $setting,
                'description' => __( 'Show or Hide box shadow.', $Feed_Them_All->plug_slug ),
                'type'        => 'checkbox',
            ) );
            $setting = 'efbl_skin_' . $skin_id . '[header_shadow_color]';
            $wp_customize->add_setting( $setting, array(
                'default'   => 'rgba(0,0,0,0.15)',
                'type'      => 'option',
                'transport' => 'postMessage',
            ) );
            $wp_customize->add_control( new Customize_Alpha_Color_Control( $wp_customize, $setting, array(
                'label'        => __( 'Shadow color', $Feed_Them_All->plug_slug ),
                'section'      => 'efbl_header',
                'settings'     => $setting,
                'show_opacity' => true,
            ) ) );
            
            if ( efl_fs()->is_plan( 'facebook_premium', true ) or efl_fs()->is_plan( 'combo_premium', true ) ) {
            } else {
                $wp_customize->add_control( new Customize_EFBL_PopUp( $wp_customize, 'efbl_dp_upgrade', array(
                    'settings'    => array(),
                    'label'       => __( 'Show Or Hide Display Picture', $Feed_Them_All->plug_slug ),
                    'section'     => 'efbl_header',
                    'description' => __( 'We are sorry, “Show Or Hide Display Picture” is a premium feature.', $Feed_Them_All->plug_slug ),
                    'popup_id'    => 'efbl_dp_upgrade',
                ) ) );
                $wp_customize->add_control( new Customize_EFBL_PopUp( $wp_customize, 'efbl_round_dp_upgrade', array(
                    'settings'    => array(),
                    'label'       => __( 'Round Display Picture', $Feed_Them_All->plug_slug ),
                    'section'     => 'efbl_header',
                    'description' => __( 'We are sorry, “Round Display Picture” is a premium feature.', $Feed_Them_All->plug_slug ),
                    'popup_id'    => 'efbl_round_dp_upgrade',
                ) ) );
            }
            
            $setting = 'efbl_skin_' . $skin_id . '[metadata_size]';
            $wp_customize->add_setting( $setting, array(
                'default'   => 16,
                'transport' => 'postMessage',
                'type'      => 'option',
            ) );
            $wp_customize->add_control( $setting, array(
                'label'       => __( 'Size of total followers', $Feed_Them_All->plug_slug ),
                'section'     => 'efbl_header',
                'settings'    => $setting,
                'description' => __( 'Select the text size of total followers in the header.', $Feed_Them_All->plug_slug ),
                'type'        => 'number',
                'input_attrs' => array(
                'min' => 0,
                'max' => 100,
            ),
            ) );
            
            if ( efl_fs()->is_plan( 'facebook_premium', true ) or efl_fs()->is_plan( 'combo_premium', true ) ) {
            } else {
                $wp_customize->add_control( new Customize_EFBL_PopUp( $wp_customize, 'efbl_head_hide_bio_upgrade', array(
                    'settings'    => array(),
                    'label'       => __( 'Show Or Hide Bio', $Feed_Them_All->plug_slug ),
                    'section'     => 'efbl_header',
                    'description' => __( 'We are sorry, “Show Or Hide Bio” is a premium feature.', $Feed_Them_All->plug_slug ),
                    'popup_id'    => 'efbl_head_hide_bio_upgrade',
                ) ) );
                $wp_customize->add_control( new Customize_EFBL_PopUp( $wp_customize, 'efbl_head_border_color_upgrade', array(
                    'settings'    => array(),
                    'label'       => __( 'Text Size of Bio', $Feed_Them_All->plug_slug ),
                    'section'     => 'efbl_header',
                    'description' => __( 'We are sorry, “Text Size of Bio” is a premium feature.', $Feed_Them_All->plug_slug ),
                    'popup_id'    => 'efbl_head_border_color_upgrade',
                ) ) );
                $wp_customize->add_control( new Customize_EFBL_PopUp( $wp_customize, 'efbl_head_border_color_upgrade', array(
                    'settings'    => array(),
                    'label'       => __( 'Header Border Color', $Feed_Them_All->plug_slug ),
                    'section'     => 'efbl_header',
                    'description' => __( 'We are sorry, “Header Border Color” is a premium feature.', $Feed_Them_All->plug_slug ),
                    'popup_id'    => 'efbl_head_border_color_upgrade',
                ) ) );
                $wp_customize->add_control( new Customize_EFBL_PopUp( $wp_customize, 'efbl_head_border_style_upgrade', array(
                    'settings'    => array(),
                    'label'       => __( 'Border Style', $Feed_Them_All->plug_slug ),
                    'section'     => 'efbl_header',
                    'description' => __( 'We are sorry, “Border Style” is a premium feature.', $Feed_Them_All->plug_slug ),
                    'popup_id'    => 'efbl_head_border_style_upgrade',
                ) ) );
                $wp_customize->add_control( new Customize_EFBL_PopUp( $wp_customize, 'efbl_head_border_top_size_upgrade', array(
                    'settings'    => array(),
                    'label'       => __( 'Border Top', $Feed_Them_All->plug_slug ),
                    'section'     => 'efbl_header',
                    'description' => __( 'We are sorry, “Border Top” is a premium feature.', $Feed_Them_All->plug_slug ),
                    'popup_id'    => 'efbl_head_border_top_size_upgrade',
                ) ) );
                $wp_customize->add_control( new Customize_EFBL_PopUp( $wp_customize, 'efbl_head_border_bottom_size_upgrade', array(
                    'settings'    => array(),
                    'label'       => __( 'Border Bottom', $Feed_Them_All->plug_slug ),
                    'section'     => 'efbl_header',
                    'description' => __( 'We are sorry, “Border Bottom” is a premium feature.', $Feed_Them_All->plug_slug ),
                    'popup_id'    => 'efbl_head_border_bottom_size_upgrade',
                ) ) );
                $wp_customize->add_control( new Customize_EFBL_PopUp( $wp_customize, 'efbl_head_border_left_size_upgrade', array(
                    'settings'    => array(),
                    'label'       => __( 'Border Left', $Feed_Them_All->plug_slug ),
                    'section'     => 'efbl_header',
                    'description' => __( 'We are sorry, “Border Left” is a premium feature.', $Feed_Them_All->plug_slug ),
                    'popup_id'    => 'efbl_head_border_left_size_upgrade',
                ) ) );
                $wp_customize->add_control( new Customize_EFBL_PopUp( $wp_customize, 'efbl_head_border_right_size_upgrade', array(
                    'settings'    => array(),
                    'label'       => __( 'Border Right', $Feed_Them_All->plug_slug ),
                    'section'     => 'efbl_header',
                    'description' => __( 'We are sorry, “Border Right” is a premium feature.', $Feed_Them_All->plug_slug ),
                    'popup_id'    => 'efbl_head_border_right_size_upgrade',
                ) ) );
                $wp_customize->add_control( new Customize_EFBL_PopUp( $wp_customize, 'efbl_head_padding_top_upgrade', array(
                    'settings'    => array(),
                    'label'       => __( 'Padding Top', $Feed_Them_All->plug_slug ),
                    'section'     => 'efbl_header',
                    'description' => __( 'We are sorry, “Padding Top” is a premium feature.', $Feed_Them_All->plug_slug ),
                    'popup_id'    => 'efbl_head_padding_top_upgrade',
                ) ) );
                $wp_customize->add_control( new Customize_EFBL_PopUp( $wp_customize, 'efbl_head_padding_bottom_upgrade', array(
                    'settings'    => array(),
                    'label'       => __( 'Padding Bottom', $Feed_Them_All->plug_slug ),
                    'section'     => 'efbl_header',
                    'description' => __( 'We are sorry, “Padding Bottom” is a premium feature.', $Feed_Them_All->plug_slug ),
                    'popup_id'    => 'efbl_head_padding_bottom_upgrade',
                ) ) );
                $wp_customize->add_control( new Customize_EFBL_PopUp( $wp_customize, 'efbl_head_padding_left_upgrade', array(
                    'settings'    => array(),
                    'label'       => __( 'Padding Left', $Feed_Them_All->plug_slug ),
                    'section'     => 'efbl_header',
                    'description' => __( 'We are sorry, “Padding Left” is a premium feature.', $Feed_Them_All->plug_slug ),
                    'popup_id'    => 'efbl_head_padding_left_upgrade',
                ) ) );
                $wp_customize->add_control( new Customize_EFBL_PopUp( $wp_customize, 'efbl_head_padding_right_upgrade', array(
                    'settings'    => array(),
                    'label'       => __( 'Padding Right', $Feed_Them_All->plug_slug ),
                    'section'     => 'efbl_header',
                    'description' => __( 'We are sorry, “Padding Right” is a premium feature.', $Feed_Them_All->plug_slug ),
                    'popup_id'    => 'efbl_head_padding_right_upgrade',
                ) ) );
            }
            
            //======================================================================
            // Feed section
            //======================================================================
            $setting = 'efbl_skin_' . $skin_id . '[feed_background_color]';
            $wp_customize->add_setting( $setting, array(
                'default'   => '#fff',
                'transport' => 'postMessage',
                'type'      => 'option',
            ) );
            $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $setting, array(
                'label'       => __( 'Background Color', $Feed_Them_All->plug_slug ),
                'section'     => 'efbl_feed',
                'settings'    => $setting,
                'description' => __( 'Select the Background color of feed.', $Feed_Them_All->plug_slug ),
            ) ) );
            $setting = 'efbl_skin_' . $skin_id . '[feed_borders_color]';
            $wp_customize->add_setting( $setting, array(
                'default'   => '#dee2e6',
                'transport' => 'postMessage',
                'type'      => 'option',
            ) );
            $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $setting, array(
                'label'       => __( 'Borders Color', $Feed_Them_All->plug_slug ),
                'section'     => 'efbl_feed',
                'settings'    => $setting,
                'description' => __( 'Select the borders color in the feed', $Feed_Them_All->plug_slug ),
            ) ) );
            
            if ( 'carousel' !== $selected_layout ) {
                $setting = 'efbl_skin_' . $skin_id . '[feed_shadow]';
                $wp_customize->add_setting( $setting, array(
                    'default'   => false,
                    'transport' => 'postMessage',
                    'type'      => 'option',
                ) );
                $wp_customize->add_control( $setting, array(
                    'label'       => __( 'Show Or Hide Box Shadow', $Feed_Them_All->plug_slug ),
                    'section'     => 'efbl_feed',
                    'settings'    => $setting,
                    'description' => __( 'Show or Hide box shadow.', $Feed_Them_All->plug_slug ),
                    'type'        => 'checkbox',
                ) );
                $setting = 'efbl_skin_' . $skin_id . '[feed_shadow_color]';
                $wp_customize->add_setting( $setting, array(
                    'default'   => 'rgba(0,0,0,0.15)',
                    'type'      => 'option',
                    'transport' => 'postMessage',
                ) );
                $wp_customize->add_control( new Customize_Alpha_Color_Control( $wp_customize, $setting, array(
                    'label'        => __( 'Shadow color', $Feed_Them_All->plug_slug ),
                    'section'      => 'efbl_feed',
                    'settings'     => $setting,
                    'show_opacity' => true,
                ) ) );
            }
            
            if ( 'grid' !== $selected_layout ) {
                
                if ( efl_fs()->is_plan( 'facebook_premium', true ) or efl_fs()->is_plan( 'combo_premium', true ) ) {
                } else {
                    $wp_customize->add_control( new Customize_EFBL_PopUp( $wp_customize, 'efbl_header_feed_upgrade', array(
                        'settings'    => array(),
                        'label'       => __( 'Show Or Hide Feed Header', $Feed_Them_All->plug_slug ),
                        'section'     => 'efbl_feed',
                        'description' => __( 'We are sorry, “Show Or Hide Feed Header” is a premium feature.', $Feed_Them_All->plug_slug ),
                        'popup_id'    => 'efbl_header_feed_upgrade',
                    ) ) );
                    $wp_customize->add_control( new Customize_EFBL_PopUp( $wp_customize, 'efbl_header_feed_logo_upgrade', array(
                        'settings'    => array(),
                        'label'       => __( 'Show Or Hide Feed Header Logo', $Feed_Them_All->plug_slug ),
                        'section'     => 'efbl_feed',
                        'description' => __( 'We are sorry, “Show Or Hide Feed Header Logo” is a premium feature.', $Feed_Them_All->plug_slug ),
                        'popup_id'    => 'efbl_header_feed_logo_upgrade',
                    ) ) );
                }
            
            }
            
            if ( efl_fs()->is_plan( 'facebook_premium', true ) or efl_fs()->is_plan( 'combo_premium', true ) ) {
            } else {
                $wp_customize->add_control( new Customize_EFBL_PopUp( $wp_customize, 'efbl_text_color_feed_upgrade', array(
                    'settings'    => array(),
                    'label'       => __( 'Text Color', $Feed_Them_All->plug_slug ),
                    'section'     => 'efbl_feed',
                    'description' => __( 'We are sorry, “Text Color” is a premium feature.', $Feed_Them_All->plug_slug ),
                    'popup_id'    => 'efbl_text_color_feed_upgrade',
                ) ) );
            }
            
            
            if ( $selected_layout == 'grid' ) {
                $feed_default_padding = 3;
            } else {
                $feed_default_padding = 15;
            }
            
            $setting = 'efbl_skin_' . $skin_id . '[feed_padding_top]';
            $wp_customize->add_setting( $setting, array(
                'default'   => $feed_default_padding,
                'transport' => 'postMessage',
                'type'      => 'option',
            ) );
            $wp_customize->add_control( $setting, array(
                'label'       => __( 'Padding Top', $Feed_Them_All->plug_slug ),
                'section'     => 'efbl_feed',
                'settings'    => $setting,
                'description' => __( 'Select the padding top', $Feed_Them_All->plug_slug ),
                'type'        => 'number',
                'input_attrs' => array(
                'min' => 0,
                'max' => 100,
            ),
            ) );
            $setting = 'efbl_skin_' . $skin_id . '[feed_padding_bottom]';
            $wp_customize->add_setting( $setting, array(
                'default'   => $feed_default_padding,
                'transport' => 'postMessage',
                'type'      => 'option',
            ) );
            $wp_customize->add_control( $setting, array(
                'label'       => __( 'Padding Bottom', $Feed_Them_All->plug_slug ),
                'section'     => 'efbl_feed',
                'settings'    => $setting,
                'description' => __( 'Select the padding bottom of feed.', $Feed_Them_All->plug_slug ),
                'type'        => 'number',
                'input_attrs' => array(
                'min' => 0,
                'max' => 100,
            ),
            ) );
            $setting = 'efbl_skin_' . $skin_id . '[feed_padding_right]';
            $wp_customize->add_setting( $setting, array(
                'default'   => $feed_default_padding,
                'transport' => 'postMessage',
                'type'      => 'option',
            ) );
            $wp_customize->add_control( $setting, array(
                'label'       => __( 'Padding Right', $Feed_Them_All->plug_slug ),
                'section'     => 'efbl_feed',
                'settings'    => $setting,
                'description' => __( 'Select the padding right for feed.', $Feed_Them_All->plug_slug ),
                'type'        => 'number',
                'input_attrs' => array(
                'min' => 0,
                'max' => 100,
            ),
            ) );
            $setting = 'efbl_skin_' . $skin_id . '[feed_padding_left]';
            $wp_customize->add_setting( $setting, array(
                'default'   => $feed_default_padding,
                'transport' => 'postMessage',
                'type'      => 'option',
            ) );
            $wp_customize->add_control( $setting, array(
                'label'       => __( 'Padding  Left', $Feed_Them_All->plug_slug ),
                'section'     => 'efbl_feed',
                'settings'    => $setting,
                'description' => __( 'Select the padding left for feed.', $Feed_Them_All->plug_slug ),
                'type'        => 'number',
                'input_attrs' => array(
                'min' => 0,
                'max' => 100,
            ),
            ) );
            $feed_transport = 'postMessage';
            
            if ( $selected_layout == 'grid' ) {
                $feed_default_spacing = 30;
            } elseif ( $selected_layout == 'carousel' ) {
                $feed_default_spacing = 10;
                $feed_transport = 'refresh';
            } else {
                $feed_default_spacing = 20;
                $feed_transport = 'postMessage';
            }
            
            $setting = 'efbl_skin_' . $skin_id . '[feed_spacing]';
            $wp_customize->add_setting( $setting, array(
                'default'   => $feed_default_spacing,
                'transport' => $feed_transport,
                'type'      => 'option',
            ) );
            $wp_customize->add_control( $setting, array(
                'label'       => __( 'Spacing', $Feed_Them_All->plug_slug ),
                'section'     => 'efbl_feed',
                'settings'    => $setting,
                'description' => __( 'Select the spacing between feeds.', $Feed_Them_All->plug_slug ),
                'type'        => 'number',
                'input_attrs' => array(
                'min' => 0,
                'max' => 100,
            ),
            ) );
            $wp_customize->add_section( 'efbl_feed', array(
                'title'       => __( 'Feed', $Feed_Them_All->plug_slug ),
                'description' => __( 'Customize the Single Feed Design In Real Time', $Feed_Them_All->plug_slug ),
                'priority'    => 35,
                'panel'       => 'efbl_customize_panel',
            ) );
            
            if ( $selected_layout !== 'grid' ) {
                
                if ( efl_fs()->is_plan( 'facebook_premium', true ) or efl_fs()->is_plan( 'combo_premium', true ) ) {
                } else {
                    $wp_customize->add_control( new Customize_EFBL_PopUp( $wp_customize, 'efbl_meta_feed_upgrade', array(
                        'settings'    => array(),
                        'label'       => __( 'Feed Meta Color', $Feed_Them_All->plug_slug ),
                        'section'     => 'efbl_feed',
                        'description' => __( 'We are sorry, “Feed Meta Color” is a premium feature.', $Feed_Them_All->plug_slug ),
                        'popup_id'    => 'efbl_meta_feed_upgrade',
                    ) ) );
                }
                
                $setting = 'efbl_skin_' . $skin_id . '[show_likes]';
                $wp_customize->add_setting( $setting, array(
                    'default'   => true,
                    'transport' => 'refresh',
                    'type'      => 'option',
                ) );
                $wp_customize->add_control( $setting, array(
                    'label'       => __( 'Show Or Hide Reactions Counter', $Feed_Them_All->plug_slug ),
                    'section'     => 'efbl_feed',
                    'settings'    => $setting,
                    'description' => __( 'Show or Hide reactions counter', $Feed_Them_All->plug_slug ),
                    'type'        => 'checkbox',
                ) );
                $setting = 'efbl_skin_' . $skin_id . '[show_comments]';
                $wp_customize->add_setting( $setting, array(
                    'default'   => true,
                    'transport' => 'refresh',
                    'type'      => 'option',
                ) );
                $wp_customize->add_control( $setting, array(
                    'label'       => __( 'Show Or Hide Comments of feeds', $Feed_Them_All->plug_slug ),
                    'section'     => 'efbl_feed',
                    'settings'    => $setting,
                    'description' => __( 'Show or Hide comments of feed', $Feed_Them_All->plug_slug ),
                    'type'        => 'checkbox',
                ) );
                $setting = 'efbl_skin_' . $skin_id . '[show_shares]';
                $wp_customize->add_setting( $setting, array(
                    'default'   => true,
                    'transport' => 'refresh',
                    'type'      => 'option',
                ) );
                $wp_customize->add_control( $setting, array(
                    'label'       => __( 'Show Or Hide Shares Counter', $Feed_Them_All->plug_slug ),
                    'section'     => 'efbl_feed',
                    'settings'    => $setting,
                    'description' => __( 'Show or Hide shares counter', $Feed_Them_All->plug_slug ),
                    'type'        => 'checkbox',
                ) );
                $setting = 'efbl_skin_' . $skin_id . '[show_feed_caption]';
                $wp_customize->add_setting( $setting, array(
                    'default'   => true,
                    'transport' => 'refresh',
                    'type'      => 'option',
                ) );
                $wp_customize->add_control( $setting, array(
                    'label'       => __( 'Show Or Hide Feed Caption', $Feed_Them_All->plug_slug ),
                    'section'     => 'efbl_feed',
                    'settings'    => $setting,
                    'description' => __( 'Show or Hide Caption.', $Feed_Them_All->plug_slug ),
                    'type'        => 'checkbox',
                ) );
            }
            
            
            if ( efl_fs()->is_plan( 'facebook_premium', true ) or efl_fs()->is_plan( 'combo_premium', true ) ) {
            } else {
                $wp_customize->add_control( new Customize_EFBL_PopUp( $wp_customize, 'efbl_popup_icon_feed_upgrade', array(
                    'settings'    => array(),
                    'label'       => __( 'Show Or Hide Open PopUp Icon', $Feed_Them_All->plug_slug ),
                    'section'     => 'efbl_feed',
                    'description' => __( 'We are sorry, “Show Or Hide Open PopUp Icon” is a premium feature.', $Feed_Them_All->plug_slug ),
                    'popup_id'    => 'efbl_popup_icon_feed_upgrade',
                ) ) );
                $wp_customize->add_control( new Customize_EFBL_PopUp( $wp_customize, 'efbl_popup_icon_color_feed_upgrade', array(
                    'settings'    => array(),
                    'label'       => __( 'Open PopUp Icon color', $Feed_Them_All->plug_slug ),
                    'section'     => 'efbl_feed',
                    'description' => __( 'We are sorry, “Open PopUp Icon color” is a premium feature.', $Feed_Them_All->plug_slug ),
                    'popup_id'    => 'efbl_popup_icon_color_feed_upgrade',
                ) ) );
                $wp_customize->add_control( new Customize_EFBL_PopUp( $wp_customize, 'efbl_popup_icon_color_feedtype_upgrade', array(
                    'settings'    => array(),
                    'label'       => __( 'Feed Type Icon color', $Feed_Them_All->plug_slug ),
                    'section'     => 'efbl_feed',
                    'description' => __( 'We are sorry, “Feed Type Icon color” is a premium feature.', $Feed_Them_All->plug_slug ),
                    'popup_id'    => 'efbl_popup_icon_color_feedtype_upgrade',
                ) ) );
                $wp_customize->add_control( new Customize_EFBL_PopUp( $wp_customize, 'efbl_popup_cta_feed_upgrade', array(
                    'settings'    => array(),
                    'label'       => __( 'Show Or Hide Feed Call To Action Buttons', $Feed_Them_All->plug_slug ),
                    'section'     => 'efbl_feed',
                    'description' => __( 'We are sorry, “Show Or Hide Feed Call To Action Buttons” is a premium feature.', $Feed_Them_All->plug_slug ),
                    'popup_id'    => 'efbl_popup_cta_feed_upgrade',
                ) ) );
            }
            
            
            if ( efl_fs()->is_plan( 'facebook_premium', true ) or efl_fs()->is_plan( 'combo_premium', true ) ) {
            } else {
                $wp_customize->add_control( new Customize_EFBL_PopUp( $wp_customize, 'efbl_popup_bg_hover_feed_upgrade', array(
                    'settings'    => array(),
                    'label'       => __( 'Feed Hover Shadow Color', $Feed_Them_All->plug_slug ),
                    'section'     => 'efbl_feed',
                    'description' => __( 'We are sorry, “Feed Hover Shadow Color” is a premium feature.', $Feed_Them_All->plug_slug ),
                    'popup_id'    => 'efbl_popup_bg_hover_feed_upgrade',
                ) ) );
            }
            
            //======================================================================
            // PopUP section
            //======================================================================
            /* Adding layout section in customizer under efbl panel.*/
            $wp_customize->add_section( 'efbl_popup', array(
                'title'       => __( 'Media lightbox', $Feed_Them_All->plug_slug ),
                'description' => __( 'Customize the PopUp In Real Time', $Feed_Them_All->plug_slug ),
                'priority'    => 35,
                'panel'       => 'efbl_customize_panel',
            ) );
            
            if ( efl_fs()->is_plan( 'facebook_premium', true ) or efl_fs()->is_plan( 'combo_premium', true ) ) {
            } else {
                $wp_customize->add_control( new Customize_EFBL_PopUp( $wp_customize, 'efbl_popup_popup_upgrade', array(
                    'settings'    => array(),
                    'label'       => __( 'Media Lightbox Settings', $Feed_Them_All->plug_slug ),
                    'section'     => 'efbl_popup',
                    'description' => __( 'We are sorry, Media Lightbox Settings are not included in your plan. Please upgrade to premium version to unlock following settings<ul>
                					 <li>Sidebar Background Color</li>
                					 <li>Sidebar Content Color</li>
                					 <li>Show Or Hide PopUp Header</li>
                					 <li>Show Or Hide Header Logo</li>
                					 <li>Header Title Color</li>
                					 <li>Post Time Color</li>
                					 <li>Show Or Hide Caption</li>
                					 <li>Show Or Hide Meta Section</li>
                					 <li>Meta Background Color</li>
                					 <li>Meta Content Color</li>
                					 <li>Show Or Hide Reactions Counter</li>
                					 <li>Show Or Hide Comments Counter</li>
                					 <li>Show Or Hide View On Facebook Link</li>
                					 <li>Show Or Hide Comments</li>
                					 <li>Comments Background Color</li>
                					 <li>Comments Color</li>
                					 </ul>', $Feed_Them_All->plug_slug ),
                    'popup_id'    => 'efbl_popup_popup_upgrade',
                ) ) );
            }
        
        }
        
        /* efbl_customizer Method ends here. */
        /**
         * Used by hook: 'customize_preview_init'
         * 
         * @see add_action('customize_preview_init',$func)
         */
        public function efbl_live_preview()
        {
            /* Getting saved skin id. */
            $skin_id = get_option( 'efbl_skin_id', false );
            /* Enqueing script for displaying live changes. */
            wp_enqueue_script(
                'efbl_live_preview',
                EFBL_PLUGIN_URL . 'admin/assets/js/efbl-live-preview.js',
                array( 'jquery', 'customize-preview' ),
                true
            );
            /* Localizing script for getting skin id in js. */
            wp_localize_script( 'efbl_live_preview', 'efbl_skin_id', $skin_id );
        }
    
    }
    /* EFBL_Cuustomizer Class ends here. */
    $EFBL_Cuustomizer = new EFBL_Cuustomizer();
}
