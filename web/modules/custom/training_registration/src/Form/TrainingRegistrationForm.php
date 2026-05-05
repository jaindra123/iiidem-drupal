<?php
namespace Drupal\training_registration\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;
use Drupal\node\NodeInterface;

class TrainingRegistrationForm extends FormBase {

  public function getFormId() {
    return 'training_registration_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state, NodeInterface $node = NULL) {

   // echo "sssds";
   // die();

    $training = $node;
    $training_id = $training ? $training->id() : NULL;

    $form['training_name'] = [
      '#type' => 'textfield',
      '#title' => 'Training',
      '#default_value' => $training ? $training->getTitle() : '',
      '#attributes' => ['readonly' => 'readonly'],
    ];

    $form['training_id'] = [
      '#type' => 'hidden',
      '#value' => $training_id,
    ];

    $form['full_name'] = [
      '#type' => 'textfield',
      '#title' => 'Full Name',
      '#required' => TRUE,
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => 'Email',
      '#required' => TRUE,
    ];

    $form['phone'] = [
      '#type' => 'textfield',
      '#title' => 'Phone',
      '#required' => TRUE,
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => 'Register',
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {

    $training_id = $form_state->getValue('training_id');
  //  print_r($training_id);
   // die();

    Node::create([
      'type' => 'registration',
      'title' => 'Registration - ' . $form_state->getValue('full_name'),
      'field_full_name' => $form_state->getValue('full_name'),
      'field_email' => $form_state->getValue('email'),
      'field_phone' => $form_state->getValue('phone'),
      'field_training_list' => $training_id,
      'status' => 1,
    ])->save();

    $form_state->setRedirect('training_registration.success');

    $mailManager = \Drupal::service('plugin.manager.mail');

    $module = 'training_registration';
    $key = 'registration_mail';
    $to = $form_state->getValue('email');
    $params['message'] = 'Thank you for registering for training.';
    $params['subject'] = 'Training Registration Confirmation';
    $mailManager->mail($module, $key, $to, \Drupal::currentUser()->getPreferredLangcode(), $params);

    $admin_email = \Drupal::config('system.site')->get('mail');
    $mailManager->mail($module, $key, $admin_email, 'en', [
      'subject' => 'New Registration',
      'message' => 'A new user has registered.',
    ]);

    //   \Drupal::messenger()->addMessage('Registration submitted successfully.');
  }
}