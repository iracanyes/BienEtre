<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 15.01.18
 * Time: 02:14
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Image;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'place',
            ChoiceType::class,
            array(
                "label"=>"Ordre d'affichage :",
                "attr" => array(
                    "class" => "form-control"
                ),
                "choices" => array(
                    "Premier plan" => 1,
                    "2ème place" => 2,
                    "3e place" => 3,
                    "4e place" => 4,
                    "5e place" => 5
                )
            )
        )
            ->add("url", FileType::class, array("label"=>"Image (JPG, JPEG, PNG) ",
                    "data_class" => null));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            "data_class" => Image::class,
        ));
    }

}