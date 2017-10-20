<?php

namespace FoodBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditPostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', ChoiceType::class,
                [
                    'choices' =>
                        [
                            'Wybierz' => 'null',
                            'Zupa' => 'Zupa',
                            'Danie Główne' => 'Danie Główne',
                            'Deser' => 'Deser',
                            'Śniadanie/kolacja' => 'Śniadanie/kolacja'
                        ],
                    'choices_as_values' => true,
                    'label' => 'Kategoria',
                ])
            ->add('subCategory', ChoiceType::class,
                [
                    'choices' =>
                        [
                            'Wybierz' => 'null',
                            'Zupa - krem' => 'Zupa - krem',
                            'Zupa - z makaronem' => 'Zupa - z makaronem',
                            'Zupa - z ziemniakami' => 'Zupa - z ziemniakami',
                            'Zupa - inna' => 'Zupa - inna',
                            'Danie główne - klasyczne (mięso, ziemiaki, suruwówka)' => 'Danie główne - klasyczne (mięso, ziemiaki, suruwówka)',
                            'Danie główne - makaron' => 'Danie główne - makaron',
                            'Danie główne - jednogarnkowe' => 'Danie główne - jednogarnkowe',
                            'Danie główne - ryba' => 'Danie główne - ryba',
                            'Danie główne - inne' => 'Danie główne - inne',
                            'Deser - lody' => 'Deser - lody',
                            'Deser - ciasto' => 'Deser - ciasto',
                            'Deser - budyń/kisiel' => 'Deser - budyń/kisiel',
                            'Deser - inne' => 'Deser - inne',
                            'Śniadanie/kolacja - kanapki' => 'Śniadanie/kolacja - kanapki',
                            'Śniadanie/kolacja - tosty' => 'Śniadanie/kolacja - tosty',
                            'Śniadanie/kolacja - omlet' => 'Śniadanie/kolacja - omlet',
                            'Śniadanie/kolacja - inne' => 'Śniadanie/kolacja - inne',
                        ]
                    ,
                    'choices_as_values' => true,
                    'label' => 'Podkategoria',
                    'choice_attr' => function ($val, $key, $index) {
                        if (strpos($val, 'Zupa') !== false) {
                            return ['data-soups' => 'true', 'class' => 'hidden'];
                        } elseif (strpos($val, 'Danie główne') !== false) {
                            return ['data-mains' => 'true', 'class' => 'hidden'];
                        } elseif (strpos($val, 'Deser') !== false) {
                            return ['data-desserts' => 'true', 'class' => 'hidden'];
                        } elseif (strpos($val, 'Śniadanie/kolacja') !== false) {
                            return ['data-breakfasts' => 'true', 'class' => 'hidden'];
                        } else {
                            return ['class' => ''];
                        }
                    },
                ])
            ->add('title', "text",
                [
                    "label" => 'Tytuł'
                ])
            ->add('description', "textarea",
                [
                    "label" => 'Krótki opis'
                ])
            ->add('hotness', ChoiceType::class,
                [
                    'choices' =>
                        [
                            'Nie ostre' => '1',
                            'Lekko ostre' => '2',
                            'Średnio ostre' => '3',
                            'Bardzo ostre' => '4'
                        ],
                    'choices_as_values' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Ostrość'
                ])
            ->add('vegan', ChoiceType::class,
                [
                    'choices' =>
                        [
                            'tak' => 'tak',
                            'nie' => 'nie',
                            'a ja wiem?' => 'a ja wiem?',
                        ],
                    'choices_as_values' => true,
                    'expanded' => true,
                    'label' => 'Wegańskie?'
                ])
            ->add('gluten', ChoiceType::class,
                [
                    'choices' =>
                        [
                            'tak' => 'tak',
                            'nie' => 'nie',
                            'a ja wiem?' => 'a ja wiem?',
                        ],
                    'choices_as_values' => true,
                    'expanded' => true,
                    'label' => 'Ma gluten?',
                ])
            ->add('expiration', "datetime", ['label' => 'Do kiedy trzeba zjeść?'])
            ->add('ingredients', 'entity', [
                'class' => 'FoodBundle\Entity\Ingredient',
                'property' => 'name',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Jakie składniki zawiera potrawa?'
            ])
            ->add('portions', "integer", ['label' => 'Ilość porcji'])
            ->add('photo', FileType::class, [
                    'data_class' => null,
                    'label' => 'Zmienić zdjęcie? ',
                    'required' => false
                ]
            );


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FoodBundle\Entity\Post'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'foodbundle_post';
    }
}