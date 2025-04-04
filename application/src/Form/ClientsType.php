<?php

namespace App\Form;

use App\Entity\Clients;
use App\Entity\County;
use App\Entity\Login;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cui')
            ->add('name')
            ->add('address')
            ->add('city')
            ->add('ins_date', null, [
                'widget' => 'single_text',
            ])
            ->add('ins_uid')
            ->add('mod_date', null, [
                'widget' => 'single_text',
            ])
            ->add('mod_uid')
            ->add('deleted')
            ->add('county', EntityType::class, [
                'class' => County::class,
                'choice_label' => 'id',
            ])
            ->add('credentials', EntityType::class, [
                'class' => Login::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Clients::class,
        ]);
    }
}
