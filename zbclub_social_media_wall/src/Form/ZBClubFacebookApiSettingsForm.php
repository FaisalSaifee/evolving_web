<?php

namespace Drupal\zbclub_social_media_wall\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines the form for ZB Club Facebook API module settings.
 */
class ZBClubFacebookApiSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'zbclub_facebook_api_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'zbclub_social_media_wall.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('zbclub_social_media_wall.settings');

    $form['facebook_api_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Facebook API URL'),
      '#description' => $this->t('Enter the URL for the Facebook API endpoint. Example: https://graph.facebook.com/v16.0/'),
      '#default_value' => $config->get('facebook_api_url'),
      '#required' => TRUE,
    ];

    $form['page_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Page ID'),
      '#description' => $this->t('Enter the ID of the Facebook page for which you want to retrieve posts'),
      '#default_value' => $config->get('page_id'),
      '#required' => TRUE,
    ];

    $form['post_variables'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Post variables'),
      '#description' => $this->t('Please enter comma-separated post variables. For example: full_picture, message.'),
      '#default_value' => $config->get('post_variables'),
      '#required' => TRUE,
    ];

    $form['filter_hastag'] = [
      '#type' => 'textfield',
      '#title' => $this->t('#Hashtag'),
      '#description' => $this->t('Enter single #hastag ID for filtering post'),
      '#default_value' => $config->get('filter_hastag'),
      '#required' => TRUE,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('zbclub_social_media_wall.settings')
      ->set('facebook_api_url', $form_state->getValue('facebook_api_url'))
      ->set('page_id', $form_state->getValue('page_id'))
      ->set('post_variables', $form_state->getValue('post_variables'))
      ->set('filter_hastag', $form_state->getValue('filter_hastag'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
