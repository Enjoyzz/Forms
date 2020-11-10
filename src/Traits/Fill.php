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

namespace Enjoys\Forms\Traits;

/**
 *
 * @author Enjoys
 */
trait Fill
{

    private array $elements = [];
    private string $parentName = '';

    public function setParentName(string $parentName): void
    {
        $this->parentName = $parentName;
//        $this->parent = false;
    }

    public function getParentName(): string
    {
        return $this->parentName;
    }

//    public function isParent(): bool
//    {
//        return $this->parent;
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
    public function fill(array $data): self
    {

        foreach ($data as $value => $title) {
            $fillHandler = new \Enjoys\Forms\FillHandler($value, $title);

            $class = '\Enjoys\Forms\Elements\\' . \ucfirst($this->getType());

            $element = new $class($fillHandler->getValue(), $fillHandler->getLabel());
            $element->setParentName($this->getName());
            $element->setAttributes($fillHandler->getAttributes(), 'fill');

            /**
             * @todo слишком много вложенности ифов. подумать как переделать
             */
            foreach ($element->getAttributes('fill') as $k => $v) {
                if (in_array($k, ['id', 'name', 'disabled', 'readonly'])) {
                    if ($element->getAttribute($k, 'fill') !== false) {
                        $element->setAttribute($k, $element->getAttribute($k, 'fill'));
                        $element->removeAttribute($k, 'fill');
                    }
                }
            }


            $element->setDefault($this->defaults);

            $this->elements[] = $element;
        }
        return $this;
    }

    /**
     *
     * @return array
     */
    public function getElements(): array
    {
        return $this->elements;
    }

//    public function updateElement($key, \Enjoys\Forms\Element $element): void
//    {
//        if (array_key_exists($key, $this->elements)) {
//            $this->elements[$key] = $element;
//        }
//    }
}
