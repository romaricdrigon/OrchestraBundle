<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Form\Type;

use RomaricDrigon\OrchestraBundle\Exception\Domain\CommandInvalidException;
use RomaricDrigon\OrchestraBundle\Resolver\FormOptions\FormOptionsResolverInterface;
use RomaricDrigon\OrchestraBundle\Resolver\FormType\FormTypeResolverInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class CommandType
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class CommandType extends AbstractType
{
    /**
     * @var FormTypeResolverInterface
     */
    protected $formTypeResolver;

    /**
     * @var FormOptionsResolverInterface
     */
    protected $formOptionsResolver;


    /**
     * @param FormTypeResolverInterface $formTypeResolver
     * @param FormOptionsResolverInterface $formOptionsResolver
     */
    public function __construct(FormTypeResolverInterface $formTypeResolver, FormOptionsResolverInterface $formOptionsResolver)
    {
        $this->formTypeResolver     = $formTypeResolver;
        $this->formOptionsResolver  = $formOptionsResolver;
    }

    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $command = $options['command'];

        $reflectionCommand = new \ReflectionClass($command);

        $properties = $reflectionCommand->getProperties(\ReflectionProperty::IS_PUBLIC);

        if (true === empty($properties)) {
            throw new CommandInvalidException($command);
        }

        foreach ($properties as $property) {
            // We try to guess, then t's up to Symfony2!
            $type = $this->formTypeResolver->getFormType($property);
            $options = $this->formOptionsResolver->getFormOptions($property);

            $builder->add($property->getName(), $type, $options);
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