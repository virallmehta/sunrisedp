<?php
/**
 * Implements hook_form_system_theme_settings_alter() function.
 *
 * @param $form
 *   Nested array of form elements that comprise the form.
 * @param $form_state
 *   A keyed array containing the current state of the form.
 */
function sunrise_form_system_theme_settings_alter(&$form, $form_state, $form_id = NULL) {
	// Work-around for a core bug affecting admin themes. See issue #943212.
	if (isset($form_id)) {
    	return;
	}

	$form['theme_settings_tab'] = array(
		'#type' => 'vertical_tabs',
		'#weight' => -2,
	); 

	// Create the form using Forms API
	$form['theme_settings_tab']['breadcrumb'] = array(
    	'#type'          => 'fieldset',
    	'#title'         => t('Breadcrumb settings'),
  	);
  	$form['theme_settings_tab']['breadcrumb']['sunrise_breadcrumb'] = array(
    	'#type'          => 'select',
    	'#title'         => t('Display breadcrumb'),
    	'#default_value' => theme_get_setting('sunrise_breadcrumb'),
    	'#options'       => array(
                          'yes'   => t('Yes'),
                          'admin' => t('Only in admin section'),
                          'no'    => t('No'),
        ),
  	);
  	$form['theme_settings_tab']['breadcrumb']['breadcrumb_options'] = array(
    	'#type' => 'container',
    	'#states' => array(
      	'invisible' => array(
        ':input[name="sunrise_breadcrumb"]' => array('value' => 'no'),
      		),
    	),
  	);
  	$form['theme_settings_tab']['breadcrumb']['breadcrumb_options']['sunrise_breadcrumb_separator'] = array(
    	'#type'          => 'textfield',
    	'#title'         => t('Breadcrumb separator'),
    	'#description'   => t('Text only. Don’t forget to include spaces.'),
    	'#default_value' => theme_get_setting('sunrise_breadcrumb_separator'),
    	'#size'          => 5,
    	'#maxlength'     => 10,
  	);
  	$form['theme_settings_tab']['breadcrumb']['breadcrumb_options']['sunrise_breadcrumb_home'] = array(
    	'#type'          => 'checkbox',
    	'#title'         => t('Show home page link in breadcrumb'),
    	'#default_value' => theme_get_setting('sunrise_breadcrumb_home'),
  	);
  	$form['theme_settings_tab']['breadcrumb']['breadcrumb_options']['sunrise_breadcrumb_trailing'] = array(
    	'#type'          => 'checkbox',
    	'#title'         => t('Append a separator to the end of the breadcrumb'),
    	'#default_value' => theme_get_setting('sunrise_breadcrumb_trailing'),
    	'#description'   => t('Useful when the breadcrumb is placed just before the title.'),
    	'#states' => array(
      	'disabled' => array(
        	':input[name="sunrise_breadcrumb_title"]' => array('checked' => TRUE),
      	),
      	'unchecked' => array(
        	':input[name="sunrise_breadcrumb_title"]' => array('checked' => TRUE),
      	),
    	),
  	);
  	$form['theme_settings_tab']['breadcrumb']['breadcrumb_options']['sunrise_breadcrumb_title'] = array(
    	'#type'          => 'checkbox',
    	'#title'         => t('Append the content title to the end of the breadcrumb'),
    	'#default_value' => theme_get_setting('sunrise_breadcrumb_title'),
    	'#description'   => t('Useful when the breadcrumb is not placed just before the title.'),
  	);
	
	// Background setting
	$form['theme_settings_tab']['custom_bg_colors'] = array(
	  '#type' => 'fieldset',
	  '#title' => t('Color Scheme Settings'),
	  '#weight' => 3,
	  '#collapsible' => TRUE,
	  '#collapsed' => FALSE,
	  '#group' => 'theme_settings_tab',
	);
	$form['theme_settings_tab']['custom_bg_colors']['bg_scheme'] = array(
		'#type' => 'select',
		'#title' => t('Choose a background color scheme. '),
		 '#description' => t('choose a background scheme for background of your website. <strong>Note:</strong> if you want to use custom setting, use <em>Custom Background Setting</em> field below. '),
		'#default_value' => theme_get_setting('bg_scheme'),
		'#options' => array(
		'stripe_default.png' => 'Default stripes',
		'stripebig.png' => 'Big Stripes',
		'tartan1.png' => 'Tartan',
		'brackets.png' => 'Brackets',
		'pixels.png' => 'Pixels',
		),
	);
	$form['theme_settings_tab']['custom_bg_colors']['custom_bg_attribute'] = array(
		'#type' => 'textfield',
		'#title' => t('Define custom CSS attribute for <em>body</em> element'),
	    '#description' => t('In this field, you can define your own css property for theme background. You can also add path to your own background image. For example: <em>url(/sites/all/themes/bg/stripes_default.png) repeat #fff</em>. Do not include ending semicolon \';\'. This will override previously defined background setting. <br><br>You should have basic knowledge of CSS background properties and how to use them in one line. A very nice and brief introduction is <a href="http://www.cssbasics.com/chapter_12_css_backgrounds.html">here</a>. If you dont want to use this field, leave it blank. '),
		'#default_value' => theme_get_setting('custom_bg_attribute'),
		'#maxlength' => 2000,		
	);	
	$form['theme_settings_tab']['custom_bg_colors']['link_color'] = array(
		'#type' => 'textfield',
		'#title' => t('Sitewide Link color. Note: please read full description below'),
	    '#description' => t('By default, your site color scheme will be used as link color. It is recommended that you leave this field blank unless you are using site color scheme that is too dark for links to appear distinct from texts. Enter six character hexadecimal color code without preceeding \'#\'.'),
		'#default_value' => theme_get_setting('link_color'),
		'#size' => 6,
		'#maxlength' => 6,
		
	);	
	$form['theme_settings_tab']['custom_bg_colors']['footer_link_color'] = array(
		'#type' => 'textfield',
		'#title' => t('Footer link color. Note: please read full description below'),
	    '#description' => t('By default, your site color scheme will be used as link color. It is recommended that you leave this field blank unless you are using site color scheme that is too dark for links to appear distinct from texts. Enter six character hexadecimal color code without preceeding \'#\'.'),
		'#default_value' => theme_get_setting('footer_link_color'),
		'#size' => 6,
		'#maxlength' => 6,
		
	);		

	$form['theme_settings_tab']['themedev'] = array(
    	'#type'          => 'fieldset',
    	'#title'         => t('Theme development settings'),
  	);
  	$form['theme_settings_tab']['themedev']['sunrise_rebuild_registry'] = array(
    	'#type'          => 'checkbox',
    	'#title'         => t('Rebuild theme registry on every page.'),
    	'#default_value' => theme_get_setting('sunrise_rebuild_registry'),
    	'#description'   => t('During theme development, it can be very useful to continuously <a href="!link">rebuild the theme registry</a>. WARNING: this is a huge performance penalty and must be turned off on production websites.', array('!link' => 'http://drupal.org/node/173880#theme-registry')),
  	);
  	$form['theme_settings_tab']['themedev']['sunrise_wireframes'] = array(
    	'#type'          => 'checkbox',
    	'#title'         => t('Add wireframes around main layout elements'),
    	'#default_value' => theme_get_setting('sunrise_wireframes'),
    	'#description'   => t('<a href="!link">Wireframes</a> are useful when prototyping a website.', array('!link' => 		'http://www.boxesandarrows.com/view/html_wireframes_and_prototypes_all_gain_and_no_pain')),
  );

	
}