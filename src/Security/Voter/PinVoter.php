<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class PinVoter extends Voter
{
    public const EDIT = 'PIN_EDIT';
    public const CREATE = 'PIN_CREATE';
    public const DELETE = 'PIN_DELETE';
    public const PIN_MANAGE = 'PIN_MANAGE';

    protected function supports(string $attribute, mixed $subject): bool
    {

        //dd($attribute, $subject);
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::PIN_MANAGE])
            && $subject instanceof \App\Entity\Pin;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {

        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::PIN_MANAGE:
                return $user->isVerified() && $user == $subject->getUser();
                // break;
            // case self::CREATE:
            //     // logic to determine if the user can VIEW
            //     return $user->isVerified();
            //     //break;
            // case self::DELETE:
            //     // logic to determine if the user can VIEW
            //     // return true or false
            //     break;
        }

        return false;
    }
}
