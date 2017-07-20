<?php

namespace VT\PaymentBundle\Controller;

use VT\VTCoreBundle\Controller\VTController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use VT\PaymentBundle\Entity\PayuWalletAuth;
use VT\PaymentBundle\Entity\Payment;

class WalletController extends VTController
{
    const _MERCHANT_KEY = "95ICRYBj";
    const _CLIENT_ID = "5535170";
    const _SALT = "9SGQghPWk8";
    const _REGISTER_URL = "https://www.payumoney.com/auth/ext/wallet/register";
    const _VERIFY_URL = "https://www.payumoney.com/auth/ext/wallet/verify";
    const _PAYMENT_URL = "https://www.payumoney.com/payment/ext/wallet/useWallet";
    const _DEDUCT_AMT = 1;

    /**
     * @Route("/admin/wallet", name="wallet_render")
     */
    public function renderWalletAction()
    {
        $loginObj = $this->getRepository('LoginBundle:Login')->find($this->getUser()->getId());
        $walletAuth = $this->getRepository('PaymentBundle:PayuWalletAuth')->findOneBy(['login' => $loginObj]);

        if ($walletAuth) {
            $isRegistered = true;
            $userData = ['userName' => $walletAuth->getEmail(), 'mobileNo' => $walletAuth->getMobileNo()];
        } else {
            $isRegistered = false;
            $userData = json_decode(json_encode($this->getUser()));
        }

        return $this->render('PaymentBundle:Wallet:render_wallet_register.html.twig', array('userData' => $userData, 'isRegistered' => $isRegistered));
    }

    /**
     * @Route("/register-wallet", name="wallet_register")
     * @param Request $request
     * @return Response
     */
    public function registerWalletDataAction(Request $request)
    {
        $requestObj = $request->request->all();

        $email = $requestObj['email'];
        $mobile = $requestObj['mobile'];
        $hash_key = self::_MERCHANT_KEY . "|$mobile|$email|" . self::_SALT;

        $hash_key = hash("sha512", $hash_key);

        $postfields = array(
            'client_id' => self::_CLIENT_ID,
            'mobile' => $mobile,
            'email' => $email,
            'hash' => $hash_key
        );
        $postfields = http_build_query($postfields, '', '&');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::_REGISTER_URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('authorization: 52Q/OivkS2j6vbxblO0T/AcVA1N7N4RaTdMTOVs/3nI='));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);

        $jresult = json_decode($result);

        if ($jresult && $jresult->status === 0) {
            $response = true;
        } else {
            $response = false;
        }
        return $this->getJsonResponse(json_encode($response));
    }

    /**
     * @Route("/verify-otp", name="verify_otp")
     * @param Request $request
     * @return Response
     */
    public function verifyOTPDataAction(Request $request)
    {
        $requestObj = $request->request->all();
        $otp = $requestObj['otp'];
        $email = $requestObj['email'];
        $mobile = $requestObj['mobile'];

        $hash_key = self::_MERCHANT_KEY . "|$mobile|$email|" . self::_SALT;
        $hash_key = hash("sha512", $hash_key);

        $postfields = array(
            'key' => self::_MERCHANT_KEY,
            'otp' => $otp,
            'client_id' => self::_CLIENT_ID,
            'email' => $email,
            'mobile' => $mobile,
            'hash' => $hash_key
        );

        $postfields = http_build_query($postfields, '', '&');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::_VERIFY_URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);

        $jresult = json_decode($result);

        if ($jresult && $jresult->status === 0) {
            $resultBody = $jresult->result->body;

            $loginObj = $this->getRepository('LoginBundle:Login')->find($this->getUser()->getId());
            $walletAuth = $this->getRepository('PaymentBundle:PayuWalletAuth')->findOneBy(['login' => $loginObj]);

            if ($walletAuth)
                $payuAuth = $walletAuth;
            else
                $payuAuth = new PayuWalletAuth();

            $payuAuth->setEmail($email);
            $payuAuth->setMobileno($mobile);
            $payuAuth->setAuthToken($resultBody->access_token);
            $payuAuth->setRefreshToken($resultBody->refresh_token);
            $payuAuth->setTokenType($resultBody->token_type);
            $payuAuth->setScope($resultBody->scope);
            $payuAuth->setStatus(1);

            $loggedInUser = $this->getUser();
            $loggedInUserID = $loggedInUser->getId();
            $loginObj = $this->getRepository('LoginBundle:Login')->find($loggedInUserID);
            $labUser = $this->getRepository('LabsBundle:Lab')->findOneBy(array('login' => $loggedInUserID));
            $labName = $labUser->getName();

            $payuAuth->setLogin($loginObj);

            $todaysDate = new \DateTime('now');

            $payuAuth->setCreated($todaysDate);
            $payuAuth->setCreatedBy($labName);
            $payuAuth->setLastUpd($todaysDate);
            $payuAuth->setLastUpdBy($labName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($payuAuth);
            $em->flush();

            $response = ['result' => true, 'msg' => ''];

        } else {
            $response = ['result' => false, 'msg' => $jresult->message];
        }

        return $this->getJsonResponse(json_encode($response));
    }

    /**
     * @Route("/deduct-from-wallet", name="deduct_from_wallet")
     * @param Request $request
     * @return Response
     */
    public function deductFromWalletDataAction(Request $request)
    {
        $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);

        $loginObj = $this->getRepository('LoginBundle:Login')->find($this->getUser()->getId());
        $walletAuth = $this->getRepository('PaymentBundle:PayuWalletAuth')->findOneBy(['login' => $loginObj]);

        if ($walletAuth) {

            $authorization = "Authorization:Bearer " . $walletAuth->getAuthToken();

            $hash_key = self::_MERCHANT_KEY . "|" . self::_DEDUCT_AMT . "||$txnid|" . self::_SALT;

            $hash_key = hash("sha512", $hash_key);

            $header_hesh = "Hash: $hash_key";

            $postfields = array(
                'key' => self::_MERCHANT_KEY,
                'client_id' => self::_CLIENT_ID,
                'totalAmount' => self::_DEDUCT_AMT,
                'merchantTransactionId' => $txnid,
                'TransactionId' => $txnid,
                'hash' => $hash_key
            );

            $postfields = http_build_query($postfields, '', '&');


            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, self::_PAYMENT_URL . "?" . $postfields);

            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-length: 0", "Content-type: application/json", $authorization, $header_hesh));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $result = curl_exec($ch);
            curl_close($ch);

            $jresult = json_decode($result);

            if ($jresult && $jresult->status === 0) {
                $payment = new Payment();

                $loggedInUser = $this->getUser();
                $loggedInUserID = $loggedInUser->getId();
                $login = $this->getRepository('LoginBundle:Login')->find($loggedInUserID);
                $labUser = $this->getRepository('LabsBundle:Lab')->findOneBy(array('login' => $loggedInUserID));
                $labName = $labUser->getName();

                $payment->setName($login->getName());
                $payment->setMobileNo($login->getMobileNo());
                $payment->setEmail($login->getUsername());

                $payment->setPackage('WALLET PAY');
                $payment->setStatus('success');
                $payment->setTxnKey(self::_MERCHANT_KEY);
                $payment->setHash($hash_key);
                $payment->setTxnId($txnid);
                $payment->setAmount(self::_DEDUCT_AMT);
                $payment->setLogin($login);
                $payment->setResponse($jresult->result);

                $todaysDate = new \DateTime('now');

                $payment->setCreated($todaysDate);
                $payment->setCreatedBy($labName);
                $payment->setLastUpd($todaysDate);
                $payment->setLastUpdBy($labName);

                $em = $this->getDoctrine()->getManager();
                $em->persist($payment);
                $em->flush();

                $response = ['response' => true, 'wallet' => true];
            } else {
                $response = ['response' => false, 'wallet' => true];
            }

        } else {
            $response = ['response' => false, 'wallet' => false];
        }

        return $this->getJsonResponse(json_encode($response));
    }

}
