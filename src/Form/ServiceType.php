<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 15.01.18
 * Time: 00:54
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Service;
use App\Form\ProviderType;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("name", TextType::class)
            ->add("description", TextareaType::class)
            ->add("pricing", TextareaType::class)
            ->add("additionalInformation", TextareaType::class)
            ->add(
                "startDate",
                DateTimeType::class,
                array(
                    "label" => "Date de début",
                    //"html5" => false,
                    //"input" => "datetime",
                    //"attr" => array("class" =>"js-datepicker")
                )
            )
            ->add("endDate", DateTimeType::class,
                array(
                    "label" => "Date de début",
                    "html5" => false,
                    "input" => "datetime",
                    "attr" => array("class" =>"js-datepicker")
                )
            )
            ->add("releaseDate", DateTimeType::class,
                array(
                    "label" => "Date de début",
                    "html5" => false,
                    "input" => "datetime",
                    "attr" => array("class" =>"js-datepicker")
                )
            )
            ->add("expiryDate", DateTimeType::class,
                array(
                    "label" => "Date de début",
                    "html5" => false,
                    "input" => "datetime",
                    "attr" => array("class" =>"js-datepicker")
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            "data_class" => Service::class
        ));
    }

}