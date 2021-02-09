<?php
include('classes/cs_walker_nav_menu.php');

// registe JS/CSS
function himajin_add_files(){
  wp_deregister_script('jquery');
  wp_enqueue_script( 'jquery', 'https://code.jquery.com/jquery-3.5.1.min.js', '');
  wp_enqueue_script( 'main-script', get_template_directory_uri() . '/js/main.js', array( 'jquery' ), filemtime(get_template_directory_uri().'/js/main.js'));
  wp_enqueue_style('main-css',get_stylesheet_uri(), '',filemtime( get_stylesheet_directory().'/style.css'));
}
add_action('wp_enqueue_scripts','himajin_add_files');

// Regist main menu
function register_himajin_menus() { 
  register_nav_menus( array( 
    'main-menu' => 'メインメニュー',
  ) );
}
add_action( 'after_setup_theme', 'register_himajin_menus' );

// Regist footer
function register_himajin_footer() {
  register_sidebar( array(
    'name' => 'フッター',
    'id' => 'footer',
    'before_widget' => '<li id="%1$s" class="widget menu column is-one-third %2$s">',
    'after_widget' => '</li>',
    'before_title'  => '<h2 class="widgettitle menu-label">',
	  'after_title'   => '</h2>'
  ));
}
add_action( 'widgets_init', 'register_himajin_footer' );

// Pagination
function himajin_pagination($pages='',$range=3) {
  $showitmes = ($range * 1) + 1;
  $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
  if($pages == ''){
    global $wp_query;
    $pages = $wp_query->max_num_pages;
    if( !$pages ){
      $pages = 1;
    }
    if(1 != $pages){
      echo "<div class='column is-full'/>";
      echo "<nav class='pagination is-centered' role='navigation'>\n";
      echo ($paged > 1) ? "<a class='pagination-previous href='".get_pagenum_link($paged-1)."'>前へ</a>\n" : '';
      echo ($paged < $pages) ? "<a class='pagination-next' href='".get_pagenum_link($paged+1)."'>次へ</a>\n" : '';
      echo "<ul class='pagination-list'>\n";

      for($i=1; $i <= $pages; $i++){
        if(1 != $pages && ( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $shoitems )){
          echo $paged == $i 
          ? "<li><a class='pagination-link is-current'>" .$i. "</a></li>" 
          : "<li><a class='pagination-link' href='" .get_pagenum_link($i)."'>" .$i. "</a></li>";
        }
      }

      echo "</ul>\n";
      echo "</nav>\n";
      echo "</div>\n";
    }
  }
}

// Limit posts per page
function himajin_limit_posts( $query ) {
  if ( ($query->is_home() || $query->is_archive()) && $query->is_main_query() ) {
      $query->set( 'post_type', 'post' );
      $query->set( 'posts_per_page', '9' );
  }
}

add_action( 'pre_get_posts', 'himajin_limit_posts' );

// Get category
function himajin_get_category(){
  $category = get_the_category(); 
  $cat = array_search('プログラミング',array_column($category,'cat_name'));
  if($cat !== false) $ret = "<p class='cat-blue'>".$category[$cat]->cat_name."</p>";

  $cat = array_search('読書',array_column($category,'cat_name'));
  if($cat !== false) $ret = "<p class='cat-green'>".$category[$cat]->cat_name."</p>";

  $cat = array_search('音楽',array_column($category,'cat_name'));
  if($cat !== false) $ret = "<p class='cat-green'>".$category[$cat]->cat_name."</p>";

  $cat = array_search('アニメ',array_column($category,'cat_name'));
  if($cat !== false) $ret = "<p class='cat-green'>".$category[$cat]->cat_name."</p>";

  if(empty($ret)) $ret = "<p class='cat-black'>".$category[0]->cat_name."</p>";
  echo $ret;
}

function himajin_get_the_archive_title() {
	if ( is_category() ) {
		$title = 'カテゴリ: <span class="page-description">' . single_term_title( '', false ) . '</span>';
	} elseif ( is_tag() ) {
		$title = 'タグ: <span class="page-description">' . single_term_title( '', false ) . '</span>';
	} elseif ( is_author() ) {
		$title = '作者: <span class="page-description">' . get_the_author_meta( 'display_name' ) . '</span>';
	} elseif ( is_year() ) {
		$title = __( 'アーカイブ: ', 'twentynineteen' ) . '<span class="page-description">' . get_the_date( _x( 'Y', 'yearly archives date format', 'twentynineteen' ) ) . '</span>';
	} elseif ( is_month() ) {
		$title = __( 'アーカイブ: ', 'twentynineteen' ) . '<span class="page-description">' . get_the_date( _x( 'F Y', 'monthly archives date format', 'twentynineteen' ) ) . '</span>';
	} elseif ( is_day() ) {
		$title = __( 'アーカイブ: ', 'twentynineteen' ) . '<span class="page-description">' . get_the_date() . '</span>';
	} elseif ( is_post_type_archive() ) {
		$title = __( 'アーカイブ: ', 'twentynineteen' ) . '<span class="page-description">' . post_type_archive_title( '', false ) . '</span>';
	} elseif ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		/* translators: %s: Taxonomy singular name. */
		$title = sprintf( esc_html__( '%s アーカイブ:', 'twentynineteen' ), $tax->labels->singular_name );
	} else {
		$title = __( 'Archives:', 'twentynineteen' );
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'himajin_get_the_archive_title' );

function himajin_get_discussion_data() {
	static $discussion, $post_id;

	$current_post_id = get_the_ID();
	if ( $current_post_id === $post_id ) {
		return $discussion; /* If we have discussion information for post ID, return cached object */
	} else {
		$post_id = $current_post_id;
	}

	$comments = get_comments(
		array(
			'post_id' => $current_post_id,
			'orderby' => 'comment_date_gmt',
			'order'   => get_option( 'comment_order', 'asc' ), /* Respect comment order from Settings » Discussion. */
			'status'  => 'approve',
			'number'  => 20, /* Only retrieve the last 20 comments, as the end goal is just 6 unique authors */
		)
	);

	$authors = array();
	foreach ( $comments as $comment ) {
		$authors[] = ( (int) $comment->user_id > 0 ) ? (int) $comment->user_id : $comment->comment_author_email;
	}

	$authors    = array_unique( $authors );
	$discussion = (object) array(
		'authors'   => array_slice( $authors, 0, 6 ),           /* Six unique authors commenting on the post. */
		'responses' => get_comments_number( $current_post_id ), /* Number of responses. */
	);

	return $discussion;
}

function himajin_comment($comment, $args, $depth) {
    if ( 'div' === $args['style'] ) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }
  ?>
  <<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
  <?php if ( 'div' != $args['style'] ) : ?>
      <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
  <?php endif; ?>
  <div class="comment-author vcard">
      <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
      <?php printf( __( '<cite class="fn">%s</cite> <span class="says">says:</span>' ), get_comment_author_link() ); ?>
  </div>
  <?php if ( $comment->comment_approved == '0' ) : ?>
       <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em>
        <br />
  <?php endif; ?>

  <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
      <?php
      /* translators: 1: date, 2: time */
      printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)' ), '  ', '' );
      ?>
  </div>

  <?php comment_text(); ?>

  <div class="reply">
      <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
  </div>
  <?php if ( 'div' != $args['style'] ) : ?>
  </div>
  <?php endif; ?>
  <?php
}