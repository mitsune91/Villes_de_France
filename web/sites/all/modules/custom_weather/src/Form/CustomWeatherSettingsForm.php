<?php

namespace Drupal\custom_weather\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class CustomWeatherSettingsForm extends ConfigFormBase
{
  const SETTINGS = 'custom_weather.settings';

  /**
   * Gets the configuration names that will be editable.
   *
   * @return array
   *   An array of configuration object names that are editable if called in
   *   conjunction with the trait's config() method.
   */
  protected function getEditableConfigNames()
  {
    return [
      static::SETTINGS];
  }

  /**
   * Returns a unique string identifying the form.
   *
   * The returned ID should be a unique string that can be a valid PHP function
   * name, since it's used in hook implementation names such as
   * hook_form_FORM_ID_alter().
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId()
  {
    return 'custom_weather_settings';
  }

  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $config = $this->config(static::SETTINGS);
    $form['apiKey'] = [
      '#type' => 'textfield',
      '#title' => t('apiKey'),
    ];
    $form['language'] = [
      '#type' => 'textfield',
      '#title' => t('language'),
    ];
    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $this->configFactory->getEditable(static::SETTINGS)
      ->set('apiKey', $form_state->getValue('apiKey'))
      ->set('language', $form_state->getValue('language'))
      ->save();
    parent::submitForm($form, $form_state);
  }
}
