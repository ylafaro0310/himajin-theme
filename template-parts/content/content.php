<div class="column is-one-third">
    <a href=<?php the_permalink() ?>>
        <div class="card">
            <div class="card-image">
                <figure class="image is-16by9">
                <?php echo get_the_post_thumbnail() == '' 
                    ? "<img src='".get_template_directory_uri()."/img/no-image.png'"." alt='サムネイル'>"
                    : get_the_post_thumbnail(); ?>
                <?php himajin_get_category();?>
                </figure>
            </div>
            <div class="card-content">
                <div class="">
                    <?php the_title();?>
                </div>
            </div>
        </div>
    </a>
</div>