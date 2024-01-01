<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('marque', TextType::class, [

                'attr' => ['class' => '', 'placeholder' => 'marque'],
                'required' => true,
            ])
            ->add('modele', TextType::class, [

                'attr' => ['class' => '', 'placeholder' => 'modele'],
                'required' => true,
            ])
            ->add('couleur', TextType::class, [

                'attr' => ['class' => '', 'placeholder' => 'couleur'],
                'required' => true,
            ])
            ->add('url', TextType::class, [

                'attr' => ['class' => '', 'placeholder' => 'url'],
                'required' => true,
            ])
            ->add('puissance', NumberType::class, [

                'attr' => ['class' => '', 'placeholder' => 'puissance'],
                'required' => true,
            ])
            ->add('price', NumberType::class, [

                'attr' => ['class' => '', 'placeholder' => 'price'],
                'required' => true,
            ])
            ->add('categorie', NumberType::class, [

                'attr' => ['class' => '', 'placeholder' => 'categorie'],
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
