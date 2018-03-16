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
 * Class providing a bridge to use the FOSUB user provider with HWIOAuth.
 *
 * In order to use the class as a connector, the appropriate setters for the
 * property mapping should be available.
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
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $username = $response->getUsername();
        /*
         * Array (
         * [id] => 113454264037914863245   ---  $response->getUsername()
         * [email] => asmproger@gmail.com
         * [verified_email] => 1
         * [name] => Кирилл Совкуцан
         * [given_name] => Кирилл
         * [family_name] => Совкуцан
         * [link] => https://plus.google.com/113454264037914863245
         * [picture] => https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg
         * [gender] => male
         * [locale] => ru
         * )
         */

        /**
         * $this->getProperty($response)   -   return gplusUid from config file.
         * as i understand, getusername returns social provider id, so we should search in our db whith id field
         */
        /**
         * @var \Sonata\UserBundle\Entity\UserManager $wtf
         */
        $user = $this->userManager->findUserBy(
            array(
                $this->getProperty($response) => $username
            )
        );
        //echo $this->getProperty($response) . '<br/>' . $username . '<br/>';

        //die(gettype($user));
        if (null === $user || null === $username) {
            try {
                $user = $this->userManager->createUser();
                $user->setUsername($response->getEmail());
                $user->setEmail($response->getEmail());
                $user->googleUid = $response->getUsername();
                $user->setEnabled(1);
                $user->setPassword('123456');


            } catch (\Exception $e) {
                throw new AccountNotLinkedException(sprintf("User '%s' not found.", $username));
            }
        }

        return $user;
    }
}