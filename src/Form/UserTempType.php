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
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\UserTemp;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
/**
 * Ici nous ajoutons une contrainte de validation car la propriété "termsAccepted" ne sera pas contenu dans la classe User
 */
use Symfony\Component\Validator\Constraints\IsTrue;


class UserTempType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add("email", EmailType::class)
            ->add("plainPassword", RepeatedType::class, array(
                "type" => PasswordType::class,
                "invalid_message" => "Les mots de passe doivent correspondre! ",
                "options" => array("attr"=>array("class" => "form-group")),
                "first_options" => array("label"=>"Mot de passe : "),
                "second_options" => array("label" => "Répéter le mot de passe : ")
            ))
            ->add(
                "userType",
                ChoiceType::class,
                array(
                    "mapped"=>true,
                    "choices" => array(
                        "Prestataire"=>"provider",
                        "Client" => "client"
                    )
                )
            )
            ->add(
                "termsAccepted",
                CheckboxType::class,
                array(
                    "attr" => array(
                        "data" => 1,
                        "checked" => "checked",
                    ),
                    "value" => "1",
                    "required" => true,
                    //"constraints" => new IsTrue()
                )
            )
            ->add("submit", SubmitType::class, array("label"=>"Inscription"));
    }
    /* Permet d'indiquer le type de class qu'implémente le formulaire
    pour permettre l'imbrication de formulaire
    */
    public function configureOptions(OptionsResolver $resolver){
        $resolver->setDefaults(array(
            "data_class" => UserTemp::class,
            // Activation protection CSRF
            "csrf_protection" => true,
            // Nom du champ contenant le token
            "csrf_field_name" => "_csrf_token",
            "csrf_token_id" => "email"
        ));
    }
}