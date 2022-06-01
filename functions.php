<?php

//スタイルシート
function enqueue_name() {
  wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');

  wp_enqueue_style('bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css');

  wp_enqueue_style('my_style', get_stylesheet_uri());

}
add_action('wp_enqueue_scripts', 'enqueue_name');

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
  'flex-width' => true,
  // ヘッダー画像の縦幅を自由に切り取れるかどうか(trueもしくはfalse)
  'flex-height' => true,
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

//headerの背景色をカスタマイザーから変更
add_action('customize_register', function ($wp_customize) {
  $wp_customize->add_setting('header_color', array(
    'default' => '#f8f9fa',
    'sanitize_callback' => 'sanitize_hex_color',
  ));
  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'header_color', array(
    'label' => 'ヘッダーの背景色',
    'section' => 'colors',
    'settings' => 'header_color',
  )));
});




//カスタムメニュー
function register_my_menus()
{
  register_nav_menus(
    array(
      'header-menu' => __('Header Menu'),
      'extra-menu' => __('Extra Menu')
    )
  );
}
add_action('init', 'register_my_menus');

//ウィジェット
function my_theme_widgets_init()
{
  register_sidebar(array(
    'name' => 'Main Sidebar',
    'id' => 'main-sidebar',
    'description' => '管理画面に表示する説明',
    'class' => '',
    'before_widget' => '<li id="%1$s" class="widget %2$s mb-4">',
    'after_widget' => '</li>',
    'before_title' => '<h2 class="widgettitle">',
    'after_title' => '</h2>',
  ));
}
add_action('widgets_init', 'my_theme_widgets_init');

//投稿のサムネイルを追加
add_theme_support('post-thumbnails');

//パンくずリスト
if (!function_exists('custom_breadcrumb')) {
  function custom_breadcrumb()
  {

    // トップページでは何も出力しないように
    if (is_front_page()) return false;

    //そのページのWPオブジェクトを取得
    $wp_obj = get_queried_object();

    //JSON-LD用のデータを保持する変数
    $json_array = array();

    echo '<div id="breadcrumb">' . //id名などは任意で
      '<ul>' .
      '<li>' .
      '<a href="' . esc_url(home_url()) . '"><span>ホーム</span></a> > ' .
      '</li>';

    if (is_attachment()) {

      //添付ファイルページ ( $wp_obj : WP_Post )
      $post_title = apply_filters('the_title', $wp_obj->post_title);
      echo '<li><span>' . esc_html($post_title) . '</span></li>';
    } elseif (is_single()) {

      //投稿ページ ( $wp_obj : WP_Post )
      $post_id = $wp_obj->ID;
      $post_type = $wp_obj->post_type;
      $post_title = apply_filters('the_title', $wp_obj->post_title);

      // カスタム投稿タイプかどうか
      if ($post_type !== 'post') {

        $the_tax = ""; //そのサイトに合わせて投稿タイプごとに分岐させて明示的に指定してもよい

        // 投稿タイプに紐づいたタクソノミーを取得 (投稿フォーマットは除く)
        $tax_array = get_object_taxonomies($post_type, 'names');
        foreach ($tax_array as $tax_name) {
          if ($tax_name !== 'post_format') {
            $the_tax = $tax_name;
            break;
          }
        }

        $post_type_link = esc_url(get_post_type_archive_link($post_type));
        $post_type_label = esc_html(get_post_type_object($post_type)->label);

        //カスタム投稿タイプ名の表示
        echo '<li>' .
          '<a href="' . $post_type_link . '">' .
          '<span>' . $post_type_label . '</span>' .
          '</a>' .
          '</li>';

        //JSON-LDデータ
        $json_array[] = array(
          'id' => $post_type_link,
          'name' => $post_type_label
        );
      } else {
        $the_tax = 'category'; //通常の投稿の場合、カテゴリーを表示
      }

      // 投稿に紐づくタームを全て取得
      $terms = get_the_terms($post_id, $the_tax);

      // タクソノミーが紐づいていれば表示
      if ($terms !== false) {

        $child_terms = array(); // 子を持たないタームだけを集める配列
        $parents_list = array(); // 子を持つタームだけを集める配列

        //全タームの親IDを取得
        foreach ($terms as $term) {
          if ($term->parent !== 0) {
            $parents_list[] = $term->parent;
          }
        }

        //親リストに含まれないタームのみ取得
        foreach ($terms as $term) {
          if (!in_array($term->term_id, $parents_list)) {
            $child_terms[] = $term;
          }
        }

        // 最下層のターム配列から一つだけ取得
        $term = $child_terms[0];

        if ($term->parent !== 0) {

          // 親タームのIDリストを取得
          $parent_array = array_reverse(get_ancestors($term->term_id, $the_tax));

          foreach ($parent_array as $parent_id) {
            $parent_term = get_term($parent_id, $the_tax);
            $parent_link = esc_url(get_term_link($parent_id, $the_tax));
            $parent_name = esc_html($parent_term->name);
            echo '<li>' .
              ' <a href="' . $parent_link . '">' .
              '<span>' . $parent_name . '</span>' .
              '</a> > ' .
              '</li>';
            //JSON-LDデータ
            $json_array[] = array(
              'id' => $parent_link,
              'name' => $parent_name
            );
          }
        }

        $term_link = esc_url(get_term_link($term->term_id, $the_tax));
        $term_name = esc_html($term->name);
        // 最下層のタームを表示
        echo '<li>' .
          ' <a href="' . $term_link . '">' .
          '<span>' . $term_name . '</span>' .
          '</a> > ' .
          '</li>';
        //JSON-LDデータ
        $json_array[] = array(
          'id' => $term_link,
          'name' => $term_name
        );
      }

      // 投稿自身の表示
      echo '<li><span> ' . esc_html(strip_tags($post_title)) . '</span></li>';
    } elseif (is_page() || is_home()) {

      //固定ページ ( $wp_obj : WP_Post )
      $page_id = $wp_obj->ID;
      $page_title = apply_filters('the_title', $wp_obj->post_title);

      // 親ページがあれば順番に表示
      if ($wp_obj->post_parent !== 0) {
        $parent_array = array_reverse(get_post_ancestors($page_id));
        foreach ($parent_array as $parent_id) {
          $parent_link = esc_url(get_permalink($parent_id));
          $parent_name = esc_html(get_the_title($parent_id));
          echo '<li>' .
            '<a href="' . $parent_link . '">' .
            '<span>' . $parent_name . '</span>' .
            '</a> > ' .
            '</li>';
          //JSON-LDデータ
          $json_array[] = array(
            'id' => $parent_link,
            'name' => $parent_name
          );
        }
      }
      // 投稿自身の表示
      echo '<li><span>' . esc_html(strip_tags($page_title)) . '</span></li>';
    } elseif (is_archive()) {

      //タームアーカイブ ( $wp_obj : WP_Term )
      $term_id = $wp_obj->term_id;
      $term_name = $wp_obj->name;
      $tax_name = $wp_obj->taxonomy;

      // 親ページがあれば順番に表示
      if ($wp_obj->parent !== 0) {

        $parent_array = array_reverse(get_ancestors($term_id, $tax_name));
        foreach ($parent_array as $parent_id) {
          $parent_term = get_term($parent_id, $tax_name);
          $parent_link = esc_url(get_term_link($parent_id, $tax_name));
          $parent_name = esc_html($parent_term->name);
          echo '<li>' .
            ' <a href="' . $parent_link . '">' .
            '<span>' . $parent_name . '</span>' .
            '</a> > ' .
            '</li>';
          //JSON-LDデータ
          $json_array[] = array(
            'id' => $parent_link,
            'name' => $parent_name
          );
        }
      }

      // ターム自身の表示
      echo '<li>' .
        ' <span>' . esc_html($term_name) . '</span>' .
        '</li>';
    } else {

      //その他のページ
      echo '<li><span>' . esc_html(get_the_title()) . '</span></li>';
    }
    echo '</ul>';

    //JSON-LDの出力（２階層以上であれば）
    if (!empty($json_array)) :
      $pos = 1;
      $json = '';
      foreach ($json_array as $data) :
        $json .= '{
  "@type": "ListItem",
  "position": ' . $pos++ . ',
  "item": {
  "@id": "' . $data['id'] . '",
  "name": "' . $data['name'] . '"
  }
  },';
      endforeach;

      echo '<script type="application/ld+json">{
  "@context": "http://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [' . rtrim($json, ',') . ']
  }</script>';
    endif;

    echo '</div>'; // 冒頭に合わせた閉じタグ

  }
}
