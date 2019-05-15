<?php declare(strict_types = 1);

namespace Statico\Core\Views\Functions;

use Zend\Config\Config;
use Zend\Form\ElementInterface;
use Statico\Core\Exceptions\Forms\FormNotFound;
use Statico\Core\Factories\FormFactory;

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

    public function __construct(Config $config, FormFactory $factory)
    {
        $this->config = $config->get('forms');
        $this->factory = $factory;
    }

    public function __invoke(string $form): ElementInterface
    {
        if (!isset($this->config[$form])) {
            throw new FormNotFound('The specified form is not registered');
        }
        return $this->factory->make($this->config[$form]);
    }
}
