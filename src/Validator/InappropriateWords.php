<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class InappropriateWords extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    //On crée un constructeur qui reçoit la liste des mots et le message approrpié quand ca ne va pas
    //Je lui rajoute aussi les paramètres que réçoit le constructeur parent
    //a l'interieur on appel le constructeur parent
    public function __construct(public array $listWords = ['merde','wesh','imbécile'], public string $message = 'This contains an inappropriate word "{{ inappropriateWord }}".', mixed $options = null, ?array $groups = null, mixed $payload = null)
    {
        parent::__construct($options, $groups, $payload);
    }
}