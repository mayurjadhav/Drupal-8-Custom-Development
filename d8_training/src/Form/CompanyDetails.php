<?php

/**
 * @file
 * Contains \Drupal\d8_training\Form\CompanyDetails.
 */

namespace Drupal\d8_training\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;

class CompanyDetails extends ConfigFormBase {

  public function __construct(ConfigFactoryInterface $config_factory) {
    parent::__construct($config_factory);
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'company_details';
  }

  /**
   * Gets the configuration names that will be editable.
   *
   * @return array
   * An array of configuration object names that are editable if called in
   * conjunction with the trait's config() method.
   */
  protected function getEditableConfigNames() {
    return ['config.company_details'];
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

    // Get the data stored in configuration object.
    $config = $this->config('config.company_details');

    // Define company name as text field.
    $form['company_name'] = [
      '#type' => 'textfield',
      '#title' => t('Company Name'),
      '#default_value' => $config->get('company_name') ? $config->get('company_name') : '',
      '#required' => TRUE,
    ];

    // Define company email as email field.
    $form['company_email'] = [
      '#type' => 'email',
      '#title' => t('Company Email ID'),
      '#default_value' => $config->get('company_email') ? $config->get('company_email') : '',
      '#required' => TRUE,
    ];

    // Define company contact as tel field.
    $form['company_contact'] = [
      '#type' => 'tel',
      '#title' => t('Contact Number'),
      '#default_value' => $config->get('company_contact') ? $config->get('company_contact') : '',
      '#required' => TRUE,
    ];

    // Define company branch as select field.
    $form['company_branch'] = [
      '#type' => 'select',
      '#title' => ('Branch'),
      '#options' => [
        'mumbai' => t('Mumbai'),
        'indore' => t('Indore'),
      ],
      '#default_value' => $config->get('company_branch') ? $config->get('company_branch') : '',
      '#required' => TRUE,
    ];

    // Return the form elements with parent form.
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
    // Check contact number is numeric or not.
    if (!is_numeric($form_state->getValue('company_contact'))) {
      $form_state->setErrorByName('candidate_number', $this->t('Contact number must be numeric.'));
    }
    // Check contact number should be at least 10 digits.
    if (strlen($form_state->getValue('company_contact')) < 10) {
      $form_state->setErrorByName('candidate_number', $this->t('Contact number is too short.'));
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
    parent::submitForm($form, $form_state);

    // Get the submitted values from $form_state.
    $values = $form_state->getValues();

    // Save the submitted values into configuration variables.
    // @TODO: Delete all configuration variables when uninstalling module.
    $this->config('config.company_details')
      ->set('company_name', $values['company_name'])
      ->set('company_email', $values['company_email'])
      ->set('company_contact', $values['company_contact'])
      ->set('company_branch', $values['company_branch'])
      ->save();
  }
}
