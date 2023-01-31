<?php

namespace App\Form;

use App\Entity\Ordered;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Votre nom...',
                ],
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre nom',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Votre nom doit comporter au moins {{ limit }} caractères',
                        'max' => 75,
                        'maxMessage' => 'Votre nom ne peut pas comporter plus de {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add(
                'firstname',
                TextType::class,
                [
                    'label' => 'Prénom',
                    'attr' => [
                        'placeholder' => 'Votre prénom...',
                    ],
                    'required' => true,
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez renseigner votre prénom',
                        ]),
                        new Length([
                            'min' => 3,
                            'minMessage' => 'Votre prénom doit comporter au moins {{ limit }} caractères',
                            'max' => 75,
                            'maxMessage' => 'Votre prénom ne peut pas comporter plus de {{ limit }} caractères',
                        ]),
                    ],
                ]
            )
            ->add('email', EmailType::class, [
                'label' => 'Adresse mail',
                'attr' => [
                    'placeholder' => 'Votre e-mail...',
                ],
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre email',
                    ]),
                    new Email(
                        [
                            'message' => 'Veuillez renseigner un email valide',
                        ]
                    )
                ],
            ])
            ->add(
                'phone',
                TelType::class,
                [
                    'label' => 'Téléphone',
                    'attr' => [
                        'placeholder' => 'Votre téléphone...',
                    ],
                    'required' => true,
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez renseigner votre téléphone',
                        ]),
                        new Length([
                            'min' => 10,
                            'minMessage' => 'Votre téléphone doit comporter au moins {{ limit }} caractères',
                            'max' => 10,
                            'maxMessage' => 'Votre téléphone ne peut pas comporter plus de {{ limit }} caractères',
                        ]),
                    ],
                ]

            )
            ->add(
                'zipcode',
                NumberType::class,
                [
                    'label' => 'Code postal',
                    'attr' => [
                        'placeholder' => 'Code postal...',
                    ],
                    'required' => true,
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez renseigner votre code postal',
                        ]),
                    ],
                ]
            )
            ->add(
                'city',
                TextType::class,
                [
                    'label' => 'Ville',
                    'attr' => [
                        'placeholder' => 'Ville...',
                    ],
                    'required' => true,
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez renseigner votre ville',
                        ]),
                    ],
                ]
            )
            ->add(
                'address',
                TextType::class,
                [
                    'label' => 'Adresse',
                    'attr' => [
                        'placeholder' => 'Adresse...',
                    ],
                    'required' => true,
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez renseigner votre adresse',
                        ]),
                    ],
                ]
            )
            ->add('comment', TextareaType::class, [
                'label' => 'Commentaire',
                'attr' => [
                    'placeholder' => 'Votre commentaire...',
                ],
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
       $resolver->setDefaults([
            'data_class' => Ordered::class,
        ]);
    }
}
