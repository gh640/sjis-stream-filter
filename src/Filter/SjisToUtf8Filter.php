<?php

namespace gh640\SjisStreamFilter\Filter;

/**
 * Filter for converting sjis to utf-8.
 */
class SjisToUtf8Filter extends \php_user_filter {

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
      $bucket->data = mb_convert_encoding($bucket->data, 'UTF-8', 'SJIS-win');
      $consumed += $bucket->datalen;
      stream_bucket_append($out, $bucket);
    }

    return PSFS_PASS_ON;
  }

  // public function onCreate() {}
  // public function onClose() {}
}
