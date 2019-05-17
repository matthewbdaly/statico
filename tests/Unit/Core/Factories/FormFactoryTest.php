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
        $formData = [[
            'spec' => [
                'name' => 'name',
                'options' => [
                    'label' => 'Your name',
                ],
                'type' => 'Text'
            ]
        ]];
        $form = m::mock('Zend\Config\Config');
        $form->shouldReceive('get')->with('elements')->once()
            ->andReturn($form);
        $form->shouldReceive('toArray')->andReturn($formData);
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
