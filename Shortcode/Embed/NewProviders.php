<?php
namespace Wpbi\Shortcode\Embed;

class NewProviders {

  public static function init() {

    self::addProvider();
    self::addHandler();
  }

  public static function addProvider() {

    wp_oembed_add_provider( 'https://*.deviantart.com/art/*', 'https://backend.deviantart.com/oembed' );
    wp_oembed_add_provider( 'http://fav.me/*', 'https://backend.deviantart.com/oembed' );
    wp_oembed_add_provider( 'https://sta.sh/*', 'https://backend.deviantart.com/oembed' );
    wp_oembed_add_provider( 'https://*.deviantart.com/*/art/*', 'https://backend.deviantart.com/oembed' );

    wp_oembed_add_provider( 'http://www.edocr.com/doc/*', 'http://www.edocr.com/api/oembed' );
    wp_oembed_add_provider( '#http://iheart.com/*#i', 'http://iheart.com/oembed', true );
    wp_oembed_add_provider( '#https://rumble.com/*#i', 'https://rumble.com/api/Media/oembed.json?url=', true );
  }

  public static function addHandler() {

    wp_embed_register_handler(
      'devianart',
      '#https://(.+?)deviantart\.net\/(?:(.+?)($|&))\/*#i',
      array(self::class, 'render')
    );
    wp_embed_register_handler(
      'edocr',
      '#http://(.+?)edocr\.com\/embed\/(?:(.+?)($|&))\/*#i',
      array(self::class, 'render')
    );
    wp_embed_register_handler(
      'iheart',
      '#http://(.+?)iheart\.com\/(?:(.+?)($|&))\/*#i',
      array(self::class, 'render')
    );
    wp_embed_register_handler(
      'rumble',
      '#http://(.+?)rumble\.com\/embed\/(?:(.+?)($|&))\/*#i',
      array(self::class, 'render')
    );

  }


  public static function render( $matches, $attr, $url, $rawattr ) {

    $embed = sprintf(
            '<iframe src="%1$s" width="%3$spx" height="%2$spx" frameborder="0" scrolling="no" marginwidth="0" marginheight="0"></iframe>',
            $url,
            $attr['height'],
            $attr['width']
            );

    return $embed;
  }
}
