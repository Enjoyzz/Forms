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

use Enjoys\Forms\ElementInterface;
use Enjoys\Forms\Elements\Button;
use Enjoys\Forms\Elements\Checkbox;
use Enjoys\Forms\Elements\File;
use Enjoys\Forms\Elements\Header;
use Enjoys\Forms\Elements\Image;
use Enjoys\Forms\Elements\Radio;
use Enjoys\Forms\Elements\Reset;
use Enjoys\Forms\Elements\Submit;
use Enjoys\Forms\Renderer\BaseElementRender;
use Enjoys\Forms\Renderer\ElementsRender\ButtonRender;
use Enjoys\Forms\Renderer\ElementsRender\ElementRenderInterface;

/**
 * Description of ElementRender
 *
 * @author Enjoys
 */
class Bootstrap4ElementRender extends BaseElementRender
{

    private $map = [
        Radio::class => Bootstrap4RadioRender::class,
        Checkbox::class => Bootstrap4CheckboxRender::class,
        Header::class => Bootstrap4HeaderRender::class,
        File::class => Bootstrap4FileRender::class,
        Button::class => ButtonRender::class,
        Submit::class => ButtonRender::class,
        Reset::class => ButtonRender::class,
        Image::class => ButtonRender::class,
        Text::class => Bootstrap4InputRender::class,
    ];

    public function __construct(ElementInterface $element)
    {
        $this->elementRender = $this->getElementRender($element);
    }

    public function render()
    {
        $html = '<div class="form-group">';
        $html .= $this->elementRender->render();
        $html .= '</div>';
        return $html;
    }

    /**
     * 
     * @param type $element
     * @return ElementRenderInterface
     */
    protected function getElementRender($element)
    {
        $key = \get_class($element);

        if (array_key_exists($key, $this->map)) {
            $class = $this->map[$key];
            return new $class($element);
        }
        
        return parent::getElementRender($element);
    }
}
