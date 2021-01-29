<?php
include('classes/cs_walker_nav_menu.php');

// Regist main menu
function register_himajin_menus() { 
  register_nav_menus( array( 
    'main-menu' => 'メインメニュー',
  ) );
}
add_action( 'after_setup_theme', 'register_himajin_menus' );

// Pagination
function himajin_pagination($pages='',$range=2) {
  $showitmes = ($range * 1) + 1;
  global $paged;
  if(empty($paged)) $himajin_paged = 1;
  if($pages == ''){
    global $wp_query;
    $pages = $wp_query->max_num_pages;
    if( !$pages ){
      $pages = 1;
    }
    if(1 != $pages){
      echo "<div>";
      echo "<ol>\n";

      for($i=1; $i <= $pages; $i++){
        if(1 != $pages && ( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $shoitems )){
          echo $paged == $i ? "<li>" .$i. "</li>" : "<li><a href'" .get_pagenum_link($i)."'>" .$i. "</a></li>";
        }
      }

      echo "</ol>\n";
      echo "</div>\n";
    }
  }
}