<?php

namespace Drupal\events_theme\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a dynamic Events Slider Block.
 *
 * @Block(
 *   id = "events_slider_block",
 *   admin_label = @Translation("Events Slider Block")
 * )
 */
class EventsSliderBlock extends BlockBase {

  public function build() {
    $event_nodes = \Drupal::entityTypeManager()
      ->getStorage('node')
      ->loadByProperties([
        'type' => 'events',
        'status' => 1,
      ]);

    $event_items = [];
    foreach ($event_nodes as $node) {
      $event_items[] = $node->label(); // Use title
    }

    return [
      '#type' => 'component',
      '#component' => 'events_theme:slider',
      '#props' => [
        'title' => 'Upcoming Events',
        'items' => $event_items,
      ],
    ];
  }
}