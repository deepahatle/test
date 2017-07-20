<?php

namespace VT\LabsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use VT\VTCoreBundle\Controller\VTController;
use VT\VTCoreBundle\Services\Doctrine\SoftDeleteFilter;
use VT\VTCoreBundle\Services\Utils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\PhpBridgeSessionStorage;

class DashboardController extends VTController
{
    /**
     * @Route("/admin/dashboard", name="dashboard_render")
     *
     * @param $request Request
     */
    public function dashboardRenderAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            throw $this->createAccessDeniedException();
        } else {
            $sessionUser = $this->getUser();
            $loggedInUser = $sessionUser->getName();
            $loggedInUserType = $sessionUser->getUserType();
            if($loggedInUserType != 'Admin') {
                $this->get('security.token_storage')->setToken(null);
                $request->getSession()->invalidate();
                $request->getSession()
                    ->getFlashBag()
                    ->add('error', 'Invalid User Type');
                return $this->redirectToRoute('backend_admin_login');           
            }

            $labUser = $this->getRepository('LabsBundle:Lab')->findOneBy(array('login' => $sessionUser->getId()));
            $labUserID = $labUser->getId();
            $labUserName = $labUser->getName();
            $session = new Session(new PhpBridgeSessionStorage());
            $session->start();            
            $session->set('labID', $labUserID);

            $recentPatients = $this->getRepository('UsersBundle:UserVisit')->fetchPatientsByFilter(['pageSpec' => ['currentPage' => 1, 'pageSize' => 10]]);
            $pendingPayments = $this->getRepository('UsersBundle:UserVisit')->fetchPatientsByPendingPayments();
            $samplesUnderTesting = $this->getRepository('UsersBundle:UserVisit')->fetchPatientsBySamplesUnderTesting();
            
            return $this->render('LabsBundle:Dashboard:dashboard_render.html.twig', json_decode(json_encode(array(
                   'user' => $labUserName,
                   'pendingPayments' => $pendingPayments,
                   'recentPatients' => $recentPatients['patients'],
                   'samplesUnderTesting' => $samplesUnderTesting
                   )
                ), true)
            );

        }
    }

    /**
     * @Route("/user/dashboard", name="user_dashboard_render")
     *
     * @param $request Request
     */
    public function userDashboardRenderAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            throw $this->createAccessDeniedException();
        } else {
            $sessionUser = $this->getUser();
            $loggedInUser = $sessionUser->getName();
            $loggedInUserType = $sessionUser->getUserType();

            if($loggedInUserType != 'Patient') {
                $this->get('security.token_storage')->setToken(null);
                $request->getSession()->invalidate();
                $request->getSession()
                    ->getFlashBag()
                    ->add('error', 'Invalid User Type');
                return $this->redirectToRoute('user_login');
            }

            // User 
            $user = $this->getRepository('UsersBundle:User')->findOneBy(array('login' => $sessionUser->getId()));

            // User Visit
            $userVisit = $this->getEntityManager(array(SoftDeleteFilter::$filterName))->getRepository('UsersBundle:UserVisit')->findBy(
                array('user' => $user, 'enableViewForUser' => 'Yes', 'status' => 'Report Delivered'),
                array('created' => 'DESC')
                );

            foreach ($userVisit as $visit) {
                $tests = $this->getEntityManager(array(SoftDeleteFilter::$filterName))->getRepository('UsersBundle:UserVisitTests')->findBy(array('userVisit' => $visit->getId()));
                $tests = json_decode(json_encode($tests));
                foreach ($tests as $test) {
                    // if($test->name == 'CHOLESTEROL/LDL RATIO' || $test->name == 'HEMOGLOBIN (HGB)')
                        if($test->actualValue != null)
                            $testData[$test->name][] = $test;
                }
            }

            return $this->render('LabsBundle:Dashboard:user_dashboard_render.html.twig', array(
               'user' => $loggedInUser,
               'testData' => $testData
               )
            );

        }
    }

}
