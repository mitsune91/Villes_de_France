<?php

namespace Drupal\custom_weather\Plugin\Block;

use Drupal\Console\Bootstrap\Drupal;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\Annotation\Block;
use Symfony\Cmf\Component\Routing\RouteObjectInterface;

/**
 * Class CustomWeatherBlock
 * @package Drupal\custom_weather\Plugin\Block
 * @Block(
 *   id = "custom_weather_block",
 *   admin_label = @Translation("Custom Weather"),
 *   category = @Translation("Custom Weather"),
 * )
 */
class CustomWeatherBlock extends BlockBase
{

  public function build()
  {
    $config = \Drupal::config('custom_weather.settings');
    $apiKey = $config->get('apiKey');
    $language = $config->get('language');
    $request = \Drupal::request();
    if ($route = $request->attributes->get(RouteObjectInterface::ROUTE_OBJECT)) {
      $title = \Drupal::service('title_resolver')->getTitle($request, $route);
    }
    $content = file_get_contents('https://api.openweathermap.org/data/2.5/weather?q=' . $title . '&units=metric&lang=' . $language . '&appid=' . $apiKey . '');
    $data = json_decode($content, true);
    $location = $data['name'];
    $icon = $data['weather'][0]['icon'];
    $description = $data['weather'][0]['description'];
    $temperature = $data['main']['temp'];

//    dump($location);dump($icon);dump($temperature);
    return [
      '#location' => $location,
      '#icon' => $icon,
      '#temperature' => $temperature,
      '#description' => $description,
      '#cache' => ['max-age' => 0,],
      '#theme' => 'custom_weather'
    ];

  }
}
