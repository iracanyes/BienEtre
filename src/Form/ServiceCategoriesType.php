<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 27.02.18
 * Time: 16:53
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Drupal\Core\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\ServiceCategoryType;



class ServiceCategoriesType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            "services",
            CollectionType::class,
            array(
                "label" => false,
                "entry_type" => ServiceCategoryType::class,
                "entry_options" => array(
                    "label" => false,
                    "attr" => array("class" =>"form-group")
                ),
                "allow_add" => true,
                "allow_delete" => true,
                "by_reference" => false
            )
            )
            ->add("submit", SubmitType::class, array("label"=> "Confirmer"));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            "data_class" => Provider::class,
        ));
    }
}