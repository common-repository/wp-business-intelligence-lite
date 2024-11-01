<?php
namespace Wpbi\Shortcode\Embed;

class ShortcodeHandler {

  public static function html($attributes) {
    $defaultShortcodeAttrs = array('id' => null);
    $attributes = shortcode_atts($defaultShortcodeAttrs, $attributes);

    $embedId = $attributes['id'];
    $embed = self::findEmbed($embedId);

    if (is_null($embed)) {
      return '';
    } else {
      try {
        return $embed;
      } catch (\PDOException $e) { // suppress error on fronted
      }
    }
  }

  /**
   * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
   * @SuppressWarnings(PHPMD.CyclomaticComplexity)
   */
  private static function findEmbed($embedId) {

    $embed = \Wpbi\Models\EmbeddedContentConnection::find($embedId);

    if (isset($embed['embedded_url'])) {
      $html = wp_oembed_get($embed['embedded_url'], array('discover' => true));
      if (empty($html)) {
        global $wp_embed;
        $html = $wp_embed->run_shortcode('[embed]' . $embed['embedded_url'] . '[/embed]');
      }
      return $html;
    }

    return null;
  }

}
