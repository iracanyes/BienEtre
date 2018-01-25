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
        $provider->setUsername($userTemp->getUsername());
        $provider->setPassword($userTemp->getPassword());
        $provider->setUserType($userTemp->getUserType());
        $provider->setRegistryDate(new \DateTime());

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
        $client->setUsername($userTemp->getUsername());
        $client->setPassword($userTemp->getPassword());
        $client->setUserType($userTemp->getUserType());
        $client->setRegistryDate(new \DateTime());

        return $client;
    }
}