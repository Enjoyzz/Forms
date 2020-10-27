<?php

declare(strict_types=1);

namespace Enjoys\Forms2;

/**
 * Description of Renderer
 *
 * @author Enjoys
 */
class Renderer
{
    use \Enjoys\Traits\Options;

    public const BOOTSTRAP4 = 'bootstrap4';
    private $renderer = 'bootstrap4';
    private Element $element;

    public function __construct(Element $element, array $options = [])
    {
        $this->element = $element;
        $this->setOptions($options);
    }

    public function setRenderer($renderer = null)
    {
        $this->renderer = $renderer;
        return $this;
    }

    public function display()
    {

        $rendererName = \ucfirst($this->renderer);
        $renderer = '\\Enjoys\\Forms2\\Renderer\\' . $rendererName . '\\' . $rendererName;

        if (!class_exists($renderer)) {
            throw new Exception\ExceptionRenderer("Class <b>{$renderer}</b> not found");
        }
        return new $renderer($this->element, $this->getOptions());
    }
//    public function __toString() {
//        return 'Redefine the method <i>__toString()</i> in the class: <b>'. static::class.'</b>';
//    }
}
