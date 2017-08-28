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

class PostType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', ChoiceType::class,
                [
                    'choices' =>
                        [
                            'Wybierz' => 'null',
                            'Zupa' => 'soup',
                            'Danie Główne' => 'main',
                            'Deser' => 'dessert',
                            'Sniadanie/kolacja' => 'breakfast'
                        ],
                    'choices_as_values' => true,
                    'label' => 'Kategoria',
                ]
            )
            ->add('subCategory', ChoiceType::class,
                [
                    'choices' =>
                        [
                            'Wybierz' => 'null',
                            'Zupa - krem' => 'creamSoup',
                            'Zupa - z makaronem' => 'noodleSoup',
                            'Zupa - z ziemniakami' => 'potatoSoup',
                            'Zupa - inna' => 'otherSoup',
                            'Danie główne - klasyczne (mięso, ziemiaki, suruwówka)' => 'classicMain',
                            'Danie główne - makaron' => 'pastaMain',
                            'Danie główme - jednogarnkowe' => 'potMain',
                            'Danie główne - ryba' => 'fishMain',
                            'Danie główne - inne' => 'otherMain',
                            'Deser - lody' => 'icecreamDessert',
                            'Deser - ciasto' => 'cakeDessert',
                            'Deser - budyń/kisiel' => 'puddingDessert',
                            'Deser - inne' => 'otherDessert',
                            'Śniadanie/kolacja - kanapki' => 'sandwichBreakfast',
                            'Śniadanie/kolacja - tosty' => 'toastsBreakfast',
                            'Śniadanie/kolacja - omlet' => 'omletBreakfast',
                            'Śniadanie/kolacja - inne' => 'otherBreakfast',
                        ]
                    ,
                    'choices_as_values' => true,
                    'label' => 'Podkategoria',
                    'choice_attr' => function ($val, $key, $index) {
                        if (strpos($val, 'Soup') !== false) {
                            return ['data-soups' => 'true', 'class' => 'hidden'];
                        } elseif (strpos($val, 'Main') !== false) {
                            return ['data-mains' => 'true', 'class' => 'hidden'];
                        } elseif (strpos($val, 'Dessert') !== false) {
                            return ['data-desserts' => 'true', 'class' => 'hidden'];
                        } elseif (strpos($val, 'Breakfast') !== false) {
                            return ['data-breakfasts' => 'true', 'class' => 'hidden'];
                        } else {
                            return ['class' => ''];
                        }
                    },
                ]
            )
            ->
            add('hotness', ChoiceType::class,
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
                ]
            )
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
                ]
            )
            ->add('expiration', "datetime",['label'=>'Do kiedy trzeba zjeść?'])
            ->add('ingredients', 'entity', ['class' => 'FoodBundle\Entity\Ingredient',
                'property' => 'name',
                'multiple' => 'true',
                'expanded' => true,
                'label'=> 'Jakie składniki zawiera potrawa?'
                ])
            ->add('photo', FileType::class, [
                    'label' => 'Photo',
                    'required' => false
                ]
            );

    }

    /**
     * {@inheritdoc}
     */
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
