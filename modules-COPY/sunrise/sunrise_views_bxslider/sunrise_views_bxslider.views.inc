<?php

/**
 * Implements hook_views_plugins()
 */
function sunrise_views_bxslider_views_plugins() {
  return array(
      'style' => array(
          'sunrise_bxslider' => array(
              'title' => t('Sunrise bxSlider'),
              'help' => t('Display the results as a bxslider'),
              'handler' => 'sunrise_views_bxslider_plugin_style_bxslide',
              'uses options' => TRUE,
              'uses row plugin' => TRUE,
              'uses row class' => TRUE,
              'type' => 'normal',
              'theme' => 'views_bxslider',
              'theme path' => drupal_get_path('module', 'sunrise_views_bxslider') . '/theme',
              'theme file' => 'sunrise_views_bxslider.theme.inc',
          ),
      ),
  );
}