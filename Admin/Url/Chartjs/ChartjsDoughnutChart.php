<?php

namespace Wpbi\Admin\Url\Chartjs;

use Wpbi\Settings\WpActions;
use Wpbi\Admin\Menu\Chartjs\ChartjsDoughnutChart as ChartjsDoughnutChartMenu;

// TODO: uncovered for no good reason
class ChartjsDoughnutChart {

  public static function showCreateUrl($slug) {
    $query = http_build_query(array('action' => 'showCreate', 'library' => $slug));
    return admin_url(sprintf('admin.php?page=%s&%s', ChartjsDoughnutChartMenu::menuSlug(), $query));
  }

  public static function showEditUrl($id, $slug) {
    $query = http_build_query(array('page' => ChartjsDoughnutChartMenu::menuSlug(), 'id' => $id, 'action' => 'showEdit', 'library' => $slug));
    $url = admin_url('admin.php?' . $query);
    return $url;
  }

  public static function createUrl($slug) {
    $query = http_build_query(array('action' => WpActions::CREATE_CHARTJS_DOUGHNUT_CHART, 'library' => $slug));
    $url = admin_url('admin-post.php?' . $query);
    return $url;
  }

  public static function editUrl($slug) {
    $query = http_build_query(array('action' => WpActions::EDIT_CHARTJS_DOUGHNUT_CHART, 'library' => $slug));
    $url = admin_url('admin-post.php?' . $query);
    return $url;
  }

}
