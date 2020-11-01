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

namespace Enjoys\Forms\Renderer;

use Enjoys\Forms\ElementInterface;
use Enjoys\Forms\Elements\Button;
use Enjoys\Forms\Elements\Checkbox;
use Enjoys\Forms\Elements\File;
use Enjoys\Forms\Elements\Header;
use Enjoys\Forms\Elements\Image;
use Enjoys\Forms\Elements\Radio;
use Enjoys\Forms\Elements\Reset;
use Enjoys\Forms\Elements\Select;
use Enjoys\Forms\Elements\Submit;
use Enjoys\Forms\Renderer\ElementsRender;

/**
 * Description of ElementRender
 *
 * @author Enjoys
 */
class BaseElementRender
{

    protected $elementRender;

    public function __construct(ElementInterface $element)
    {
        $this->elementRender = $this->getElementRender($element);
    }

    protected function getElementRender(ElementInterface $element)
    {

        switch (\get_class($element)) {
            case Radio::class:
                return new ElementsRender\RadioRender($element);
            case Checkbox::class:
                return new ElementsRender\CheckboxRender($element);
            case Header::class:
                return new ElementsRender\HeaderRender($element);
            case File::class:
                return new ElementsRender\FileRender($element);
            case Select::class:
                return new ElementsRender\SelectRender($element);
            case Button::class:
            case Submit::class:
            case Reset::class:
            case Image::class:
                return new ElementsRender\ButtonRender($element);
            default:
                return new ElementsRender\InputRender($element);
        }
    }

    public function render()
    {
        return $this->elementRender->render() . "<br />\n";
    }
}
