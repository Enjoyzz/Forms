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

namespace Tests\Enjoys\Forms\Elements;

/**
 * Class CaptchaTest
 *
 * @author Enjoys
 */
class CaptchaTest extends \PHPUnit\Framework\TestCase
{

    use \Tests\Enjoys\Forms\Reflection;

    public function test_init_captcha()
    {
        $form = new \Enjoys\Forms\Form();
        $element = $form->captcha(new \Enjoys\Forms\Captcha\Defaults\Defaults());
        $this->assertTrue($element instanceof \Enjoys\Forms\Elements\Captcha);
    }

    public function test_init_captcha_set_rule_message()
    {
        $form = new \Enjoys\Forms\Form();
        $element = $form->captcha(new \Enjoys\Forms\Captcha\Defaults\Defaults('test'));
        $rule = $element->getRules()[0];
        $method = $this->getPrivateMethod(\Enjoys\Forms\Rule\Captcha::class, 'getMessage');
        $this->assertSame('test', $method->invoke($rule));
    }



}
