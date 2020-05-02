<?php

declare(strict_types=1);

namespace Statico\Tests\Unit\Core\Views\Functions;

use Statico\Tests\TestCase;
use Mockery as m;
use Statico\Core\Views\Functions\Form;

final class FormTest extends TestCase
{
    /**
     * @dataProvider configProvider
     */
    public function testRenderForm($data): void
    {
        $config = m::mock('PublishingKit\Config\Config');
        $config->shouldReceive('get')
            ->with('forms')
            ->once()
            ->andReturn($data);
        $mockForm = m::mock('Laminas\Form\FormInterface');
        $factory = m::mock('Statico\Core\Contracts\Factories\FormFactory');
        $factory->shouldReceive('make')
            ->with($data['contact'])
            ->once()
            ->andReturn($mockForm);
        $helper = m::mock('Laminas\Form\View\Helper\Form');
        $helper->shouldReceive('__invoke')->once();
        $pluginManager = m::mock('Laminas\View\HelperPluginManager');
        $pluginManager->shouldReceive('setInvokableClass')
            ->with('formRow', 'Laminas\Form\View\Helper\FormRow')
            ->once();
        $pluginManager->shouldReceive('setInvokableClass')
            ->with('form_label', 'Laminas\Form\View\Helper\FormLabel')
            ->once();
        $pluginManager->shouldReceive('setInvokableClass')
            ->with('form_element', 'Laminas\Form\View\Helper\FormElement')
            ->once();
        $pluginManager->shouldReceive('setInvokableClass')
            ->with('form_element_errors', 'Laminas\Form\View\Helper\FormElementErrors')
            ->once();
        $pluginManager->shouldReceive('setInvokableClass')
            ->with('forminput', 'Laminas\Form\View\Helper\FormInput')
            ->once();
        $pluginManager->shouldReceive('setInvokableClass')
            ->with('formtext', 'Laminas\Form\View\Helper\FormText')
            ->once();
        $pluginManager->shouldReceive('setInvokableClass')
            ->with('formsubmit', 'Laminas\Form\View\Helper\FormSubmit')
            ->once();
        $pluginManager->shouldReceive('setInvokableClass')
            ->with('formtextarea', 'Laminas\Form\View\Helper\FormTextarea')
            ->once();
        $pluginManager->shouldReceive('setInvokableClass')
            ->with('formemail', 'Laminas\Form\View\Helper\FormEmail')
            ->once();
        $renderer = m::mock('Laminas\View\Renderer\PhpRenderer');
        $renderer->shouldReceive('getHelperPluginManager')
            ->once()
            ->andReturn($pluginManager);
        $helper->shouldReceive('setView')
            ->with($renderer)
            ->once();
        $form = new Form($config, $factory, $helper, $renderer);
        $form->__invoke('contact');
    }

    public function testException()
    {
        $this->expectException('Statico\Core\Exceptions\Forms\FormNotFound');
        $config = m::mock('PublishingKit\Config\Config');
        $config->shouldReceive('get')
            ->with('forms')
            ->once()
            ->andReturn([]);
        $factory = m::mock('Statico\Core\Contracts\Factories\FormFactory');
        $renderer = m::mock('Laminas\View\Renderer\PhpRenderer');
        $helper = m::mock('Laminas\Form\View\Helper\Form');
        $helper->shouldReceive('setView')
            ->with($renderer)
            ->once();
        $pluginManager = m::mock('Laminas\View\HelperPluginManager');
        $pluginManager->shouldReceive('setInvokableClass')
            ->with('formRow', 'Laminas\Form\View\Helper\FormRow')
            ->once();
        $pluginManager->shouldReceive('setInvokableClass')
            ->with('form_label', 'Laminas\Form\View\Helper\FormLabel')
            ->once();
        $pluginManager->shouldReceive('setInvokableClass')
            ->with('form_element', 'Laminas\Form\View\Helper\FormElement')
            ->once();
        $pluginManager->shouldReceive('setInvokableClass')
            ->with('form_element_errors', 'Laminas\Form\View\Helper\FormElementErrors')
            ->once();
        $pluginManager->shouldReceive('setInvokableClass')
            ->with('forminput', 'Laminas\Form\View\Helper\FormInput')
            ->once();
        $pluginManager->shouldReceive('setInvokableClass')
            ->with('formtext', 'Laminas\Form\View\Helper\FormText')
            ->once();
        $pluginManager->shouldReceive('setInvokableClass')
            ->with('formsubmit', 'Laminas\Form\View\Helper\FormSubmit')
            ->once();
        $pluginManager->shouldReceive('setInvokableClass')
            ->with('formtextarea', 'Laminas\Form\View\Helper\FormTextarea')
            ->once();
        $pluginManager->shouldReceive('setInvokableClass')
            ->with('formemail', 'Laminas\Form\View\Helper\FormEmail')
            ->once();
        $renderer->shouldReceive('getHelperPluginManager')
            ->once()
            ->andReturn($pluginManager);
        $form = new Form($config, $factory, $helper, $renderer);
        $form->__invoke('contact');
    }

    public function configProvider()
    {
        return [
                [
                 [
                  "contact" => [
                                "attributes" => ["class" => "form-inline my-2 my-lg-0 pull-right"],
                                "elements"   => [
                                                 [
                                                  "spec" => [
                                                             "name"       => "name",
                                                             "options"    => ["label" => "Your name"],
                                                             "type"       => "Text",
                                                             "attributes" => ["class" => "form-control mr-sm-2"],
                                                            ],
                                                 ],
                                                 [
                                                  "spec" => [
                                                             "name"       => "submit",
                                                             "options"    => ["label" => "submit"],
                                                             "type"       => "Submit",
                                                             "attributes" => ["class" => "form-control mr-sm-2"],
                                                            ],
                                                 ],
                                                ],
                               ],
                 ],
                ],
               ];
    }
}
