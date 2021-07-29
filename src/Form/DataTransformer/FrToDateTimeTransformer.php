<?php

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class FrToDateTimeTransformer implements DataTransformerInterface{

    // transforme les données originelles pour qu'elles puissent s'afficher dans un formulaire
    public function transform($date){

        if($date === null){

            return '';

        }
        // on retourne une date ne fr
        return $date->format('d/m/Y');

    }

    // c'est l'inverse : elle prend la donnée qui arrive du formulaire et la remet dans le format qu'on attend
    public function reverseTransform($dateFr){

        // date en fr
        if($dateFr === null){

            //exception
            throw new TransformationFailedException("Fournir une date");
        }

        $date = \DateTime::createFromFormat('d/m/Y',$dateFr);

        if($date === false){

            //exception
            throw new TransformationFailedException("Le format de la date n'est pas correct");
        }

        return $date;

    }

}