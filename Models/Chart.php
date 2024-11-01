<?php
namespace Wpbi\Models;

// TODO: uncovered
class Chart {

  public static $chartTypes = array(
    'bar-chart' => array(
      'slug' => 'bar-chart',
      'name' => 'Bar',
      'model' => Britechart\BarChart::class,
      'menu' => \Wpbi\Admin\Menu\Britechart\BarChart::class,
    ),
    'pie-chart' => array(
      'slug' => 'pie-chart',
      'name' => 'Donut',
      'model' => Britechart\PieChart::class,
      'menu' => \Wpbi\Admin\Menu\Britechart\PieChart::class,
    ),
    'grouped-bar-chart' => array(
      'slug' => 'grouped-bar-chart',
      'name' => 'Grouped Bar',
      'model' => Britechart\GroupedBarChart::class,
      'menu' => \Wpbi\Admin\Menu\Britechart\GroupedBarChart::class,
    ),
    'line-chart' => array(
      'slug' => 'line-chart',
      'name' => 'Line',
      'model' => Britechart\LineChart::class,
      'menu' => \Wpbi\Admin\Menu\Britechart\LineChart::class,
    ),
  );

  public static $chartTypesChartJs = array(
    'chartjs-line-chart' => array(
      'slug' => 'chartjs-line-chart',
      'name' => 'Line',
      'model' => Chartjs\ChartjsLineChart::class,
      'menu' => \Wpbi\Admin\Menu\Chartjs\ChartjsLineChart::class,
    ),
    'chartjs-doughnut-chart' => array(
      'slug' => 'chartjs-doughnut-chart',
      'name' => 'Doughnut',
      'model' => Chartjs\ChartjsDoughnutChart::class,
      'menu' => \Wpbi\Admin\Menu\Chartjs\ChartjsDoughnutChart::class,
    ),
    'radar-chart' => array(
      'slug' => 'radar-chart',
      'name' => 'Radar',
      'model' => Chartjs\RadarChart::class,
      'menu' => \Wpbi\Admin\Menu\Chartjs\RadarChart::class,
    ),
    'vertical-bar-chart' => array(
      'slug' => 'vertical-bar-chart',
      'name' => 'Vertical Bar',
      'model' => Chartjs\VerticalBarChart::class,
      'menu' => \Wpbi\Admin\Menu\Chartjs\VerticalBarChart::class,
    ),
  );

  public static $wordpressDataChart = array(
    'wordpress-data-connection' => array(
      'slug' => 'wordpress-data-connection',
      'name' => 'WordPress Data',
      'model' => WordpressDataConnection::class,
      'menu' => \Wpbi\Admin\Menu\Connections\WordpressDataConnection::class,
    ),
  );

  public static function chartSeries() {
    return array_merge(self::$chartTypes, self::$chartTypesChartJs);
  }

  public static function chartModels() {
    return array_map(function ($chartModel) {
      return $chartModel['model'];
    }, self::chartSeries());
  }

  public static function chartMenus() {
    return array_map(function ($chartModel) {
      return $chartModel['menu']; 
    }, self::chartSeries());
  }

  public static function chartNames() {
    return array_map(function ($chartModel) {
      return $chartModel['name'];
    }, self::chartSeries());
  }

  public static function chartSlugs() {
    return array_keys(self::chartSeries());
  }

  public function allChartsToArray() {
    $charts = array();
    foreach ($this->allCharts() as $chartGroup) {
      foreach ($chartGroup as $chart) {
        $charts[] = $chart->toArray();
      }
    }
    return $charts;
  }

  public function allCharts() {
    return array_map(function ($chartModel) {
      return call_user_func(array($chartModel, 'all'));
    }, $this->chartModels());
  }

}
