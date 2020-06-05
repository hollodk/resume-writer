<?php

namespace App\Form;

use App\Entity\Resume;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResumeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('color', ChoiceType::class, [
                'choices' => [
                    'Red' => '#581010',
                    'Green' => '#1D473A',
                    'Blue' => '#082A4D',
                    'Purple' => '#32084D',
                    'Grey' => '#1B212F',
                ],
            ])
            ->add('slug', null, [
                'help' => 'Suffix for public sharing',
            ])
            ->add('jobTitle')
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('phone')
            ->add('country')
            ->add('city')
            ->add('street')
            ->add('postalCode')
            ->add('drivingLicense')
            ->add('nationality')
            ->add('placeOfBirth')
            ->add('dateOfBirth')
            ->add('professionalSummary', null, [
                'attr' => [
                    'rows' => 7,
                ],
            ])
            ->add('hobbies', null, [
                'attr' => [
                    'rows' => 7,
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Resume::class,
        ]);
    }
}
