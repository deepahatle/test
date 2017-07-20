<?php

namespace VT\HomeBundle\Controller;

use VT\VTCoreBundle\Controller\VTController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class HomeController extends VTController
{
    /**
     * @Route("/", name="home_render")
     */
    public function homeRenderAction()
    {
    	$latestPosts = '';
    	$request = Request::createFromGlobals();
    	$blogAPI = 'http://sugarlogger.com/blog/api/get_recent_posts/?count=5';
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $blogAPI);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	$server_output = curl_exec($ch);
    	curl_close($ch);
    	if ($server_output != '') {
    		$latestPosts = json_decode($server_output);
    	}

        return $this->render('HomeBundle:HomeController:home_render.html.twig', array('blogPosts' => $latestPosts));
    }

}
