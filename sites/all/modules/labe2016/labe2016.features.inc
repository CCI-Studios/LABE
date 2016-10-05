<?php
/**
 * @file
 * labe2016.features.inc
 */

/**
 * Implements hook_views_api().
 */
function labe2016_views_api($module = NULL, $api = NULL) {
  return array("api" => "3.0");
}

/**
 * Implements hook_image_default_styles().
 */
function labe2016_image_default_styles() {
  $styles = array();

  // Exported image style: header.
  $styles['header'] = array(
    'label' => 'Header',
    'effects' => array(
      7 => array(
        'name' => 'image_scale_and_crop',
        'data' => array(
          'width' => 2440,
          'height' => 596,
        ),
        'weight' => 1,
      ),
    ),
  );

  // Exported image style: header_preview.
  $styles['header_preview'] = array(
    'label' => 'Header Preview',
    'effects' => array(
      8 => array(
        'name' => 'image_scale_and_crop',
        'data' => array(
          'width' => 244,
          'height' => 60,
        ),
        'weight' => 1,
      ),
    ),
  );

  // Exported image style: pdf_download.
  $styles['pdf_download'] = array(
    'label' => 'PDF Download',
    'effects' => array(
      9 => array(
        'name' => 'image_scale_and_crop',
        'data' => array(
          'width' => 640,
          'height' => 908,
        ),
        'weight' => 1,
      ),
    ),
  );

  // Exported image style: pdf_download_preview.
  $styles['pdf_download_preview'] = array(
    'label' => 'PDF Download Preview',
    'effects' => array(
      10 => array(
        'name' => 'image_scale_and_crop',
        'data' => array(
          'width' => 192,
          'height' => 272,
        ),
        'weight' => 1,
      ),
    ),
  );

  // Exported image style: slideshow.
  $styles['slideshow'] = array(
    'label' => 'Slideshow',
    'effects' => array(
      5 => array(
        'name' => 'image_scale_and_crop',
        'data' => array(
          'width' => 2440,
          'height' => 980,
        ),
        'weight' => 1,
      ),
    ),
  );

  // Exported image style: slideshow_preview.
  $styles['slideshow_preview'] = array(
    'label' => 'Slideshow Preview',
    'effects' => array(
      6 => array(
        'name' => 'image_scale_and_crop',
        'data' => array(
          'width' => 244,
          'height' => 98,
        ),
        'weight' => 1,
      ),
    ),
  );

  return $styles;
}
