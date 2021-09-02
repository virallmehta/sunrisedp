<?php

function sunrise_shortcodes_icon_shortcode_info(&$shortcodes) {
  $shortcodes['icon'] = array(
      'title' => t('Icon'),
      'description' => t('Create Icon shortcode'),
      'process callback' => 'sunrise_shortcodes_icon',
      'tips callback' => 'sunrise_shortcodes_icon_tips',
  );
}

function sunrise_shortcodes_icon($attrs, $text) {
  $attrs = shortcode_attrs(array(
      'class' => '', // font awesome class 
      'link' => ''), $attrs);
  $attrs['content'] = $text;
  return trim(theme('sunrise_shortcodes_icon', $attrs));
}

function sunrise_shortcodes_icon_theme(&$themes) {
  $path = drupal_get_path('module', 'sunrise_shortcodes');
  $themes['sunrise_shortcodes_icon'] = array(
      'template' => 'icon',
      'path' => $path . '/theme',
      'pattern' => 'shortcode__',
      'preprocess functions' => array(
          'template_preprocess',
          'sunrise_shortcodes_preprocess_shortcode_icon',
      ),
      'variables' => array(
          'class' => '',
          'link' => '',
          'content' => '',
      )
  );
}

function sunrise_shortcodes_preprocess_shortcode_icon(&$vars) {
  $vars['theme_hook_suggestions'][] = 'shortcode__icon';
}

function sunrise_shortcodes_icon_tips($format, $long) {
  $output = "[icon class='' link='']TEXT_HERE[/icon]";
  return $output;
}