<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 08.02.18
 * Time: 03:40
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\LocalityType;
use App\Form\PostalCodeType;
use App\Form\TownshipType;


class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options):void
    {
        $builder->add("locality", LocalityType::class, array("label"=>"Localité : "))
            ->add("township", TownshipType::class, array("label"=>"Commune : "))
            ->add("postalCode", PostalCodeType::class, array("label"=>"Code postal : "));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array("data_class"=> UserType::class)
        );
    }
}