<?php

namespace FMSCommunication\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;


class CoreController extends Controller
{
    public function indexAction()
    {
        return $this->render('CoreBundle:Core:index.html.twig');
    }

    public function contactAction(Request $request)
    {
        $formBuilder = $this->createFormBuilder();
        $formBuilder
            ->add('name',       TextType::class, array('attr' => array('placeholder' => 'Nom',)))
            ->add('surname',    TextType::class, array('attr' => array('placeholder' => 'Prénom',)))
            ->add('email',      EmailType::class, array('attr' => array('placeholder' => 'Email',)))
            ->add('message',    TextareaType::class, array('attr' => array('placeholder' => 'Message',)))
            ->add('save',       SubmitType::class)
        ;
        $form = $formBuilder->getForm();
        if ($form->handleRequest($request)->isValid()) {
            $message = \Swift_Message::newInstance()
                ->setSubject('Nouveau message envoyer depuis fmscommunication.fr')
                ->setFrom('noreply@fmscommunication.fr')
                ->setTo('contact@fmscommunication.fr')
                ->setBody(
                    $this->renderView(
                        // app/Resources/views/Emails/registration.html.twig
                        'Emails/contact.html.twig',
                        array(
                            'name'      => $form->getData()['name'],
                            'surname'   => $form->getData()['surname'],
                            'email'     => $form->getData()['email'],
                            'message'   => $form->getData()['message'],
                            'date'      => date('d/m/Y H:i:s'))
                    ),
                    'text/html'
                )
            ;
            //return var_dump($message);
            $this->get('mailer')->send($message);
            $request->getSession()->getFlashBag()->add('success', "Le message a bien été envoyer.");
            return $this->redirect($this->generateUrl('core_homepage'));
        }

            return $this->render('CoreBundle:Core:contact.html.twig', array(
            'form'  => $form->createView(),
        ));
    }
}
