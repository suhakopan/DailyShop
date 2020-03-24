<?php
/**
 * Created by PhpStorm.
 * User: SEFA
 * Date: 13.01.2019
 * Time: 13:47
 */

namespace App\Form\Admin;


class ImageeType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('images', FileType::class, array(
                'attr' => array(
                    'accept' => 'image/*',
                    'multiple' => 'multiple'
                )
            ))
            ->add('save',SubmitType::class,array('label'=>'Insert Image','attr'=>array('class'=>'btn btn-primary','style'=>'margin-bottom:15px')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => images::class
        ));
    }
}