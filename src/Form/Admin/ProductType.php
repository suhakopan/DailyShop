<?php

namespace App\Form\Admin;

use App\Entity\Admin\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('CategoryNo')
            ->add('Title')
            ->add('Amount')
            ->add('Price')
            ->add('Description')
            ->add('SavedDate')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
            'csrf_protection'=>false,
        ]);
    }
}
