<?php

declare(strict_types=1);

namespace Tests\Enjoys\Forms\Traits;

use Enjoys\Forms\Elements\Select;
use PHPUnit\Framework\TestCase;
use Tests\Enjoys\Forms\Reflection;

/**
 * Class FillTest
 *
 * @author Enjoys
 */
class FillTest extends TestCase
{
    use Reflection;

    public function test_setIndexKeyFill()
    {
        $select = new Select('select');
        $select->fill(
            [
                1,
                2,
                3
            ],
            true
        );
        $this->assertEquals('1', $select->getElements()[0]->getName());
        $this->assertEquals('2', $select->getElements()[1]->getName());
        $this->assertEquals('3', $select->getElements()[2]->getName());

        $select->fill(
            [
                1,
                2,
                3
            ],
            true
        );
        $this->assertEquals('1', $select->getElements()[3]->getName());
        $this->assertEquals('2', $select->getElements()[4]->getName());
        $this->assertEquals('3', $select->getElements()[5]->getName());

        $this->assertEquals('select', $select->getElements()[5]->getParentName());
    }

    public function test_setIndexKeyFillIntAsValue()
    {
        $select = new Select('select');
        $select->fill(
            [
                46 => 1,
                2,
                3
            ]
        );
        $this->assertEquals('46', $select->getElements()[0]->getAttribute('value'));
        $this->assertEquals('47', $select->getElements()[1]->getAttribute('value'));
        $this->assertEquals('48', $select->getElements()[2]->getAttribute('value'));
    }

    public function test_closurefill()
    {
        $class1 = new \stdClass();
        $class1->id = 52;
        $class1->name = '#52';

        $class2 = new \stdClass();
        $class2->id = 36;
        $class2->name = '#36';

        $data = [$class1, $class2];
        $select = new Select('select');
        $select->fill(function () use ($data){
            $ret = [];
            foreach ($data as $item) {
                $ret[$item->id] = $item->name;
            }
            return $ret;
        });
        $this->assertEquals('52', $select->getElements()[0]->getAttribute('value'));
        $this->assertEquals('36', $select->getElements()[1]->getAttribute('value'));
    }

    public function test_closure_invalid_return()
    {
        $this->expectException(\InvalidArgumentException::class);
        $select = new Select('select');
        $select->fill(function (){
            return 'invalid return';
        });
    }

//    /**
//     * @dataProvider elements
//     */
//    public function test_fill_with_attributes($el, $name)
//    {
//       // $this->markTestSkipped('Не нужен тест, он больше фунциональный');
//        $class = '\Enjoys\Forms\Elements\\' . ucfirst($el);
//        $element = new $class('foo');
//        $element->fill([
//            'test' => [
//                'title1',
//                [
//                    'disabled'
//                ]
//            ],
//            'foz' => [
//                2,
//                [
//                    'id' => 'newfoz'
//                ]
//            ],
//            'baz' => 3
//        ]);
//        $this->assertEquals(null, $element->getElements()[0]->getAttribute('disabled'));
//        $this->assertEquals(false, $element->getElements()[1]->getAttribute('disabled'));
//        $this->assertEquals('newfoz', $element->getElements()[1]->getAttribute('id'));
//        $this->assertEquals($name, $element->getElements()[2]->getParentName());
//    }
//
//    public function elements()
//    {
//        return [
//            ['select', 'foo'],
//            ['radio', 'foo'],
//            ['checkbox', 'foo[]'],
//        ];
//    }
}
