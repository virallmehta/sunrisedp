<?php

function sunrise_shortcodes_title_shortcode_info(&$shortcodes) {
  $shortcodes['title'] = array(
      'title' => t('Title'),
      'description' => t('Title shortcode'),
      'process callback' => 'sunrise_shortcodes_title',
      'tips callback' => 'sunrise_shortcodes_title_tips',
  );
}

function sunrise_shortcodes_title($attrs, $text) {
  $attrs = shortcode_attrs(array(
      'under_line' => '',
  ), $attrs);
  $attrs['content'] = $text;
  return theme('sunrise_shortcodes_title', $attrs);
}

function sunrise_shortcodes_title_theme(&$themes) {
  $path = drupal_get_path('module', 'sunrise_shortcodes');
  $themes['sunrise_shortcodes_title'] = array(
      'template' => 'title',
      'path' => $path . '/theme',
      'pattern' => 'shortcode__',
      'preprocess functions' => array(
          'template_preprocess',
          'sunrise_shortcodes_preprocess_shortcode_title',
      ),
      'variables' => array(
          'under_line' => '',
          'content' => '',
      )
  );
}

function sunrise_shortcodes_preprocess_shortcode_title(&$vars) {
  $vars['theme_hook_suggestions'][] = 'shortcode__title';
}

function sunrise_shortcodes_title_tips($format, $long) {
  $output = '[title under_line ="yes OR no"]TITLE HERE[/title]';
  return $output;
}