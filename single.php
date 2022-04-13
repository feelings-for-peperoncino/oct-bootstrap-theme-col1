<?php get_header(); ?>
<div class="main-wrap">
  <main>
    <div class="container-fluid py-5">
      <?php while (have_posts()) : the_post(); ?>
        <div class="mb-5">
          <?php the_post_thumbnail(); ?>
        </div>
        <h1><?php the_title(); ?></h1>
        <p class="mb-0"><?php the_author(); ?></p>
        <p><?php the_time("Y.m.d"); ?></p>
        <div class="mb-5">
        <?php the_content(); ?>
        </div>
      <?php endwhile; ?>
      <?php the_post_navigation(); ?>
    </div>
  </main>
</div>
<?php get_footer(); ?>