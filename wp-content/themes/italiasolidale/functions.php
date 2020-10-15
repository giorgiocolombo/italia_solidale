<?php

show_admin_bar( false );

define( 'ITAS_IS_ADMIN' , current_user_can( 'edit_others_posts' ));

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_head', 'print_emoji_styles' );

function ITAS_setup(){
    remove_theme_support( 'core-block-patterns' );
    
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	
	register_nav_menus( array('main_menu'=> 'Main Menu') );

}
add_action( 'after_setup_theme', 'ITAS_setup' );

function remove_default_post_type_and_comments() {
    remove_menu_page('edit.php');
    remove_menu_page( 'edit-comments.php' );
}
add_action('admin_menu','remove_default_post_type_and_comments');

function ITAS_styles_scripts(){
    wp_deregister_script('jquery');
    wp_enqueue_script( 'jquery' , 'https://code.jquery.com/jquery-3.5.1.min.js', array(), '1.0.0', 'all' );
    wp_enqueue_script( 'script' , ITAS_INCLUDES.'js/script.js', array(), '1.0.0', 'all' );

	wp_enqueue_style( 'ITAS-reset', get_stylesheet_directory_uri().'/style.css', array(), '1.0.0', 'all' );
    wp_enqueue_style( 'ITAS-font1', 'https://fonts.googleapis.com/css2?family=Raleway:wght@300;500&display=swap', array( 'ITAS-reset' ), '1.0.0', 'all' );
    wp_enqueue_style( 'ITAS-font2', 'https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap', array( 'ITAS-font1' ), '1.0.0', 'all' );
    wp_enqueue_style( 'ITAS-style', ITAS_INCLUDES.'css/style.css', array( 'ITAS-font2' ), '1.0.0', 'all' );
	
}
add_action( 'wp_enqueue_scripts', 'ITAS_styles_scripts' );

function ITAS_styles_gutenberg_backend(){
	wp_enqueue_style( 'ITAS-style', ITAS_INCLUDES.'css/style.css', array(), '1.0.0', 'all' );
}
add_action('enqueue_block_editor_assets','ITAS_styles_gutenberg_backend');


function ITAS_allowed_block_types() {
    
    return array(
        'core/image',
		'core/paragraph',
		'core/heading',
        'core/buttons',
        'core-embed/youtube',
        'jetpack/slideshow',
        'webfactory/map',
        'acf/chosen-products',
        'acf/block-left-img',
        'acf/block-right-img',        
        'acf/contacts'        
	);
    
}
add_filter( 'allowed_block_types', 'ITAS_allowed_block_types' );

function ITAS_acf_init_block_types() {
    
    if( function_exists('acf_register_block_type') ) {
        acf_register_block_type(array(
            'name'              => 'chosen-products',
            'title'             => __('Selezione di libri'),
            'description'       => __('Mostra una selezione di libri scelti'),
            'render_template'   => 'template_parts/blocks/chosen_products/chosen_products.php',
            'category'          => 'design',
            'icon'              => 'feedback',
            'keywords'          => array( 'chosen_products', 'quote' ),
        ));

        acf_register_block_type(array(
            'name'              => 'block-left-img',
            'title'             => __('Blocco Immagine Sinistra'),
            'description'       => __('Mostra un blocco con Titolo, Paragrafo e Immagine a sinistra'),
            'render_template'   => 'template_parts/blocks/block_left_right_img/block-left-img.php',
            'category'          => 'formatting',
            'icon'              => 'align-left',
            'keywords'          => array( 'block-left-img', 'quote' ),
        ));

        acf_register_block_type(array(
            'name'              => 'block-right-img',
            'title'             => __('Blocco Immagine Destra'),
            'description'       => __('Mostra un blocco con Titolo, Paragrafo e Immagine a destra'),
            'render_template'   => 'template_parts/blocks/block_left_right_img/block-right-img.php',
            'category'          => 'formatting',
            'icon'              => 'align-right',
            'keywords'          => array( 'block-right-img', 'quote' ),
        ));

        acf_register_block_type(array(
            'name'              => 'contacts',
            'title'             => __('Blocco contatti'),
            'description'       => __('Mostra un blocco con i contatti'),
            'render_template'   => 'template_parts/blocks/contacts/contacts.php',
            'category'          => 'design',
            'icon'              => 'email',
            'keywords'          => array( 'contacts', 'quote' ),
        ));
    }
}
add_action('acf/init', 'ITAS_acf_init_block_types');

function ITAS_widgets_init() {

	register_sidebar( array(
		'name'          => 'Sidebar',
		'id'            => 'sidebar',
		'before_widget' => '<sidebar>',
		'after_widget'  => '</sidebar>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	) );

}
add_action( 'widgets_init', 'ITAS_widgets_init' );

function ITAS_add_woocommerce_support() {
    add_theme_support( 'woocommerce' );
    }
add_action( 'after_setup_theme', 'ITAS_add_woocommerce_support' );