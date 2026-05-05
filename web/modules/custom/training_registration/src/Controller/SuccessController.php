<?php
namespace Drupal\training_registration\Controller;

use Drupal\Core\Controller\ControllerBase;

class SuccessController extends ControllerBase {
  public function content() {
    return [
      '#markup' => '<h2>Thank you for registering!</h2><p>We will contact you soon.</p>',
    ];
  }
}