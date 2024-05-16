<?php

namespace App\Form;

use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\String\Slugger\AsciiSlugger;

class   FormListenerFactory {

    public function autoSlug(string $field): callable   {

        return function (PostSubmitEvent $event) use ($field) {
            $data=$event->getData();
            $slugger= new AsciiSlugger();
            $data->setSlug(strtolower($slugger->slug($data->getName())));
        };


    }

    public function timestamps(): callable  {   

        return function (PostSubmitEvent $event) {

            $data=$event->getData();
            $data->setUpdatedAt(new \DateTimeImmutable());
            if (!$data->getId()) 
            $data->setCreatedAt(new \DateTimeImmutable());

        };

    }
    
}