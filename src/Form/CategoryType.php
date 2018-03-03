<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 03.03.18
 * Time: 12:30
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\ServiceCategory;
use App\Form\ImageType;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
                "name",
                TextType::class,
                array(
                    "label" => "Nom de la catégorie de stage",
                    "attr" => array("class" => "form-control")
                )
            )
            ->add(
                "description",
                TextareaType::class,
                array(
                    "label" => "Description "

                )
            )
            ->add(
                "inFrontPage",
                CheckboxType::class,
                array(
                    "label" => "Mis en avant"
                )
            )
            ->add(
                "image",
                ImageType::class
            )
            ->add(
                "submit",
                SubmitType::class,
                array(
                    "label" => "Confirmer",
                    "attr" => array("class"=>"btn btn-primary")
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            "data_class" => ServiceCategory::class
        ));
    }
}