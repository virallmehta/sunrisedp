<?php

function sunrise_shortcodes_stats_shortcode_info(&$shortcodes) {
  $shortcodes['stats'] = array(
      'title' => t('Stats'),
      'description' => t('Js Stats shortcode'),
      'process callback' => 'sunrise_shortcodes_stats',
      'tips callback' => 'sunrise_shortcodes_stats_tips',
  );
}

function sunrise_shortcodes_stats($attrs, $text) {
  $attrs = shortcode_attrs(array(
      'class' => '',
      'timer' => '',
      'number' => ''), $attrs);
  $attrs['content'] = $text;
  return trim(theme('sunrise_shortcodes_stats', $attrs));
}

function sunrise_shortcodes_stats_theme(&$themes) {
  $path = drupal_get_path('module', 'sunrise_shortcodes');
  $themes['sunrise_shortcodes_stats'] = array(
      'template' => 'stats',
      'path' => $path . '/theme',
      'pattern' => 'shortcode__',
      'preprocess functions' => array(
          'template_preprocess',
          'sunrise_shortcodes_preprocess_shortcode_stats',
      ),
      'variables' => array(
          'class' => '',
          'timer' => '',
          'number' => '',
          'content' => '',
      )
  );
}

function sunrise_shortcodes_preprocess_shortcode_stats(&$vars) {
  $vars['stats_id'] = drupal_html_id("sunrise_stats");
  $vars['theme_hook_suggestions'][] = 'shortcode__button';
}

function sunrise_shortcodes_stats_tips($format,$long) {
  $output = "[stats timer='' number='' class='']Title[/stats]";
  return $output;
}