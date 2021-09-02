<div class="<?php print $classes;?>">
  <?php if ($icon): ?>
    <div class="box-icon"><i class="<?php print $icon; ?>"></i></div>
  <?php endif; ?>
  <?php if ($title): ?>
    <h3 class="box-title"><?php print $title; ?></h3>
  <?php endif; ?>
  <?php if ($content): ?>
    <div class="box-content"><?php print $content; ?></div>
  <?php endif; ?>
</div>