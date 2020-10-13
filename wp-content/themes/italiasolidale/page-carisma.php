<?php /* Template Name: Carisma */ ?>
<?php get_header();?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <?php get_sidebar(); ?>
    <div class="cover">
        <img src="<?php echo the_field('immagine_copertina') ?>" alt="">
        <div class="opacity_cover"></div>
        <h2><?php echo the_title() ?></h2>
    </div>
    <aside>
        <?php if( get_field('immagine_sidebar') ): ?>
            <img src="<?php echo the_field('immagine_sidebar') ?>" alt="">
        <?php endif; ?>
        <div class="aside_content">
            <?php dynamic_sidebar( 'sidebar' ); ?>
        </div>
    </aside>
    <article>
        <?php 
                the_content();
                endwhile;
                endif;
        ?>
    </article>
<?php get_footer();?>