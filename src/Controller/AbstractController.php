<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as CoreAbstractController;
use Symfony\Component\Form\FormInterface;

class AbstractController extends CoreAbstractController
{
    /**
     * Extract form errors into a more meaningful array
     *
     * @param FormInterface $form
     * @return array
     */
    protected function getFormErrors(FormInterface $form): array
    {
        $errors = [];
        foreach ($form->getErrors(true) as $error) {
            $errors[] = $error->getMessage();
        }
        return $errors;
    }
}