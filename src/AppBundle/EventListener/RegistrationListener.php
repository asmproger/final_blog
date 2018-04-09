<?php
/**
 * Created by PhpStorm.
 * User: sovkutsan
 * Date: 4/2/18
 * Time: 10:06 AM
 */

namespace AppBundle\EventListener;

use AppBundle\Entity\Image;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Application\Sonata\UserBundle\Entity\User;
class RegistrationListener
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function onFosUserRegistrationCompleted(FilterUserResponseEvent $event)
    {
        /**
         * @var User $user
         */
        $params = $event->getRequest()->request->get('custom_registration_form');
        $image_id = intval(isset($params['image_id']) ? $params['image_id'] : 0);

        $user = $event->getUser();

        $image = $this->entityManager->getRepository(Image::class)->find($image_id);
        $user->setImage($image);

        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush($user);
        } catch (ORMException $e) {
            die('Register listener er: ' . $e->getMessage());
        }
    }
}