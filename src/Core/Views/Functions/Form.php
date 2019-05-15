<?php declare(strict_types = 1);

namespace Statico\Core\Views\Functions;

use Zend\Config\Config;
use Statico\Core\Exceptions\Forms\FormNotFound;

final class Form
{
    /**
     * @var Config;
     */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config->get('forms');
    }

    public function __invoke(string $form): string
    {
        if (!isset($this->config[$form])) {
            throw new FormNotFound('The specified form is not registered');
        }
        return '';
    }
}
