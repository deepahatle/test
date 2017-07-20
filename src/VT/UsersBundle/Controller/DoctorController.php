<?php

namespace VT\UsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use VT\VTCoreBundle\Controller\VTController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use VT\UsersBundle\Entity\Doctor;
use Symfony\Component\HttpFoundation\JsonResponse;
use VT\VTCoreBundle\Services\Utils;
use VT\UsersBundle\Form\DoctorCreateType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DoctorController extends VTController
{
    /**
     * @Route("/admin/doctors", name="doctor_render")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function doctorRenderAction()
    {
        return $this->render('UsersBundle:Doctor:doctor_render.html.twig', array());
    }

    /**
     * @Route("doctor-data", name="doctor_data")
     *
     * @param $request Request
     * @return array
     *
     */
    public function doctorDataAction(Request $request)
    {
        $fullSpec = json_decode($request->getContent(), true);
        $doctors = $this->getRepository('UsersBundle:Doctor')->fetchDoctorsByFilter($fullSpec);
        $doctors = json_encode($doctors);
        return $this->getJsonResponse($doctors); 
    }

    /**
     * @Route("/admin/add-doctor", name="add_doctor_render")
     * @Route("/admin/edit-doctor", name="doctor_edit")
     * @Template("UsersBundle:Doctor:add_doctor_render.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @param $request Request
     * @return array
     *
     */
    public function addDoctorRenderAction(Request $request)
    {
        $id = $request->get('id');

        if(empty($id))
            $doctor = new Doctor();
        else
            $doctor = $this->getRepository('UsersBundle:Doctor')->find($id);

        $form = $this->createForm(DoctorCreateType::class, $doctor);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $todaysDate = new \DateTime('now');

            $loggedInUser = Utils::getContainer()->get("vt.aclmanager")->getUser();

            if(empty($id)){
                $labUser = $this->getRepository('LabsBundle:Lab')->findOneBy(array('login' => $loggedInUser->getId()));
                $doctor->setLab($labUser);
                $doctor->setCreated($todaysDate);
                $doctor->setCreatedBy($loggedInUser->getName());
            }

            $doctor->setLastUpd($todaysDate);
            $doctor->setLastUpdBy($loggedInUser->getName());
            $em->persist($doctor);
            $em->flush();

            return $this->redirectToRoute('doctor_render');
        }

        return array('form' => $form->createView());
    }

    /**
     *
     * @Route("delete-doctor", name="doctor_delete")
     *
     * @param $id string This is the user record primary key we want to delete.
     * @return Response This represents the json indicating that delete was done.
     *
     */
    public function deleteDoctorAction(Request $request)
    {
        $id = $request->get("id");

        $doctor = $this->getRepository("UsersBundle:Doctor")->find($id);

        $em = $this->getDoctrine()->getManager();

        $doctor->setDeleted(1);

        $todaysDate = new \DateTime('now');
        $loggedInUser = Utils::getContainer()->get("vt.aclmanager")->getUser();

        $doctor->setLastUpd($todaysDate);
        $doctor->setLastUpdBy($loggedInUser->getName());
        $em->persist($doctor);
        $em->flush();

        $response = new JsonResponse(json_encode(array("msg" => "deleted")));
        $response->headers->set("Content-Type", "application/json");
        return $response;       
        
    }

}
