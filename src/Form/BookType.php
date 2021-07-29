<?php

namespace App\Form;

use App\Entity\Book;
use App\Form\BookType;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Form\DataTransformer\FrToDateTimeTransformer;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BookType extends ApplicationType
{
    private $transformer;

    public function __construct(FrToDateTimeTransformer $transformer){

        $this->transformer = $transformer;

    }


    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $date = new \DateTime();
        $currentDate = $date;
        $endDate = $date->modify('+5 years');
        $builder
            ->add('startDate',DateType::class,['label'=>'Date de réservation',
                                                'format'=>'dd MM yyyy',
                                                'years'=>range(date('Y'),$endDate->format('Y')),
                                                'placeholder'=>['year'=>'année','month'=>'mois','day'=>'jour']])
            ->add('time',TimeType::class,$this->getConfiguration("Horaire","Horaire de livraison souhaité"))
            ->add('guest',IntegerType::class,$this->getConfiguration("Nombre de couverts","Nombre de couverts souhaité",['required'=>true]))
            
        ;
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
