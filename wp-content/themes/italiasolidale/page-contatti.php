<?php /* Template Name: Contatti */ ?>
<?php get_header();?>

<div class="contact_form_container">
    <img src="<?php echo the_field('contact_form_img')?>" alt="">
    <div class="form_area">
        <h2>Scrivici</h2>
        <h5>Compila il form per essere ricontattato</h5>
        <?php echo do_shortcode( '[contact-form-7 id="18" title="Modulo di contatto 1"]' ); ?>
    </div>
</div>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<?php 
    the_content();
    endwhile;
    endif;
?>
<?php get_footer();?>
