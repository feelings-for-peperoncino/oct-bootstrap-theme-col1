<div class="footer-wrap">
  <footer class="p-footer">
    <div class="container-fluid text-center py-5">
      <!-- カスタムウィジェット -->
      <div class="text-start mb-5">
        <?php if (is_active_sidebar('main-sidebar')) : ?>
          <ul class="menu">
            <?php dynamic_sidebar('main-sidebar'); ?>
          </ul>
        <?php endif; ?>
      </div>
      <div class="mb-5">
        <?php get_search_form(); ?>
      </div>
      <small>(c)Project Oct</small>
    </div>
  </footer>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<?php wp_footer(); ?>
</body>

</html>