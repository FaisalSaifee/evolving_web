<?php

namespace Drupal\zbclub_social_media_wall\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\File\FileSystemInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a custom block.
 *
 * @Block(
 *   id = "zbclub_social_media_wall_block",
 *   admin_label = @Translation("ZB Club Social Media Wall"),
 * )
 */
class ZBClubSocialMediaWallBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The file system service.
   *
   * @var \Drupal\Core\File\FileSystemInterface
   */
  protected $fileSystem;

  /**
   * The configuration factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Constructs a new ZBClubSocialMediaWallBlock object.
   *
   * @param array $configuration
   *   The block configuration.
   * @param string $plugin_id
   *   The plugin ID for the block.
   * @param mixed $plugin_definition
   *   The plugin definition for the block.
   * @param \Drupal\Core\File\FileSystemInterface $file_system
   *   The file system service.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The configuration factory.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, FileSystemInterface $file_system, ConfigFactoryInterface $config_factory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->fileSystem = $file_system;
    $this->configFactory = $config_factory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('file_system'),
      $container->get('config.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    try {
      $config = $this->configFactory->get('zbclub_social_media_wall.settings');
      $filter = $config->get('filter_hastag');
      $file_path = 'public://facebook-api/';
      $file_name = 'zb-club-facebook-page.json';
      $json_data = file_get_contents($file_path . $file_name);
      $data = json_decode($json_data, TRUE);
      $module_path = '/' . drupal_get_path('module', 'zbclub_social_media_wall');

      $output = [
        '#theme' => 'zbclub_social_media_wall_block',
        '#content' => $data,
        '#filter' => $filter,
        '#modulepath' => $module_path,
      ];
    }
    catch (\Exception $e) {
      $this->logger('zbclub_social_media_wall')->error($e->getMessage());
      $output = [
        '#markup' => $this->t('There was an error fetching data from the Json file.'),
      ];
    }

    return $output;
  }

}
