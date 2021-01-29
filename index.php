<?php
get_header();
?>
<div class="container">
    <div class="columns is-multiline">
    <?php
        if ( have_posts() ) {
            while ( have_posts() ) {
                the_post();
                get_template_part('template-parts/content/content');
            }
        } else {
            get_template_part('template-parts/content/content-none');
        }
    ?>
    </div>
</div>
<?php
get_footer();
?>