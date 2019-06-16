<?php declare(strict_types = 1);

namespace Tests\Unit\Views;

use Tests\TestCase;
use Mockery as m;
use Statico\Core\Views\Functions\Form;

final class FormTest extends TestCase
{
    /**
     * @dataProvider configProvider
     */
    public function testRenderForm($data): void
    {
        $config = m::mock('Zend\Config\Config');
        $config->shouldReceive('get')
            ->with('forms')
            ->once()
            ->andReturn($data);
        $mockForm = m::mock('Zend\Form\FormInterface');
        $factory = m::mock('Statico\Core\Contracts\Factories\FormFactory');
        $factory->shouldReceive('make')
            ->with($data['contact'])
            ->once()
            ->andReturn($mockForm);
        $helper = m::mock('Zend\Form\View\Helper\Form');
        $helper->shouldReceive('__invoke')->once();
        $pluginManager = m::mock('Zend\View\HelperPluginManager');
        $pluginManager->shouldReceive('setInvokableClass')
            ->with('formRow', 'Zend\Form\View\Helper\FormRow')
            ->once();
        $pluginManager->shouldReceive('setInvokableClass')
            ->with('form_label', 'Zend\Form\View\Helper\FormLabel')
            ->once();
        $pluginManager->shouldReceive('setInvokableClass')
            ->with('form_element', 'Zend\Form\View\Helper\FormElement')
            ->once();
        $pluginManager->shouldReceive('setInvokableClass')
            ->with('form_element_errors', 'Zend\Form\View\Helper\FormElementErrors')
            ->once();
        $pluginManager->shouldReceive('setInvokableClass')
            ->with('forminput', 'Zend\Form\View\Helper\FormInput')
            ->once();
        $pluginManager->shouldReceive('setInvokableClass')
            ->with('formtext', 'Zend\Form\View\Helper\FormText')
            ->once();
        $pluginManager->shouldReceive('setInvokableClass')
            ->with('formsubmit', 'Zend\Form\View\Helper\FormSubmit')
            ->once();
        $renderer = m::mock('Zend\View\Renderer\PhpRenderer');
        $renderer->shouldReceive('getHelperPluginManager')
            ->once()
            ->andReturn($pluginManager);
        $helper->shouldReceive('setView')
            ->with($renderer)
            ->once();
        $form = new Form($config, $factory, $helper, $renderer);
        $form->__invoke('contact');
    }

    public function configProvider()
    {
        return [[[
            "contact" => [
                "attributes" => [
                    "class" => "form-inline my-2 my-lg-0 pull-right",
                ],
                "elements" => [
                    [
                        "spec" => [
                            "name" => "name",
                            "options" => [
                                "label" => "Your name",
                            ],
                            "type" => "Text",
                            "attributes" => [
                                "class" => "form-control mr-sm-2",
                            ],
                        ],
                    ],
                    [
                        "spec" => [
                            "name" => "submit",
                            "options" => [
                                "label" => "submit",
                            ],
                            "type" => "Submit",
                            "attributes" => [
                                "class" => "form-control mr-sm-2",
                            ],
                        ],
                    ],
                ],
            ],
        ]]];
    }
}
