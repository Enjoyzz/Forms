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

namespace Enjoys\Forms\Elements;

use Enjoys\Forms\Element;

/**
 * Description of Textarea
 *
 * @author deadl
 */
class Textarea extends Element
{
    use \Enjoys\Forms\Traits\Description;
    use \Enjoys\Forms\Traits\Rules;
    /**
     *
     * @var string
     */
    protected string $type = 'textarea';
    private $value;

    public function setValue(string $value): self
    {
        $this->value = $value;
        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    /**
     * rows Высота поля в строках текста.
     * @param string|int $rows
     * @return \self
     */
    public function setRows($rows): self
    {
        $this->setAttribute('rows', (string) $rows);
        return $this;
    }

    /**
     * cols Ширина поля в символах.
     * @param string|int $cols
     * @return \self
     */
    public function setCols($cols): self
    {
        $this->setAttribute('cols', (string) $cols);
        return $this;
    }

    public function baseHtml(): ?string
    {
        return "<textarea{$this->getAttributes()}>{$this->getValue()}</textarea>";
    }
}
