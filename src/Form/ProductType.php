<?php
namespace App\Form;


use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProductType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add("id", TextType::class)
            ->add("name", TextType::class, array('constraints'=>[new NotBlank()]))
            ->add("reserved", TextType::class, array('data'=>0))
            ->add("price", NumberType::class, array('constraints'=>[new NotBlank()]))
            ->add("preference", NumberType::class, array('constraints'=>[new NotBlank()]))
            ->add("url", UrlType::class, array('constraints'=>[new NotBlank()]))
            ->add("list", TextType::class, array('constraints'=>[new NotBlank()]));
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            "data_class" => Product::class
        ]);
    }
}