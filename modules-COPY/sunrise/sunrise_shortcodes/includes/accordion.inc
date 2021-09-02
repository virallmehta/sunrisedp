<?php

function sunrise_shortcodes_accordions_shortcode_info(&$shortcodes) {
  $shortcodes['accordions'] = array(
      'title' => t('Accordions wrapper'),
      'description' => t('Accordions wrapper shortcode'),
      'process callback' => 'sunrise_shortcodes_accordions',
      'tips callback' => 'sunrise_shortcodes_accordion_tips',
  );
}

function sunrise_shortcodes_accordions($attrs, $text) {
  $attrs['content'] = $text;
  return theme('sunrise_shortcodes_accordions', $attrs);
}

function sunrise_shortcodes_accordions_theme(&$themes) {
  $path = drupal_get_path('module', 'sunrise_shortcodes');
  $themes['sunrise_shortcodes_accordions'] = array(
      'template' => 'accordions',
      'path' => $path . '/theme',
      'pattern' => 'shortcode__',
      'preprocess functions' => array(
          'template_preprocess',
          'sunrise_shortcodes_preprocess_shortcode_accordions',
      ),
      'variables' => array(
          'content' => '',
      )
  );
}

function sunrise_shortcodes_preprocess_shortcode_accordions(&$vars) {
  $vars['accordion_wapper_id'] = drupal_html_id("sunrise_accordions_wrapper");
  $vars['content'] = str_replace('ACCORDION_WRAPPER_ID', $vars['accordion_wapper_id'], $vars['content']);
  $vars['theme_hook_suggestions'][] = 'shortcode__accordions';
}

function sunrise_shortcodes_accordion_shortcode_info(&$shortcodes) {
  $shortcodes['accordion'] = array(
      'title' => t('Accordion item'),
      'description' => t('Accordion item shortcode'),
      'process callback' => 'sunrise_shortcodes_accordion',
  );
}

function sunrise_shortcodes_accordion($attrs, $text) {
  shortcode_attrs(array('title'=>'',
      'expand' => ''
      ), $attrs);
  $attrs['content'] = $text;
  return theme('sunrise_shortcodes_accordion', $attrs);
}

function sunrise_shortcodes_accordion_theme(&$themes) {
  $path = drupal_get_path('module', 'sunrise_shortcodes');
  $themes['sunrise_shortcodes_accordion'] = array(
      'template' => 'accordion',
      'path' => $path . '/theme',
      'pattern' => 'shortcode__',
      'preprocess functions' => array(
          'template_preprocess',
          'sunrise_shortcodes_preprocess_shortcode_accordion',
      ),
      'variables' => array(
          'title' => '',
          'expand' => '',
          'content' => '',
      )
  );
}

function sunrise_shortcodes_preprocess_shortcode_accordion(&$vars) {
  
  $vars['accordion_item_id'] = drupal_html_id("sunrise_accordion_item");
  $vars['item_collapse'] = 'collapsed';
  if ($vars['expand'] == true) {
    $vars['item_active'] = 'in';
    $vars['item_collapse'] = '';
  } else {
    $vars['item_active'] = '';
  }
  $vars['theme_hook_suggestions'][] = 'shortcode__accordions';
}

function sunrise_shortcodes_accordion_tips($format, $long) {
  $output = '[accordions][accordion title="Title1"] Your content1 here [/accordion][accordion title="Title2"] Your content2 here [/accordion][/accordions]';
  return $output;
}