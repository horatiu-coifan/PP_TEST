<?php

namespace App\Form;

use App\Entity\Clients;
use App\Entity\County;
use App\Entity\Login;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Clients1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('credentials', EntityType::class, [
                'class' => Login::class,
                'choice_label' => 'username',
            ])
            ->add('name')
            ->add('cui')
            
            ->add('address')
            ->add('city')
            ->add('county', EntityType::class, [
                'class' => County::class,
                'choice_label' => 'name',
            ])
            ->add('ins_date', null, [
                'widget' => 'single_text',
                'disabled' => true,
            ])
            ->add('mod_date', null, [
                'widget' => 'single_text',
                'disabled' => true,
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
