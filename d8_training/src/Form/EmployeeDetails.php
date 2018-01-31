<?php

/**
 * @file
 * Contains \Drupal\d8_training\Form\EmployeeDetails.
 */

namespace Drupal\d8_training\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

class EmployeeDetails extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'employee_details';
  }

  /**
   * Form constructor.
   *
   * @param array $form
   * An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   * The current state of the form.
   *
   * @return array
   * The form structure.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    // Define employee name as text field.
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#required' => TRUE,
    ];

    // Define employee ID as text field.
    $form['employee_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Employee ID'),
      '#required' => TRUE,
    ];

    // Define employee email as email field.
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#required' => TRUE,
    ];

    // Define Address as text field.
    $form['address'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Address'),
    ];

    // Define Address as text field.
    $form['gender'] = [
      '#type' => 'select',
      '#title' => $this->t('Gender'),
      '#options' => [
        '0' => t('Male'),
        '1' => t('Female'),
      ],
      '#required' => TRUE,
    ];

    // Define Date Of Birth as date field.
    $form['date_of_birth'] = [
      '#type' => 'date',
      '#title' => $this->t('Date Of Birth'),
      '#default_value' => date('Y-m-d'),
      '#required' => TRUE,
    ];

    // Define Submit Button.
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save Employee Details'),
      '#attributes' => [
        'class' => ['btn'],
      ],
    ];

    // Use custom template to render form.
    $form['#theme'] = ['employee_details_template'];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);

    // Check date of birth is not greater than current date.
    if (date('Y-m-d') < $form_state->getValue('date_of_birth')) {
      $form_state->setErrorByName('candidate_number', $this->t('Date Of Birth should less than current date.'));
    }
  }

  /**
   * Form submission handler.
   *
   * @param array $form
   * An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   * The current state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Get the submitted values from $form_state.
    $values = $form_state->getValues();

//    // Save employee details using database connection in the submit form itself.
//    $connection = Database::getConnection();
//    $connection->insert('employee')->fields(
//      [
//        'name' => $values['name'],
//        'employee_id' => $values['employee_id'],
//        'email' => $values['email'],
//        'address' => $values['address'],
//        'gender' => $values['gender'],
//        'date_of_birth' => strtotime($values['date_of_birth']),
//      ]
//    )->execute();

    // Save employee details using services method.
    \Drupal::service('d8_training.employee_details')->StoreEmployeeDetails($values);

    drupal_set_message('Employee Details has been submitted successfully.');
  }
}
