<?php
namespace Wpbi\Admin\Menu;

use League\Plates\Engine;
use Wpbi\Settings;

// TODO: uncovered
class DataSources {

  public static function menuSlug() {
    return 'data-sources';
  }

  public static function adminPage() {
    return 'admin.php?page=';
  }

  public static function addMenu() {
    $parentSlug = Main::menuSlug();
    $pageTitle = 'Data Sources';
    $menuTitle = 'Data Sources';
    $capability = Settings::capability();
    $menuSlug = self::menuSlug();
    $function = array(self::class, 'route');
    add_submenu_page($parentSlug, $pageTitle, $menuTitle, $capability, $menuSlug, $function);
  }

  /**
   * @SuppressWarnings(PHPMD.CyclomaticComplexity)
   */
  public static function route() {

    echo (new Engine(Settings::platesDirectory()))
      ->render('admin/DataSources',
               array('connections' => self::connectionsData()));
  }


  public static function connectionsData() {

    return [
      [
        'title'       => 'Connections',
        'url'         => admin_url(self::adminPage() . \Wpbi\Admin\Menu\Connections\DatabaseConnection::menuSlug()),
        'description' => 'Connect to your own MySQL database and securely display data on your website.'
      ],
      [
        'title'       => 'Data from WordPress',
        'url'         => admin_url(self::adminPage() . \Wpbi\Admin\Menu\Connections\WordpressDataConnection::menuSlug()),
        'description' => 'Use our pre-built queries to quickly generate charts and graphs from your WordPress data. You can even add these to your Admin dashboard with just a click.'
      ],
    ];
  }

}
