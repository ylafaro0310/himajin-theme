<?php if( has_nav_menu('main-menu') ) :?>
    <nav class="navbar is-fixed-top" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a class="navbar-item" href="/">
                <?php bloginfo('name'); ?>
            </a>

            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            </a>
        </div>
        <?php
        wp_nav_menu(
            array(
                'theme_location'    => 'main-menu',
                'depth'             => 0,
                'container'         => false,
                // 'items_wrap'     => 'div',
                'menu_class'        => 'navbar-menu',
                'menu_id'           => 'main-menu',
                'after'             => "</div>",
                'walker' => new cs_walker_nav_menu
            )
        );
        ?>
    </nav>
<?php endif; ?>