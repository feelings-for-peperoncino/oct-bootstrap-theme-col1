<?php get_header(); ?>
<div class="main-wrap">
    <main>
      <div class="container-fluid py-5">
        <h1><?php the_title(); ?></h1>
        <?php the_content(); ?>
      </div>
    </main>
</div>
<?php get_footer(); ?>