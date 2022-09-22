<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Format\Filter
 * - Autoload, application dependencies
 *
 * MIT License
 *
 * Copyright (c) 2020 Ysare
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */
namespace Sammy\Packs\Format\Filter {
  use Sammy\Packs\Format\IFormatFilter;
  /**
   * Make sure the module base internal class is not
   * declared in the php global scope before creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!class_exists ('Sammy\Packs\Format\Filter\ColorFilter')) {
  /**
   * @class ColorFilter
   * Base internal class for the
   * Format\Filter module.
   * -
   * This is (in the ils environment)
   * an instance of the php module,
   * which should contain the module
   * core functionalities that should
   * be extended.
   * -
   * For extending the module, just create
   * an 'exts' directory in the module directory
   * and boot it by using the ils directory boot.
   * -
   */
  class ColorFilter implements IFormatFilter {
    public function filter ($string) {}

    private function _runningPropmt () {
      return in_array (php_sapi_name (), ['cli']);
    }

    # \033[31m\n# {$title}\033[0m

    public function black ($text) {
      if ($this->_runningPropmt ()) {
        return join ('', ["\033[30m", $text, "\033[0m"]);
      }

      return join ('', ['<span style="color: black;">', $text, '</span>']);
    }

    public function red ($text) {
      if ($this->_runningPropmt ()) {
        return join ('', ["\033[31m", $text, "\033[0m"]);
      }

      return join ('', ['<span style="color: red;">', $text, '</span>']);
    }

    public function green ($text) {
      if ($this->_runningPropmt ()) {
        return join ('', ["\033[32m", $text, "\033[0m"]);
      }

      return join ('', ['<span style="color: green;">', $text, '</span>']);
    }

    public function yellow ($text) {
      if ($this->_runningPropmt ()) {
        return join ('', ["\033[33m", $text, "\033[0m"]);
      }

      return join ('', ['<span style="color: yellow;">', $text, '</span>']);
    }

    public function blue ($text) {
      if ($this->_runningPropmt ()) {
        return join ('', ["\033[34m", $text, "\033[0m"]);
      }

      return join ('', ['<span style="color: blue;">', $text, '</span>']);
    }

    public function purple ($text) {
      if ($this->_runningPropmt ()) {
        return join ('', ["\033[35m", $text, "\033[0m"]);
      }

      return join ('', ['<span style="color: purple;">', $text, '</span>']);
    }

    public function teal ($text) {
      if ($this->_runningPropmt ()) {
        return join ('', ["\033[36m", $text, "\033[0m"]);
      }

      return join ('', ['<span style="color: teal;">', $text, '</span>']);
    }

    public function white ($text) {
      if ($this->_runningPropmt ()) {
        return join ('', ["\033[37m", $text, "\033[0m"]);
      }

      return join ('', ['<span style="color: white;">', $text, '</span>']);
    }
  }}
}
