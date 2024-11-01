<?php
namespace Wpbi\Admin\Menu;

use Wpbi\Settings;
use Wpbi\Admin\Menu\Connections\DatabaseConnection as DatabaseConnection;
use Wpbi\Admin\Menu\Connections\WordpressDataConnection as WordpressDataConnection;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Main {

  public static function menuSlug() {
    return 'wpbi-main';
  }

  /**
   * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
   */
  public static function addMenu() {
    $pageTitle = Settings::PLUGIN_NAME;
    $menuTitle = Settings::PLUGIN_NAME;
    $capability = Settings::capability();
    $menuSlug = self::menuSlug();
    $function = function () {}; // phpcs:ignore
    $iconUrl = "data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAyNC4zLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiDQoJIHZpZXdCb3g9IjAgMCAxMDAwIDEwMDAiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDEwMDAgMTAwMDsiIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPHN0eWxlIHR5cGU9InRleHQvY3NzIj4NCgkuc3Qwe2ZpbGw6IzMyMzYzRjt9DQoJLnN0MXtmaWxsOiMwMEQyQ0Y7fQ0KCS5zdDJ7ZmlsbDojRTAzQTdCO30NCgkuc3Qze2ZpbGw6I0ZGQTYwMDt9DQoJLnN0NHtmaWxsOiNGRkZGRkY7fQ0KPC9zdHlsZT4NCjxnPg0KCTxyZWN0IHg9IjMwMC4zIiB5PSIzNjEiIGNsYXNzPSJzdDEiIHdpZHRoPSI5NC41IiBoZWlnaHQ9IjM2My41Ii8+DQoJPHJlY3QgeD0iNDU2LjgiIHk9IjI3NS41IiBjbGFzcz0ic3QyIiB3aWR0aD0iOTQuNSIgaGVpZ2h0PSI0NDkiLz4NCgk8cmVjdCB4PSI2MDUuMSIgeT0iNDc2LjYiIGNsYXNzPSJzdDMiIHdpZHRoPSI5NC41IiBoZWlnaHQ9IjI0Ny45Ii8+DQoJPHJlY3QgeD0iMzAwLjMiIHk9IjUxMC4yIiBjbGFzcz0ic3Q0IiB3aWR0aD0iOTQuNSIgaGVpZ2h0PSIyMTQuNCIvPg0KCTxyZWN0IHg9IjQ1Ni44IiB5PSI0NDguNyIgY2xhc3M9InN0NCIgd2lkdGg9Ijk0LjUiIGhlaWdodD0iMjc1LjkiLz4NCgk8cmVjdCB4PSI0NTYuOCIgeT0iNTkzLjMiIGNsYXNzPSJzdDQiIHdpZHRoPSI5NC41IiBoZWlnaHQ9IjEzMS4yIi8+DQoJPHJlY3QgeD0iNjA1LjEiIHk9IjU1NC42IiBjbGFzcz0ic3Q0IiB3aWR0aD0iOTQuNSIgaGVpZ2h0PSIxNjkuOSIvPg0KPC9nPg0KPC9zdmc+DQo=";
    $position = "99.00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000";
    add_menu_page($pageTitle, $menuTitle, $capability, $menuSlug, $function, $iconUrl, $position);
    Home::addMenu();
    Query::addMenu();
    Chart::addMenu();
    Datatable::addMenu();
    DatabaseConnection::addMenu();
    WordpressDataConnection::addMenu();
    DataSources::addMenu();
    Variable::addMenu(); 
    foreach (\Wpbi\Models\Chart::chartMenus() as $chartMenu) {
      call_user_func(array($chartMenu, 'addMenu'));
    }
    remove_submenu_page($menuSlug, $menuSlug);
  }

  /**
   * @SuppressWarnings(PHPMD.CyclomaticComplexity)
   */
  public static function hideSubMenus() {
    $submenu = &$GLOBALS['submenu'];
    if (is_null($submenu) || ! array_key_exists(self::menuSlug(), $submenu)) {
      return;
    }

    $stopClasses = [
      DatabaseConnection::menuSlug(),
      WordpressDataConnection::menuSlug(),
    ];

    foreach ($submenu[self::menuSlug()] as $i => $menuItem) {
      if (in_array($menuItem[2], \Wpbi\Models\Chart::chartSlugs())) { // [2] is the submenu's slug
        /**
         * hack - this functionality is not accessible through add_submenu_page or add_menu_page.
         * The only place I could found it used was in menu.php (search for 'hide-if-no-customize').
         * http://svn.automattic.com/wordpress/tags/4.4/wp-admin/menu.php
         */
        $submenu[self::menuSlug()][$i][4] = 'hidden'; // [4] is for class
      }

      foreach ($stopClasses as $stopClass) {
        if ($menuItem[2] == $stopClass) { // [2] is the submenu's slug
          $submenu[self::menuSlug()][$i][4] = 'hidden'; // [4] is for class
        }
      }
    }
  }

  public static function showSelectedSubmenu($submenuFile, $parentFile) {
    if ($parentFile !== static::menuSlug()) {
      return $submenuFile;
    }
    $pluginPage = $GLOBALS['plugin_page'];

    // Select another submenu item to highlight
    if (is_null($pluginPage) !== true && in_array($pluginPage, \Wpbi\Models\Chart::chartSlugs())) {
      $submenuFile = Chart::menuSlug();
    }

    return $submenuFile;
  }

}
