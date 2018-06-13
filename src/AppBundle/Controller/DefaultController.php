<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Profession;
use AppBundle\Entity\Profile;
use AppBundle\Entity\StaticPage;
use AppBundle\Event\CustomEvent;
use AppBundle\Form\RegistrationType;
use AppBundle\Utils\FileUploader;
use Application\Sonata\UserBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Stripe\Charge;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Test2;
use AppBundle\Entity\Test3;

class DefaultController extends Controller
{

    /**
     * @Route("/product", name="product")
     */
    public function productAction(Request $request  ) {
        $price = mt_rand(10, 1000);
        $id = mt_rand(10, 1000);

        return $this->render('default/product.html.twig', [
            'success' => $request->get('success', 0),
            'price' => $price,
            'id' => $id,
        ]);
    }

    /**
     * @Route("/charge", name="charge")
     */
    public function chargeAction(Request $request)
    {
        $tokenId = $request->get('stripeToken', null);
        $price = $request->get('price', 0);
        $id = $request->get('id', 0);

        if(!$tokenId) {
            throw new \InvalidArgumentException("Invalid token provided");
        }

        Stripe::setApiKey('sk_test_KmFcDM51ukyxta34VOnmvtf1');

        try {
            /**
             * @var Charge $charge
             */
            $charge = Charge::create(array(
                'amount' => $price,
                'currency' => 'usd',
                'description' => 'Test',
                'source' => $tokenId,
                'statement_descriptor' => 'statement descriptor'
            ));
            $em = $this->getDoctrine()->getManager();

            // save charge
            $chargeObj = new \AppBundle\Entity\Charge();
            $chargeObj->setChargeId($charge->offsetGet('id'));
            $chargeObj->setProductId($id);
            $chargeObj->setAmount($price);

            $card = $charge->offsetGet('card');
            if($card) {
                // save card
                $cardObj = new \AppBundle\Entity\Card();
                $cardObj->setCardId($card->offsetGet('id'));
            }

            $em->persist($chargeObj);
            $em->persist($cardObj);
            $em->flush();

            // @TODO save charge to database
            return $this->redirect($this->generateUrl('product', array('success' => true)));
        } catch (\Exception $e) {
            dump($e->getTraceAsString());
            die($e->getMessage());
        }


        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }



    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {


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
        if (isset($imageArray['photo_control']) && !empty(isset($imageArray['photo_control']))) {
            $response = [];
            foreach ($imageArray['photo_control'] as $img) {
                $uploader = $this->get('custom.file.uploader');
                $image = $uploader->uploadImage($img);
                if (null !== $image) {
                    $response[] = [
                        'id' => $image->getId(),
                        'image' => '/uploaded_images/' . $image->getPath()
                    ];
                } else {
                    return new JsonResponse(['status' => false]);
                }
            }
            if (!empty($response)) {
                return new JsonResponse([
                    'status' => true,
                    'data' => $response
                ], 200);
            }
        } else {
            $response = new JsonResponse(['status' => false]);
            return $response;
        }
    }
}