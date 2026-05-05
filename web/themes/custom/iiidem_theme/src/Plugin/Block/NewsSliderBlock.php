<?php

namespace Drupal\events_theme\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\node\Entity\Node;

/**
 * Provides a dynamic News Slider Block.
 *
 * @Block(
 *   id = "news_slider_block",
 *   admin_label = @Translation("News Slider Block")
 * )
 */
class NewsSliderBlock extends BlockBase {

  public function build() {
    $news_nodes = \Drupal::entityTypeManager()
      ->getStorage('node')
      ->loadByProperties([
        'type' => 'news',
        'status' => 1,
      ]);

    $news_items = [];
    foreach ($news_nodes as $node) {
      $news_items[] = $node->label(); // Use title
      //$news_items[] = '<img src="' . file_create_url($node->get('field_image')->entity->getFileUri()) . '" alt="' . $node->label() . '">';
    }
    //  Props are passed via a render array in PHP  (#type => component, #props => [...])
    return [
      '#type' => 'component',
      '#component' => 'events_theme:slider',
      '#props' => [
        'title' => 'Latest News',
        'items' => $news_items,
      ],
    ];
  }
}