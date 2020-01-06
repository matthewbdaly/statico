<?php

declare(strict_types=1);

namespace Statico\Core\Views\Functions;

use Laminas\Config\Config;
use Laminas\Form\ElementInterface;
use Statico\Core\Exceptions\Forms\FormNotFound;
use Statico\Core\Contracts\Factories\FormFactory;
use Laminas\Form\View\Helper\Form as FormHelper;
use Laminas\View\Renderer\PhpRenderer;
use Twig\Markup;

final class Form
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var FormFactory
     */
    private $factory;

    /**
     * @var FormHelper
     */
    private $helper;

    public function __construct(Config $config, FormFactory $factory, FormHelper $helper, PhpRenderer $renderer)
    {
        $this->config = $config->get('forms');
        $this->factory = $factory;
        $plugin = $renderer->getHelperPluginManager();
        foreach ($this->getInvokables() as $pluginName => $pluginClass) {
            $plugin->setInvokableClass($pluginName, $pluginClass);
        }
        $helper->setView($renderer);
        $this->helper = $helper;
    }

    public function __invoke(string $name): Markup
    {
        if (!isset($this->config[$name])) {
            throw new FormNotFound('The specified form is not registered');
        }
        $form = $this->factory->make($this->config[$name]);
        return new Markup($this->helper->__invoke($form), 'UTF-8');
    }

    private function getInvokables(): array
    {
        return [
            'formRow' => 'Laminas\Form\View\Helper\FormRow',
            'form_label' => 'Laminas\Form\View\Helper\FormLabel',
            'form_element' => 'Laminas\Form\View\Helper\FormElement',
            'form_element_errors' => 'Laminas\Form\View\Helper\FormElementErrors',
            'forminput' => 'Laminas\Form\View\Helper\FormInput',
            'formtext' => 'Laminas\Form\View\Helper\FormText',
            'formtextarea' => 'Laminas\Form\View\Helper\FormTextarea',
            'formemail' => 'Laminas\Form\View\Helper\FormEmail',
            'formsubmit' => 'Laminas\Form\View\Helper\FormSubmit',
        ];
    }
}
