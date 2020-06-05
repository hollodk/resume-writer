<?php

namespace App\Form;

use App\Entity\Language;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LanguageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('language')
            ->add('level', ChoiceType::class, [
                'choices' => [
                    'Native speaker' => 'native speaker',
                    'Highly proficient' => 'highly proficient',
                    'Very good command' => 'very good command',
                    'Good working knowledge' => 'good working knowledge',
                    'Working knowledge' => 'working knowledge',
                    'C2' => 'c2',
                    'C1' => 'c1',
                    'B2' => 'b2',
                    'B1' => 'b1',
                    'A2' => 'a2',
                    'A1' => 'a1',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Language::class,
        ]);
    }
}
