<?php

function themename_custom_logo_setup()
{
  $defaults = array(
    'height'               => 100,
    'width'                => 400,
    'flex-height'          => true,
    'flex-width'           => true,
    'header-text'          => array('site-title', 'site-description'),
    'unlink-homepage-logo' => true,
  );

  add_theme_support('custom-logo', $defaults);
}

add_action('after_setup_theme', 'themename_custom_logo_setup');

function wphead_cb()
{
  echo '<style type="text/css">';
  echo '.p-header__ttl, .p-header__info { color: #' . get_header_textcolor() . ' }';
  echo '</style>';
}

$custom_header_args = array(
  // デフォルトで表示するヘッダー画像(画像のURLを入力)
  'default-image' => get_template_directory_uri() . '/img/default.jpg',
  'width' => 1000,
  'height' => 198,
  // ヘッダー画像の横幅を自由に切り取れるかどうか(trueもしくはfalse)
  'flex-width' => false,
  // ヘッダー画像の縦幅を自由に切り取れるかどうか(trueもしくはfalse)
  'flex-height' => false,
  // ヘッダーテキストを表示するかどうかを指定する機能の使うかどうか(trueもしくはfalse)
  'header-text' => true,
  // ヘッダーテキストのデフォルトの色
  'default-text-color' => '000',
  // 動画ヘッダーに対応するかどうか(trueもしくはfalse)
  'video' => true,
  // adminへの画像ファイルのアップロードを許可するか(trueもしくはfalse)
  'uploads' => false,
  // ヘッダー画像をランダムにローテーションするかどうか(trueもしくはfalse)
  'random-default' => false,
  // テーマのheadタグ内に呼び出したいコードが書かれた関数を指定(関数名)
  'wp-head-callback' => 'wphead_cb',
  // カスタムヘッダーページのheadタグ内に呼び出したいコードが書かれた関数を指定(関数名)
  'admin-head-callback' => 'adminhead_cb',
  // カスタムヘッダーページのプレビュー部分に表示したいコードが書かれた関数を指定(関数名)
  'admin-preview-callback' => 'adminpreview_cb',
);
add_theme_support('custom-header', $custom_header_args);

//カスタム背景
$defaults = array(
  'default-color'          => 'fff',
  'default-image'          => '',
  'default-repeat'         => '',
  'default-position-x'     => '',
  'default-attachment'     => '',
  'wp-head-callback'       => '_custom_background_cb',
  'admin-head-callback'    => '',
  'admin-preview-callback' => '',
);
add_theme_support('custom-background', $defaults);

//カスタムメニュー
function register_my_menus() {
  register_nav_menus(
    array(
      'header-menu' => __( 'Header Menu' ),
      'extra-menu' => __( 'Extra Menu' )
     )
   );
 }
 add_action( 'init', 'register_my_menus' );

//ウィジェット
function my_theme_widgets_init() {
  register_sidebar( array(
    'name' => 'Main Sidebar',
    'id' => 'main-sidebar',
    'description' => '管理画面に表示する説明',
    'class' => '',
    'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget' => '</li>',
    'before_title' => '<h2 class="widgettitle">',
    'after_title' => '</h2>',
  ) );
 }
 add_action( 'widgets_init', 'my_theme_widgets_init' );

//投稿のサムネイルを追加
 add_theme_support( 'post-thumbnails' );