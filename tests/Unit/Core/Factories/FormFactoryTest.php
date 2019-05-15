<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Factories;

use Tests\TestCase;
use Statico\Core\Factories\FormFactory;
use Zend\Form\Factory;
use Mockery as m;

class FormFactoryTest extends TestCase
{
    public function testMake()
    {
        $wrappedFactory = new Factory;
        $factory = new FormFactory($wrappedFactory);
        $form = [[
            'spec' => [
                'name' => 'name',
                'options' => [
                    'label' => 'Your name',
                ],
                'type' => 'Text'
            ]
        ]];
        $response = $factory->make($form);
        $elements = $response->getElements();
        $this->assertCount(1, $elements);
        $el = $elements['name'];
        $this->assertEquals([
            'type' => 'text',
            'name' => 'name'
        ], $el->getAttributes());
    }
}
