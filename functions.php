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
