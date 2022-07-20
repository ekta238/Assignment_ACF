<?php

namespace Drupal\custom_config_form;

use Drupal\Core\Datetime\DrupalDateTime;

/**
 * CurrentTimeService Class Doc Comment.
 */
class CurrentTimeService {

  /**
   * {@inheritdoc}
   */
  public function currentTime() {

    $config = \Drupal::config('custom_config_form.adminsettings');
    $timezone = $config->get('timezone');
    $replace_zone = str_replace('-', '/', $timezone);
    $upper_case_zone = ucwords($replace_zone, '/_');

    $date_time = new DrupalDateTime();
    $date_time->setTimezone(new \DateTimeZone($upper_case_zone));
    $current_date_time = $date_time->format('jS F Y \- h:i A');

    return $current_date_time;
  }

}
