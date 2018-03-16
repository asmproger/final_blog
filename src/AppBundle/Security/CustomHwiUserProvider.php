<?php

/*
 * This file is part of the HWIOAuthBundle package.
 *
 * (c) Hardware.Info <opensource@hardware.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Security;

#namespace HWI\Bundle\OAuthBundle\Security\Core\User;

use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider;

use FOS\UserBundle\Model\User;
use FOS\UserBundle\Model\UserManagerInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Custom user provider for hwioauthbundle
 *
 * @author Alexander <iam.asm89@gmail.com>
 */
class CustomHwiUserProvider extends FOSUBUserProvider
{
    /**
     * Constructor.
     *
     * @param UserManagerInterface $userManager fOSUB user provider
     * @param array $properties property mapping
     */
    public function __construct(UserManagerInterface $userManager, array $properties)
    {
        parent::__construct($userManager, $properties);
    }

    /**
     * Overrided method
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        // not username, it's user id in social network
        $username = $response->getUsername();
        // user entity field name, associated with id from social network
        $field = $this->getProperty($response);
        // setter for this id in user entity
        $method = 'set' . ucfirst($field);
        // is there same id in our db?
        $user = $this->userManager->findUserBy(
            array(
                $field => $username
            )
        );

        $service = $response->getResourceOwner()->getName();

        // lets add new user
        if (null === $user || null === $username) {
            try {
                $user = $this->userManager->createUser();

                $user->setUsername($username);
                $user->setEmail($response->getEmail());
                $user->setEnabled(1);
                // ugly hack. send email with password should be here?
                $user->setPassword('123456');

                if(method_exists($user, $method)) {
                    $user->$method($username);
                }
            } catch (\Exception $e) {
                throw new AccountNotLinkedException(sprintf("User '%s' not found.", $username));
            }
        }
        // let's return normal user
        return $user;
    }
}