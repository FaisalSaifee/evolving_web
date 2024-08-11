<?php

namespace Drupal\zbclub_social_media_wall\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use GuzzleHttp\ClientInterface;
use Drupal\Core\Site\Settings;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller for ZbclubFacebookApiController.
 */
class ZbclubFacebookApiController extends ControllerBase {

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
   * {@inheritdoc}
   */
  public function zbCron() {
    $config = $this->configFactory->get('zbclub_social_media_wall.settings');
    $facebook_api_url = $config->get('facebook_api_url');
    $page_id = $config->get('page_id');
    $post_variables = $config->get('post_variables');
    $access_token = Settings::get('zbclub_facebook_access_token');
    $url = trim($facebook_api_url);
    $url .= trim($page_id);
    $url .= '?fields=posts.limit(100){' . trim($post_variables) . '}&';
    $url .= 'access_token=' . trim($access_token);

    try {
      $response = $this->httpClient->get($url);

      // Process the response.
      $data = json_decode($response->getBody());

      // Save the file with the given content.
      $file_path = 'public://facebook-api/';
      $file_name = 'zb-club-facebook-page.json';
      $file_contents = json_encode($data);

      $this->fileSystem->prepareDirectory($file_path, FileSystemInterface::CREATE_DIRECTORY);
      $this->fileSystem->saveData($file_contents, $file_path . $file_name, FileSystemInterface::EXISTS_REPLACE);
    }
    catch (\Exception $e) {
      $this->loggerFactory->get('zbclub_social_media_wall')->error($e->getMessage());
    }

    return [
      '#markup' => $this->t('Finished running the Facebook API cron job.'),
    ];
  }

}
