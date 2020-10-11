<?php get_header();?>
<main>
    <div class="home_header">
        <img src="<?php the_field('header_img') ?>" class="header_img" alt="">
        <h1 class="header_text"><?php the_field('header_text') ?></h1>
    </div>
    <?php 
        if ( have_posts() ) : while ( have_posts() ) : the_post();
        the_content();
        endwhile;
        endif;
    ?>
</main>

<?php get_footer();?>