<?php
/**
 * Created by PhpStorm.
 * User: sovkutsan
 * Date: 4/9/18
 * Time: 11:56 AM
 */

namespace AppBundle\Form\DataTransformer;


use AppBundle\Entity\Profession;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ProfessionToStringDataTransformer implements DataTransformerInterface
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function transform($item)
    {
        if (null == $item || !($item instanceof Profession)) {
            return null;
        }

        return $item->getTitle();
    }

    public function reverseTransform($value)
    {
        if(!$value) {
            return null;
        }

        $item = $this->entityManager->getRepository(Profession::class)->getProfession($value);

        if(empty($item)) {
            $item = new Profession();
            $item->setTitle($value);
            $item->setCode($value);
            $this->entityManager->persist($item);
            $this->entityManager->flush();
        }

        return $item;
    }
}