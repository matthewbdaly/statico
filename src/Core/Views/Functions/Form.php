<?php declare(strict_types = 1);

namespace Statico\Core\Views\Functions;

use Zend\Config\Config;
use Zend\Form\ElementInterface;
use Statico\Core\Exceptions\Forms\FormNotFound;
use Statico\Core\Factories\FormFactory;
use Zend\Form\View\Helper\Form as FormHelper;

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

    public function __construct(Config $config, FormFactory $factory, FormHelper $helper)
    {
        $this->config = $config->get('forms');
        $this->factory = $factory;
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
}
