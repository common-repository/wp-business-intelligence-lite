<?php

namespace Wpbi\Admin\Url\Chartjs;

use Wpbi\Settings\WpActions;
use Wpbi\Admin\Menu\Chartjs\ChartjsLineChart as ChartjsLineChartMenu;

// TODO: uncovered for no good reason
class ChartjsLineChart {

  public static function showCreateUrl($slug) {
    $query = http_build_query(array('action' => 'showCreate', 'library' => $slug));
    return admin_url(sprintf('admin.php?page=%s&%s', ChartjsLineChartMenu::menuSlug(), $query));
  }

  public static function showEditUrl($id, $slug) {
    $query = http_build_query(array('page' => ChartjsLineChartMenu::menuSlug(), 'id' => $id, 'action' => 'showEdit', 'library' => $slug));
    $url = admin_url('admin.php?' . $query);
    return $url;
  }

  public static function createUrl($slug) {
    $query = http_build_query(array('action' => WpActions::CREATE_CHARTJS_LINE_CHART, 'library' => $slug));
    $url = admin_url('admin-post.php?' . $query);
    return $url;
  }

  public static function editUrl($slug) {
    $query = http_build_query(array('action' => WpActions::EDIT_CHARTJS_LINE_CHART, 'library' => $slug));
    $url = admin_url('admin-post.php?' . $query);
    return $url;
  }

}
