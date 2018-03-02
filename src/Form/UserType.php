<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 09.01.18
 * Time: 16:22
 */
namespace App\Form;

/* Formulaire d'inscription */
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\User;
use App\Form\Township;
use App\Form\Locality;
use App\Form\PostalCode;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\ImageType;
use Doctrine\ORM\EntityRepository;



class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add("avatar", ImageType::class)
            ->add("email", EmailType::class)
            ->add(
                "plainPassword",
                RepeatedType::class,
                array(
                    "type" => PasswordType::class,
                    "first_options" => array("label"=>"Mot de passe :", "empty_data"=> "abc"),
                    "second_options" => array("label" => "Répéter le mot de passe :", "empty_data"=> "abc")
                )
            )
            ->add(
                "userType",
                ChoiceType::class,
                array(
                    "mapped"=>false,
                    "choices" => array(
                        "Prestataire"=>"Provider",
                        "Client" => "Client"
                    )
                )
            )
            ->add(
                "township",
                EntityType::class,
                array(
                    "class" => Township::class,
                    "label" => "Commune :",
                    "choice_label" => "township",
                    "multiple" => false,
                    "expanded" => false,

                )
            )
            ->add(
                "locality",
                EntityType::class,
                array(
                    "class" => Locality::class,
                    "label" => "Localité :",
                    "choice_label" => "locality",
                    "multiple" => false,
                    "expanded" => false,

                )
            )
            ->add(
                "postalCode",
                EntityType::class,
                array(
                    "class" => PostalCode::class,
                    "label" => "Code postal :",
                    "choice_label" => "postalCode",
                    "multiple" => false,
                    "expanded" => false,

                )
            )
            ->add("token", HiddenType::class)
            ->add("submit", SubmitType::class, array("label"=>"Inscription"));
    }
    /* Permet d'indiquer le type de class qu'implémente le formulaire
    pour permettre l'imbrication de formulaire
    */
    public function configureOptions(OptionsResolver $resolver){
        $resolver->setDefaults(array(
            "data_class" => User::class,
            // Activation protection CSRF
            "csrf_protection" => true,
            // Nom du champ contenant le token
            "csrf_field_name" => "_token",
            "csrf_token_id" => "email"
        ));
    }
}