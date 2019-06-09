<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Factories;

use Tests\TestCase;
use Statico\Core\Factories\Forms\ZendFormFactory;
use Zend\Form\Factory;
use Mockery as m;

final class ZendFormFactoryTest extends TestCase
{
    public function testMake()
    {
        $wrappedFactory = new Factory;
        $factory = new ZendFormFactory($wrappedFactory);
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
