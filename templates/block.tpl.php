<<?php print $tag; ?> id="<?php print $block_html_id; ?>" class="<?php print $block->delta . ' '  ?> <?php print $classes; ?>"<?php print $attributes; ?>>
  <div class="block-contents">
  <?php print render($title_prefix); ?>
  <?php if ($title): ?>
  	<div class="block-head">
    <h2<?php print $title_attributes; ?>><span><?php print $title; ?></span></h2>
   </div>
  <?php endif; ?>
  <?php print render($title_suffix); ?>
  <div class="content"<?php print $content_attributes; ?>>
    <?php print $content; ?>
  </div>
</div>
</<?php print $tag; ?>><!-- /.block -->
