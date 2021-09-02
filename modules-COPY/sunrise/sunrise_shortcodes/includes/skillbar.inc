<?php

function sunrise_shortcodes_skillbar_shortcode_info(&$shortcodes) {
  $shortcodes['skillbar'] = array(
      'title' => t('Skill bar'),
      'description' => t('Skill bar shortcode'),
      'process callback' => 'sunrise_shortcodes_skillbar',
      'tips callback' => 'sunrise_shortcodes_skillbar_tips',
  );
}

function sunrise_shortcodes_skillbar($attrs, $text) {
  $attrs = shortcode_attrs(array(
      'percent' => '',
   ), $attrs);
  $attrs['content'] = $text;
  return theme('sunrise_shortcodes_skillbar',$attrs);
}

function sunrise_shortcodes_skillbar_theme(&$themes) {
  $path = drupal_get_path('module', 'sunrise_shortcodes');
  $themes['sunrise_shortcodes_skillbar'] = array(
      'template' => 'skillbar',
      'path' => $path . '/theme',
      'pattern' => 'shortcode__',
      'preprocess functions' => array(
          'template_preprocess',
          'sunrise_shortcodes_preprocess_shortcode_skillbar',
      ),
      'variables' => array(
          'percent' => '',
          'content' => ''
      )
  );
}

function sunrise_shortcodes_preprocess_shortcode_skillbar(&$vars) {
  $vars['element_id'] = drupal_html_id('skill_bar');
  $vars['theme_hook_suggestions'][] = 'shortcode__skillbar';
}

function sunrise_shortcodes_skillbar_tips($format, $long) {
  $output = "[skillbar percent='']Title[/skillbar]";
  return $output;
}