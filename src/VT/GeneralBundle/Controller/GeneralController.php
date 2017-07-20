<?php

namespace VT\GeneralBundle\Controller;

use VT\VTCoreBundle\Controller\VTController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class GeneralController extends VTController
{
    /**
     * @Route("/generalRender", name="general_render")
     */
    public function generalRenderAction()
    {
    	$generalData = $this->generalDataAction();
        return $this->render('GeneralBundle:General:general_render.html.twig', array('generalData' => $generalData));
    }

    public function generalDataAction(){
    	$loggedInUser = $this->getUser();
    	$generalData = array();

    	$expiry = $loggedInUser->getExpiry();
        $generalData['daysLeft'] = "";

        $currentDate = new \DateTime('now');
        $closeToExpiry = new \DateTime('now');
        $closeToExpiry->modify('31 days');

        if($expiry < $closeToExpiry){                    
            $diffDate = $currentDate->diff($expiry);
            $generalData['daysLeft'] = $diffDate->format('%a');
        }

        $isTrial = $loggedInUser->getIsTrial();
        if($isTrial == 'Yes'){
            $generalData['isTrial'] = true;
        }
    	else
    		$generalData['isTrial'] = false;

    	$labUser = $this->getRepository('LabsBundle:Lab')->findOneBy(array('login' => $loggedInUser->getId()));
    	if(empty($labUser->getAddress())	||
    		empty($labUser->getCity())		||
    		empty($labUser->getPincode())	||
    		empty($labUser->getDoctor())	||
    		empty($labUser->getSignature())	
    	)    		
    		$generalData['profileComplete'] = false;
    	else
    		$generalData['profileComplete'] = true;

    	return $generalData;
    }


    /**
     * @Route("/userGeneralRender", name="user_general_render")
     */
    public function userGeneralRenderAction()
    {
        $loggedInUser = $this->getUser();
        $user = $this->getRepository('LoginBundle:Login')->find($loggedInUser->getId());
        if($user->getCreatedBy() == $user->getLastUpdBy())
            $profileComplete = false;
        else
            $profileComplete = true;
        return $this->render('GeneralBundle:General:user_general_render.html.twig', array('profileComplete' => $profileComplete));
    }


    /**
     * @Route(path="/terms-condition", name="terms_condition_render")
     */
    public function termsConditionRenderAction()
    {
        return $this->render('GeneralBundle:General:terms_condition_render.html.twig', array());
    }

    /**
     * @Route(path="/disclaimer", name="disclaimer_render")
     */
    public function disclaimerRenderAction()
    {
        return $this->render('GeneralBundle:General:disclaimer_render.html.twig', array());
    }
}
