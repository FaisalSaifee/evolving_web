<?php

namespace Drupal\zbclub_social_media_wall\Commands;

use Drush\Commands\DrushCommands;
use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use GuzzleHttp\ClientInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\zbclub_social_media_wall\Controller\ZbclubFacebookApiController;

/**
 * Drush commands for ZB Club Facebook Api.
 *
 * @package Drupal\zbclub_social_media_wall\Commands
 *
 * @DrushCommand(
 *   name = "zbclub_social_media_wall",
 *   namespace = "Drupal\zbclub_social_media_wall\Commands",
 *   description = "ZB Club Facebook API commands.",
 *   aliases = {"zbsm"}
 * )
 */
class ZbclubFacebookApiCommands extends DrushCommands {

  /**
   * The configuration factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The HTTP client to make API requests.
   *
   * @var \GuzzleHttp\ClientInterface
   */

  protected $httpClient;

  /**
   * The file system.
   *
   * @var \Drupal\Core\File\FileSystemInterface
   */
  protected $fileSystem;

  /**
   * The logger factory.
   *
   * @var \Drupal\Core\Logger\LoggerChannelFactoryInterface
   */
  protected $loggerFactory;

  /**
   * Constructs a new ZbclubFacebookApiController object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The configuration factory.
   * @param \GuzzleHttp\ClientInterface $http_client
   *   The HTTP client to make API requests.
   * @param \Drupal\Core\File\FileSystemInterface $file_system
   *   The file system.
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $logger_factory
   *   The logger factory.
   */
  public function __construct(ConfigFactoryInterface $config_factory, ClientInterface $http_client, FileSystemInterface $file_system, LoggerChannelFactoryInterface $logger_factory) {
    $this->configFactory = $config_factory;
    $this->httpClient = $http_client;
    $this->fileSystem = $file_system;
    $this->loggerFactory = $logger_factory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('http_client'),
      $container->get('file_system'),
      $container->get('logger.factory')
    );
  }

  /**
   * Drush command that pulls ZB Club Facebook Post.
   *
   * @command zbclub_social_media_wall:update
   * @aliases zbsm
   * @usage zbclub_social_media_wall:update
   */
  public function updateZbClubPost() {

    $zbClubPostUpdate = new ZbclubFacebookApiController($this->configFactory, $this->httpClient, $this->fileSystem, $this->loggerFactory);
    $result = $zbClubPostUpdate->zbCron();
    $this->output()->writeln($result);

  }

}
