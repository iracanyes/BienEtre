<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 20.02.18
 * Time: 12:21
 */

namespace App\Form;

use App\Entity\Provider;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Service;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServicesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            "services",
            CollectionType::class,
            array(
                "label" => false,
                "entry_type" => array(
                    "label"=> false,
                    "attr" => array("class"=>"form-group")
                ),
                "allow_add" => true,
                "allow_delete" => true,
                "by_reference" => false
            )
        )
        ->add("submit", SubmitType::class, array("label"=>"Confirmer"));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array("data_class"=>Provider::class)
        );
    }

}