<?php

namespace Bundle\AppBundle\Security\Voter;

use AppBundle\Entity\User;
use Kolab\Holiday\Infrastructure\Projection\HolidayRead;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class HolidayVoter extends Voter
{
    const VIEW = 'view';

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::VIEW])) {
            return false;
        }

        if (!$subject instanceof HolidayRead) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        $cycle = $subject;

        if($user->hasRole('ROLE_ADMIN')) {
            return true;
        }

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($cycle, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(HolidayRead $holiday, User $user)
    {
        return $user->userId() === $holiday->customerId();
    }

}