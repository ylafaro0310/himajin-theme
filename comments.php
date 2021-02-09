<div class='column is-two-thirds'>
<?php

$discussion = himajin_get_discussion_data();

if( have_comments() ){
?>
<div class="content">
    <ol class="comment-list">
                <?php
                wp_list_comments(
                    array(
                        'short_ping'  => true,
                        'style'       => 'ol',
                    )
                );
                ?>
    </ol>
</div>
<?php
        $prev_icon     = '<';
        $next_icon     = '>';
        $comments_text = 'コメント';
        the_comments_navigation(
            array(
                'prev_text' => sprintf( '%s <span class="nav-prev-text"><span class="primary-text">%s</span> <span class="secondary-text">%s</span></span>', $prev_icon, '前の', 'コメント' ),
                'next_text' => sprintf( '<span class="nav-next-text"><span class="primary-text">%s</span> <span class="secondary-text">%s</span></span> %s', '次の', 'コメント', $next_icon ),
            )
        );
}


comment_form(array(
    'id_form'           => 'commentform',
    'id_submit'         => 'submit',
    'title_reply'       => '<div class="title is-5">'.__( 'Leave a Reply' ). '</div>',
    'title_reply_to'    => '<div class="title is-5">'.__( 'Leave a Reply to %s' ). '</div>',
    'cancel_reply_link' => __( 'Cancel Reply' ),
    'label_submit'      => __( 'Post Comment' ),
  
    'comment_field' =>  '<div class="comment-form-comment field"><label for="comment" class="label">' . _x( 'Comment', 'noun' ) .
      '</label><div class="control"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true">' .
      '</textarea></div></div>',
  
    'must_log_in' => '<p class="must-log-in">' .
      sprintf(
        __( 'You must be <a href="%s">logged in</a> to post a comment.' ),
        wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
      ) . '</p>',
  
    'logged_in_as' => '<p class="logged-in-as">' .
      sprintf(
      __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ),
        admin_url( 'profile.php' ),
        $user_identity,
        wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
      ) . '</p>',
  
    'comment_notes_before' => '<p class="comment-notes help">' .
      __( 'Your email address will not be published.' ) . ( $req ? $required_text : '' ) .
      '</p>',
  
    'fields' => apply_filters( 'comment_form_default_fields', array(
  
      'author' =>
        '<div class="comment-form-author field">' .
        '<label for="author" class="label">' . '名前' .
        ( $req ? '<span class="required">*</span>' : '' ) . '</label> ' .
        '<div class="control"><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
        '" size="30"' . $aria_req . ' /></div></div>',
  
      'email' =>
        '<div class="comment-form-email field"><label for="email" class="label">' . 'メール' . 
        ( $req ? '<span class="required">*</span>' : '' ) . '</label> ' .
        '<div class="control"><input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
        '" size="30"' . $aria_req . ' /></div></div>',
  
      'url' =>
        '<div class="comment-form-url field"><label for="url" class="label">' .
        'サイトURL' . '</label>' .
        '<div class="control"><input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
        '" size="30" /></div></div>'
      )
    ),
  )
);
?>
</div>