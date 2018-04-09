<?php

namespace AppBundle\Form;

use AppBundle\Entity\Profile;
use AppBundle\Entity\Sex;
use AppBundle\Form\DataTransformer\ProfessionToStringDataTransformer;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /*->add('profession', CollectionType::class, [
                'entry_type' => ProfessionType::class,
                'entry_options' => array('label' => false),
            ])*/
            ->add('profession', ProfessionType::class, [
                'required' => false
                ])
            ->add('sex', EntityType::class, [
                'class' => Sex::class,
                'choice_label' => 'title'
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Profile::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_profile';
    }


}
