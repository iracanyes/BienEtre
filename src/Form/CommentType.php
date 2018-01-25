<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 15.01.18
 * Time: 02:02
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\ClientType;
use App\Form\ProviderType;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("title", TextType::class)
            ->add("positiveComment", TextareaType::class)
            ->add("negativeComment", TextareaType::class)
            ->add(
                "vote",
                RangeType::class,
                array(
                    "attr" => array(
                        "min" => 1,
                        "max" => 5
                    )

                )
            )
            ->add("entryDate", DateTimeType::class)
            ->add("client", ClientType::class)
            ->add("provider", Provider::class)
            ->add("submit", SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            "data_class" => Comment::class
        ));
    }
}