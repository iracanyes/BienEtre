<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 23.01.18
 * Time: 21:06
 */

namespace App\Security\User;

use App\Entity\UserTemp;
use App\Entity\Provider;
use App\Entity\Client;

class UserConverter
{
    /**
     * @param UserTemp $userTemp
     * @return Provider
     */
    public function convertToProvider(UserTemp $userTemp)
    {
        $provider = new Provider();

        $provider->setEmail($userTemp->getEmail());
        $provider->setPassword($userTemp->getPassword());
        $provider->setUserType($userTemp->getUserType());
        $provider->setRegistryDate(new \DateTime());
        $provider->setRegistryConfirmed(true);
        // éviter les erreurs de champs vides
        $provider->setPlainPassword("abc");


        return $provider;
    }

    /**
     * @param UserTemp $userTemp
     * @return Client
     */
    public function convertToClient(UserTemp $userTemp)
    {
        $client = new Client();

        $client->setEmail($userTemp->getEmail());
        $client->setPassword($userTemp->getPassword());
        $client->setUserType($userTemp->getUserType());
        $client->setRegistryDate(new \DateTime());
        $client->setRegistryConfirmed(true);
        $client->setPlainPassword("abc");

        return $client;
    }
}