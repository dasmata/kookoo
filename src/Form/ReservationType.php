<?php

namespace App\Form;


use App\Entity\Product;
use App\Entity\Reservation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ReservationType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add("name", TextType::class, array(
                "constraints" => [new NotBlank()]
            ))
            ->add("product", EntityType::class, array(
                "class" => Product::class,
                "constraints" => [new NotBlank()]
            ));
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            "data_class" => Reservation::class,
            "allow_extra_fields" => true
        ]);
    }

}