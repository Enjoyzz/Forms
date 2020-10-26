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

declare(strict_types=1);

namespace Enjoys\Forms2\Traits;

/**
 *
 * @author deadl
 */
trait Fill
{
//    private string $parentName = '';
//
//    public function setParentName(string $parentName)
//    {
//        $this->parentName = $parentName;
//    }
//
//    public function getParentName()
//    {
//        return $this->parentName;
//    }


    /**
     * @since 2.4.0 Изменен принцип установки value и id из индексированных массивов
     * т.е. [1,2] значения будут 1 и 2 сответсвенно, а не 0 и 1 как раньше.
     * Чтобы использовать число в качестве value отличное от title, необходимо
     * в массиве конуретно указать значение key. Например ["40 " => test] (обратите внимание на пробел).
     * Из-за того что php преобразует строки, содержащие целое число к int, приходится добавлять
     * пробел либо в начало, либо в конец ключа. В итоге пробелы в начале и в конце удаляются автоматически.
     *
     * @param array $data
     * @return $this
     */
    public function fill(array $data)
    {

        foreach ($data as $value => $title) {
//            $index_key = $this->getIndexKey();

            $attributes = [];

            $_title = $title;

            /** @since 2.4.0 */
            if (is_string($value)) {
                $value = \trim($value);
            }

            /** @since 2.4.0 */
            if (is_int($value)) {
                $value = $title;
            }

            if (is_array($title)) {
                $_title = $title[0];

                if (isset($title[1]) && is_array($title[1])) {
                    $attributes = array_merge($attributes, $title[1]);
                }
            }

            $class = '\Enjoys\Forms2\Elements\\' . \ucfirst($this->type);

            $element = new $class((string) $value, (string) $_title);

//            $element->setParentName($this->getName());
            // $element->setCounterId(\count($this->elements));
            $element->setAttributes($attributes);
            
            $this->add($element);


        }
        return $this;
    }

}
