<?php

declare(strict_types=1);

namespace Statico\Core\Factories\Forms;

use Laminas\Form\ElementInterface;
use Laminas\Form\Factory;
use Laminas\Hydrator\ArraySerializableHydrator;
use PublishingKit\Config\Config;
use Statico\Core\Contracts\Factories\FormFactory;

final class LaminasFormFactory implements FormFactory
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
                                           'elements' => $form->get('elements')->toArray(),
                                          ]);
    }
}
