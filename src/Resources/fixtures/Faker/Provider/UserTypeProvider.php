<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 14.10.17
 * Time: 04:48
 */

namespace App\Resources\fixtures\Faker\Provider;

/**
 * Class UserTypeProvider
 * @package App\Resources\fixtures\Faker\Provider
 *
 * Permet de générer le type d'utilisateur lors de l'ajout des fixtures.
 * Ce service aura le tag : nelmio_alice.faker.provider
 * =>qui permet de charger le service lors de l'événement de chargement des faker providers de nelmio_alice
 */
class UserTypeProvider
{
    const USER_TYPE = ["user","client","provider"];

    public static function userType()
    {
        return array_rand(self::USER_TYPE);
        /*
        $userTypes = array("internaute","prestataire");

        return $userTypes[array_rand($userTypes)];

        */
    }


}