<?php
namespace Wpbi\Models\Chartjs;

use League\Plates\Engine;
use Wpbi\Settings;
use Wpbi\Models\AbstractChart;

// TODO: uncovered
class ChartjsDoughnutChart extends AbstractChart {

  protected $chartSlug = 'chartjs-doughnut-chart';

  protected $mappedAttributes = array('topic', 'value');

  protected $fillable = array(
    'topic', 'value',
    'query_id',
    'cname',
    'caption',
    'library',
    'color_scheme',
    'in_dash'
  );

  protected $casts = array(
    'cname' => 'string',
    'caption' => 'string',
    'color_scheme' => 'string',
    'in_dash' => 'boolean',
    'library' => 'string'
  );

  public function setInDashAttribute($value) {
    if ((boolean) $value == true) {
      $set = 1;
    } else {
      $set = 0;
    }
    $this->attributes['in_dash'] = $set;
  }

  public function setLibraryAttribute($value) {
    $this->attributes['library'] = $value;
  }

  public function setColorSchemeAttribute($value) {
    $this->attributes['color_scheme'] = $value;
  }

  public function setCnameAttribute($value) {
    $this->attributes['cname'] = (string) $value;
  }

  public function setCaptionAttribute($value) {
    $this->attributes['caption'] = (string) $value;
  }

  public function resultsToJson() {
    $mappings = $this->mappings;
    $hasNecessaryKeys = array_key_exists('value', $mappings) === false;
    if ($hasNecessaryKeys === true) {
      return json_encode(array());
    }
    $mappedData = $this->mapData();
    return json_encode($mappedData);
  }

  public function labelsToJson() {
    $mappings = $this->mappings;
    $hasNecessaryKeys = array_key_exists('topic', $mappings) === false;
    if ($hasNecessaryKeys === true) {
      return json_encode(array());
    }
    $mappedData = $this->mapLabels();
    return json_encode($mappedData);
  }

  public function getHtml($caption) {
    #self::enqueueAssetsChartjs();
    return (new Engine(Settings::platesDirectory()))
      ->render('chart/chartjs/doughnut-chart',
        array('chartId' => $this->id,
          'options' => $this->options(),
          'chartLabels' => $this->labelsToJson(),
          'chartData' => $this->resultsToJson(),
          'assets' => Settings::plugin_asset_path(),
          'caption' => $caption));
  }

  private function options() {
    $options = array();
    $options['cname'] = $this->cname;
    $options['caption'] = $this->caption;
    $options['color_scheme'] = $this->color_scheme;
    $options['in_dash'] = ($this->in_dash === true) ? 'true' : 'false';
    $options['library'] = $this->library;
    return $options;
  }

  private function mapData() {
    $chartData = $this->queryStatement->results();
    $key = $this->mappings['value']['sql'];
    $mappedData = array();
    foreach ($chartData as $row) {
      $point = $row[$key];
      $mappedData[] = $point;
    }
    return $mappedData;
  }

  private function mapLabels() {
    $chartData = $this->queryStatement->results();
    $key = $this->mappings['topic']['sql'];
    $mappedData = array();
    foreach ($chartData as $row) {
      $point = $row[$key];
      $mappedData[] = $point;
    }
    return $mappedData;
  }
}
