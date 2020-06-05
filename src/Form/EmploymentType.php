<?php

namespace App\Form;

use App\Entity\Employment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmploymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('jobTitle')
            ->add('employer')
            ->add('start')
            ->add('end')
            ->add('city')
            ->add('description', null, [
                'attr' => [
                    'rows' => 20,
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Employment::class,
        ]);
    }
}
