<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 15.01.18
 * Time: 00:43
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Provider;

class ProviderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
                "brandName",
                TextType::class,
                array(
                    "label" => "Nom de l'organisation :"
                )
            )
            ->add(
                "website",
                UrlType::class,
                array(
                    "label" => "Site internet :"
                )
            )
            ->add(
                "emailContact",
                EmailType::class,
                array(
                    "label" => "E-mail de contact:"
                )
            )
            ->add("phoneNumber", TelType::class,
                array(
                    "label" => "Numéro de téléphone :"
                )
            )
            ->add("tvaNumber", TextType::class,
                array(
                    "label" => "Numéro TVA :"
                )
            )
            ->add("street", TextType::class,
                array(
                    "label" => "Rue :"
                )
            )
            ->add(
                "locality",
                LocalityType::class,
                array("label"=>"Localité : ")
            )
            ->add(
                "township",
                TownshipType::class,
                array("label"=>"Commune : ")
            )
            ->add(
                "postalCode",
                PostalCodeType::class,
                array("label"=>"Code postal : ")
            )
            ->add("submit", SubmitType::class, array("label"=>"Confirmer"));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            "data_class" => Provider::class,
        ));
    }

}