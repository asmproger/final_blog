<?php
/**
 * Created by PhpStorm.
 * User: sovkutsan
 * Date: 3/14/18
 * Time: 5:03 PM
 */

namespace AppBundle\Admin;

use AppBundle\Entity\StaticPage;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class StaticPageAdmin extends AbstractAdmin
{
    public $baseRouteName = 'static-page';
    public $baseRoutePattern = 'static-page';

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', TextType::class)
            ->add('slug', TextType::class)
            ->add('short', TextType::class)
            ->add('body', TextType::class);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('slug');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('slug')
            ->add('short');
    }

    public function toString($object)
    {
        /**
         * @var $object StaticPage
         */
        if ($object) {
            return $object->getTitle();
        }
    }

}