<?php
/**
 * Created by PhpStorm.
 * User: ruben
 * Date: 13/01/2020
 * Time: 16:41
 */

namespace App\Security;


use App\Entity\User as AppUser;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {


        if ($user->getEnabled() == false) {
            echo "su cuenta no ha sido habilitada" ;
            die();
        }

        // user is deleted, show a generic Account Not Found message.

    }

    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof AppUser) {
            return;
        }


    }
}
