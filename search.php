<?php get_header(); ?>
<div class="main-wrap">
  <main>
    <div class="container-fluid py-5">
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
          <div class="my-5">
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <?php the_excerpt(); ?>
          </div>
      <?php endwhile; endif; ?>
    </div>
  </main>
</div>
<?php get_footer(); ?>