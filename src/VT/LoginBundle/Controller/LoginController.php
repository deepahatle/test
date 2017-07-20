<?php

namespace VT\LoginBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use VT\VTCoreBundle\Controller\VTController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use VT\PaymentBundle\Entity\Payment;
use VT\LoginBundle\Entity\Login;
use VT\LabsBundle\Entity\Lab;
use VT\LabsBundle\Entity\LabTest;
use VT\LoginBundle\Form\UserCreateType;
use VT\LoginBundle\Form\ChangePasswordType;
use VT\LoginBundle\Form\ChangePasswordAfterResetType;
use VT\LoginBundle\Form\Model\ChangePassword;

class LoginController extends VTController
{
    private $pkgData = array(
        'Trial Pack' => ['name' => 'Trial Pack', 'duration' => '1 month', 'cost' => 'Free'],
        'Silver Pack' => ['name' => 'Silver Pack', 'duration' => '1 year', 'cost' => '15000'],
        'Gold Pack' => ['name' => 'Gold Pack', 'duration' => '2 years', 'cost' => '25000'],
        'Platinum Pack' => ['name' => 'Platinum Pack', 'duration' => '3 years', 'cost' => '30000']
    );
    const _MERCHANT_KEY = "HIQXM81p";
    const _SALT = "qyL5hxKSlw";

    /**
     * @Route("/admin/login", name="backend_admin_login")
     * @Route("/login", name="user_login")
     * @Template()
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function loginAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
                return $this->redirect($this->generateUrl('dashboard_render'));
            }
            if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
                return $this->redirect($this->generateUrl('user_dashboard_render'));
            }
        }

        $fromRegistration = $request->get('from_registration', 'no');

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return array(
            // last username entered by the user
            'last_username' => $lastUsername,
            'error' => $error,
            'from_registration' => $fromRegistration,
        );
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
        // this controller will not be executed,
        // as the route is handled by the Security system
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        // this controller will not be executed,
        // as the route is handled by the Security system
    }

    /**
     * @Route("/register", name="user_registration")
     * @Template()
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function registerAction(Request $request)
    {
        // 1) build the form
        $user = new Login();
        $form = $this->createForm(UserCreateType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        $userExists = false;
        if ($form->isSubmitted() && $form->isValid()) {

            $username = $form->getData()->getUsername();
            $mobile = $form->getData()->getMobileNo();
            $existingUser = $this->getRepository('LoginBundle:Login')->findOneByUserNameOrEmail($username, $mobile);
            if ($existingUser)
                $userExists = true;
            else {
                $package = $form->get('package')->getData();
                $this->createUser($form->getData(), $package);
                if ($package == 'Trial Pack') {
                    return $this->redirectToRoute('backend_admin_login', array('from_registration' => 'yes'));
                } else {
                    $dataId = $this->paymentInitiateData($form->getData(), $package);
                    return $this->redirectToRoute('payment_redirect', array('dataId' => $dataId));
                }
            }

        }

        return array(
            'form' => $form->createView(),
            'pkgData' => $this->pkgData,
            'userExists' => $userExists
        );
    }

    /**
     * @Route("/payment-redirect", name="payment_redirect")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function paymentRedirectRenderAction(Request $request)
    {
        $dataId = $request->get('dataId');
        $postData = $this->getRepository('PaymentBundle:Payment')->find($dataId);
        return $this->render('PaymentBundle:Payment:payment_redirect.html.twig', array('postData' => $postData));
    }


    /**
     * @Route("/payment-redirect", name="payment_initiate")
     * @param Login $login
     * @param $package
     * @return string
     */
    public function paymentInitiateData(Login $login, $package)
    {
        $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);

        $postData['key'] = self::_MERCHANT_KEY;
        $postData['txnid'] = $txnid;
        $postData['amount'] = $this->pkgData[$package]['cost'];
        $postData['firstname'] = $login->getName();
        $postData['email'] = $login->getUsername();
        $postData['productinfo'] = "SugarLogger - " . $package;

        $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
        $hashVarsSeq = explode('|', $hashSequence);
        $hash_string = '';
        foreach ($hashVarsSeq as $hash_var) {
            $hash_string .= isset($postData[$hash_var]) ? $postData[$hash_var] : '';
            $hash_string .= '|';
        }
        $hash_string .= self::_SALT;
        $hash = strtolower(hash('sha512', $hash_string));

        $payment = new Payment();

        $payment->setName($login->getName());
        $payment->setMobileNo($login->getMobileNo());
        $payment->setEmail($login->getUsername());

        $payment->setPackage($package);
        $payment->setStatus('Payment Initiated');
        $payment->setTxnKey(self::_MERCHANT_KEY);
        $payment->setHash($hash);
        $payment->setTxnId($txnid);
        $payment->setAmount($this->pkgData[$package]['cost']);
        $payment->setLogin($login);
        $this->setProspectFields($payment);

        $em = $this->getDoctrine()->getManager();
        $em->persist($payment);
        $em->flush();
        return $payment->getId();
    }

    /**
     * @Route("/payment-{status}", name="payment_status", requirements={"status"="success|failure"})
     *
     * @param Request $request
     * @param $status
     * @return array
     */
    public function payStatus($status, Request $request)
    {
        $statusText = $request->get("status");
        $firstname = $request->get("firstname");
        $amount = $request->get("amount");
        $txnid = $request->get("txnid");
        $posted_hash = $request->get("hash");
        $key = $request->get("key");
        $productinfo = $request->get("productinfo");
        $email = $request->get("email");
        $salt = self::_SALT;

        if (isset($_POST["additionalCharges"])) {
            $additionalCharges = $_POST["additionalCharges"];
            $retHashSeq = $additionalCharges . '|' . $salt . '|' . $statusText . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        } else {
            $retHashSeq = $salt . '|' . $statusText . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        }
        $hash = hash("sha512", $retHashSeq);

        $payment = $this->getRepository('PaymentBundle:Payment')->findOneBy(array('txnId' => $txnid));

        $responseJson = json_encode($request->request->all());
        $payment->setResponse($responseJson);

        $payment->setStatus($status);

        $todaysDate = new \DateTime('now');
        $payment->setLastUpd($todaysDate);
        $payment->setLastUpdBy('SYSTEM');

        $em = $this->getDoctrine()->getManager();
        $em->persist($payment);
        $em->flush();

        if ($hash != $posted_hash) {
            return $this->render('PaymentBundle:Payment:payment_response.html.twig', array('response' => 'invalid'));
        } else {
            if ($status == 'success') {
                $login = $this->getRepository('LoginBundle:Login')->find($payment->getLogin());
                $login->setIsActive('Yes');
                $login->setLastUpd($todaysDate);
                $login->setLastUpdBy('SYSTEM');

                $em->persist($login);
                $em->flush();
            }
            $responseData = ['status' => $statusText, 'txnid' => $txnid, 'amount' => $amount];
            return $this->render('PaymentBundle:Payment:payment_response.html.twig', array(
                    'response' => $status,
                    'responseData' => $responseData
                )
            );
        }
    }

    /**
     * @Route("/createUser", name="create_user")
     */
    public function createUser(Login $login, $package)
    {
        if ($package == 'Trial Pack') {
            $login->setIsTrial('Yes');
            $login->setIsActive('Yes');
        } else {
            $login->setIsTrial('No');
            $login->setIsActive('No');
        }

        $password = $this->get('security.password_encoder')->encodePassword($login, $login->getPlainPassword());
        $login->setPassword($password);

        $login->setUserType('Admin');
        $login->setRoles(array('ROLE_ADMIN'));

        $date = new \DateTime('now');
        $date->modify('+' . $this->pkgData[$package]['duration']);
        $login->setExpiry($date);

        $this->setProspectFields($login);

        $em = $this->getDoctrine()->getManager();
        $em->persist($login);

        $lab = new Lab();
        $lab->setName($login->getName());
        $lab->setMobile($login->getMobileNo());
        $lab->setEmail($login->getUsername());
        $lab->setRegistrationNo(substr(md5(rand()), 0, 7));
        $lab->setLogin($login);
        $this->setProspectFields($lab);

        $em->persist($lab);

        $tests = $this->getRepository('TestsBundle:TestMaster')->findAll();
        foreach ($tests as $test) {
            $labtest = new LabTest();
            $labtest->setTest($test);
            $labtest->setLab($lab);
            $labtest->setCost($test->getDefaultCost());
            $this->setProspectFields($labtest);
            $em->persist($labtest);
        }
        $em->flush();

        return 'Login Created';
    }

    public function setProspectFields(&$entity)
    {
        $todaysDate = new \DateTime('now');

        $entity->setCreated($todaysDate);
        $entity->setCreatedBy('SYSTEM');
        $entity->setLastUpd($todaysDate);
        $entity->setLastUpdBy('SYSTEM');
    }

    /**
     * @Route("/change-password", name="change_password")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function changePasswdAction(Request $request)
    {
        $changePasswordModel = new ChangePassword();
        $form = $this->createForm(ChangePasswordType::class, $changePasswordModel);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $login = $this->getUser();
            $login = $this->getRepository('LoginBundle:Login')->find($login->getId());
            $password = $this->get('security.password_encoder')->encodePassword($login, $form->getData()->getNewPassword());
            $login->setPassword($password);
            $login->setLastUpd(new \DateTime('now'));
            $login->setLastUpdBy($login->getName());
            $em = $this->getDoctrine()->getManager();
            $em->persist($login);
            $em->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Password changed successfully!');
            if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
                return $this->redirect($this->generateUrl('dashboard_render'));
            } else {
                return $this->redirect($this->generateUrl('user_dashboard_render'));
            }
        }

        return $this->render('LoginBundle:Login:change_password.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/checkPassword", name="check_pwd")
     *
     * @param Request $request
     * @return Response
     */
    public function checkPasswordAction(Request $request)
    {
        $newPassword = $request->request->get('pass');

        $user = $this->getUser();
        $oldPassword = $user->getPassword();
        $salt = $user->getSalt();
        $encoder = $this->get('security.encoder_factory')->getEncoder($user);

        if ($encoder->isPasswordValid($oldPassword, $newPassword, $salt)) {
            $response = true;
        } else {
            $response = false;
        }

        return $this->getJsonResponse(json_encode($response));
    }

    /**
     * @Route("/forgot-password", name="forgot_password_render")
     */
    public function forgotPasswordAction()
    {
        return $this->render('LoginBundle:Login:forgot_password.html.twig');
    }

    /**
     * @Route("/checkRegisteredEmail", name="check_registered_email")
     * @param Request $request
     * @return Response
     */
    public function checkRegisteredEmailAction(Request $request)
    {
        $email = $request->get('email');
        $isRegistered = $this->getRepository('LoginBundle:Login')->checkIsRegisteredEmail($email);
        return $this->getJsonResponse(json_encode($isRegistered));
    }

    /**
     * @Route(path="/sendResetPasswordLink", name="send_reset_password_link")
     * @param Request $request
     * @return Response
     */
    public function sendResetPasswordLinkAction(Request $request)
    {
        $email = $request->get('email');

        $user = $this->getRepository('LoginBundle:Login')->findOneBy(array('username' => $email));
        $id = $user->getId();
        $changePasswordLink = $this->generateUrl('reset_password_render', array('rowID' => base64_encode($id)), UrlGeneratorInterface::ABSOLUTE_URL);
        $data = array(
            'name' => $user->getName(),
            'userName' => $user->getUsername(),
            'changePasswordLink' => $changePasswordLink,
        );

        $msg = \Swift_Message::newInstance()
            ->setSubject("Reset your SugarLogger password")
            ->setFrom(['info@sugarlogger.com' => 'SugarLogger'])
            ->setTo($email)
            ->setBody($this->renderView('Emails/email_forgot_password.html.twig', $data), 'text/html');

        $result = $this->get('mailer')->send($msg);
        if ($result == 1)
            $response = true;
        else
            $response = false;

        return $this->getJsonResponse(json_encode($response));
    }

    /**
     * @Route(path="/reset-password/{rowID}", name="reset_password_render", requirements={"rowID":"[a-zA-Z0-9-]+"})
     * @Template("LoginBundle:Login:reset_password_render.html.twig")
     * @param $rowID
     * @return array
     */
    public function resetPasswordRenderAction(Request $request, $rowID)
    {
        $id = base64_decode($rowID);

        $form = $this->createForm(ChangePasswordAfterResetType::class);

        $form->handleRequest($request);

        $login = $this->getRepository('LoginBundle:Login')->find($id);
        $role = $login->getRolesAsString();
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $password = $this->get('security.password_encoder')->encodePassword($login, $formData['newPassword']);
            $login->setPassword($password);
            $login->setLastUpd(new \DateTime('now'));
            $login->setLastUpdBy($login->getName());
            $em = $this->getDoctrine()->getManager();
            $em->persist($login);
            $em->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Password changed successfully!');

            if ($role == 'ROLE_ADMIN')
                return $this->redirect($this->generateUrl('backend_admin_login'));
            else
                return $this->redirect($this->generateUrl('user_login'));
        }
        return array('form' => $form->createView());
    }
}
