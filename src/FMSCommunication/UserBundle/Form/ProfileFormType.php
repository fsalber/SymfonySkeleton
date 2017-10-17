<?php

namespace FMSCommunication\UserBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;

class ProfileFormType extends BaseType
{
    public function buildUserForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildUserForm($builder, $options);

        $builder
            ->add('last_name')
            ->add('first_name')
            ->add('address')
            ->add('zipcode')
            ->add('city')
            ->add('country');
    }

    public function getParent()
    {
        return 'fos_user_profile';
    }

    public function getName()
    {
        return 'fms_user_profile';
    }
}