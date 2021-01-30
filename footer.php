    <aside class='container mt-4'>
        <ul class='columns'><?php 
            ob_start();
            dynamic_sidebar('footer');
            $sidebar = ob_get_contents();
            ob_end_clean();
    
            $sidebar_corrected_ul = str_replace("<ul>", '<ul class="menu-list">', $sidebar);
    
            echo $sidebar_corrected_ul;
        ?></ul>
    </aside>
    <div class='container has-text-centered mt-4 mb-4'>
        <?php the_privacy_policy_link('','/'); ?>
        ©2020
        <a class="site-name" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
    </div>
    <?php wp_footer();?>
    </body>
</html>