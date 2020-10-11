<div class="woocommerce_picked">
    <h2><?php echo the_field('chosen_products_title') ?></h2>
    <h3><?php echo the_field('chosen_products_subtitle') ?></h3>
    <?php

    $loop = new WP_Query( 
        array( 
        'post_type' => 'product',
        'post__in' => [get_field('chosen_product_1'), get_field('chosen_product_2'), get_field('chosen_product_3')]
        )
    );

    while ( $loop->have_posts() ) : $loop->the_post(); ?>

        <a href="<?php echo get_permalink( $loop->post->ID ) ?>">
            <img src="<?php echo get_the_post_thumbnail_url()?>" alt="">
            <h3><?php the_title(); ?></h3>
            <p><?php the_excerpt(); ?></p>
        </a>

    <?php endwhile; wp_reset_query();?>
    <div class="button"><a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>">Sfoglia tutti</a></div>
</div>