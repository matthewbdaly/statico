<?php declare(strict_types = 1);

namespace Statico\Core\Views\Functions;

use Zend\Config\Config;
use Zend\Form\ElementInterface;
use Statico\Core\Exceptions\Forms\FormNotFound;
use Statico\Core\Factories\FormFactory;
use Zend\Form\View\Helper\Form as FormHelper;
use Zend\View\Renderer\PhpRenderer;

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

    public function __invoke(string $name)
    {
        if (!isset($this->config[$name])) {
            throw new FormNotFound('The specified form is not registered');
        }
        $form = $this->factory->make($this->config[$name]);
        return $this->helper->__invoke($form);
    }

    private function getInvokables()
    {
        return [
            'formRow' => 'Zend\Form\View\Helper\FormRow',
            'form_label' => 'Zend\Form\View\Helper\FormLabel',
            'form_element' => 'Zend\Form\View\Helper\FormElement',
            'form_element_errors' => 'Zend\Form\View\Helper\FormElementErrors',
            'forminput' => 'Zend\Form\View\Helper\FormInput',
            'formtext' => 'Zend\Form\View\Helper\FormText',
            'formsubmit' => 'Zend\Form\View\Helper\FormSubmit',
        ];
    }
}