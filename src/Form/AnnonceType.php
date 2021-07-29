<?php

namespace App\Form;

use App\Entity\Ad;
use App\Form\ImageType;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AnnonceType extends ApplicationType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class,$this->getConfiguration('Titre','Insérer un titre'))
            ->add('slug',TextType::class,$this->getConfiguration('Alias','Personnaliser un alias pour générer l\'url',['required'=>false]))
            ->add('coverImage',UrlType::class,$this->getConfiguration('Image de couverture','Insérer une image'))
            ->add('introduction',TextType::class,$this->getConfiguration('Résumé','Présentation du plat'))
            ->add('content',TextareaType::class,$this->getConfiguration('Description détaillée','Déscription détaillée du plat'))
            ->add('price',MoneyType::class,$this->getConfiguration('Prix','Prix du plat/personne'))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
