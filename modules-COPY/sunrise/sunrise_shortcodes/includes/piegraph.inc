<?php

function sunrise_shortcodes_piegraph_shortcode_info(&$shortcodes) {
  $shortcodes['piegraph'] = array(
      'title' => t('Pie Graph'),
      'description' => t('Draw percer circle use HTML5 canvas'),
      'process callback' => 'sunrise_shortcodes_piegraph',
      'tips callback' => 'sunrise_shortcodes_piegraph_tips',
  );
}

function sunrise_shortcodes_piegraph($attrs, $text) {
  $attrs = shortcode_attrs(array(
      'title' => '',
      'percent' => '0',
      'width' => '200'), $attrs
  );
  $attrs['content'] = $text;
  return theme('sunrise_shortcodes_piegraph', $attrs);
}

function sunrise_shortcodes_piegraph_theme(&$themes) {
  $path = drupal_get_path('module', 'sunrise_shortcodes');
  $themes['sunrise_shortcodes_piegraph'] = array(
      'template' => 'piegraph',
      'path' => $path . '/theme',
      'pattern' => 'shortcode__',
      'preprocess functions' => array(
          'template_preprocess',
          'sunrise_shortcodes_preprocess_shortcode_piegraph',
      ),
      'variables' => array(
          'title' => '',
          'percent' => '',
          'width' => '',
          'content' => '',
      )
  );
}

function sunrise_shortcodes_preprocess_shortcode_piegraph(&$vars) {
  $vars['element_id'] = drupal_html_id("sunrise_piegraph".REQUEST_TIME);
  $vars['theme_hook_suggestions'][] = 'shortcode__piegraph';
}

function sunrise_shortcodes_piegraph_tips($format, $long) {
  $output = "[piegraph title='' percent='' width='']Content[/piegraph]";
  return $output;
}