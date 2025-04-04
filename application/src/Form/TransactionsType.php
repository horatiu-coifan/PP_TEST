<?php

namespace App\Form;

use App\Entity\Clients;
use App\Entity\Products;
use App\Entity\Transactions;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransactionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('amount')
            ->add('date', null, [
                'widget' => 'single_text',
            ])
            ->add('status')
            ->add('ins_date', null, [
                'widget' => 'single_text',
            ])
            ->add('ins_uid')
            ->add('mod_date', null, [
                'widget' => 'single_text',
            ])
            ->add('mod_uid')
            ->add('deleted')
            ->add('product', EntityType::class, [
                'class' => Products::class,
                'choice_label' => 'id',
            ])
            ->add('client', EntityType::class, [
                'class' => Clients::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transactions::class,
        ]);
    }
}
