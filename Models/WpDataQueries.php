<?php
namespace Wpbi\Models;

use Wpbi\Settings;

// TODO: uncovered
class WpDataQueries {

  public $query_table = '_wp_data_queries';

  public $con_table = '_wordpress_data_connections';

  protected $fillable = array(
    'name',
    'sql'
  );

  public function getSql($query_id) {

    global $wpdb;

    $table = $wpdb->prefix . Settings::PLUGIN_ABBREVIATION . $this->getTableName();
    $sql = $wpdb->prepare(
      "SELECT DISTINCT(wpsql) FROM {$table} WHERE name = %s", $query_id
    );
    $sql = $wpdb->get_var( $sql );

    return $sql;
  }

  public function saveData($query_id, $data) {

    global $wpdb;

    $table = $wpdb->prefix . Settings::PLUGIN_ABBREVIATION . $this->getConnectionTableName();
    $data = ['mappings' => maybe_serialize($data)];
    $wpdb->update( $table, $data, ['id' => $query_id], ['%s'], ['%d'] );
  }

  public function getData($query_id, $query) {

    global $wpdb;
    
    switch ($query_id) {
      case 'posts_365':
        $data = array();
        $lastMonth = self::getLastyear();
        foreach ($lastMonth as $i => $ym) {
          $sql = $wpdb->prepare(
            $query, $ym[1], $ym[0]
          );
          $item = $wpdb->get_results( $sql, ARRAY_A );
          $data[] = [
            'id' => $i,
            'name' => $ym[0].'-'.$ym[1],
            'value' => (int) $item[0]['COUNT(*)']
            ];
        }
        break;

      case 'comments_365':
        $data = array();
        $lastMonth = self::getDatesOfLastyear();
        foreach ($lastMonth as $i => $ymd) {
          $sql = $wpdb->prepare(
            $query, implode('-', $ymd) . '%'
          );
          $item = $wpdb->get_results( $sql, ARRAY_A );
          $data[] = [
            'id' => $i,
            'name' => $ymd[0].'-'.$ymd[1].'-'.$ymd[2],
            'value' => (int) $item[0]['COUNT(*)']
            ];
        }
        break;

      case 'authors_30':
        $table = $wpdb->posts;
        $lastMonth = self::getDatesOfLastMonth();
        $sql = $wpdb->prepare(
          $query, $lastMonth[0], $lastMonth[1]
        );
        $items = $wpdb->get_results( $sql, ARRAY_A );
        foreach ($items as $item) {
          $author_obj = get_user_by('id', $item['post_author']);
          $author[] = (isset($author_obj->user_nicename) ? $author_obj->user_nicename : $item['post_author']);
          $count[] = $item['post_count'];
        }
        $data['name'] = $author;
        $data['value'] = $count;
        break;

      case 'users_365':
        $data = array();
        $lastMonth = self::getLastyear();
        foreach ($lastMonth as $i => $ym) {
          $sql = $wpdb->prepare(
            $query, $ym[1], $ym[0]
          );
          $item = $wpdb->get_results( $sql, ARRAY_A );
          $data[] = [
            'id' => $i,
            'name' => $ym[0].'-'.$ym[1],
            'value' => (int) $item[0]['COUNT(*)']
            ];
        }
        break;

      case 'comments_10':
        $table = $wpdb->posts;
        $lastMonth = self::getDatesOfLastMonth();
        $sql = $wpdb->prepare(
          $query, $lastMonth[0], $lastMonth[1]
        );
        $items = $wpdb->get_results( $sql, ARRAY_A );
        $author = $count = [];
        foreach ($items as $item) {
          $post_obj = get_post($item['comment_post_ID']);
          $author[] = (isset($post_obj->post_title) ? $post_obj->post_title : $item['comment_post_ID']);
          $count[] = $item['comment_count'];
        }
        $data['name'] = $author;
        $data['value'] = $count;
        break;
    }

    return $data;
  }

  private static function getLastyear() {

    $yms = array();
    $now = date('Y-m');
    for($x = 12; $x >= 1; $x--) {
      $m = date('m', strtotime($now . " -$x month"));
      $y = date('Y', strtotime($now . " -$x month"));
      $yms[] = [$y, $m];
    }

    return $yms;
  }

  private static function getDatesOfLastyear() {

    $ymd = array();
    $now = date('Y-m-d');
    for($x = 365; $x >= 0; $x--) {
      $m = date('m', strtotime($now . " -$x day"));
      $y = date('Y', strtotime($now . " -$x day"));
      $d = date('d', strtotime($now . " -$x day"));
      $ymd[] = [$y, $m, $d];
    }

    return $ymd;
  }

  private static function getDatesOfLastMonth() {

    $ymd = [];
    $now = date('Y-m-d');

    $m = date('Y-m-d H:i:s', strtotime($now . " -1 month"));
    $ymd[] = $m;

    $m = date('Y-m-d H:i:s', strtotime($now));
    $ymd[] = $m;

    return $ymd;
  }

  private function getTableName() {
    return $this->query_table;
  }

  private function getConnectionTableName() {
    return $this->con_table;
  }
}
