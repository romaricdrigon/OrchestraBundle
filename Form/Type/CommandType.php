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
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class CommandType
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class CommandType extends AbstractType
{
    public function __construct()
    {
    }

    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $command = $options['command'];

        $properties = get_object_vars($command);

        if (null === $properties) {
            throw new CommandInvalidException($command);
        }

        $properties = array_keys($properties);

        foreach ($properties as $property) {
            // We let Symfony2 guess!
            $builder->add($property);
        }

        // Add a submit button!
        $builder->add('save', 'submit');
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'orchestra_command_type';
    }

    /**
     * We require a "command" option
     *
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(['command']);
    }
} 