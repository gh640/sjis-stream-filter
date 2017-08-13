<?php

namespace gh640\SjisStreamFilter\Filter;

/**
 * Filter for converting utf-8 to sjis.
 */
class Utf8ToSjisFilter extends \php_user_filter {

  /**
   * The filter name set with stream_filter_register().
   *
   * @var string
   */
  // $filtername;

  /**
   * The params passed to stream_filter_append().
   */
  // $params;

  /**
   * Filter the stream.
   *
   * @param resource $in
   * @param resource $out
   * @param int $consumed
   * @param bool $closing
   */
  public function filter($in, $out, &$consumed, $closing) {
    while ($bucket = stream_bucket_make_writeable($in)) {
      $bucket->data = mb_convert_encoding($bucket->data, 'SJIS-win', 'UTF-8');
      $consumed += $bucket->datalen;
      stream_bucket_append($out, $bucket);
    }

    return PSFS_PASS_ON;
  }

  // public function onCreate() {}
  // public function onClose() {}
}
