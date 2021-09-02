<?php

function sunrise_shortcodes_box_shortcode_info(&$shortcodes) {
  $shortcodes['box'] = array(
      'title' => t('Boxes'),
      'description' => t('Create a block content with icon'),
      'process callback' => 'sunrise_shortcodes_box',
      'tips callback' => 'sunrise_shortcodes_box_tips',
  );
}

function sunrise_shortcodes_box($attrs, $text) {
  $attrs = shortcode_attrs(array(
      'title' => '',
      'border' => 'none',//none,square,circle
      'background' => 'no',
      'align' => 'center',//left,center,right
      'icon' => ''), $attrs
  );
  $attrs['content'] = $text;
  return theme('sunrise_shortcodes_box', $attrs);
}

function sunrise_shortcodes_box_theme(&$themes) {
  $path = drupal_get_path('module', 'sunrise_shortcodes');
  $themes['sunrise_shortcodes_box'] = array(
      'template' => 'box',
      'path' => $path . '/theme',
      'pattern' => 'shortcode__',
      'preprocess functions' => array(
          'template_preprocess',
          'sunrise_shortcodes_preprocess_shortcode_box',
      ),
      'variables' => array(
          'title' => '',
          'border' => 'none',
          'background' =>'no',
          'align' => 'center',
          'icon' =>'',
          'content' => '',
      )
  );
}

function sunrise_shortcodes_preprocess_shortcode_box(&$vars) {
  $border = $vars['border'];
  $align = $vars['align'];
  if($vars['background'] == 'yes'){
    $vars['classes_array'][] = 'box-background';
  }
  $vars['classes_array'][] = 'box-'.$border;
  $vars['classes_array'][] = 'box-'.$align;
  $vars['theme_hook_suggestions'][] = 'shortcode__box__' . $align;
  $vars['theme_hook_suggestions'][] = 'shortcode__box__' . $align.'__'.$border;
}

function sunrise_shortcodes_box_tips($long, $format) {
  $output = "[box title='' border='yes|no' background='yes|no', align='left|center|right' icon='fa fa-ICON']Content here[/box]";
  return $output;
}