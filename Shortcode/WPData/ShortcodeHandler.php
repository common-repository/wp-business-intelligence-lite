<?php
namespace Wpbi\Shortcode\WPData;

use Wpbi\Models\Chartjs\VerticalBarChart;
use Wpbi\Models\Chartjs\ChartjsLineChart;

class ShortcodeHandler {

  public static function html($attributes) {
    $defaultShortcodeAttrs = array('id' => null);
    $attributes = shortcode_atts($defaultShortcodeAttrs, $attributes);

    $chartId = $attributes['id'];
    $chart = self::findChart($chartId);

    if (is_null($chart)) {
      return '';
    } else {
      try {
        return $chart;
      } catch (\PDOException $e) { // suppress error on fronted
      }
    }
  }

  /**
   * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
   * @SuppressWarnings(PHPMD.CyclomaticComplexity)
   */
  private static function findChart($chartId) {

    if (empty($chartId)) {
      return false;
    }

    $chart = \Wpbi\Models\WordpressDataConnection::find($chartId);

    if (empty($chart)) {
      return false;
    }

    $attributes = $chart->getAttributes();
    $maps = maybe_unserialize($attributes['mappings']);
    if (!empty($maps) && is_array($maps)) {

      $args = [];
      $args['cname'] = $attributes['cname'];
      $args['caption'] = $attributes['caption'];
      $args['color_scheme'] = $attributes['color_scheme'];
      $args['library'] = $attributes['library'];

      switch ($attributes['query_id']) {
        case 'posts_365':
          $data['labels'] = json_encode(array_column($maps, 'name'));
          $data['data'] = json_encode(array_column($maps, 'value'));
          $html = VerticalBarChart::getHtmlForWpData($chartId, $data, $args, $attributes['caption']);
          break;
        case 'comments_365':
          $data['labels'] = json_encode(array_column($maps, 'name'));
          $data['data'] = json_encode(array_column($maps, 'value'));
          $html = VerticalBarChart::getHtmlForWpData($chartId, $data, $args, $attributes['caption']);
          break;
        case 'authors_30':
          $data['labels'] = json_encode($maps['name']);
          $data['data'] = json_encode($maps['value']);
          $html = ChartjsLineChart::getHtmlForWpData($chartId, $data, $args, $attributes['caption']);
          break;
        case 'users_365':
          $data['labels'] = json_encode(array_column($maps, 'name'));
          $data['data'] = json_encode(array_column($maps, 'value'));
          $html = ChartjsLineChart::getHtmlForWpData($chartId, $data, $args, $attributes['caption']);
          break;
        case 'comments_10':
          $data['labels'] = json_encode($maps['name']);
          $data['data'] = json_encode($maps['value']);
          $html = VerticalBarChart::getHtmlForWpData($chartId, $data, $args, $attributes['caption']);
          break;
      }

      return $html;
    }

    return null;
  }

}
