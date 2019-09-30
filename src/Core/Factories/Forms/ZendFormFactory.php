<?php

declare(strict_types=1);

namespace Statico\Core\Factories\Forms;

use Zend\Form\ElementInterface;
use Zend\Form\Factory;
use Zend\Hydrator\ArraySerializableHydrator;
use Zend\Config\Config;
use Statico\Core\Contracts\Factories\FormFactory;

final class ZendFormFactory implements FormFactory
{
    /**
     * @var Factory
     */
    private $factory;

    public function __construct()
    {
        $this->factory = new Factory();
    }

    public function make(Config $form = null): ElementInterface
    {
        return $this->factory->createForm([
            'hydrator' => ArraySerializableHydrator::class,
            'elements' => $form->get('elements')->toArray()
        ]);
    }
}
