<?php

namespace App\Form;

use App\Entity\Articles;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                "attr" => [
                    'class' => 'form-control',
                    'placeholder' => "Nom de nouvel article"
                ],
                "required" => true,
            ])
            ->add('description', TextareaType::class, [
                "attr" => [
                    'class' => 'form-control',
                    'placeholder' => "Décrire le nouvel article "
                ],
                "required" => true,
            ])
            ->add('prix', NumberType::class, [
                "attr" => [
                    'class' => 'form-control',
                    'placeholder' => "Le prix de nouvel article"
                ],
                "required" => true,
            ])
            ->add('nombresEnStock', NumberType::class, [
                "attr" => [
                    'class' => 'form-control',
                    'placeholder' => "Nombres de cet article dans le stock"
                ],
                "required" => true,
            ]);
        // ->add('categorie', NumberType::class, [
        //     "attr" => [
        //         'class' => 'form-control',
        //         'placeholder' => "Catégorie à laquelle cet article appartient",
        //     ],
        //     "required" => true,
        // ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
