<?php

namespace Drupal\events_theme\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a dynamic Gallery Slider Block.
 *
 * @Block(
 *   id = "gallery_slider_block",
 *   admin_label = @Translation("Gallery Slider Block")
 * )
 */
class GallerySliderBlock extends BlockBase {

  public function build() {
    $gallery_nodes = \Drupal::entityTypeManager()
      ->getStorage('node')
      ->loadByProperties([
        'type' => 'gallery',
        'status' => 1,
      ]);

    $gallery_items = [];
    foreach ($gallery_nodes as $node) {
      $gallery_items[] = $node->label(); // Use title
    }

    return [
      '#type' => 'component',
      '#component' => 'events_theme:slider',
      '#props' => [
        'title' => 'Photo Gallery',
        'items' => $gallery_items,
      ],
    ];
  }
}