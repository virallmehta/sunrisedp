<?php

function sunrise_shortcodes_embeded_shortcode_info(&$shortcodes) {
  $shortcodes['embeded'] = array(
      'title' => t('Embeded content'),
      'description' => t('Embeded content view block '),
      'process callback' => 'sunrise_shortcodes_embeded',
      'tips callback' => 'sunrise_shortcodes_embeded_tips',
  );
}

function sunrise_shortcodes_embeded($attrs, $text) {
  $attrs = shortcode_attrs(array(
      'view_name' => '',
      'block_id' => '', 
  ), $attrs);
  return theme('sunrise_shortcodes_embeded', $attrs);
}

function sunrise_shortcodes_embeded_theme(&$themes) {
  $path = drupal_get_path('module', 'sunrise_shortcodes');
  $themes['sunrise_shortcodes_embeded'] = array(
      'template' => 'embeded',
      'path' => $path . '/theme',
      'pattern' => 'shortcode__',
      'preprocess functions' => array(
          'template_preprocess',
          'sunrise_shortcodes_preprocess_shortcode_embeded',
      ),
      'variables' => array(
          'view_name' => '',
          'block_id' => '',
      )
  );
}

function sunrise_shortcodes_preprocess_shortcode_embeded(&$vars) {
  $vars['theme_hook_suggestions'][] = 'shortcode__embeded';
}

function sunrise_shortcodes_embeded_tips($long, $format) {
  $output = "[embeded view_name='' block_id =''][/embeded]";
  return $output;
}