<?php

namespace gh640\SjisStreamFilter\Manager;

use gh640\SjisStreamFilter\Exception\Exception;

/**
 * Manager class for stream filters.
 */
class SjisFilterManager {

  const FILTER_SJIS_TO_UTF8 = 'sjis_to_utf8';
  const FILTER_UTF8_TO_SJIS = 'utf8_to_sjis';

  /**
   * Registers the specified stream filter.
   *
   * @param string $type
   *   The type of filter to register. 'sjis_to_utf8'|'utf8_to_sjis' .
   * @param string|null $filtername
   *   The filter name. This fallbacks to the return value of
   *   this->getDefaultFilterName() if not specified.
   */
  public function register($type, $filtername = NULL) {
    switch ($type) {
      case self::FILTER_SJIS_TO_UTF8:
        $class = '\gh640\SjisStreamFilter\Filter\SjisToUtf8Filter';
        break;

      case self::FILTER_UTF8_TO_SJIS:
        $class = '\gh640\SjisStreamFilter\Filter\Utf8ToSjisFilter';
        break;

      default:
        throw new Exception("Invalid filter is specified: $type .");
    }

    $filtername = $filtername ?: $this->getDefaultFilterName($type);

    if (in_array($filtername, stream_get_filters(), TRUE)) {
      return $filtername;
    }

    $result = stream_filter_register($filtername, $class);
    if ($result) {
      return $filtername;
    }

    return false;
  }

  /**
   * Register all the filters with the default names.
   */
  public function registerAll() {
    foreach ($this->listAll() as $type) {
      $this->register($type);
    }
  }

  /**
   * Returns all prepared filter types.
   *
   * @return string[]
   *   Array of all filter type names.
   */
  public function listAll() {
    return [
      self::FILTER_SJIS_TO_UTF8,
      self::FILTER_UTF8_TO_SJIS,
    ];
  }

  /**
   * Returns the default filter name for specified type.
   *
   * @param string $type
   *   The type name.
   *
   * @return string
   *   The default filter name for the type.
   */
  private function getDefaultFilterName($type) {
    return $type . '_filter';
  }

}
