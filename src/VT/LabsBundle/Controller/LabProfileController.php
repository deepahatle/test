<?php

namespace VT\LabsBundle\Controller;

use VT\VTCoreBundle\Controller\VTController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use VT\VTCoreBundle\Services\Utils;
use VT\LabsBundle\Form\LabEditType;

class LabProfileController extends VTController
{
    /**
     * @Route("/admin/edit-profile", name="edit_lab_render")
     * @Template("LabsBundle:LabProfile:edit_lab_render.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @param $request Request
     * @return array
     *
     */
    public function editLabProfileRenderAction(Request $request)
    {

        // 1) build the form
        $loggedInUser = Utils::getContainer()->get("vt.aclmanager")->getUser();
        $lab = $this->getRepository('LabsBundle:Lab')->findOneBy(array('login' => $loggedInUser->getId()));
        $form = $this->createForm(LabEditType::class, $lab);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $todaysDate = new \DateTime('now');

            $lab->setLastUpd($todaysDate);
            $lab->setLastUpdBy('SYSTEM');
            
            $em = $this->getDoctrine()->getManager();            
            $em->persist($lab);
            $em->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Profile updated successfully!');
            return $this->redirectToRoute('dashboard_render');
        }

        return array(
            'form' => $form->createView(),
            'regNo' => $lab->getRegistrationNo()
        );
    
    }

    /**
     * @Route("/uploadAttachment", name="upload_attachment")
     * @param $request Request
     * @return Response
     */
    public function uploadAttachmentDataAction(Request $request)
    {
        $attach = $request->files->get('attachment');
        if (!empty($attach)) {
            $extension = $attach->guessExtension();
            if (!$extension) {
                // extension cannot be guessed
                $extension = 'jpg';
            }
            $todaysDate = new \DateTime('now');
            $fileName = md5(uniqid()).'.'.$extension;

            $imgDir = $this->container->getParameter('image_directory');

            $file = $attach->move($imgDir, $fileName);
            $imagePath = $file->getPathname();
            // Image Compression
            $imagine = $this->container->get('liip_imagine.controller');
            $imagemanagerResponse = $imagine->filterAction($request, $imagePath, 'minimized');
            unlink($this->get('kernel')->getRootDir() . '/../web/' . $imgDir . $fileName);

            $response = new Response(json_encode(array("attachment_id" => $fileName)));
            $response->headers->set("Content-Type", "application/json");
            return $response;
        }

        $response = new Response(json_encode(array("attachment_id" => null)));
        $response->headers->set("Content-Type", "application/json");
        return $response;
    }


    /**
     * @Route("/deleteAttachment", name="delete_attachment")
     * @param $request Request
     * @return Response
     */
    public function deleteAttachmentDataAction(Request $request)
    {
        $attachmentID = $request->get('id');
        if (!empty($attachmentID)) {

            $imgDir = $this->container->getParameter('min_image_directory');
            unlink($this->get('kernel')->getRootDir() . '/../web/' . $imgDir . $attachmentID);
            
            $response = new Response(json_encode(array("msg" => "success")));
            $response->headers->set("Content-Type", "application/json");
            return $response;
        }

        $response = new Response(json_encode(array("msg" => "failure")));
        $response->headers->set("Content-Type", "application/json");
        return $response;
    }

}
