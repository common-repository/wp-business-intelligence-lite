<?php

namespace Wpbi\Admin\Url\Connections;

use Wpbi\Settings\WpActions;
use Wpbi\Admin\Menu\Connections\WordpressDataConnection as WordpressDataConnectionMenu;

// TODO: uncovered for no good reason
class WordpressDataConnection {

  public static function showIndexUrl() {
    return admin_url(sprintf('admin.php?page=%s', WordpressDataConnectionMenu::menuSlug()));
  }

  public static function showCreateUrl() {
    $query = http_build_query(array('action' => 'showCreate'));
    return admin_url(sprintf('admin.php?page=%s&%s', WordpressDataConnectionMenu::menuSlug(), $query));
  }

  public static function showEditUrl($id) {
    $query = http_build_query(array('page' => WordpressDataConnectionMenu::menuSlug(), 'id' => $id, 'action' => 'showEdit'));
    $url = admin_url('admin.php?' . $query);
    return $url;
  }

  public static function createUrl() {
    $query = http_build_query(array('action' => WpActions::CREATE_WORDPRESS_DATA_CONNECTION));
    $url = admin_url('admin-post.php?' . $query);
    return $url;
  }

  public static function editUrl() {
    $query = http_build_query(array('action' => WpActions::EDIT_WORDPRESS_DATA_CONNECTION));
    $url = admin_url('admin-post.php?' . $query);
    return $url;
  }

  public static function deleteUrl($id) {
    $query = http_build_query(array('id' => $id,
      'action' => WpActions::DELETE_WORDPRESS_DATA_CONNECTION));
    $url = admin_url('admin-post.php?' . $query);
    return $url;
  }

}
