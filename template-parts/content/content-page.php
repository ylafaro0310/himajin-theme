<div class="column is-two-thirds">
    <div class="title is-4"><?php the_title();?></div>
    <div class="level">        
        <div class="level-left">投稿者: <?php the_author();?></div>
        <div class="level-right"><?php the_date('Y.m.d');?></div>
    </div>
    <div class="content mt-4">
        <?php the_content();?>
    </div>
</div>
