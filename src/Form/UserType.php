<?php
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add("username", EmailType::class, array(
                "constraints" => [new NotBlank()],
                "attr" => [
                    "class" => "form-control",
                    "placeholder" => "Your unique username"
                ]
            ))
            ->add("plainPassword", RepeatedType::class, array(
                "type" => PasswordType::class,
                "first_options" => [
                    "label" => "Password",
                    "attr" => [
                        "class" => "form-control",
                        "placeholder" => "Type a smart password"
                    ]
                ],
                "second_options" => [
                    "label" => "Repeat password",
                    "attr" => [
                        "class" => "form-control",
                        "placeholder" => "Retype that smart password"
                    ]
                ],
                "constraints" => [new NotBlank()]
            ));
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            "data_class" => User::class
        ]);
    }
}