<?php

namespace gh640\SjisStreamFilter\Manager;

use PHPUnit\Framework\TestCase;
use gh640\SjisStreamFilter\Exception\Exception;

class SjisFilterManagerTest extends TestCase {

  /**
   * Sets up the test environment.
   */
  public function setUp() {
    $this->factory = new SjisFilterManager();
  }

  /**
   * Tests register() method.
   */
  public function testRegister() {

    // Tests the default name.
    $result = $this->factory->register(SjisFilterManager::FILTER_SJIS_TO_UTF8);
    $this->assertEquals(SjisFilterManager::FILTER_SJIS_TO_UTF8 . '_filter', $result);

    // Tests the custom name.
    $filtername = 'sample_filter';
    $result = $this->factory->register(SjisFilterManager::FILTER_UTF8_TO_SJIS, $filtername);
    $this->assertEquals($filtername, $result);
  }

  /**
   * Tests if register() method fails if the type name is not valid.
   *
   * @expectedException Exception
   */
  public function testRegisterFailure() {
    $result = $this->factory->register('this_is_an_invalid_type');
  }

  /**
   * Tests registerAll() method.
   */
  public function testRegisterAll() {
    $this->factory->registerAll();
    $registered_filters = stream_get_filters();

    $expected_filters = [
      SjisFilterManager::FILTER_SJIS_TO_UTF8 . '_filter',
      SjisFilterManager::FILTER_UTF8_TO_SJIS . '_filter',
    ];

    foreach ($expected_filters as $filter) {
      $this->assertContains($filter, $registered_filters);
    }
  }

}
