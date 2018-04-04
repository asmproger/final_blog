<?php
/**
 * Created by PhpStorm.
 * User: sovkutsan
 * Date: 4/4/18
 * Time: 9:52 AM
 */

namespace AppBundle\Utils;


use AppBundle\Entity\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\EntityManager;

class FileUploader
{
    private $entityManager;
    private $directory;

    public function __construct(EntityManager $entityManager, $directory)
    {
        $this->entityManager = $entityManager;
        $this->directory = $directory;
    }

    public function uploadImage(UploadedFile $file, array $params = [])
    {
        $defaults = [
            'newName' => md5($file->getBasename() . time() . mt_rand(-9999, 9999)) . '.' . $file->guessExtension(),
            'title' => 'Title #' . md5(time() . $file->getBasename())
        ];
        $params = array_merge($defaults, $params);
        if ($file->isValid()) {
            $file->move($this->directory, $params['newName']);
            $image = new Image();
            $image->setTitle($params['title']);
            $image->setPath($params['newName']);
            try {
                $this->entityManager->persist($image);
                $this->entityManager->flush($image);
                return $image;
            } catch (\Exception $e) {
                // silent exception
            }
        }
        return false;
    }
}