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
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Provider;
use App\Entity\Township;
use App\Entity\Locality;
use App\Entity\PostalCode;

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
            /* Embeed Collection of forms */
            ->add(
                "logos",
                CollectionType::class,
                array(
                    "label" => false,
                    "entry_type" => ImageType::class,
                    // Options passés à chaque formulaire image
                    "entry_options" => array(
                        "label" => false,
                        "attr" => array("class" => "form-group")
                    ),
                    "allow_add" => true,
                    "allow_delete" => true,
                    "by_reference"=> false
                )
            )
            ->add(
                "images",
                CollectionType::class,
                array(
                    "label"=> false,
                    "entry_type" => ImageType::class,
                    //Options de chaque widget
                    "entry_options"=> array(
                        "label" => false,
                        "attr" => array("class"=>"form-group")
                    ),
                    "allow_add" => true,
                    "allow_delete" => true,
                    "by_reference"=> false
                )
            )
            ->add(
                "serviceCategories",
                CollectionType::class,
                array(
                    "label"=> false,
                    "entry_type" => ServiceCategoryType::class,
                    //Options de chaque widget
                    "entry_options"=> array(
                        "label" => false,
                        "attr" => array("class"=>"form-group")
                    ),
                    "allow_add" => true,
                    "allow_delete" => true,
                    "by_reference"=> false
                )
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