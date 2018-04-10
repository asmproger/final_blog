<?php
/**
 * Created by PhpStorm.
 * User: sovkutsan
 * Date: 4/2/18
 * Time: 10:20 AM
 */

namespace AppBundle\EventSubscriber;

use AppBundle\Entity\Profile;
use AppBundle\Event\CustomEvent;
use Application\Sonata\UserBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Workflow\Event\Event;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_COMPLETED => [
                ['afterRegistration']
            ]
        );
    }
    public function afterRegistration(FilterUserResponseEvent $event)
    {
        /**
         * @var User $user
         * @var Profile $profile
         */
        /*$user = $event->getUser();
        $profile = $user->getProfile();

        $params = $event->getRequest()->request->get('custom_registration_form');
        $images_ids = (isset($params['image_id']) ? $params['image_id'] : '');
        $images_ids = explode(',',$images_ids);

        $profile->setImages($images_ids);*/
    }
}