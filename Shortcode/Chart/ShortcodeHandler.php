<?php
namespace Wpbi\Shortcode\Chart;

class ShortcodeHandler {

  public static function html($attributes) {
    $defaultShortcodeAttrs = array('id' => null, 'type' => null, 'caption' => null);
    $attributes = shortcode_atts($defaultShortcodeAttrs, $attributes);

    $chartId = $attributes['id'];
    $chartType = strtolower($attributes['type']);
    $caption = strtolower($attributes['caption']);
    $chart = self::findChart($chartType, $chartId);

    if (is_null($chart)) {
      return '';
    } else {
      try {
        return $chart->getHtml($caption);
      } catch (\PDOException $e) { // suppress error on fronted
      }
    }
  }

  /**
   * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
   * @SuppressWarnings(PHPMD.CyclomaticComplexity)
   */
  private static function findChart($chartType, $chartId) {
    switch ($chartType) {
      case 'bar':
        return \Wpbi\Models\Britechart\BarChart::find($chartId);
      case 'horizontal bar':
        return \Wpbi\Models\Britechart\HorizontalBarChart::find($chartId);
      case 'pie':
        return \Wpbi\Models\Britechart\PieChart::find($chartId);
      case 'grouped bar':
        return \Wpbi\Models\Britechart\GroupedBarChart::find($chartId);
      case 'line':
        return \Wpbi\Models\Britechart\LineChart::find($chartId);
      case 'sparkline':
        return \Wpbi\Models\Britechart\SparklineChart::find($chartId);
      case 'stacked area':
        return \Wpbi\Models\Britechart\StackedAreaChart::find($chartId);
      case 'stacked bar':
        return \Wpbi\Models\Britechart\StackedBarChart::find($chartId);
      case 'step':
        return \Wpbi\Models\Britechart\StepChart::find($chartId);
      case 'brush':
        return \Wpbi\Models\Britechart\BrushChart::find($chartId);
      case 'counter':
        return \Wpbi\Models\Counterchart\CounterChart::find($chartId);
      case 'chartjs bubble':
        return \Wpbi\Models\Chartjs\BubbleChart::find($chartId);
      case 'chartjs line':
        return \Wpbi\Models\Chartjs\ChartjsLineChart::find($chartId);
      case 'chartjs stacked line':
        return \Wpbi\Models\Chartjs\ChartjsStackedLineChart::find($chartId);
      case 'chartjs stepped line':
        return \Wpbi\Models\Chartjs\SteppedLineChart::find($chartId);
      case 'chartjs multi axis line':
        return \Wpbi\Models\Chartjs\MultiAxisLineChart::find($chartId);
      case 'chartjs pie':
        return \Wpbi\Models\Chartjs\ChartjsPieChart::find($chartId);
      case 'chartjs multi series pie':
        return \Wpbi\Models\Chartjs\MultiSeriesPieChart::find($chartId);
      case 'chartjs doughnut':
        return \Wpbi\Models\Chartjs\ChartjsDoughnutChart::find($chartId);
      case 'poalr area':
        return \Wpbi\Models\Chartjs\PolarAreaChart::find($chartId);
      case 'scatter':
        return \Wpbi\Models\Chartjs\ScatterChart::find($chartId);
      case 'radar':
        return \Wpbi\Models\Chartjs\RadarChart::find($chartId);
      case 'stacked radar':
        return \Wpbi\Models\Chartjs\StackedRadarChart::find($chartId);
      case 'combo bar line':
        return \Wpbi\Models\Chartjs\ComboBarLineChart::find($chartId);
      case 'stacked bar line':
        return \Wpbi\Models\Chartjs\StackedBarLineChart::find($chartId);
      case 'floating bar':
        return \Wpbi\Models\Chartjs\FloatingBarChart::find($chartId);
      case 'vertical bar':
        return \Wpbi\Models\Chartjs\VerticalBarChart::find($chartId);
      case 'horizontal bar':
        return \Wpbi\Models\Chartjs\ChartjsHorizontalBarChart::find($chartId);
      case 'chartjs stacked bar':
        return \Wpbi\Models\Chartjs\ChartjsStackedBarChart::find($chartId);
      case 'chartjs stacked grouped bar':
        return \Wpbi\Models\Chartjs\ChartjsStackedGrooupedBarChart::find($chartId);
      case 'googlechart line':
        return \Wpbi\Models\Googlechart\GooglechartLineChart::find($chartId);
      case 'googlechart stepped area':
        return \Wpbi\Models\Googlechart\GooglechartSteppedAreaChart::find($chartId);
      case 'googlechart gauge':
        return \Wpbi\Models\Googlechart\GooglechartGaugeChart::find($chartId);
      case 'googlechart scatter':
        return \Wpbi\Models\Googlechart\GooglechartScatterChart::find($chartId);
      case 'googlechart candlestick':
        return \Wpbi\Models\Googlechart\GooglechartCandlestickChart::find($chartId);
      case 'googlechart histogram':
        return \Wpbi\Models\Googlechart\GooglechartHistogramChart::find($chartId);
      case 'googlechart timeline':
        return \Wpbi\Models\Googlechart\GooglechartTimelineChart::find($chartId);
    }
    return null;
  }

}
