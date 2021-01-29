<?php
get_header();
?>
<header>
    <?php get_template_part('template-parts/header/site-branding') ?>
</header>
<section class="hero mb-4 is-medium is-fullheight is-info">
  <div class="hero-body">
      <div class="container has-text-centered">
        <p class="title">
            <?php bloginfo('name'); ?>
        </p>
        <p class="subtitle">
            <?php bloginfo('description'); ?>
        </p>
    </div>
  </div>
</section>
<div class="container">
    <div class="columns is-multiline">
    <?php
        if ( have_posts() ) {
            while ( have_posts() ) {
                the_post();
                get_template_part('template-parts/content/content');
            }
            himajin_pagination();
        } else {
            get_template_part('template-parts/content/content-none');
        }
    ?>
    </div>
</div>
<?php
get_footer();
?>