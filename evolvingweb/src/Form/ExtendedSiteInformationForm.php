<?php

namespace Drupal\evolvingweb\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\system\Form\SiteInformationForm;

/**
 * Extending system site form.
 */
class ExtendedSiteInformationForm extends SiteInformationForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $site_config = $this->config('system.site');
    $form = parent::buildForm($form, $form_state);
    $form['site_info'] = [
      '#type' => 'details',
      '#title' => t('Site Info'),
      '#open' => TRUE,
    ];
    $form['site_info']['siteapikey'] = [
      '#type' => 'textfield',
      '#title' => t('Site API Key'),
      '#default_value' => $site_config->get('siteapikey') ?: 'No API Key yet',
      '#description' => t("Custom field to set the API Key"),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $siteApiKey = $form_state->getValue('siteapikey');
    $this->config('system.site')
      ->set('siteapikey', $siteApiKey)
      ->save();
    parent::submitForm($form, $form_state);
    if ($siteApiKey == NULL || $siteApiKey === 'No API Key yet') {
      $this->messenger->addStatus('The Site API Key has been saved with value => NULL');
    }
    else {
      $this->messenger->addStatus('The Site API Key has been saved with value => ' . $siteApiKey);
    }
  }

}
