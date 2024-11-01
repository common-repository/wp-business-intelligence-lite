<?php
namespace Wpbi;

class Settings {

  const PLUGIN_ABBREVIATION = 'wpbi';
  const WP_GLOBAL_INDEX = self::PLUGIN_ABBREVIATION . '\wp_global_access';
  const PLUGIN_SLUG = 'wp-business-intelligence-lite';
  const PLUGIN_NAME = 'WP Business Intelligence';
  const SUPPORT_EMAIL = 'wpbi.support@wpbusinessintelligence.com';
  const PLUGIN_FILE_PATH = 'wp-business-intelligence-lite/index.php';
  const PHINX_ADAPTER = 'wpbiMySQL';

  public static function plugin_asset_path() {
    return plugins_url( '/Assets', __FILE__ );
  }

  public static function chartLibrary() {
    return array(
      'britechart',
      'chartjs'
    );
  }

  public static function britechartSlug() {
    return 'britechart';
  }

  public static function chartjsSlug() {
    return 'chartjs';
  }

  public static function platesDirectory() {
    return __DIR__ . DIRECTORY_SEPARATOR . 'templates';
  }

  public static function tableShortCode() {
    return self::PLUGIN_ABBREVIATION . '_table';
  }

  public static function chartShortCode() {
    return self::PLUGIN_ABBREVIATION . '_chart';
  }

  public static function wpDataShortCode() {
    return self::PLUGIN_ABBREVIATION . '_wp_data';
  }

  public static function datatableScriptName() {
    return self::PLUGIN_ABBREVIATION . '_datatable';
  }

  public static function datatableStyleName() {
    return self::datatableScriptName() . '_style';
  }

  public static function d3ScriptName() {
    return self::PLUGIN_ABBREVIATION . '_d3_script';
  }

  public static function briteChartsScriptName() {
    return self::PLUGIN_ABBREVIATION . '_britecharts_script';
  }

  public static function briteChartsStyleName() {
    return self::PLUGIN_ABBREVIATION . '_britecharts_style';
  }

  public static function briteChartsColorScriptName() {
    return self::PLUGIN_ABBREVIATION . '_britecharts_color_script';
  }

  public static function briteChartsGlobalStyleName() {
    return self::PLUGIN_ABBREVIATION . '_britecharts_global_style';
  }

  public static function briteChartsHelperScriptName() {
    return self::PLUGIN_ABBREVIATION . '_britecharts_helper_script';
  }

  public static function docReadyScriptName() {
    return self::PLUGIN_ABBREVIATION . '_doc_ready_script';
  }

  public static function capability() {
    return 'manage_options';
  }

  public static function chartJsScriptName() {
    return self::PLUGIN_ABBREVIATION . '_chartjs_script';
  }

  public static function britechartsColorScheme() {
    return array(
      'random',
			'grey',
			'orange',
			'blueGreen',
			'teal',
			'green',
			'yellow',
			'pink',
			'purple',
			'red'
		);
  }

  public static function wordpressDataDefaults() {

    return array(
      'posts_365'    => 'Number of blog posts over the past year displayed monthly',
      'comments_365' => 'Number of comments daily for the past year',
      'authors_30'   => 'Line chart showing 10 authors with the most posts over the past 30 days',
      'users_365'    => 'Line chart showing aggregate total users over the past year displayed monthly',
      'comments_10'  => 'Bar chart showing top 10 most commented on articles in the past month arranged in descending order (most to least commnets)',
    );
  }

  public static function wordpressDataQueries() {

    global $wpdb;

    return array(
      'posts_365'    => "SELECT COUNT(*) FROM {$wpdb->posts} WHERE MONTH(post_date) = %d AND YEAR(post_date) = %d AND post_status = 'publish' AND (post_type = 'post' OR post_type = 'page')",
      'comments_365' => "SELECT COUNT(*) FROM {$wpdb->comments} WHERE comment_date LIKE %s AND comment_approved = 1",
      'authors_30'   => "SELECT DISTINCT(post_author), (SELECT COUNT(ID) FROM {$wpdb->posts} WHERE post_author = Posts.post_author) AS `post_count` FROM {$wpdb->posts} AS Posts WHERE post_date BETWEEN %s AND %s ORDER BY post_count DESC LIMIT 10",
      'users_365'    => "SELECT COUNT(*) FROM {$wpdb->users} WHERE MONTH(user_registered) = %d AND YEAR(user_registered) = %d",
      'comments_10'  => "SELECT DISTINCT(comment_post_ID), (SELECT COUNT(*) FROM {$wpdb->comments} WHERE comment_post_ID = Posts.comment_post_ID) AS `comment_count` FROM {$wpdb->comments} AS Posts WHERE comment_date BETWEEN %s AND %s AND comment_approved = 1 ORDER BY comment_count DESC LIMIT 10"
    );
  }

  public static function chartTypes() {

    return array(
      'pie',
      'bar',
      'grouped bar',
      'line',
      'sparkline',
      'stacked area',
      'stacked bar',
      'step',
      'horizontal bar',
      'brush',
      'chartjs line',
      'radar',
      'vertical bar',
      'chartjs doughnut',
    );
  }

}
