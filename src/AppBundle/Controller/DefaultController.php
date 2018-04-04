<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Image;
use AppBundle\Entity\StaticPage;
use AppBundle\Event\CustomEvent;
use AppBundle\Form\RegistrationType;
use AppBundle\Utils\FileUploader;
use Application\Sonata\UserBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        /**
         * @var \Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher $dispatcher
         */
        $event = new CustomEvent('WTF, BRO!');
        $dispatcher = $this->get('event_dispatcher');
        $dispatcher->dispatch(CustomEvent::EVENT_NAME, $event);

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/restricted", name="restricted")
     */
    public function restrictedAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/restricted.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/page/{slug}", name="static_page")
     * @param Request $request
     */
    public function pageAction(Request $request)
    {
        $slug = $request->get('slug', '');

        $page = $this->getDoctrine()->getRepository(StaticPage::class)->findOneBy(['slug' => $slug]);

        if (!$page || !$slug) {
            throw new \Exception("Page not found");
        }

        return $this->render('default/page.html.twig', [
            'page' => $page
        ]);
    }

    /**
     * @Route("/upload-photo", name="upload_photo")
     */
    public function uploadPhotoAction(Request $request)
    {
        /**
         * @var \Symfony\Component\HttpFoundation\FileBag $files
         * @var \Symfony\Component\HttpFoundation\File\UploadedFile $img
         * @var \AppBundle\Utils\FileUploader $uploader
         */
        $files = $request->files;
        $imageArray = $files->get('custom_registration_form');
        if (isset($imageArray['photo_control'])) {
            $img = $imageArray['photo_control'];
            $uploader = $this->get('custom.file.uploader');
            $image = $uploader->uploadImage($img);
            $response = null;
            if (null !== $image) {

                $imagesPath = $this->getParameter('images_directory');

                return new JsonResponse([
                    'status' => true,
                    'data' => [
                        'id' => $image->getId(),
                        'image' => '/uploaded_images/' . $image->getPath()
                    ]
                ], 200);
            } else {
                return new JsonResponse(['status' => false]);;
            }
        } else {
            $response = new JsonResponse(['status' => false]);
            return $response;
        }
    }
}