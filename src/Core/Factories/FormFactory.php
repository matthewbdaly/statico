<?php declare(strict_types = 1);

namespace Statico\Core\Factories;

use Zend\Form\ElementInterface;
use Zend\Form\Factory;
use Zend\Hydrator\ArraySerializableHydrator;

final class FormFactory
{
    /**
     * @var Factory
     */
    private $factory;

    public function __construct()
    {
        $this->factory = new Factory;
    }

    public function make(array $form): ElementInterface
    {
        return $this->factory->createForm([
            'hydrator' => ArraySerializableHydrator::class,
            'elements' => $form
        ]);
    }
}
