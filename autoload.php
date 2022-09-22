<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @namespace Sammy\Packs\Format
 * - Autoload, application dependencies
 */
namespace Sammy\Packs\Format {
  $autoloadFile = __DIR__ . '/vendor/autoload.php';

  if (is_file ($autoloadFile)) {
    include_once $autoloadFile;
  }

  include_once __DIR__ . '/src/filters/index.php';
}
