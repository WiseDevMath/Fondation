<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class AppsubfunctionVoter extends Voter
{
    public const EDIT = 'APPSUBFUNCTION_EDIT';
    public const VIEW = 'APPSUBFUNCTION_VIEW';
    public const LIST = 'APPSUBFUNCTION_LIST';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        
        return in_array($attribute, [self::EDIT, self::VIEW, self::LIST])
        && $subject instanceof \App\DTO\AppFunctionSubFunction ;

    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {        
        $user = $token->getUser();      

        // if the user is anonymous, do not grant access
        if (!$user instanceof User) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                // logic to determine if the user can EDIT
                // return true or false
                return $subject->level=='FULL' or $subject->level=='EDIT';
                break;

            case self::VIEW:
                // logic to determine if the user can VIEW
                // return true or false
                break;
            case self::LIST:
                return $subject->level=='FULL' or $subject->level=='EDIT' or $subject->level=='VIEW' or $subject->level=='LIST';
            break;
        }

        return false;
    }
}
