<?php

namespace Wpbi\Admin\Menu\Chartjs;

use Wpbi\Admin\Menu\AbstractChart;

// TODO: uncovered
class ChartjsDoughnutChart extends AbstractChart {

  protected static function checkboxFields() {
    return array('show_legend', 'in_dash');
  }

}
