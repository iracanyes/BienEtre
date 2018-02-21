<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 15.01.18
 * Time: 01:07
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


class ServiceCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("name", TextType::class)
            ->add("description", TextareaType::class)
            ->add("inFrontPage", CheckboxType::class)
            ->add("image", ImageType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            "data_class" => ServiceCategory::class
        ));
    }
}