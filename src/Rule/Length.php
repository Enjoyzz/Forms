<?php

/*
 * The MIT License
 *
 * Copyright 2020 deadl.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Enjoys\Forms\Rule;

use Enjoys\Forms\RuleBase;
use Enjoys\Forms\Interfaces\Rule;
use Enjoys\Forms\Exception;

/**
 * Description of Length
 *
 * @author Enjoys
 */
class Length extends RuleBase implements Rule
{

    private $operatorToMethodTranslation = [
        '==' => 'equal',
        '!=' => 'notEqual',
        '>' => 'greaterThan',
        '<' => 'lessThan',
        '>=' => 'greaterThanOrEqual',
        '<=' => 'lessThanOrEqual',
    ];

    public function setMessage(?string $message): void {
        if (is_null($message)) {
            $message = 'Ошибка ввода';
        }
        parent::setMessage($message);
    }

    public function validate(\Enjoys\Forms\Element $element): bool {
        $request = new \Enjoys\Base\Request();
        $input_value = $request->post($element->getValidateName(), $request->get($element->getValidateName(), ''));
        if (!$this->check($input_value)) {
            $element->setRuleError($this->getMessage());
            return false;
        }

        return true;
    }

    private function check($value) {
        if(is_array($value)){
            return true;
        }
        
        $length = \mb_strlen($value, 'UTF-8');
        if (empty($value)) {
            return true;
        }

        foreach ($this->getParams() as $operator => $threshold) {
            $method = 'unknown';

            if (isset($this->operatorToMethodTranslation[$operator])) {
                $method = $this->operatorToMethodTranslation[$operator];
            }

            if (!method_exists(Length::class, $method)) {
                throw new \Exception('Unknown Compare Operator.');
            }

            if (!$this->$method($length, $threshold)) {
                return false;
            }
        }

        return true;
    }

    private function equal($value, $threshold) {
        return $value == $threshold;
    }

    private function notEqual($value, $threshold) {
        return $value != $threshold;
    }

    private function greaterThan($value, $threshold) {
        return $value > $threshold;
    }

    private function lessThan($value, $threshold) {
        return $value < $threshold;
    }

    private function greaterThanOrEqual($value, $threshold) {
        return $value >= $threshold;
    }

    private function lessThanOrEqual($value, $threshold) {
        return $value <= $threshold;
    }

}