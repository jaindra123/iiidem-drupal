<?php
use Drupal\file\Entity\File;

/**
 * Implements hook_form_system_theme_settings_alter().
 */
function iiidem_theme_form_system_theme_settings_alter(&$form, &$form_state) {

  /* ==============================
   * Vertical Tabs
   * ============================== */
  $form['theme_options'] = [
    '#type' => 'vertical_tabs',
    '#title' => t('IIIDEM Theme Settings'),
    '#weight' => -10,
  ];

  /* ==============================
   * HEADER SETTINGS
   * ============================== */
  $form['header'] = [
    '#type' => 'details',
    '#title' => t('Header Settings'),
    '#group' => 'theme_options',
    '#open' => TRUE,
  ];

  $form['header']['address'] = [
    '#type' => 'textfield',
    '#title' => t('Address'),
    '#default_value' => theme_get_setting('address'),
  ];

  $form['header']['header_mail'] = [
    '#type' => 'textfield',
    '#title' => t('Email'),
    '#default_value' => theme_get_setting('header_mail'),
  ];

  $form['header']['contact'] = [
    '#type' => 'textfield',
    '#title' => t('Phone Number'),
    '#default_value' => theme_get_setting('contact'),
  ];

  /* ==============================
   * SOCIAL MEDIA
   * ============================== */
  $form['social'] = [
    '#type' => 'details',
    '#title' => t('Social Media'),
    '#group' => 'theme_options',
  ];

  $socials = ['facebook', 'twitter', 'instagram', 'youtube', 'linkedin'];

  foreach ($socials as $social) {
    $form['social'][$social] = [
      '#type' => 'textfield',
      '#title' => ucfirst($social),
      '#default_value' => theme_get_setting($social),
    ];
  }

  /* ==============================
   * FOOTER SETTINGS
   * ============================== */
  $form['footer'] = [
    '#type' => 'details',
    '#title' => t('Footer Settings'),
    '#group' => 'theme_options',
  ];

  $form['footer']['footer_about'] = [
    '#type' => 'textarea',
    '#title' => t('Footer About Text'),
    '#default_value' => theme_get_setting('footer_about'),
  ];

  $form['footer']['footer_address'] = [
    '#type' => 'textfield',
    '#title' => t('Footer Address'),
    '#default_value' => theme_get_setting('footer_address'),
  ];

  $form['footer']['footer_email'] = [
    '#type' => 'textfield',
    '#title' => t('Footer Email'),
    '#default_value' => theme_get_setting('footer_email'),
  ];

  $form['footer']['footer_phone'] = [
    '#type' => 'textfield',
    '#title' => t('Footer Phone'),
    '#default_value' => theme_get_setting('footer_phone'),
  ];

  $form['footer']['copyright'] = [
    '#type' => 'textfield',
    '#title' => t('Copyright Text'),
    '#default_value' => theme_get_setting('copyright'),
  ];

  /* ==============================
   * FOOTER LOGO UPLOAD
   * ============================== */
    $footer_logo = theme_get_setting('footer_logo');

    if (!empty($footer_logo) && !is_array($footer_logo)) {
      $footer_logo = [$footer_logo];
    }

    $form['footer']['footer_logo'] = [
      '#type' => 'managed_file',
      '#title' => t('Footer Logo'),
      '#upload_location' => 'public://theme-settings/',
      '#default_value' => $footer_logo,
      '#upload_validators' => [
        'FileExtension' => ['extensions' => 'png jpg jpeg webp svg'],
      ],
    ];

  /* ==============================
   * SEO SETTINGS
   * ============================== */
  $form['seo'] = [
    '#type' => 'details',
    '#title' => t('SEO Settings'),
    '#group' => 'theme_options',
  ];

  $form['seo']['meta_description'] = [
    '#type' => 'textarea',
    '#title' => t('Meta Description'),
    '#default_value' => theme_get_setting('meta_description'),
  ];

  $form['seo']['meta_keywords'] = [
    '#type' => 'textfield',
    '#title' => t('Meta Keywords'),
    '#default_value' => theme_get_setting('meta_keywords'),
  ];

  /* ==============================
   * CUSTOM CSS
   * ============================== */
  $form['custom_css'] = [
    '#type' => 'details',
    '#title' => t('Custom CSS'),
    '#group' => 'theme_options',
  ];

  $form['custom_css']['custom_css_code'] = [
    '#type' => 'textarea',
    '#title' => t('Paste Custom CSS'),
    '#default_value' => theme_get_setting('custom_css_code'),
    '#description' => t('Add custom CSS here.'),
  ];

  /* ==============================
   * BRANDING
   * ============================== */
  $form['branding'] = [
    '#type' => 'details',
    '#title' => t('Branding'),
    '#group' => 'theme_options',
  ];

  $form['branding']['site_tagline'] = [
    '#type' => 'textfield',
    '#title' => t('Site Tagline'),
    '#default_value' => theme_get_setting('site_tagline'),
  ];

  /* ==============================
   * SUBMIT HANDLER
   * ============================== */
  $form['#submit'][] = 'iiidem_theme_settings_submit';
}

/**
 * Custom submit handler for managed_file fields.
 */
function iiidem_theme_settings_submit($form, &$form_state) {

  $fid = $form_state->getValue('footer_logo');

  if (!empty($fid[0])) {
    $file = File::load($fid[0]);

    if ($file) {
      $file->setPermanent();
      $file->save();
    }
  }

}