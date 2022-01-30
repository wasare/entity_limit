<?php

namespace Drupal\entity_limit\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Component\Plugin\PluginManagerInterface;

/**
 * Manage limit for for entity limits.
 */
class EntityLimitAddLimitForm extends EntityForm {

  /**
   * The entity manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface;
   */
  protected $entityManager;

  /**
   * The entity manager.
   *
   * @var \Drupal\Component\Plugin\PluginManagerInterface
   */
  protected $pluginManager;

  /**
   * Constructs the NodeTypeForm object.
   *
   * @param Drupal\Core\Entity\EntityTypeManagerInterface $entity_manager
   *   The entity manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_manager, PluginManagerInterface $plugin_manager) {
    $this->entityManager = $entity_manager;
    $this->pluginManager = $plugin_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
      $container->get('plugin.manager.entity_limit')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $entity_limit = $this->entity;
    $selected_plugin = $entity_limit->getPlugin();
    $plugin = $this->pluginManager->createInstance($selected_plugin, ['of' => 'configuration values']);
    $form['#entity_limit'] = $entity_limit;
    $form = parent::form($form, $form_state);
    $form = $plugin->buildConfigurationForm($form, $form_state);
    return $form;
  }

}
