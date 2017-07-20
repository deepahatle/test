<?php

namespace VT\VTCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use VT\VTCoreBundle\Entity\VTEntityRepository;
use VT\VTCoreBundle\Services\Doctrine\VTEntityManager;
use VT\VTCoreBundle\Services\Utils;

class VTController extends Controller
{
    /**
     * @param string $data
     * @return Response
     */
    protected function getJsonResponse($data)
    {
        $response = new Response($data);
        $response->headers->set("Content-Type", "text/json");
        return $response;
    }

    /**
     *
     * @param string $entityName
     * @return VTEntityRepository
     *
     */
    protected function getRepository($entityName)
    {
        return $this->getEntityManager()->getRepository($entityName);
    }

    /**
     *
     * @param array $filtersToEnable
     * @return \Doctrine\ORM\EntityManager
     *
     */
    protected function getEntityManager($filtersToEnable = array())
    {
        return VTEntityManager::getInstance()->getEntityManager($filtersToEnable);
    }

    /**
     *
     * Returns the currently logged in user.
     *
     * @return \VT\UserBundle\Entity\User
     *
     */
    /*public function getUser()
    {
        $container = Utils::getContainer();

        if (!$container->has('security.token_storage')) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        if (null === $token = $container->get('security.token_storage')->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            return;
        }

        $user = VTEntityManager::getInstance()->getEntityManager(array())->getRepository("UserBundle:User")->find($user->getId());

        return $user;

    }*/

    public function sendEmail($parameters){

        $toEmail = $parameters['toEmail'];
        $toCC = $parameters['ccEmail']!=null?$parameters['ccEmail']:null;
        $toBcc = $parameters['bccEmail']!=null?$parameters['bccEmail']:null;

        if(!empty($toEmail)){
            $message = \Swift_Message::newInstance()
                ->setSubject($parameters['subject'])
//                ->setFrom('vitruviantechnologies@gmail.com')
                ->setFrom('info@lacaco.com');

            if(!empty($toEmail))
                $message->setTo($toEmail);
            if(!empty($toCC))
                $message->setCc($toCC);
            if(!empty($toBcc))
                $message->setBcc($toBcc);

            $message->setBody(
                    $this->renderView(
                        'Emails/'.$parameters['template'],
                        $parameters['data']
                    ),
                    'text/html')
            ;
            $this->get('mailer')->send($message);
        }

        return new Response("Email Sent");

    }
}
