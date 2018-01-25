<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 15.01.18
 * Time: 01:18
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use App\Form\ProviderType;
use App\Form\ServiceCategoryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Promotion;

class PromotionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("name", TextType::class)
            ->add("description", TextareaType::class)
            ->add("pdf", UrlType::class)
            ->add("startDate", DateTimeType::class)
            ->add("endDate", DateTimeType::class)
            ->add("releaseDate", DateTimeType::class)
            ->add("expiryDate", DateTimeType::class)
            ->add("provider", ProviderType::class)
            ->add("serviceCategory", ServiceCategoryType::class)
            ->add("submit", SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            "data_class" => Promotion::class,
        ));
    }

}