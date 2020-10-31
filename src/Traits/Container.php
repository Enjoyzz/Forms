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

namespace Enjoys\Forms\Traits;



/**
 *
 * @author Enjoys
 */
trait Container
{

    /**
     *
     * @var array Objects stack \Enjoys\Forms\Element
     */
    private array $elements = [];

    /**
     * @method \Enjoys\Forms\Elements\Text text(string $name, string $title = null)
     * @method \Enjoys\Forms\Elements\Hidden hidden(string $name, string $value = null)
     * @method \Enjoys\Forms\Elements\Password password(string $name, string $title = null)
     * @method \Enjoys\Forms\Elements\Submit submit(string $name, string $title = null)
     * @method \Enjoys\Forms\Elements\Header header(string $title = null)
     * @method \Enjoys\Forms\Elements\Color color(string $name, string $title = null)
     * @method \Enjoys\Forms\Elements\Date date(string $name, string $title = null)
     * @method \Enjoys\Forms\Elements\Datetime datetime(string $name, string $title = null)
     * @method \Enjoys\Forms\Elements\Datetimelocal datetimelocal(string $name, string $title = null)
     * @method \Enjoys\Forms\Elements\Email email(string $name, string $title = null)
     * @method \Enjoys\Forms\Elements\Number number(string $name, string $title = null)
     * @method \Enjoys\Forms\Elements\Range range(string $name, string $title = null)
     * @method \Enjoys\Forms\Elements\Search search(string $name, string $title = null)
     * @method \Enjoys\Forms\Elements\Tel tel(string $name, string $title = null)
     * @method \Enjoys\Forms\Elements\Time time(string $name, string $title = null)
     * @method \Enjoys\Forms\Elements\Url url(string $name, string $title = null)
     * @method \Enjoys\Forms\Elements\Month month(string $name, string $title = null)
     * @method \Enjoys\Forms\Elements\Week week(string $name, string $title = null)
     * @method \Enjoys\Forms\Elements\Textarea textarea(string $name, string $title = null)
     * @method \Enjoys\Forms\Elements\Select select(string $name, string $title = null)
     * @method \Enjoys\Forms\Elements\Button button(string $name, string $title = null)
     * @method \Enjoys\Forms\Elements\Datalist datalist(string $name, string $title = null)
     * @method \Enjoys\Forms\Elements\Checkbox checkbox(string $name, string $title = null)
     * @method \Enjoys\Forms\Elements\Image image(string $name, string $title = null)
     * @method \Enjoys\Forms\Elements\Radio radio(string $name, string $title = null)
     * @method \Enjoys\Forms\Elements\Reset reset(string $name, string $title = null)
     * @method \Enjoys\Forms\Elements\Captcha captcha(string $captchaName = null, string $message = null)
     * @method \Enjoys\Forms\Elements\Group group(string $title = null, array $elements = null)
     * @method \Enjoys\Forms\Elements\File file(string $name, string $label = null)
     *
     * @return @method
     */
    public function __call(string $name, array $arguments)
    {
        $class_name = '\Enjoys\\Forms\\Elements\\' . ucfirst($name);
        if (!class_exists($class_name)) {
            throw new \Enjoys\Forms\Exception\ExceptionElement("Class <b>{$class_name}</b> not found");
        }
        /** @var Element $element */
        $element = new $class_name(...$arguments);

        // dump($element);
        $this->addElement($element);
        return $element;
    }
    
        /**
     *
     * @param Element $element
     * @return \self
     */
    public function addElement(\Enjoys\Forms\Element $element): self
    {
        $element->setRequest($this->request);
        $this->elements[$element->getName()] = $element;
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

    public function getElement($name): ?\Enjoys\Forms\Element
    {
        if ($this->elementExists($name)) {
            return $this->elements[$name];
        }

        return null;
    }

    public function removeElement(?\Enjoys\Forms\Element $element): self
    {
        if (null === $element) {
            return $this;
        }

        if ($this->elementExists($element->getName())) {
            unset($this->elements[$element->getName()]);
        }
        return $this;
    }

    private function elementExists($name): bool
    {
        if (array_key_exists($name, $this->elements) && $this->elements[$name] instanceof \Enjoys\Forms\Element) {
            return true;
        }
        return false;
    }


}