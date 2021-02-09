<?php
get_header();
?>
<header>
    <?php get_template_part('template-parts/header/site-branding') ?>
</header>
<section class="hero mt-6 mb-4 is-info">
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
<section class="section">
    <div class="container">
        <div class="columns is-multiline is-centered">
        <?php
            if ( have_posts() ) {
                while ( have_posts() ) {
                    the_post();
                    get_template_part('template-parts/content/content','single');
                }
            } else {
                get_template_part('template-parts/content/content-none');
            }
        ?>
        </div>
        <div class="columns is-multiline is-centered">
        <?php
            if ( comments_open() || get_comments_number() ) {
                comments_template();
            }
        ?>
    </div>
</section>
<?php
get_footer();
?>