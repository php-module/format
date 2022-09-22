<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Format
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
namespace Sammy\Packs\Format {
  /**
   * Make sure the module base internal class is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!class_exists('Sammy\Packs\Format\FormatContext')){
  /**
   * @class FormatContext
   * Base internal class for the
   * Format module.
   * -
   * This is (in the ils environment)
   * an instance of the php module,
   * wich should contain the module
   * core functionalities that should
   * be extended.
   * -
   * For extending the module, just create
   * an 'exts' directory in the module directory
   * and boot it by using the ils directory boot.
   * -
   */
  class FormatContext {
    /**
     * @var array contextDatas
     *
     * An array storing the context datas
     * wish should be accesible from the
     * contructor;
     * It holds each context properties .
     */
    private $i = -1;
    private $contextDatas = [];

    public function __set ($prop, $value) {
      $this->contextDatas [$prop] = $value;
    }

    public function __get ($prop) {
      if (isset ($this->contextDatas [$prop])) {
        return $this->contextDatas [$prop];
      }
    }

    public function setArguments ($arguments) {
      $this->arguments = $arguments;
    }

    public function getArgument ($argumentIndex) {
      if (isset ($this->arguments [$argumentIndex])) {
        return $this->arguments [$argumentIndex];
      }
    }

    public function readArgument ($argument) {
      $argument = trim ($argument);

      $argumentList = preg_split ('/\\|/', $argument);
      $argument = (int)(trim ($argumentList [ 0 ]));

      $argumentValue = null;

      if (!is_numeric ($argumentList[0])) {
        $arguments = is_array ($this->arguments) ? $this->arguments : [];

        if (isset ($arguments [$this->i + 1])) {
          $argumentValue = $this->arguments [ ++$this->i ];
        }
      } else {
        $argumentValue = $this->getArgument ($argument);
      }

      return $this->applyValueFilters (
        $argumentValue,
        array_slice (
          $argumentList, 1,
          count ($argumentList)
        )
      );
    }

    private function applyValueFilters ($value, $filters) {
      if (!(is_array ($filters) && $filters)) {
        return $value;
      }

      $finalValue = $value;

      foreach ($filters as $filter) {
        $finalValue = $this->applyValueFilter (
          $finalValue, $filter
        );
      }

      return $finalValue;
    }

    private function applyValueFilter ($value, $filter) {

      if ($f = self::definedFilter ($filter)) {
        list ($filter, $method) = $f;

        return call_user_func_array (
          [$filter, $method], [$value]
        );
      }

      if (function_exists ($filter)) {
        return call_user_func_array ($filter, [$value]);
      }

      return $value;
    }

    public function __desctruct () {
      $this->contextDatas = [];
    }

    private static function definedFilter (string $filterRef) {
      $filterRef = preg_split ('/:{1,2}/', $filterRef);

      $filter = trim ($filterRef [0]);

      if (!isset ($filterRef [1])) {
        $filterRef [1] = 'filter';
      }

      $formatNamespace = 'Sammy\Packs\Format\Filter\\';
      $iFormatFilter = 'Sammy\Packs\Format\IFormatFilter';

      $filterNameAlternates = [
        $formatNamespace.$filter.'Filter',
        $formatNamespace.$filter,
        $filter.'Filter',
        $filter
      ];

      foreach ($filterNameAlternates as $filterName) {
        $definedClassName = ( boolean ) (
          class_exists ($filterName) &&
          in_array ($iFormatFilter, class_implements (
            $filterName
          ))
        );

        if ($definedClassName) {
          return [new $filterName, $filterRef [1]];
        }
      }
    }
  }}
}
