<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    /**
     * @var UserId
     */
    private $userId;

    /**
     * @var string
     */
    private $username;

    /**
     * @var Email
     */
    private $email;

    /**
     * @var Role
     */
    private $roles;

    /**
     * @var string
     */
    private $plainPassword;

    /**
     * @var string
     */
    private $password;

    /**
     * @var boolean
     */
    private $isActive;

    /**
     * @var string
     */
    private $createdAt;

    /**
     * @var string
     */
    private $deletedAt = null;

    /**
     * @var string
     */
    private $lastLoggedAt = null;

    /**
     * @var string
     */
    private $actionToken;

    /**
     * @var \DateTime
     */
    private $actionTokenRequestedAt;

    private $temporaryEmail;

    /**
     * User constructor.
     * @param UserId $userId
     */
    public function __construct(UserId $userId)
    {
        $this->userId = $userId;
        $this->username = $userId;
        $this->createdAt = new \DateTime('now');
        $this->isActive = false;
        $this->roles = new ArrayCollection();
    }

    /**
     * @return UserId
     */
    public function userId()
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function username()
    {
        return $this->username;
    }

    /**
     * @return Role
     */
    public function roles()
    {
        return $this->roles;
    }


    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function email()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function lastLoggedAt()
    {
        return $this->lastLoggedAt;
    }


    /**
     * @return mixed
     */
    public function isActive()
    {
        return $this->isActive;
    }

    public function activate()
    {
        $this->isActive = true;
    }

    public function deactivate()
    {
        $this->isActive = false;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function plainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return null
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    public function eraseCredentials()
    {
    }

    /**
     * @param string $lastLoggedAt
     */
    public function setLastLoggedAt($lastLoggedAt)
    {
        $this->lastLoggedAt = $lastLoggedAt;
    }

    public function findUserRole($role)
    {
        /** @var Role $roleItem */
        foreach ($this->getRoles() as $roleItem) {
            if ($role == $roleItem->getRole()) {
                return $roleItem;
            }
        }

        return false;
    }

    public function hasRole($role)
    {
        return $this->findUserRole($role) instanceof Role;
    }

    public function addRole($role)
    {
        if (!$role instanceof Role) {
            throw new \Exception('addRole takes a Role object as the parameter');
        }

        if (!$this->hasRole($role->getRole())) {
            $this->roles[] = $role;
        }

        return $this;
    }

    /**
     * @param mixed $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return array|ArrayCollection|Role
     */
    public function getRoles()
    {
        if (!is_array($this->roles)) {
            $roles = $this->roles->toArray();
        } else {
            $roles = $this->roles;
        }

        return $roles;
    }

    public function eraseRoles()
    {
        $this->roles->clear();
    }

    /**
     * @return string
     */
    public function actionToken()
    {
        return $this->actionToken;
    }

    /**
     * @param string $actionToken
     */
    public function setActionToken(string $actionToken)
    {
        $this->actionToken = $actionToken;
    }


    public function cleanActionToken()
    {
        $this->actionToken = null;
    }

    /**
     * @return \DateTime
     */
    public function getActionTokenRequestedAt()
    {
        return $this->actionTokenRequestedAt;
    }

    /**
     * @param \DateTime $passwordRequestedAt
     */
    public function setActionTokenRequestedAt($actionTokenRequestedAt)
    {
        $this->actionTokenRequestedAt = $actionTokenRequestedAt;
    }

    public function isActionTokenExpired($ttl)
    {
        return $this->getActionTokenRequestedAt() instanceof \DateTime
            && $this->getActionTokenRequestedAt()->getTimestamp() + $ttl < time();
    }

    public function temporaryEmail()
    {
        return $this->temporaryEmail;
    }

    public function setTemporaryEmail($temporaryEmail)
    {
        $this->temporaryEmail = $temporaryEmail;
    }

    public function cleanTemporaryEmail()
    {
        $this->temporaryEmail = '';
    }

    public function isNotActivated()
    {
        return !$this->isActive() && !$this->lastLoggedAt();
    }
}