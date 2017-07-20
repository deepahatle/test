<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 13/06/17
 * Time: 10:11 AM
 */

namespace VT\GeneralBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use VT\GeneralBundle\Form\ContactUsType;
use VT\GeneralBundle\Form\Model\ContactUs;
use VT\VTCoreBundle\Controller\VTController;

class ContactusController extends VTController
{
    /**
     * @Route("/contact-us", name="contact_us_render")
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\Response
     */
    public function contactUsRenderAction(Request $request)
    {

        // build the form.
        $contactUs = new ContactUs();
        $form = $this->createForm(ContactUsType::class, $contactUs);

        // handle the form submit.
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $data = array(
                'name' => $form->getData()->getName(),
                'phoneNumber' => $form->getData()->getPhoneNumber(),
                'emailId' => $form->getData()->getEmailId(),
                'message' => $form->getData()->getMessage()
            );

            $msg = \Swift_Message::newInstance()
                ->setSubject("Contactus form filled")
                ->setFrom(['info@sugarlogger.com' => 'SugarLogger'])
                ->setTo(array('rajkumar.alchemist@gmail.com', 'harish.rk.patel@gmail.com'))
                ->setBody($this->renderView('Emails/email_contactus.html.twig', $data), 'text/html');

            $this->get('mailer')->send($msg);

            // having sent the email we need to render the thank you page.
            return $this->redirectToRoute('thank_you_render');

        }

        // render the form view.
        return $this->render(
            'GeneralBundle:Contact:contact_us_render.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function sendEmail($parameters)
    {
        $toEmail = $parameters ['toEmail'];
        $toCC = $parameters ['ccEmail'] != null ? $parameters ['ccEmail'] : null;
        $toBcc = $parameters ['bccEmail'] != null ? $parameters ['bccEmail'] : null;

        $response = "Email not sent";
        if (!empty($toEmail)) {

            $body = $this->renderView('Emails/' . $parameters ['template'], $parameters ['data']);
            $message = \Swift_Message::newInstance()
                ->setSubject($parameters ['subject'])
                ->setFrom($this->getParameter('company_email'));

            if (!empty($toEmail))
                $message->setTo($toEmail);
            if (!empty($toCC))
                $message->setCc($toCC);
            if (!empty($toBcc))
                $message->setBcc($toBcc);

            $message->setBody($body, 'text/html');
            $mailer = $this->get('mailer');
            $response = $mailer->send($message);
        }

        return $response;
    }

    /**
     * @Route("/thank-you", name="thank_you_render")
     */
    public function thankYouRenderAction()
    {
        return $this->render("GeneralBundle:Contact:thank_you_render.html.twig");
    }


}
