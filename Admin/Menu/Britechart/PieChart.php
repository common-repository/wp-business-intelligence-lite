<?php

namespace Wpbi\Admin\Menu\Britechart;

use Wpbi\Admin\Menu\AbstractChart;

// TODO: uncovered
class PieChart extends AbstractChart {

  protected static function checkboxFields() {
    return array('show_legend');
  }

}
