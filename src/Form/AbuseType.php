<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 15.01.18
 * Time: 01:33
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\ClientType;
use App\Form\CommentType;
use App\Entity\Abuse;

class AbuseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("description", TextareaType::class)
            ->add("entryDate", DateTimeType::class)
            ->add("client", ClientType::class)
            ->add("comment", CommentType::class)
            ->add("submit", SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            "data_class" => Abuse::class
        ));
    }

}