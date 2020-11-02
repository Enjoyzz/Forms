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

namespace Enjoys\Forms\Renderer\Bootstrap4;

use Enjoys\Forms\Renderer\BaseRenderer;
use Enjoys\Forms\Renderer\RendererInterface;

/**
 * Description of Bootstrap4
 *
 * @author Enjoys
 */
class Bootstrap4 extends BaseRenderer implements RendererInterface
{
    use \Enjoys\Traits\Options;

    public function __construct($options = [])
    {
        $this->setOptions($options);
    }

    protected function elementRender(\Enjoys\Forms\Element $element): string
    {

        if (method_exists($element, 'getDescription') && !empty($element->getDescription())) {
            $element->setAttributes([
                'id' => $element->getAttribute('id') . 'Help',
                'class' => 'form-text text-muted'
                    ], \Enjoys\Forms\Form::ATTRIBUTES_DESC);
            $element->setAttributes([
                'aria-describedby' => $element->getAttribute('id', \Enjoys\Forms\Form::ATTRIBUTES_DESC)
            ]);
        }

        if (method_exists($element, 'isRuleError') && $element->isRuleError()) {
            $element->setAttributes([
                'class' => 'is-invalid'
            ]);
            $element->setAttributes([
                'class' => 'invalid-feedback d-block'
                    ], \Enjoys\Forms\Form::ATTRIBUTES_VALIDATE);
        }
        
        $elementRender = new Bootstrap4ElementRender($element, $this);
        return $elementRender->render();
    }
}