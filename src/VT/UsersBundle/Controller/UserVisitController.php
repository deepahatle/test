<?php

namespace VT\UsersBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use VT\UsersBundle\Entity\UserVisitTests;
use VT\LoginBundle\Entity\Login;
use VT\VTCoreBundle\Controller\VTController;
use VT\UsersBundle\Entity\UserVisit;
use Symfony\Component\HttpFoundation\JsonResponse;
use VT\VTCoreBundle\Services\Utils;
use VT\UsersBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use VT\UsersBundle\Form\PatientCreateType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class UserVisitController extends VTController
{
    /**
     * @Route("/admin/patients-visit-list", name="patient_record")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function patientRecordRenderAction()
    {
        $loggedInUser = $this->getUser();
        $lab = $this->getRepository('LabsBundle:Lab')->findOneBy(array('login' => $loggedInUser));

        return $this->render('UsersBundle:UserVisit:patient_record_render.html.twig', array('freeCredits' => $lab->getFreeCredits()));
    }

    /**
     * @Route("patient-data", name="patient_data")
     *
     * @param $request Request
     * @return array
     *
     */
    public function patientDataAction(Request $request)
    {
        $fullSpec = json_decode($request->getContent(), true);
        $patients = $this->getRepository('UsersBundle:UserVisit')->fetchPatientsByFilter($fullSpec);
        $patients = json_encode($patients);
        return $this->getJsonResponse($patients);
    }

    /**
     * @Route("/admin/add-patient-visit", name="add_patient_record")
     * @Template("UsersBundle:UserVisit:add_patient_record_render.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @param $request Request
     * @return array
     *
     */
    public function addPatientRecordRenderAction(Request $request)
    {
        // 1) build the form
        $patient = new UserVisitTests();
        $form = $this->createForm(PatientCreateType::class, $patient);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $userVisitData = $form->getData()->getUserVisit();
            $userVisit = new UserVisit();
            $userData = $userVisitData['user'];
            $em = $this->getDoctrine()->getManager();

            $existingUser = $this->getRepository('UsersBundle:User')->findOneBy(array('mobile' => $userData['mobile']));
            if ($existingUser) {
                $user = $existingUser;
            } else {
                $user = new User();
                $login = new Login();
                $login->setName($userData['name']);
                $login->setUsername($userData['email']);
                $login->setMobileNo($userData['mobile']);
                $login->setPassword($this->get('security.password_encoder')->encodePassword($login, $userData['mobile']));
                $login->setUserType('Patient');
                $login->setIsActive('Yes');
                $login->setRoles(array('ROLE_USER'));
                $this->setProspectFields($login);
                $em->persist($login);
                $em->flush();
                $user->setLogin($login);
            }

            $user->setName($userData['name']);
            $user->setEmail($userData['email']);
            $user->setMobile($userData['mobile']);
            $user->setAddress($userData['address']);
            $user->setCity($userData['city']);
            $user->setGender($userData['gender']);
            $user->setDob($userData['dob']);
            $this->setProspectFields($user);
            $em->persist($user);
            $em->flush();

            $loggedInUser = Utils::getContainer()->get("vt.aclmanager")->getUser();
            $labUser = $this->getRepository('LabsBundle:Lab')->findOneBy(array('login' => $loggedInUser->getId()));

            $userVisit->setLab($labUser);
            $userVisit->setUser($user);
            $userVisit->setDoctor($userVisitData['doctor']);
            // $userVisit->setTax();
            $userVisit->setTotalAmount($userVisitData['totalAmount']);
            $userVisit->setDiscount($userVisitData['discount']);
            $userVisit->setNetAmount($userVisitData['netAmount']);
            $userVisit->setPaidAmount($userVisitData['paidAmount']);

            $oldVisit = $this->getRepository('UsersBundle:UserVisit')->findOneBy(array('user' => $user, 'lab' => $labUser));
            $userVisit->setEnableViewForUser('No');
            $userVisit->setStatus('Sample Collected');
            $this->setProspectFields($userVisit);
            $em->persist($userVisit);
            $em->flush();

            $labTests = $this->getRepository('LabsBundle:LabTest')->fetchLabTests($form->getData()->getLabTest());

            // var_dump($labTests);die;
            foreach ($labTests as $labTest) {
                $userVisitTests = new UserVisitTests();
                $userVisitTests->setUserVisit($userVisit);
                $this->setProspectFields($userVisitTests);
                $userVisitTests->setLabTest($labTest);
                $em->persist($userVisitTests);
                $em->flush();
            }

            return $this->redirectToRoute('patient_record');
        }

        return array('form' => $form->createView());
    }

    public function setProspectFields(&$entity)
    {
        $todaysDate = new \DateTime('now');

        $loggedInUser = Utils::getContainer()->get("vt.aclmanager")->getUser();

        $entity->setCreated($todaysDate);
        $entity->setCreatedBy($loggedInUser->getName());
        $entity->setLastUpd($todaysDate);
        $entity->setLastUpdBy($loggedInUser->getName());
    }

    /**
     * @Route("testData", name="lab_test_data")
     *
     * @param Request $request
     * @return Response
     *
     */
    public function getLabTestData(Request $request)
    {
        $tests = $this->getRepository('LabsBundle:LabTest')->findAll();
        $response = $this->getJsonResponse(json_encode($tests));
        return $response;
    }

    /**
     * @Route("userByMobile", name="user_by_mobile")
     *
     * @param Request $request
     * @return Response
     *
     */
    public function userByMobile(Request $request)
    {
        $user = $this->getRepository('UsersBundle:User')->findOneBy(array('mobile' => $request->get('mobile')));
        $response = $this->getJsonResponse((json_encode($user)));
        return $response;
    }

    /**
     * @Route("testsByPatientId", name="tests_by_patient_id")
     *
     * @param Request $request
     * @return Response
     *
     */
    public function testsByPatientId(Request $request)
    {
        $tests = $this->getRepository('UsersBundle:UserVisitTests')->findBy(array('userVisit' => $request->get('id')));
        $response = $this->getJsonResponse((json_encode($tests)));
        return $response;
    }

    /**
     * @Route("updateUserVisit", name="update_user_visit")
     *
     * @param Request $request
     * @return Response
     *
     */
    public function updateUserVisitAction(Request $request)
    {
        $id = $request->get("id");
        $status = $request->get("status");
        $addAmt = $request->get("addAmt");
        $enableViewForUser = $request->get("enableViewForUser");

        /** @var UserVisit $userVisit */
        $userVisit = $this->getRepository("UsersBundle:UserVisit")->find($id);

        $em = $this->getDoctrine()->getManager();

        $result = '';
        if (!empty($status))
            $userVisit->setStatus($status);
        if (!empty($enableViewForUser)) {
            $userVisit->setEnableViewForUser('Yes');
            $userVisit->setStatus("Report Delivered");

            // every time a report is enabled to be viewed by the user
            // we send an email notifying the user that his / her report is now ready for viewing.
            if ($enableViewForUser == 'Yes') {
                // TODO: Send an email to the user. All user details should be there on the UserVisit entity.
                $user = $userVisit->getUser();

                if (!empty($user)) {
                    $email = $user->getEmail();

                    if (!empty($email) && isset($email)) {
                        $data = array(
                            "user" => $user,
                            "lab" => $userVisit->getLab(),
                            "userVisit" => $userVisit
                        );

                        $msg = \Swift_Message::newInstance()
                            ->setSubject("Report available !")
                            ->setFrom(['info@sugarlogger.com' => 'SugarLogger'])
                            ->setTo($userVisit->getUser()->getEmail())
                            ->setBody($this->renderView('Emails/email_report_available.html.twig', $data), 'text/html');

                        $this->get('mailer')->send($msg);
                    }
                }
            }
        }
        if (!empty($addAmt)) {
            $netAmount = $userVisit->getNetAmount();
            $paidAmount = $userVisit->getPaidAmount();
            if ($addAmt + $paidAmount > $netAmount)
                return $this->getJsonResponse(json_encode(array('msg' => false)));
            else
                $userVisit->setPaidAmount($paidAmount + $addAmt);
        }

        $todaysDate = new \DateTime('now');
        $loggedInUser = Utils::getContainer()->get("vt.aclmanager")->getUser();

        $userVisit->setLastUpd($todaysDate);
        $userVisit->setLastUpdBy($loggedInUser->getName());
        $em->persist($userVisit);
        $em->flush();

        $response = $this->getJsonResponse(json_encode(array('msg' => 'Updated')));
        return $response;
    }

    /**
     * @Route("updateUserVisitTests", name="update_user_visit_tests")
     *
     * @param Request $request
     * @return Response
     *
     */
    public function updateUserVisitTests(Request $request)
    {
        $tests = json_decode($request->getContent('tests'), true);

        $em = $this->getDoctrine()->getManager();
        foreach ($tests['tests'] as $test) {
            $userVisitTests = $this->getRepository("UsersBundle:UserVisitTests")->find($test['id']);
            $userVisitTests->setActualValue($test['actualValue']);
            $userVisitTests->setComments($test['comments']);

            $todaysDate = new \DateTime('now');
            $loggedInUser = Utils::getContainer()->get("vt.aclmanager")->getUser();

            $userVisitTests->setLastUpd($todaysDate);
            $userVisitTests->setLastUpdBy($loggedInUser->getName());
            $em->persist($userVisitTests);
            $em->flush();
        }

        $response = new JsonResponse(json_encode(array("msg" => "updated")));
        return $response;
    }

    /**
     * @Route("deductFreeCredits", name="deduct_free_credits")
     *
     * @param Request $request
     * @return Response
     *
     */
    public function deductFreeCredits(Request $request)
    {
        $loggedInUser = $this->getUser();
        $lab = $this->getRepository('LabsBundle:Lab')->findOneBy(array('login' => $loggedInUser));
        $lab->setFreeCredits($lab->getFreeCredits() - 1);
        $lab->setLastUpd(new \DateTime('now'));
        $lab->setLastUpdBy($loggedInUser->getName());
        $em = $this->getDoctrine()->getManager();
        $em->persist($lab);
        $em->flush();

        $this->forward('UsersBundle:UserVisit:updateUserVisit', array(
            'id' => $request->get("id"),
            'enableViewForUser' => $request->get("enableViewForUser")
        ));
        return $this->getJsonResponse(json_encode(['creditsRemaining' => $lab->getFreeCredits()]));
    }
}
