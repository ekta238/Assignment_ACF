<?php

namespace Drupal\custom_config_form\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\custom_config_form\CurrentTimeService;

/**
 * Defines a current time block.
 *
 * @Block(
 *   id = "custom_config_form_block",
 *   admin_label = @Translation("Current Time Block"),
 * )
 */
class CurrentTimeBlock extends BlockBase implements ContainerFactoryPluginInterface {
  /**
   * Drupal\custom_config_form\CurrentTimeService definition.
   *
   * @var \Drupal\custom_config_form\CurrentTimeService
   */
  protected $timeServices;

  /**
   * Create function.
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
          $configuration,
          $plugin_id,
          $plugin_definition,
          $container->get('current_time_service.timezone')
      );
  }

  /**
   * Class constructor.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, CurrentTimeService $timeServices) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->dateTimeService = $timeServices;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $current_site_time = $this->dateTimeService->currentTime();
    $config = \Drupal::config('custom_config_form.adminsettings');
    $country = $config->get('country');
    $city = $config->get('city');

    $site_data = [
      'country' => $country,
      'city' => $city,
      'time' => $current_site_time,
    ];

    return [
      '#theme' => 'custom_current_time_date',
      '#site_data_info' => $site_data,
      '#cache' => [
        'max-age' => 0,
      ],
    ];
  }

}
