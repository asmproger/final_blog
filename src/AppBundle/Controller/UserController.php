<?php

namespace AppBundle\Controller;

use AppBundle\Entity\StaticPage;
use Application\Sonata\UserBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class UserController extends Controller
{
    /**
     * @Route("/people", name="people_page")
     * @param Request $request
     */
    public function peopleAction(Request $request)
    {
        $items = $this->getDoctrine()->getRepository(User::class)->findAll();
        $user = $this->getUser();
        return $this->render('user/people.html.twig', [
            'user' => $user,
            'items' => $items,
        ]);
    }

    /**
     * @Route("/follow", name="people_follow")
     * @param Request $request
     */
    public function followAction(Request $request)
    {
        /**
         * @var $user User
         * @var $friend User
         */
        $user = $this->getUser();
        if (!$user) {
            return new JsonResponse([
                'status' => false
            ], 401);
        }

        $mode = $request->get('mode', 1);
        $friend_id = $request->get('friend_id', 0);
        $friend = $this->getDoctrine()->getManager()->getRepository(User::class)->find($friend_id);

        if (!$friend_id) {
            return new JsonResponse([
                'status' => false
            ], 200);
        }

        if ($mode) {
            $user->addFriend($friend);
        } else {
            $user->removeFriend($friend);
        }

        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse([
            'status' => true
        ], 200);
    }

    /**
     * @Route("/", name="user_photo")
     */
    public function indexAction(Request $request)
    {

        /*$fakeStr = "{'exp': '2521454015','username': 'fake','iat': '2521450415'}";
        $fake = base64_encode($fakeStr);

        $fakeToken = "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXUyJ9" . $fake . "pklNyQhI9vSFx-pVTL_FE6kfzfQlwMHdpqM5gBDNpho4or02dFpRhlGqZSUoW1UNi6DgXR366Cq8gsdh_Cwe_D7jo6PAAqT1xByBSGpyDBectAxtD54xq-sLT5DL7oTHHXbZSgtFSmcFCOVNwAHeZxR-xez4mNyMVaJMihqx4Je7595hHGRp3GnMqTnRBAthffLxVEVFrS-00P4JL9lUxj9qQBqqvKCqdxZ674BDLYOL7FRPW7Wud0AYkTNOxWkPOwUuSW3IxWXnmly2Ghsc9hhGOLa6UbI-gGiQ_cZX4gW35ZHNaCrOTdx4IDpmmnX1VRC9dL_mSFXPNxN5-c2HjH0joDk1C3_VQwWciOUNa5dDNuFuITx7K_uIKURPX0xd-2t217w8l8Gz4pqOzWlGsT-ajKyscX4c6ZuU2KtZuwsgE40_1MxcreDGaR4gJ1VsgYwwISACX0ISELKfdTdgRDpxgy9nIMIjS0yIIGxQtCneNJuildnuG0LDTsvoO57_5F1rf0sLpWUoc6JC7YxTGCLuLiNyn93uqJdTuQUYf_TPrbAUFs7jWKABHOhp4rLqWEKhAfMjozJWUC7rtIALTUuJGpbwM8QbrYZ4TQg6TVY9VNyCphwmgM3Uhtu";
        die($fakeToken);

        $tokenSrc = "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXUyJ9.eyJleHAiOjE1MjE0NTQwMTUsInVzZXJuYW1lIjoic2RzZGZzZGYiLCJpYXQiOiIxNTIxNDUwNDE1In0.pklNyQhI9vSFx-pVTL_FE6kfzfQlwMHdpqM5gBDNpho4or02dFpRhlGqZSUoW1UNi6DgXR366Cq8gsdh_Cwe_D7jo6PAAqT1xByBSGpyDBectAxtD54xq-sLT5DL7oTHHXbZSgtFSmcFCOVNwAHeZxR-xez4mNyMVaJMihqx4Je7595hHGRp3GnMqTnRBAthffLxVEVFrS-00P4JL9lUxj9qQBqqvKCqdxZ674BDLYOL7FRPW7Wud0AYkTNOxWkPOwUuSW3IxWXnmly2Ghsc9hhGOLa6UbI-gGiQ_cZX4gW35ZHNaCrOTdx4IDpmmnX1VRC9dL_mSFXPNxN5-c2HjH0joDk1C3_VQwWciOUNa5dDNuFuITx7K_uIKURPX0xd-2t217w8l8Gz4pqOzWlGsT-ajKyscX4c6ZuU2KtZuwsgE40_1MxcreDGaR4gJ1VsgYwwISACX0ISELKfdTdgRDpxgy9nIMIjS0yIIGxQtCneNJuildnuG0LDTsvoO57_5F1rf0sLpWUoc6JC7YxTGCLuLiNyn93uqJdTuQUYf_TPrbAUFs7jWKABHOhp4rLqWEKhAfMjozJWUC7rtIALTUuJGpbwM8QbrYZ4TQg6TVY9VNyCphwmgM3Uhtu";
        $token = "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXUyJ9";
        //$token = "eyJleHAiOjE1MjE0NTQwMTUsInVzZXJuYW1lIjoic2RzZGZzZGYiLCJpYXQiOiIxNTIxNDUwNDE1In0";
        print_r(base64_decode($token));
        die;*/

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }
}
