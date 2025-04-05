<?php

namespace App\Form;

use App\Entity\Clients;
use App\Entity\Products;
use App\Entity\Transactions;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Transactions1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('client', EntityType::class, [
                'class' => Clients::class,
                'choice_label' => 'name',
            ])
            ->add('product', EntityType::class, [
                'class' => Products::class,
                'choice_label' => 'name',
            ])
            ->add('amount')
            ->add('date', null, [
                'widget' => 'single_text',
            ])
            ->add('status')
            ->add('ins_date', null, [
                'widget' => 'single_text',
                'disabled' => true,
            ])
            // ->add('ins_uid')
            ->add('mod_date', null, [
                'widget' => 'single_text',
                'disabled' => true,
            ])
            // ->add('mod_uid')
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transactions::class,
        ]);
    }
}
