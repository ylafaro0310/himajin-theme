<div class="column is-two-thirds">
    <div class="title is-4"><?php the_title();?></div>
    <div class="level">        
        <div class="level-left">投稿者: <?php the_author();?></div>
        <div class="level-right"><?php the_date('Y.m.d');?></div>
    </div>
    <figure class="image is-16by9">
        <?php echo get_the_post_thumbnail() == '' 
            ? "<img src='".get_template_directory_uri()."/img/no-image.png'"." alt='サムネイル'>"
            : get_the_post_thumbnail(); ?>
        <?php himajin_get_category();?>
    </figure>
    <div class="content mt-4">
        <?php the_content();?>
    </div>
    <div>
        カテゴリ:<?php the_category(',')?>
    </div>
</div>
