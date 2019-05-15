<?php declare(strict_types = 1);

namespace Statico\Core\Factories;

use Zend\Form\ElementInterface;
use Zend\Form\Factory;
use Zend\Hydrator\ArraySerializable;

final class FormFactory
{
    /**
     * @var Factory
     */
    private $factory;

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    public function make(array $form): ElementInterface
    {
        return $this->factory->createForm([
            'hydrator' => ArraySerializable::class,
            'elements' => $form
        ]);
    }
}
