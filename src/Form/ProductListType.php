<?php
/**
 * Created by PhpStorm.
 * User: tiberiu.popovici
 * Date: 26.12.2017
 * Time: 23:29
 */

namespace App\Form;


use App\Entity\ProductsList;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProductListType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add("id", TextType::class, array())
            ->add("name", TextType::class, array('constraints'=>[new NotBlank()]))
            ->add("activeFrom", TextType::class, array('constraints'=>[new NotBlank()]))
            ->add("activeUntil", TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            "data_class" => ProductsList::class
        ]);
    }
}