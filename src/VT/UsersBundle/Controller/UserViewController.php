<?php

namespace VT\UsersBundle\Controller;

use VT\VTCoreBundle\Controller\VTController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use VT\VTCoreBundle\Services\Doctrine\SoftDeleteFilter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use VT\VTCoreBundle\Services\Utils;

class UserViewController extends VTController
{
    /**
     * @Route("reports", name="user_report")
     */
    public function userReportRenderAction()
    {
        $testData = $this->userViewTestData();        
        return $this->render('UsersBundle:UserView:user_report_render.html.twig', array(
           'testData' => $testData
            )
        );
    }

    /**
     * @Route("userViewTestData", name="user_view_test_data")
     */
    public function userViewTestData(){
        $sessionUser = $this->getUser();
        // User 
        $user = $this->getRepository('UsersBundle:User')->findOneBy(array('login' => $sessionUser->getId()));
        $testData = json_decode(json_encode($user));

        // User Visit
        $userVisit = $this->getEntityManager(array(SoftDeleteFilter::$filterName))->getRepository('UsersBundle:UserVisit')->findBy(
            array('user' => $user, 'enableViewForUser' => 'Yes', 'status' => 'Report Delivered'),
            array('created' => 'DESC')
            );
        $userVisit = json_decode(json_encode($userVisit));
        $testData->userVisit = $userVisit;

        // User visit tests
        foreach ($userVisit as $visit) {
            $tests = $this->getEntityManager(array(SoftDeleteFilter::$filterName))->getRepository('UsersBundle:UserVisitTests')->findBy(array('userVisit' => $visit->id));
            $visit->tests = json_decode(json_encode($tests));
        }
        return $testData;
    }

    /**
     * @Route("tracking-chart", name="user_tracking_chart")
     * @return array
     */
    public function userTrackingChartRenderAction()
    {
        $testData = $this->userViewTestData();
        $testArray = [];
        foreach ($testData->userVisit as $visit) {
            foreach ($visit->tests as $test) {
                if($test->actualValue != null)
                    $testArray[$test->name][] = $test;
            }
        }
        uasort($testArray, function ($a, $b){ return count($b) - count($a); });
        return $this->render('UsersBundle:UserView:user_tracking_chart_render.html.twig', array(
            'testData' => $testArray
            )
        );
    }

    /**
     * @Route("generate-pdf", name="generate_report_pdf")
     * @param Request $request
     */
    public function userGeneratePdfRenderAction(Request $request)
    {
        $id = $request->get('id');
        $userVisit = $this->getEntityManager(array(SoftDeleteFilter::$filterName))->getRepository('UsersBundle:UserVisit')->find($id);

        $labData = json_decode(json_encode($userVisit->getLab()));

        $userVisit = json_decode(json_encode($userVisit));
        $userVisit->tests = $this->getEntityManager(array(SoftDeleteFilter::$filterName))->getRepository('UsersBundle:UserVisitTests')->findBy(array('userVisit' => $id));
        $visitData = json_decode(json_encode($userVisit));
        $visitData->labData = $labData;

        $html = $this->renderView('UsersBundle:UserView:user_report.html.twig', ['visitData'  => $visitData]);
        $footerHtml = $this->renderView('UsersBundle:UserView:user_report_footer.html.twig', ['visitData' => $visitData]);

        $pdf = $this->get('knp_snappy.pdf');
        $pdf->setOption('footer-html', $footerHtml);
        $pdf = $pdf->getOutputFromHtml($html);
        
        return new Response(
            $pdf, 
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="'. $userVisit->name .' Test Report - ' . $userVisit->date . '.pdf"'
            )
        );

    }    

}
