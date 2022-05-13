<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
  <!-- <link rel="stylesheet" href="css/bootstrap.css"> -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <div class="header-wrap">
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-xxl">
            <!-- 検討中 -->
            <div class="d-flex align-items-center">
              <!-- カスタムロゴ -->
              <?php
              if (function_exists('the_custom_logo')) {
                the_custom_logo();
              }
              ?>
              <div>
                <?php
                if (display_header_text()) {
                ?>
                  <h1 class="p-header__ttl">
                    <a href="<?php echo esc_url(home_url('/')); ?>">
                      <?php bloginfo('name'); ?>
                    </a>
                  </h1>
                  <p class="p-header__info"><?php bloginfo('description'); ?></p>
                <?php
                }
                ?>
              </div>
            </div>
            <!-- 検討中 -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <!-- カスタムメニュー -->
            <?php wp_nav_menu(array(
              'theme_location' => 'header-menu',
              'container' => 'div',
              'container_id' => 'navbarSupportedContent',
              'container_class' => 'collapse navbar-collapse',
              'menu_class' => 'navbar-nav me-auto mb-2 mb-lg-0',
              'fallback_cb' => ''
            )); ?>

          </div>
        </nav>

        <!-- カスタムメインビュー -->
        <?php if (get_header_image()) : ?>
          <div class="smple">
            <img src="<?php header_image(); ?>" width="100%" alt="">
          </div>
        <?php endif; ?>

      <!-- パンくずリスト -->
      <div class="container-fluid">
        <?php custom_breadcrumb(); ?>
      </div>
    </header>

  </div>