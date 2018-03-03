<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 03.03.18
 * Time: 18:26
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use App\Entity\Provider;

class PwdType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("email", HiddenType::class)
            ->add(
                "plainPassword",
                RepeatedType::class,
                array(
                    "type" => PasswordType::class,
                    "first_options" => array("label"=>"Mot de passe :", "empty_data"=> "abc"),
                    "second_options" => array("label" => "Répéter le mot de passe :", "empty_data"=> "abc")
                )
            )
            ->add("submit", SubmitType::class, array("label"=>"Inscription"));
    }

    /* Permet d'indiquer le type de class qu'implémente le formulaire
    pour permettre l'imbrication de formulaire
    */
    public function configureOptions(OptionsResolver $resolver){
        $resolver->setDefaults(array(
            "data_class" => Provider::class,
            // Activation protection CSRF
            "csrf_protection" => true,
            // Nom du champ contenant le token
            "csrf_field_name" => "_token",
            "csrf_token_id" => "email"
        ));
    }
}