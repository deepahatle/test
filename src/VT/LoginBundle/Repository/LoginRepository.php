<?php

namespace VT\LoginBundle\Repository;

use VT\VTCoreBundle\Entity\VTEntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

/**
 * LoginRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LoginRepository extends VTEntityRepository implements UserProviderInterface, UserLoaderInterface
{
	public function findOneByUserNameOrEmail($username, $mobile = null)
    {
        $q = "";
        $q .= " select u ";
        $q .= " from LoginBundle:Login as u ";
        $q .= " where (u.username = '" . $username . "' or u.mobileNo = '" . ($mobile ? $mobile : $username) . "') ";
        $q .= " and u.deleted = 0 ";
        $q .= " and u.isActive = 'Yes' ";
        $clientRecords = $this->createQuery($q)->getResult();

        if (empty($clientRecords))
            return null;

        return $clientRecords[0];
    }

	/**
     * Loads the user for the given username.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @param string $username The username
     *
     * @return UserInterface
     *
     * @see UsernameNotFoundException
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByUsername($username)
    {
        $user = $this->findOneByUserNameOrEmail($username);

        if (!$user) {
            throw new UsernameNotFoundException('No user found for username ' . $username);
        }

        return $user;
    }

    /**
     * Refreshes the user for the account interface.
     *
     * It is up to the implementation to decide if the user data should be
     * totally reloaded (e.g. from the database), or if the UserInterface
     * object can just be merged into some internal array of users / identity
     * map.
     *
     * @param UserInterface $user
     *
     * @return UserInterface
     *
     * @throws UnsupportedUserException if the account is not supported
     */
    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
        }

        return $user;
    }

    /**
     * Whether this provider supports the given user class.
     *
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        return $this->getEntityName() === $class || is_subclass_of($class, $this->getEntityName());
    }

    public function checkIsRegisteredEmail($email){
        $q = "";
        $q .= "select l from LoginBundle:Login as l ";
        $q .= "where l.username = '$email' ";
        $q .= "and l.isActive = 'Yes' ";
        $q .= "and l.deleted = 0 ";

        $clientRecords = $this->createQuery($q)->getResult();

        if (empty($clientRecords))
            return false;
        else
            return true;
    }
}