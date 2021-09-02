<?php

/**
 * Implements hook_views_plugins
 */
function sunrise_grid_views_plugins() {
  return array(
      'style' => array(
          'sunrise_grid2' => array(
              'title' => t('Sunrise Responsive Grid'),
              'help' => t('Display content in a responsive grid.'),
              'handler' => 'sunrise_grid_plugin_style_grid',
              //'path' => drupal_get_path('module', 'sunrise_portfolio') . '/views',
              'uses options' => TRUE,
              'uses row plugin' => TRUE,
              'uses row class' => TRUE,
              'type' => 'normal',
              'theme' => 'views_sunrise_grid',
              //'theme path' => drupal_get_path('module', 'sunrise_portfolio') . '/theme',
              //'theme file' => 'sunrise_grid.theme.inc',
          ),
      ),
  );
}