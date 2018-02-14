<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 15.01.18
 * Time: 00:21
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Client;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname', TextType::class, array("label"=>"Nom :"))
            ->add("lastname", TextType::class, array("label"=>"Prénom :"))
            ->add(
                "newsletter",
                CheckboxType::class,
                array(
                    "label" => "Inscription à notre Newsletter ?",
                    "required"=> false
                )
            )
        ->add("locality", LocalityType::class, array("label"=>"Localité :"))
        ->add("township", TownshipType::class, array("label"=>"Commune :"))
        ->add("postalCode", PostalCodeType::class, array("label"=>"Code postal : "))
        ->add("avatar", ImageType::class, array("label"=>"Avatar "))
        ->add("submit", SubmitType::class, array("label"=>"Confirmer"));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            "data_class" => Client::class,
        ));
    }

}