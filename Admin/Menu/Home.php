<?php
namespace Wpbi\Admin\Menu;

use League\Plates\Engine;
use Wpbi\Admin\Table\Action;
use Wpbi\Admin\Table\Actions;
use Wpbi\Settings;

// TODO: uncovered
// TODO: perhaps the menu/routing/controller things should be broken up

/**
 * TODO: complexity
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
class Home {

  public static function menuSlug() {
    return 'wpbi-lite';
  }

  public static function addMenu() {
    $parentSlug = Main::menuSlug();
    $pageTitle = 'WordPress Business Intelligence';
    $menuTitle = 'Home';
    $capability = Settings::capability();
    $menuSlug = self::menuSlug();
    $function = array(self::class, 'route');
    add_submenu_page($parentSlug, $pageTitle, $menuTitle, $capability, $menuSlug, $function);
  }

  /**
   * @SuppressWarnings(PHPMD.CyclomaticComplexity)
   */
  public static function route() {
    $action = (isset($_GET['action']) === true) ? $_GET['action'] : 'showIndex';
    switch ($action) {
      case 'showIndex':
      default:
        (new self)->showIndex();
        break;
    }
  }

  public static function showIndex() {
    echo (new Engine(Settings::platesDirectory()))
      ->render('admin/HomeIndex', [
        'v'          => '3.2.0',
        'query'      => '<a href="' . admin_url('/admin.php?page=query') . '">Query</a>',
        'chart'      => '<a href="' . admin_url('/admin.php?page=chart') . '">Chart</a>',
        'dataTable'  => '<a href="' . admin_url('/admin.php?page=datatable') . '">Data Table</a>',
        'variable'   => '<a href="' . admin_url('/admin.php?page=variable') . '">Variable</a>',
        'message'    => 'Get more chart types, more ways to display your data, and more ways to customize your business intelligence dashboards with <a href="https://www.wpbusinessintelligence.com/" target="_blank">WP Business Intelligence Pro</a>'
      ]);
  }

}
