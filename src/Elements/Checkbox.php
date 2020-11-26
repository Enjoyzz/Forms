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

namespace Enjoys\Forms\Elements;

use Enjoys\Forms\Element;
use Enjoys\Forms\Form;
use Enjoys\Forms\Traits\Description;
use Enjoys\Forms\Traits\Fill;
use Enjoys\Forms\Traits\Rules;

/**
 * Description of Checkbox
 *
 * @author Enjoys
 */
class Checkbox extends Element implements \Enjoys\Forms\FillableInterface
{
    use Fill;
    use Description;
    use Rules;

    private const DEFAULT_PREFIX = 'cb_';

    /**
     *
     * @var string
     */
    protected string $type = 'checkbox';
    private static string $prefix_id = 'cb_';

    /**
     * @var mixed
     */
    private $defaults = '';

    public function __construct(string $name, string $title = null)
    {
        $construct_name = $name;
        if (\substr($name, -2) !== '[]') {
            $construct_name = $name . '[]';
        }
        parent::__construct($construct_name, $title);

        $this->setAttributes([
            'value' => $name,
            'id' => $this->getPrefixId() . $name
        ]);
        $this->removeAttribute('name');
    }

//    public function prepare()
//    {
//
//    }

    public function setPrefixId(string $prefix): self
    {
        static::$prefix_id = $prefix;
        $this->setAttribute('id', static::$prefix_id . $this->getName());
        return $this;
    }

    public function getPrefixId(): string
    {
        return static::$prefix_id;
    }

    public function resetPrefixId(): void
    {
        $this->setPrefixId(self::DEFAULT_PREFIX);
    }

    /**
     *
     * @param mixed $value
     * @return $this
     */
    protected function setDefault($value = null): self
    {


        // $value = $this->form->getDefaultsHandler()->getValue($this->getParentName());
        $this->defaults = $value ?? $this->getForm()->getDefaultsHandler()->getValue($this->getName());


        if (is_array($value)) {
            if (in_array($this->getAttribute('value'), $value)) {
                $this->setAttribute('checked');
                return $this;
            }
        }

        if (is_string($value) || is_numeric($value)) {
            if ($this->getAttribute('value') == $value) {
                $this->setAttribute('checked');
                return $this;
            }
        }
        return $this;
    }

    public function baseHtml(): string
    {



        $this->setAttribute('for', $this->getAttribute('id'), Form::ATTRIBUTES_LABEL);
        $this->setAttributes($this->getAttributes('fill'), Form::ATTRIBUTES_LABEL);


        $this->setAttributes(['name' => $this->getParentName()]);
        return "<input type=\"{$this->getType()}\"{$this->getAttributesString()}><label{$this->getAttributesString(Form::ATTRIBUTES_LABEL)}>{$this->getLabel()}</label>\n";
    }
}
