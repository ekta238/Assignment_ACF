<?php

namespace Drupal\custom_config_form\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides configuration form for location and time.
 */
class LocationAndTimeConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'custom_config_form.adminsettings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('custom_config_form.adminsettings');

    $form['country'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Country'),
      '#required' => TRUE,
      '#default_value' => $config->get('country'),
    ];
    $form['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#required' => TRUE,
      '#default_value' => $config->get('city'),
    ];
    $form['timezone'] = [
      '#type' => 'select',
      '#title' => $this->t('Timezone'),
      '#options' => list_of_timezones(),
      '#required' => TRUE,
      '#default_value' => $config->get('timezone'),
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('custom_config_form.adminsettings')
      ->set('country', $form_state->getValue('country'))
      ->set('city', $form_state->getValue('city'))
      ->set('timezone', $form_state->getValue('timezone'))
      ->save();
  }

}
