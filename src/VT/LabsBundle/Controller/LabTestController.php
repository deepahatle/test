<?php

namespace VT\LabsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use VT\VTCoreBundle\Controller\VTController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use VT\LabsBundle\Form\TestCreateType;
use VT\LabsBundle\Entity\LabTest;
use VT\VTCoreBundle\Services\Utils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class LabTestController extends VTController
{
    /**
     * @Route("/admin/tests", name="test_render")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function labTestRenderAction()
    {
        return $this->render('LabsBundle:LabTest:lab_test_render.html.twig', array());
    }

    /**
     * @Route("tests-data", name="test_data")
     *
     * @param $request Request
     * @return array
     *
     */
    public function labTestDataAction(Request $request)
    {        
        $fullSpec = json_decode($request->getContent(), true);
        $tests = $this->getRepository('LabsBundle:LabTest')->fetchTestsByFilter($fullSpec);
        $tests = json_encode($tests);
        return $this->getJsonResponse($tests); 
    }

    /**
     * @Route("/admin/add-tests", name="add_test_render")
     * @Template("LabsBundle:LabTest:add_lab_test_render.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @param $request Request
     * @return array
     *
     */
    public function addLabTestRenderAction(Request $request)
    {
        // 1) build the form
        $labtest = new LabTest();
        $form = $this->createForm(TestCreateType::class, $labtest);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $todaysDate = new \DateTime('now');
            $loggedInUser = Utils::getContainer()->get("vt.aclmanager")->getUser();
            $labUser = $this->getRepository('LabsBundle:Lab')->findOneBy(array('login' => $loggedInUser->getId()));
            $labtest->setLab($labUser);
            $labtest->setCreated($todaysDate);
            $labtest->setCreatedBy($loggedInUser->getName());
            $labtest->setLastUpd($todaysDate);
            $labtest->setLastUpdBy($loggedInUser->getName());
            $em->persist($labtest);
            $em->flush();

            return $this->redirectToRoute('test_render');
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("getTestsByDept", name="get_tests_by_dept")
     *
     * @param Request $request
     * @return Response
     *
     */
    public function getTestsByDeptAction(Request $request)
    {
		$deptId = $request->get('departmentId');
        $keyword = $request->get('q');

        $tests = $this->getRepository('TestsBundle:TestMaster')->fetchTestsByDeptId($deptId, $keyword);
        if (!empty($tests)) {            
            foreach ($tests as $key => $value) {
                $list[] =
                    [
                        'id' => $value['id'],
                        'text' => $value['name']
                    ];
            }
            $response = new JsonResponse();
            $response->setData(['results' => $list]);

            return $response;
        } else {
            $response = new JsonResponse();
            $response->setData(['results' => $list = []]);

            return $response;
        }
    }

    /**
     * @Route("getCostByTest", name="get_cost_by_test")
     *
     * @param Request $request
     * @return Response
     *
     */
    public function getCostByTestAction(Request $request)
    {
        $testId = $request->get('testId');
        $master = $request->get('master');

        if($master != 'no')
            $cost = $this->getRepository('TestsBundle:TestMaster')->fetchCostByTestId($testId);
        else
            $cost = $this->getRepository('LabsBundle:LabTest')->fetchCostByTestId($testId);
        $response = new JsonResponse();
        $response->setData($cost[0]);
        return $response;
    }

    /**
     *
     * @Route("update-test", name="test_update")
     *
     * @param $id string This is the user record primary key we want to delete.
     * @return Response This represents the json indicating that delete was done.
     *
     */
    public function updateTestsAction(Request $request)
    {
        $id = $request->get("id");
        $cost = $request->get("cost");

        $test = $this->getRepository("LabsBundle:LabTest")->find($id);

        $em = $this->getDoctrine()->getManager();

        if(!empty($cost))
            $test->setCost($cost);
        else
            $test->setDeleted(1);

        $todaysDate = new \DateTime('now');
        $loggedInUser = Utils::getContainer()->get("vt.aclmanager")->getUser();

        $test->setLastUpd($todaysDate);
        $test->setLastUpdBy($loggedInUser->getName());
        $em->persist($test);
        $em->flush();

        $response = new JsonResponse(json_encode(array("msg" => "deleted")));
        $response->headers->set("Content-Type", "application/json");
        return $response;       
        
    }

}
