<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
  <!-- <link rel="stylesheet" href="css/bootstrap.css"> -->


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
                  <?php $description = get_bloginfo( 'description', 'display' ); if ($description) : ?>
                  <p class="p-header__info"><?php bloginfo('description'); ?></p>
                  <?php endif; ?>
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