<?php

/*
 * The MIT License
 *
 * Copyright 2020 Enjoys.
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

declare(strict_types=1);

namespace Enjoys\Forms;

/**
 * Description of FillHandler
 *
 * @author Enjoys
 */
class FillHandler
{
    private $attributes = [];
    private $value = null;
    private $title = null;
    
    public function __construct($value, $title)
    {

            $this->title = $title;

            if (is_array($title)) {
                $this->title = $title[0];

                if (isset($title[1]) && is_array($title[1])) {
                    $this->attributes = array_merge($this->attributes, $title[1]);
                }
            }
            
            /** @since 2.4.0 */
            if (is_string($value)) {
                $this->value = \trim($value);
            }            
            
              /** @since 2.4.0 */
            if (is_int($value)) {
                $this->value = $this->title;
            }
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }
    
    public function getValue():? string
    {
        return $this->value;
    }
    
    public function getLabel():? string
    {
        return $this->title;
    }
}
