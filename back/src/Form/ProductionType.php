<?php

namespace App\Form;

use App\Entity\Production;
use App\Service\TextFormatService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductionType extends AbstractType
{
    private $TextFormatService;

    public function __construct(TextFormatService $TextFormatService)
    {
        $this->TextFormatService = $TextFormatService;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label'     => 'Titre',
                'attr'      => [
                    'placeholder' => 'Titre'
                ]
            ])
            ->add('original_title', TextType::class, [
                'label'     => 'Titre original',
                'attr'      => [
                    'placeholder' => 'Titre original'
                ]
            ])
            ->add('slug', HiddenType::class, [
                'empty_data'    => 'test',
            ])
            ->add('imdb_id', HiddenType::class, [
                'empty_data'    => null
            ])
            ->add('type', ChoiceType::class, [
                'label'     => 'Type',
                'choices'   => [
                    'Film'      => 'movie',
                    'Série'     => 'tv'
                ]
            ])
            ->add('release_date', DateType::class, [
                'label'     => 'Date de sortie / première diffusion',
                'widget'    => 'single_text',
                'format'    => 'yyyy-MM-dd',
                'attr'      => [
                    'placeholder' => 'Date de sortie'
                ]
            ])
            ->add('duration', NumberType::class, [
                'label'     => 'Durée',
                'attr'      => [
                    'placeholder' => 'Durée',
                    'help'        => 'Durée en minutes'
                ]
            ])
            ->add('tagline', TextType::class, [
                'label'     => 'Slogan',
                'attr'      => [
                    'placeholder' => 'Slogan'
                ]
            ])
            ->add('synopsis', TextareaType::class, [
                'label'     => 'Synopsis',
                'attr'      => [
                    'placeholder' => 'Synopsis'
                ]
            ])
            ->add('poster', HiddenType::class, [
                'empty_data'    => 'https://via.placeholder.com/300x450.png?text=Pas+d\'image+disponible'
            ])
            ->add('backdrop', HiddenType::class, [
                'empty_data'    => 'https://via.placeholder.com/450x300.png?text=Pas+d\'image+disponible'
            ])
            ->add('trailer', HiddenType::class, [
                'empty_data'    => 'https://www.youtube.com/embed/0W0Wc1E8ffk'
            ])
            /* ->add('tags')
            ->add('countries') */;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Production::class,
        ]);
    }
}