<?php

namespace Wpbi\Admin\Url\Britechart;

use Wpbi\Settings\WpActions;
use Wpbi\Admin\Menu\Britechart\GroupedBarChart as GroupedBarChartMenu;

// TODO: uncovered for no good reason
class GroupedBarChart {

  public static function showCreateUrl($slug) {
    $query = http_build_query(array('action' => 'showCreate', 'library' => $slug));
    return admin_url(sprintf('admin.php?page=%s&%s', GroupedBarChartMenu::menuSlug(), $query));
  }

  public static function showEditUrl($id, $slug) {
    $query = http_build_query(array('page' => GroupedBarChartMenu::menuSlug(), 'id' => $id, 'action' => 'showEdit', 'library' => $slug));
    $url = admin_url('admin.php?' . $query);
    return $url;
  }

  public static function createUrl($slug) {
    $query = http_build_query(array('action' => WpActions::CREATE_GROUPED_BAR_CHART, 'library' => $slug));
    $url = admin_url('admin-post.php?' . $query);
    return $url;
  }

  public static function editUrl($slug) {
    $query = http_build_query(array('action' => WpActions::EDIT_GROUPED_BAR_CHART, 'library' => $slug));
    $url = admin_url('admin-post.php?' . $query);
    return $url;
  }

}
