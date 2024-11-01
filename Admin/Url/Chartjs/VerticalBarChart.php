<?php

namespace Wpbi\Admin\Url\Chartjs;

use Wpbi\Settings\WpActions;
use Wpbi\Admin\Menu\Chartjs\VerticalBarChart as VerticalBarChartMenu;

// TODO: uncovered for no good reason
class VerticalBarChart {

  public static function showCreateUrl($slug) {
    $query = http_build_query(array('action' => 'showCreate', 'library' => $slug));
    return admin_url(sprintf('admin.php?page=%s&%s', VerticalBarChartMenu::menuSlug(), $query));
  }

  public static function showEditUrl($id, $slug) {
    $query = http_build_query(array('page' => VerticalBarChartMenu::menuSlug(), 'id' => $id, 'action' => 'showEdit', 'library' => $slug));
    $url = admin_url('admin.php?' . $query);
    return $url;
  }

  public static function createUrl($slug) {
    $query = http_build_query(array('action' => WpActions::CREATE_CHARTJS_VERTICAL_BAR_CHART, 'library' => $slug));
    $url = admin_url('admin-post.php?' . $query);
    return $url;
  }

  public static function editUrl($slug) {
    $query = http_build_query(array('action' => WpActions::EDIT_CHARTJS_VERTICAL_BAR_CHART, 'library' => $slug));
    $url = admin_url('admin-post.php?' . $query);
    return $url;
  }

}
