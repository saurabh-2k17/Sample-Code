<?php

namespace Drupal\evolvingweb\Controller;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * {@inheritdoc}
 */
class CommonController extends ControllerBase {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Creates ConfigManager objects.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * Returns JSON response with basic page title value.
   */
  public function getApi($auth, $nid) {
    $apiKey = \Drupal::config('system.site')->get('siteapikey');
    $node = $this->entityTypeManager->getStorage('node')->load($nid);
    $contentType = $node->get('type')->getValue()[0]['target_id'];
    if ($auth == $apiKey && $contentType === 'page') {
      $response = [
        "Title" => $node->get('title')->getValue()[0]['value'],
        "Body" => $node->get('body')->getValue()[0]['value'],
      ];
      return new JsonResponse($response);
    }
    else {
      throw new AccessDeniedHttpException();
    }

  }

}
