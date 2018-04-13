<?php
/**
 * Created by PhpStorm.
 * User: sovkutsan
 * Date: 4/2/18
 * Time: 10:06 AM
 */

namespace AppBundle\EventListener;

use AppBundle\Entity\Image;
use AppBundle\Entity\Profile;
use AppBundle\Entity\Profession;
use Application\Sonata\UserBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use FOS\UserBundle\Event\FilterUserResponseEvent;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\HttpFoundation\RequestStack;

class DoctrineListener
{
    private $entityManager;
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function postPersist(LifecycleEventArgs $event)
    {
        /**
         * @var Profile $profile
         * @var Profession $profession
         */
        $entity = $event->getEntity();

        if (!($entity instanceof Profile)) {
            return;
        }

        $request = $this->requestStack->getCurrentRequest();
        $params = $request->get('custom_registration_form');
        $images_ids = (isset($params['image_id']) ? $params['image_id'] : '');
        $images_ids = explode(',',$images_ids);

        $images = $event->getEntityManager()->getRepository(Image::class)->findBy([
            'id' => $images_ids
        ]);
        foreach($images as $image) {
            $image->setProfile($entity);
            $event->getEntityManager()->persist($image);
        }
        $event->getEntityManager()->flush();
    }

    public function prePersist(LifecycleEventArgs $event)
    {
        /**
         * @var User $entity
         * @var Profile $profile
         * @var Profession $profession
         */
        $entity = $event->getEntity();

        if (!($entity instanceof User)) {
            return;
        }

        $profile = $entity->getProfile();
        $profession = $profile->getProfession();

        if (!$profession || !($profession instanceof Profession) || $profession->getId()) {
            return;
        }

        $profession = $profession->getTitle();

        $prof = $event->getEntityManager()
            ->getRepository(Profession::class)
            ->findOneBy(['title' => $profession]);

        if (is_null($prof)) {
            $prof = new Profession();
            $prof->setTitle($profession);
            $prof->setCode($profession);

        }
        $profile->setProfession($prof);
    }
}