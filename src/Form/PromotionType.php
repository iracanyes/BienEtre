<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 15.01.18
 * Time: 01:18
 */

namespace App\Form;

use App\Entity\ServiceCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Promotion;

class PromotionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("name", TextType::class, array("label"=>"Titre"))
            ->add("description", TextareaType::class, array("label"=>"Description"))
            ->add("pdf", FileType::class, array("label"=>"PDF"))
            ->add("startDate", DateTimeType::class, array("label"=>"Date de début"))
            ->add("endDate", DateTimeType::class, array("label"=>"Date de fin"))
            ->add("releaseDate", DateTimeType::class, array("label"=>"Date de publication"))
            ->add("expiryDate", DateTimeType::class, array("label"=>"Date d'expiration"))
            ->add(
                "serviceCategory",
                EntityType::class,
                array(
                    "class" => ServiceCategory::class,
                    "choice_label" => "name",
                    "multiple" => false,
                    "expanded" => false,
                    "label" => "Catégorie de service",
                    "label_attr" => array("class" => "col-sm-2 control-label", "required" => false),
                )
            )
            ->add(
                "submit"
                ,
                SubmitType::class,
                array(
                    "label"=>"Confirmer",
                    "attr" => array("class" => "btn btn-primary")
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            "data_class" => Promotion::class,
        ));
    }

}