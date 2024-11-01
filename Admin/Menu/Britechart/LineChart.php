<?php

namespace Wpbi\Admin\Menu\Britechart;

use Wpbi\Admin\Menu\AbstractChart;

// TODO: uncovered
class LineChart extends AbstractChart {

  protected static function checkboxFields() {
    return array('show_legend');
  }

}
