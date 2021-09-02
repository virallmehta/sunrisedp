<?php
/**
 * @file
 * Contains theme override functions and preprocess functions for the sunrise theme.
 */

// Auto-rebuild the theme registry during theme development.
if (theme_get_setting('sunrise_rebuild_registry') && !defined('MAINTENANCE_MODE')) {
  // Rebuild .info data.
  system_rebuild_theme_data();
  // Rebuild theme registry.
  drupal_theme_rebuild();
}

/*
 * Override or insert variables into the html template.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered. This is usually "html", but can
 *   also be "maintenance_page" since sunrise_preprocess_maintenance_page() calls
 *   this function to have consistent variables.
 */
function sunrise_preprocess_html(&$vars, $hook) {
    $library = libraries_get_libraries();
    $path = $library['bxslider'];
    drupal_add_css($path . '/jquery.bxslider.css');
    drupal_add_js($path . '/jquery.bxslider.min.js');

   /* Body background scheme goes here -----------*/
    if(theme_get_setting('custom_bg_attribute') == '') {
    	$css = 'body { background: url("' . $GLOBALS["base_url"] . base_path() . path_to_theme() . '/images/bg/' . theme_get_setting("bg_scheme"). '") repeat;';
    }
    else {
        $css = 'body{ background: ' . theme_get_setting("custom_bg_attribute") . ';';
    }   	
	
	drupal_add_css(
      $css,
      array(
        'group' => CSS_THEME,
        'type' => 'inline',
        'media' => 'screen',
        'preprocess' => FALSE,
        'weight' => '9999',
      )
    );
}

/**
 *  Implementation of hook_css_alter().
 */
function sunrise_css_alter(&$css) {
  // For each item, don't allow preprocessing to disable @import.
  foreach ($css as &$item) {
    if (file_exists($item['data'])) {
      $item['preprocess'] = FALSE;
    }
  }
}

function sunrise_preprocess_page(&$vars) {
  global $current_theme_path;
  $current_theme_path = base_path() . path_to_theme();  
  // Page tpl suggestions
  if (isset($vars['node'])) {
    // If the node type is "blog_madness" the template suggestion will be "page--blog-madness.tpl.php".
    $vars['theme_hook_suggestions'][] = 'page__'. $vars['node']->type;
  }
  // Unset Front Page System Message
  if (drupal_is_front_page()) {
    $vars['title'] = '';  
  }
  // Unset Drupal Default HTML contnet
  if(drupal_is_front_page()) {
    unset($vars['page']['content']['system_main']['default_message']);
  }

  // Get the entire main menu tree
  $main_menu_tree = menu_tree_all_data('main-menu');
  // Add the rendered output to the $main_menu_expanded variables
  $vars['main_menu_expanded'] = menu_tree_output($main_menu_tree);  

  // Primary nav
  $vars['primary_nav'] = FALSE;
  if ($vars['main_menu']) {
    // Build links
    $vars['primary_nav'] = menu_tree(variable_get('menu_main_links_source', 'main-menu'));
    // Provide default theme wrapper function
    $vars['primary_nav']['#theme_wrappers'] = array('menu_tree__primary');
  }

  // Secondary nav
  $vars['secondary_nav'] = FALSE;
  if ($vars['secondary_menu']) {
    // Build links
    $vars['secondary_nav'] = menu_tree(variable_get('menu_secondary_links_source', 'user-menu'));
    // Provide default theme wrapper function
    $vars['secondary_nav']['#theme_wrappers'] = array('menu_tree__secondary');
  }  

  $vars['main_content'] = "col-xs-12 col-sm-12 col-md-12 col-lg-12";
  $vars['sidebar'] = "";

  if (_sunrise_region_has_block('sidebar_first') and _sunrise_region_has_block('sidebar_second')) {
    $vars['main_content'] = "col-xs-12 col-sm-12 col-md-6 col-lg-6";
    $vars['sidebar'] = "col-xs-12 col-sm-12 col-md-3 col-lg-3";
  }
  else if ( _sunrise_region_has_block('sidebar_first') or _sunrise_region_has_block('sidebar_second')) {
    $vars['main_content'] = "col-xs-12 col-sm-12 col-md-9 col-lg-9";
    $vars['sidebar'] = "col-xs-12 col-sm-12 col-md-3 col-lg-3";
  }

  $vars['copyright_site_name'] = $vars['site_name'];
  $vars['site_name'] = '';
  $vars['site_by'] = l(t('Sunrise Softlab'), 'http://www.sunrisesoftlab.com');

}

function sunrise_preprocess_node(&$vars) {
  global $base_path;

  // Add node-type-page template suggestion
  if ($vars['page']) {
    $vars['theme_hook_suggestions'][] = 'node__'. $vars['node']->type . '__'.$vars['view_mode'];
    $vars['theme_hook_suggestions'][] = 'node__'. $vars['node']->type .'-page';
    $vars['theme_hook_suggestions'][] = 'node__'. $vars['node']->type .'-'. $vars['node']->nid .'-page';
  }
  else {
    $vars['theme_hook_suggestions'][] = 'node__'. $vars['node']->type . '__'.$vars['view_mode'];
    $vars['theme_hook_suggestions'][] = 'node__'. $vars['node']->type .'-teaser';
    $vars['theme_hook_suggestions'][] = 'node__'. $vars['node']->nid;
  }

    // Add $unpublished variable.
    $vars['unpublished'] = (!$vars['status']) ? TRUE : FALSE; 
    // Class for each view mode, core assumes we only need to target teasers but neglects custom view modes or full
    if ($vars['view_mode'] !== 'teaser') {
      $vars['classes_array'][] = drupal_html_class('node-' . $vars['view_mode']);
    }

    // Langauge
    if (module_exists('translation')) {
      if ($vars['node']->language) {
          $vars['classes_array'][] = 'node-lang-' . $vars['node']->language;
      }
    }

    //
    // AT Core builds additional time and date variables for use in templates
    //
    // datetime stamp formatted correctly to ISO8601
    $vars['datetime'] = format_date($vars['created'], 'custom', 'F d, Y'); // PHP 'c' format is not proper ISO8601!

    // Publication date, formatted with time element
    $vars['publication_date'] = '<time datetime="' . $vars['datetime'] . '" pubdate="pubdate">' . $vars['datetime'] . '</time>';

    // Last update variables
    $vars['datetime_updated'] = format_date($vars['node']->changed, 'custom', 'Y-m-d\TH:i:sO');
    $vars['custom_date_and_time'] = date('jS F, Y - g:ia', $vars['node']->changed);

    // Last updated formatted in time element
    $vars['last_update'] = '<time datetime="' . $vars['datetime_updated'] . '" pubdate="pubdate">' . $vars['custom_date_and_time'] . '</time>';

    // Build the submitted variable used by default in node templates
    if (variable_get('node_submitted_' . $vars['node']->type, TRUE)) {
      $vars['submitted'] = t('<i class="icon-calendar"></i> !datetime  <i class="icon-user"></i> by !username ',
        array(
          '!username' => $vars['name'],
          '!datetime' => $vars['publication_date'],
        )
      );
    }
    else {
      $vars['submitted'] = '';
    }
}

function sunrise_preprocess_region(&$vars) {
  $vars['class_array'][] = drupal_region_class($vars['region']);
  $vars['theme_hook_suggestions'][] = 'region__' . $vars['region'];
}

function sunrise_preprocess_block(&$vars) {
  // Provide additional suggestions so the block__menu suggestion can be overridden easily
  $vars['theme_hook_suggestions'][] = 'block__' . $vars['block']->region . '__' . $vars['block']->module;
  $vars['theme_hook_suggestions'][] = 'block__' . $vars['block']->region . '__' . $vars['block']->delta;

  // Block subject, under certain conditions, is not set
  $vars['tag'] = 'div';
  $vars['title'] = '';
 

  if (isset($vars['block']->subject)) {
    if (!empty($vars['block']->subject)) {
    // Generate the wrapper element, if there's a title use section
    $vars['tag'] = 'section';

    // Use a $title variable instead of $block->subject
    $vars['title'] = $vars['block']->subject;
  } // subject can be set and empty, i.e. using <none>
    else {
        $vars['classes_array'][] = 'no-title';
    }
  } // sometimes subject is not set at all
  else {
    $vars['classes_array'][] = 'no-title';
  } 

  // The menu bar region gets special treatment for the block template
  if ($vars['block']->region === 'menu_bar') {
  // They are always menu blocks, right?
    $vars['tag'] = 'nav';
  }

  // Zebra.
  $vars['classes_array'][] = $vars['block_zebra'];

  $vars['classes_array'][] =  drupal_html_class('block-' . 'asa');
  // Count.
  $vars['classes_array'][] = 'block-count-' . $vars['id'];
  // Region.
  $vars['classes_array'][] = drupal_html_class('block-region-' . $vars['block']->region);
  // Delta.
  $vars['classes_array'][] = drupal_html_class('block-' . $vars['block']->delta);

  // Main Top Dynamic Columns Width
  if(_sunrise_region_has_block('main_top')) {
    $no_of_blocks_main_top = count(block_list('main_top'));
    $classes_main_top =  _sunrise_get_cloumn($no_of_blocks_main_top);
  }

  // Main Upper Dynamic Columns Width
  if(_sunrise_region_has_block('main_upper')) {
    $no_of_blocks_main_upper = count(block_list('main_upper'));
    $classes_main_upper =  _sunrise_get_cloumn($no_of_blocks_upper);
  }

  // Main Lower Dynamic Columns Width
  if(_sunrise_region_has_block('main_lower')) {
    $no_of_blocks_lower = count(block_list('main_lower'));
    $classes_main_lower =  _sunrise_get_cloumn($no_of_blocks_lower);

    ///drupal_set_message('<pre>' . check_plain(var_export($vars, TRUE)) . '</pre>');
  }  

  // Main Bottom Dynamic Columns Width
  if(_sunrise_region_has_block('main_bottom')) {
    $no_of_blocks_bottom = count(block_list('main_bottom'));
    $classes_main_bottom =  _sunrise_get_cloumn($no_of_blocks_bottom);
  }

  // // Footer Dynamic Columns Width
  // if(_sunrise_region_has_block('footer')) {
  //   $no_of_blocks_footer = count(block_list('footer'));
  //   $classes_footer =  _sunrise_get_cloumn($no_of_blocks_footer);
  // }  


  // Grid Column class
  switch( $vars['block']->region ) {
    case 'main_top':
        $vars['classes_array'][] = $classes_main_top;
      break;
    case 'main_upper':
      $vars['classes_array'][] = $classes_main_upper;
      break;
    case 'main_lower':
      $vars['classes_array'][] = $classes_main_lower;
      break;
    case 'main_bottom':
      $vars['classes_array'][] = $classes_main_bottom;
      break;
    case 'footer':
      //$vars['classes_array'][] = $classes_footer;
      break;
  } 
  

  // Add class to block title.
  if (!isset($vars['title_attributes_array']['class'])) {
    $vars['title_attributes_array']['class'] = array();
  }
  $vars['title_attributes_array']['class'][] = 'block-title';

  // Add class to block content.
  if (!isset($vars['content_attributes_array']['class'])) {
    $vars['content_attributes_array']['class'] = array();
  }
  $vars['content_attributes_array']['class'][] = 'block-content';

}

function sunrise_status_messages($vars) {
  $display = $vars['display'];
  $output = '';

  $status_heading = array(
    'status' => t('Status message'),
    'error' => t('Error message'),
    'warning' => t('Warning message'),
  );

  $status_class = array(
    'status' => 'success',
    'error' => 'danger',
    'warning' => 'warning',
  );

  foreach (drupal_get_messages($display) as $type => $messages) {

    $class = (isset($status_class[$type])) ? ' alert-' . $status_class[$type] : '';

    $output .= '<div class="alert alert-dismissable fade in';
    $output .=  $class;
    $output .= '" role="alert">';
    $output .= '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>';
    $output .= "<div class=\" raw \">\n";
    if (!empty($status_heading[$type])) {
      $output .= '<h2 class="element-invisible">' . $status_heading[$type] . "</h2>\n";
    }

    if (count($messages) > 1) {
      $output .= " <ul>\n";
      foreach ($messages as $message) {
        $output .= '  <li>' . $message . "</li>\n";
      }
      $output .= " </ul>\n";
    }
    else {
      $output .= $messages[0];
    }
    $output .= "</div><!-- /raw -->\n";
    $output .= "</div>\n";
  }
  return $output;  
}

/**
 * Returns HTML for a form element.
 */
function sunrise_form_element(&$variables) {
  $element = &$variables['element'];
  // This is also used in the installer, pre-database setup.
  $t = get_t();

  // This function is invoked as theme wrapper, but the rendered form element
  // may not necessarily have been processed by form_builder().
  $element += array(
    '#title_display' => 'before',
  );

  // Add element #id for #type 'item'.
  if (isset($element['#markup']) && !empty($element['#id'])) {
    $attributes['id'] = $element['#id'];
  }

  $exclude_control = FALSE;
  $control_wrapper = '<div class="controls">';
  // Add bootstrap class
  if (isset($element['#type']) && ($element['#type'] == "radio" || $element['#type'] == "checkbox")){
    $exclude_control = TRUE;
  }
  else {
    $attributes['class'] = array('control-group');
  }

  // Check for errors and set correct error class
  if (isset($element['#parents']) && form_get_error($element)) {
    $attributes['class'][] = 'error';
  }

  if (!empty($element['#type'])) {
    $attributes['class'][] = 'form-type-' . strtr($element['#type'], '_', '-');
  }
  if (!empty($element['#name'])) {
    $attributes['class'][] = 'form-item-' . strtr($element['#name'], array(' ' => '-', '_' => '-', '[' => '-', ']' => ''));
  }
  // Add a class for disabled elements to facilitate cross-browser styling.
  if (!empty($element['#attributes']['disabled'])) {
    $attributes['class'][] = 'form-disabled';
  }
  $attributes['class'][] = 'form-item';
  $output = '<div' . drupal_attributes($attributes) . '>' . "\n";

  // If #title is not set, we don't display any label or required marker.
  if (!isset($element['#title'])) {
    $element['#title_display'] = 'none';
  }
  $prefix = isset($element['#field_prefix']) ? '<span class="field-prefix">' . $element['#field_prefix'] . '</span> ' : '';
  $suffix = isset($element['#field_suffix']) ? ' <span class="field-suffix">' . $element['#field_suffix'] . '</span>' : '';

  // Prepare input whitelist - added to ensure ajax functions don't break
  $whitelist = _bootstrap_element_whitelist();

  switch ($element['#title_display']) {
    case 'before':
    case 'invisible':
      $output .= ' ' . theme('form_element_label', $variables);
      // Check if item exists in element whitelist
      if (isset($element['#id']) && in_array($element['#id'], $whitelist)) {
        $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
        $exclude_control = TRUE;
      }
      else {
        $output = $exclude_control ? $output : $output.$control_wrapper;
        $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      }
      break;

    case 'after':
      $output = $exclude_control ? $output : $output.$control_wrapper;
      $variables['#children'] = ' ' . $prefix . $element['#children'] . $suffix;
      $output .= ' ' . theme('form_element_label', $variables) . "\n";
      break;

    case 'none':
    case 'attribute':
      // Output no label and no required marker, only the children.
      $output = $exclude_control ? $output : $output.$control_wrapper;
      $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      break;
  }

  if ( !empty($element['#description']) ) {
    $output .= '<p class="help-block">' . $element['#description'] . "</p>\n";
  }

  // Check if control wrapper was added to ensure we close div correctly
  if ($exclude_control) {
    $output .= "</div>\n";
  }
  else {
    $output .= "</div></div>\n";
  }
  return $output;
}

/**
 * Returns HTML for a form element label and required marker.
 */
function sunrise_form_element_label(&$variables) {
  $element = $variables['element'];
  // This is also used in the installer, pre-database setup.
  $t = get_t();

  // If title and required marker are both empty, output no label.
  if ((!isset($element['#title']) || $element['#title'] === '' && $element['#type'] !== 'radio' && $element['#type'] !== 'checkbox') && empty($element['#required'])) {
    return '';
  }

  // If the element is required, a required marker is appended to the label.
  $required = !empty($element['#required']) ? theme('form_required_marker', array('element' => $element)) : '';

  $title = filter_xss_admin($element['#title']);

  $attributes = array();
  // Style the label as class option to display inline with the element.
  if ($element['#title_display'] == 'after') {
    $attributes['class'][] = 'option';
    $attributes['class'][] = $element['#type'];
  }
  // Show label only to screen readers to avoid disruption in visual flows.
  elseif ($element['#title_display'] == 'invisible') {
    $attributes['class'][] = 'element-invisible';
  }

  if (!empty($element['#id'])) {
    $attributes['for'] = $element['#id'];
  }

  // @Bootstrap: Add Bootstrap control-label class except for radio.
  if ($element['#type'] != 'radio') {
    $attributes['class'][] = 'control-label';
  }
  // @Bootstrap: Insert radio and checkboxes inside label elements.
  $output = '';
  if ( isset($variables['#children']) ) {
    $output .= $variables['#children'];
  }

  // @Bootstrap: Append label
  $output .= $t('!title !required', array('!title' => $title, '!required' => $required));

  // The leading whitespace helps visually separate fields from inline labels.
  return ' <label' . drupal_attributes($attributes) . '>' . $output . "</label>\n";
}

/**
 * Preprocessor for theme('button').
 */
function sunrise_preprocess_button(&$vars) {
  $vars['element']['#attributes']['class'][] = 'btn';
  if (isset($vars['element']['#value'])) {
    $classes = array(
      //specifics
      t('Save and add') => 'btn-info',
      t('Add another item') => 'btn-info',
      t('Add effect') => 'btn-primary',
      t('Add and configure') => 'btn-primary',
      t('Update style') => 'btn-primary',
      t('Download feature') => 'btn-primary',

      //generals
      t('Save') => 'btn-default',
      t('Apply') => 'btn-primary',
      t('Create') => 'btn-primary',
      t('Confirm') => 'btn-primary',
      t('Submit') => 'btn-primary',
      t('Export') => 'btn-primary',
      t('Import') => 'btn-primary',
      t('Restore') => 'btn-primary',
      t('Rebuild') => 'btn-primary',
      t('Search') => 'btn-primary',
      t('Add') => 'btn-info',
      t('Update') => 'btn-info',
      t('Delete') => 'btn-danger',
      t('Remove') => 'btn-danger',
      t('Send message') => 'btn-default',
      t('Log in') => 'btn-primary',
    );
    foreach ($classes as $search => $class) {
      if (strpos($vars['element']['#value'], $search) !== FALSE) {
        $vars['element']['#attributes']['class'][] = $class;
        break;
      }
    }
  }
}

/**
 * Returns HTML for a button form element.
 */
function sunrise_button($vars) {
  $element = $vars['element'];
  $label = $element['#value'];
  element_set_attributes($element, array('id', 'name', 'value', 'type'));

  $element['#attributes']['class'][] = 'form-' . $element['#button_type'];
  if (!empty($element['#attributes']['disabled'])) {
    $element['#attributes']['class'][] = 'form-button-disabled';
  }

  // Prepare input whitelist - added to ensure ajax functions don't break
  $whitelist = _bootstrap_element_whitelist();

  if (isset($element['#id']) && in_array($element['#id'], $whitelist)) {
    return '<input' . drupal_attributes($element['#attributes']) . ">\n"; // This line break adds inherent margin between multiple buttons
  }
  else {
    return '<button' . drupal_attributes($element['#attributes']) . '>'. $label ."</button>\n"; // This line break adds inherent margin between multiple buttons
  }
}

/**
 * Returns HTML for primary and secondary local tasks.
 */
function sunrise_menu_local_tasks(&$variables) {
  $output = '';

  if (!empty($variables['primary'])) {
    $variables['primary']['#prefix'] = '<h2 class="element-invisible">' . t('Primary tabs') . '</h2>';
    $variables['primary']['#prefix'] = '<ul class="nav nav-tabs">';
    $variables['primary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['primary']);
  }

  if (!empty($variables['secondary'])) {
    $variables['primary']['#prefix'] = '<h2 class="element-invisible">' . t('Primary tabs') . '</h2>';
    $variables['secondary']['#prefix'] = '<ul class="nav nav-pills">';
    $variables['secondary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['secondary']);
  }

  return $output;
}

/**
 * Returns HTML for primary and secondary local tasks.
 *
 * @ingroup themeable
 */
function sunrise_menu_local_task($variables) {
  $link = $variables['element']['#link'];
  $link_text = $link['title'];
  $classes = array();

  if (!empty($variables['element']['#active'])) {
    // Add text to indicate active tab for non-visual users.
    $active = '<span class="element-invisible">' . t('(active tab)') . '</span>';

    // If the link does not contain HTML already, check_plain() it now.
    // After we set 'html'=TRUE the link will not be sanitized by l().
    if (empty($link['localized_options']['html'])) {
      $link['title'] = check_plain($link['title']);
    }
    $link['localized_options']['html'] = TRUE;
    $link_text = t('!local-task-title!active', array('!local-task-title' => $link['title'], '!active' => $active));

    $classes[] = 'active';
  }

  return '<li class="' . implode(' ', $classes) . '">' . l($link_text, $link['href'], $link['localized_options']) . "</li>\n";
}

function sunrise_menu_link(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';
if ($element['#below']) {
    // Prevent dropdown functions from being added to management menu so it
    // does not affect the navbar module.
    if (($element['#original_link']['menu_name'] == 'management') && (module_exists('navbar'))) {
      $sub_menu = drupal_render($element['#below']);
    }
    elseif ((!empty($element['#original_link']['depth'])) && ($element['#original_link']['depth'] == 1)) {
      // Add our own wrapper.
      unset($element['#below']['#theme_wrappers']);
      $sub_menu = '<ul class="dropdown-menu">' . drupal_render($element['#below']) . '</ul>';
      // Generate as standard dropdown.
      $element['#title'] .= ' <span class="caret"></span>';
      $element['#attributes']['class'][] = 'dropdown';
      $element['#localized_options']['html'] = TRUE;

      // Set dropdown trigger element to # to prevent inadvertant page loading
      // when a submenu link is clicked.
      $element['#localized_options']['attributes']['data-target'] = '#';
      $element['#localized_options']['attributes']['class'][] = 'dropdown-toggle';
      $element['#localized_options']['attributes']['data-toggle'] = 'dropdown';
    }
  }
  // On primary navigation menu, class 'active' is not set on active menu item.
  // @see https://drupal.org/node/1896674
  if (($element['#href'] == $_GET['q'] || ($element['#href'] == '<front>' && drupal_is_front_page())) && (empty($element['#localized_options']['language']))) {
    $element['#attributes']['class'][] = 'active';
  }
  array_push($element['#attributes']['class'], preg_replace("/[^a-zA-Z0-9]/", "", strtolower($element['#title'])) );
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}

/**
 * Overrides theme_menu_tree().
 */
function sunrise_menu_tree(&$variables) {
  return '<ul class="menu nav">' . $variables['tree'] . '</ul>';
}

/**
 * Bootstrap theme wrapper function for the primary menu links.
 */
function sunrise_menu_tree__primary(&$variables) {
  return '<ul class="menu nav navbar-nav">' . $variables['tree'] . '</ul>';
}

/**
 * Bootstrap theme wrapper function for the secondary menu links.
 */
function sunrise_menu_tree__secondary(&$variables) {
  return '<ul class="menu nav navbar-nav secondary">' . $variables['tree'] . '</ul>';
}


/*
 * Overwrites the default item list to make it prettier
 */
function sunrise_item_list($variables) {
  $items = $variables['items'];
  $title = $variables['title'];
  $type = $variables['type'];
  $attributes = $variables['attributes'];
  $output = '';

  if (isset($title)) {
    $output .= '<h3>' . $title . '</h3>';
  }

  if (!empty($items)) {
    $output .= "<$type" . drupal_attributes($attributes) . '>';
    $num_items = count($items);
    $i = 0;
    foreach ($items as $item) {
      $attributes = array();
      $children = array();
      $data = '';
      $i++;
      if (is_array($item)) {
        foreach ($item as $key => $value) {
          if ($key == 'data') {
            $data = $value;
          }
          elseif ($key == 'children') {
            $children = $value;
          }
          else {
            $attributes[$key] = $value;
          }
        }
      }
      else {
        $data = $item;
      }
      if (count($children) > 0) {
        // Render nested list.
        $data .= theme('item_list', array('items' => $children, 'title' => NULL, 'type' => $type, 'attributes' => $attributes));
      }
      $attributes['class'][] = 'item';
      if ($i == 1) {
        $attributes['class'][] = 'first';
      }
      if ($i == $num_items) {
        $attributes['class'][] = 'last';
      }
      $output .= '<li' . drupal_attributes($attributes) . '>' . $data . "</li>\n";
    }
    $output .= "</$type>";
  }

  return $output;
}

/*
 * Helper functions
 */
function _sunrise_region_has_block($region) {
  $number_of_blocks = count(block_list($region));
  if ($number_of_blocks > 0) {
    return TRUE;
  }
  else {
    return FALSE;
  }
}

function _sunrise_block_render($module, $block_id) {
  $block = block_load($module, $block_id);
  if(!isset($block->title)){
    $block->title = '';
  }
  if(!isset($block->region)){
    $block->region = '';
  }
  $block_content = _block_render_blocks(array($block));
  $build = _block_get_renderable_array($block_content);
  $block_rendered = drupal_render($build);
  return $block_rendered;
}

function _sunrise_get_cloumn($block_count) {
  $available_column = 12;

  if ($block_count != 0) {
    $col = round($available_column / $block_count);
  }
  else {
    $col = "col-md-12 col-lg-12";
  }

  return "col-xs-12 col-sm-12 col-md-" . $col . " col-lg-" . $col;
}

/**
 * Returns an array containing ids of any whitelisted drupal elements
 */
function _bootstrap_element_whitelist() {
/**
 * Why whitelist an element?
 * The reason is to provide a list of elements we wish to exclude
 * from certain modifications made by the bootstrap theme which
 * break core functionality - e.g. ajax.
 */
  return array(
    'edit-refresh',
    'edit-pass-pass1',
    'edit-pass-pass2',
    'panels-ipe-cancel',
    'panels-ipe-customize-page',
    'panels-ipe-save',
  );
}

function block_render($module, $block_id) {
  $block = block_load($module, $block_id);
  if(!isset($block->title)){
    $block->title = '';
  }
  if(!isset($block->region)){
    $block->region = '';
  }
  $block_content = _block_render_blocks(array($block));
  $build = _block_get_renderable_array($block_content);
  $block_rendered = drupal_render($build);
  return $block_rendered;
}