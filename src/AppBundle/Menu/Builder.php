<?php

namespace AppBundle\Menu;

use AppBundle\Entity\Post;
use Doctrine\ORM\EntityManager;
use Knp\Menu\FactoryInterface;
use Knp\Menu\MenuFactory;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\RequestStack;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;
    private $factory;
    private $requestStack;
    private $entityManager;

    public function __construct(FactoryInterface $factory, RequestStack $requestStack, EntityManager $entityManager) {
        $this->factory = $factory;
        $this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
    }

    public function breadcrumbsMenu(array $options) {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute("class" , "blog-breadcrumb-menu");
        $menu
            ->addChild('Blog', ['route' => 'post_index'])
            ->setLinkAttribute('class', 'blog-breadcrumb-item-main blog-breadcrumb-item')
        ;

        $request = $this->requestStack->getCurrentRequest();
        $route = $request->get('_route');
        switch($route) {
            case 'post_show':
                $id = $request->get('id');
                $post = $this->entityManager->getRepository(Post::class)->find($id);
                if($post) {
                    $menu
                        ->addChild($post->getTitle(), [])
                        ->setAttribute('class', 'blog-breadcrumb-item blog-breadcrumb-item-child')
                        //->setLinkAttribute('class', 'blog-breadcrumb-item blog-breadcrumb-item-child')
                    ;
                }
                break;
            case 'post_new':
                $menu
                    ->addChild('Add new post', ['route' => 'post_new'])
                    ->setAttribute('class', 'blog-breadcrumb-item blog-breadcrumb-item-child')
                ;
                break;
            case 'post_edit':
                break;
            default:
        }

        return $menu;
    }

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu
            ->addChild('Home', ['route' => 'homepage'])
            ->setLinkAttribute('class', 'blog-nav-item')
        ;

// access services from the container!
        $em = $this->container->get('doctrine')->getManager();
// findMostRecent and Blog are just imaginary examples
//        $blog = $em->getRepository('AppBundle:Blog')->findMostRecent();
//
//        $menu->addChild('Latest Blog Post', array(
//            'route' => 'blog_show',
//            'routeParameters' => array('id' => $blog->getId())
//        ));

// create another menu item
        //$menu->addChild('About Me', array('route' => 'about'));
// you can also add sub level's to your menu's as follows
        //$menu['About Me']->addChild('Edit profile', array('route' => 'edit_profile'));

// ... add more children

        return $menu;
    }
}