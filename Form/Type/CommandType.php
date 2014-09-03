<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Form\Type;

use RomaricDrigon\OrchestraBundle\Domain\Command\CommandInterface;
use RomaricDrigon\OrchestraBundle\Exception\Domain\CommandInvalidException;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class CommandType
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class CommandType extends AbstractType
{
    /**
     * @var CommandInterface
     */
    protected $command;

    /**
     * @param CommandInterface $command
     */
    public function __construct(CommandInterface $command)
    {
        $this->command = $command;
    }

    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $properties = get_object_vars($this->command);

        if (null === $properties) {
            throw new CommandInvalidException($this->command);
        }

        $properties = array_keys($properties);

        foreach ($properties as $property) {
            // We let Symfony2 guess!
            $builder->add($property);
        }
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'orchestra_command_type';
    }
} 