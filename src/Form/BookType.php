<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('author')
            ->add('isbn')
            ->add('stock')
            ->add('short_description')
            ->add('image', FileType::class, [
                'label' => 'Couverture',
                'mapped' => false,
                'required' => false,
                'constraints'=>[
                    new File(
                        maxSize : '1024k',
                        mimeTypes : [
                            'image/jpeg',
                            'image/png',
                            'image/jpg',
                            'image/webp',
                        ],
                        maxSizeMessage : 'Votre image excède 1024ko',
                        mimeTypesMessage : 'Veuillez choisir un fichier de type image valide(jpeg, png, jpg, webp)!!',
                    )
                ]
            ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
