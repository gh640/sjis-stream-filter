<?php

namespace gh640\SjisStreamFilter\Filter;

use PHPUnit\Framework\TestCase;

/**
 * Filter for converting sjis to utf-8.
 */
class SjisToUtf8FilterTest extends TestCase {

  /**
   * Sets up the test environment.
   */
  public function setUp() {
    $this->filtername = 'sjis_to_utf8_filter';
    $class = '\gh640\SjisStreamFilter\Filter\SjisToUtf8Filter';
    stream_filter_register($this->filtername, $class);
  }

  /**
   * Tests the basic conversion.
   */
  public function testFilter() {
    $content_sjis = file_get_contents('php://filter/' . $this->filtername . '/resource=' . __DIR__ . '/files/poem_sjis.txt');
    $content_utf8 = file_get_contents(__DIR__ . '/files/poem_utf8.txt');

    $this->assertEquals($content_utf8, $content_sjis);
  }

}
