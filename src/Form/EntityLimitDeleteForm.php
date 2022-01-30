<?php

namespace Drupal\entity_limit\Form;

use Drupal\Core\Entity\EntityConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Builds the form to delete Entity Limit entities.
 */
class EntityLimitDeleteForm extends EntityConfirmFormBase {
  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Are you sure you want to delete %name?', array('%name' => $this->entity->label()));
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('entity.entity_limit.collection');
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return $this->t('Delete');
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $label = $this->entity->label();
    $this->entity->delete();
    \Drupal::messenger()->addStatus($this->t('The entity limit @label has been deleted.', array('@label' => $label)));
    $form_state->setRedirectUrl($this->getCancelUrl());
  }
}
