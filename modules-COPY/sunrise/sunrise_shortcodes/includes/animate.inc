<?php

function sunrise_shortcodes_animate_shortcode_info(&$shortcodes) {
  $shortcodes['animate'] = array(
      'title' => t('Animate appears'),
      'description' => t('Add appears animate to content'),
      'process callback' => 'sunrise_shortcodes_animate',
  );
}

function sunrise_shortcodes_animate($attrs, $text) {
  $attrs = shortcode_attrs(array(
      'type' => 'fade',
      ), $attrs
  );
  $attrs['content'] = $text;
  return '<div class="sunrise-animate" data-animate="'.$attrs['type'].'">'.$text.'</div>';
}