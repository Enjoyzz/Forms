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

namespace Tests\Enjoys\Forms;

use \PHPUnit\Framework\TestCase,
    Enjoys\Forms\Element,
    Enjoys\Forms\Form;

/**
 * Description of ElementTest
 *
 * @author deadl
 */
class ElementTest extends TestCase
{
    use Reflection;
    /**
     *
     * @var  Enjoys\Forms\Forms $form 
     */
    protected $obj;

    protected function setUp(): void
    {
        $this->obj = new Form();
        $this->obj->removeElement(Form::_TOKEN_SUBMIT_);
        $this->obj->removeElement(Form::_TOKEN_CSRF_);
    }

    protected function tearDown(): void
    {
        $this->obj = null;
    }

    public function test_setName_1_0()
    {
        $element = new Element(new \Enjoys\Forms\FormDefaults([], new Form()), 'Foo');
        $this->assertEquals('Foo', $element->getName());
        $element->setName('Baz');
        $this->assertEquals('Baz', $element->getName());
    }

    public function test_setId_1_0()
    {
        $element = new Element(new \Enjoys\Forms\FormDefaults([], new Form()), 'Foo');
        $this->assertEquals('Foo', $element->getId());
        $element->setId('Baz');
        $this->assertEquals('Baz', $element->getId());
    }

    public function test_getType_1_0()
    {
        $text = $this->obj->text('Foo');
        $this->assertEquals('text', $text->getType());
    }
    
    public function test_setValue_1_0()
    {
        $element = new Element(new \Enjoys\Forms\FormDefaults([], new Form()), 'test');
        $method = $this->getPrivateMethod(Element::class, 'setValue');
        $method->invokeArgs($element, ['foo']);
        $method->invokeArgs($element, ['bar']);
        $this->assertEquals('foo', $element->getAttribute('value'));
    }    
    
    public function test_setTitle_1_0() {
        $element = new Element(new \Enjoys\Forms\FormDefaults([], new Form()), 'Foo', 'Bar');
        $this->assertEquals('Bar',$element->getTitle());
        $element->setTitle('Baz');
        $this->assertEquals('Baz',$element->getTitle());
    }       

    public function test_setDescription_1_0() {
        $element = new Element(new \Enjoys\Forms\FormDefaults([], new Form()), 'Foo', 'Bar');
        $element->setDescription('Zed');
        $this->assertEquals('Zed', $element->getDescription());
    }
    
    public function test_setFormDefaults_1_0()
    {
        $element = new Element(new \Enjoys\Forms\FormDefaults([], $this->obj), 'Foo', 'Bar');
        $element->setFormDefaults(new \Enjoys\Forms\FormDefaults([
            'Foo' => 'newvalue'
        ], $this->obj));
        $this->assertEquals('newvalue', $element->getAttribute('value'));
        
    }
    
    public function test_setFormDefaults_1_1()
    {
        $this->markTestIncomplete();
        $element = $this->obj->text('Foo', 'Bar');
        $element->setFormDefaults(new \Enjoys\Forms\FormDefaults([
            'Foo' => [
                'first_string', 'second_string'
            ]
        ], $this->obj));
        $this->assertEquals('first_string', $element->getAttribute('value'));
        
    }    
  
}
