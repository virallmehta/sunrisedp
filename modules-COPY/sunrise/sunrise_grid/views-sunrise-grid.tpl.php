<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
<?php 
$lg_zise = round(12/$options['grid_cols_lg']);
$md_zise = round(12/$options['grid_cols_md']);
$sm_zise = round(12/$options['grid_cols_sm']);
$xs_zise = round(12/$options['grid_cols_xs']);
$span_class = $options['grid_bootstrap']?" col-lg-{$lg_zise} col-md-{$md_zise} col-sm-{$sm_zise} col-xs-{$xs_zise}" : "";
?>
<div class="sunrise-grid-items">
  <div class="row">
    <?php foreach($rows as $row):?>
      <div class="sunrise-grid-item<?php print $span_class?>">
        <?php print $row; ?>
      </div>
    <?php endforeach;?>
  </div>
</div>