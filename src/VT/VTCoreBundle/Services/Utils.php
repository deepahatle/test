<?php

namespace VT\VTCoreBundle\Services;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use VT\VTCoreBundle\Services\Doctrine\SoftDeleteFilter;
use VT\VTCoreBundle\Services\Doctrine\VTEntityManager;

class Utils
{
    const NO_ACCESS_CODE = "403";
    const NOT_FOUND_CODE = "404";
    const OK_CODE = "200";

    public static function generateRandomString($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function getLabID()
    {
        $session = new Session();
        $labID = $session->get('labID');
        return $labID;
    }

    public static function getContainer()
    {
        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        return $kernel->getContainer();
    }

    public static function implode($glue = ',', $surrounding = '"', $pieces)
    {
        if (!empty($surrounding))
            return ($surrounding . implode(($surrounding . ' ' . $glue . ' ' . $surrounding), $pieces) . $surrounding);
        else
            return implode($glue, $pieces);
    }

    public static function blankIfNull($array, $key)
    {
        return isset($array[$key]) ? $array[$key] : '';
    }

    public static function getCredentials()
    {
        return array("username" => "sa_new", "password" => "sa_new");
    }

    /**
     * @param string $serviceUrl
     * This is the URL where the service to be invoked is located
     *
     * @param array $serviceData
     * Any other data that needs to be passed to the service
     *
     * @return string
     * Response generated by the service
     *
     */
    public static function invokeRemoteService($serviceData, $serviceUrl)
    {
        $credentials = Utils::getCredentials();

        // convert variables array to string
        $_data = array();
        while (list($n, $v) = each($serviceData)) {
            $_data[] = urlencode($n) . "=" . urlencode($v);
        }
        // format --> test1=a&test2=b etc.
        $_data = implode('&', $_data);

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $serviceUrl);
        curl_setopt($ch, CURLOPT_POST, count($serviceData));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_USERPWD, $credentials['username'] . ':' . $credentials['password']);

        //execute post
        $result = curl_exec($ch);

        //close connection
        curl_close($ch);

        return utf8_encode($result);
    }

    public static function isVector(&$array)
    {
        if (!is_array($array)) {
            return false;
        }
        $next = 0;
        foreach ($array as $k => $v) {
            if ($k !== $next) {
                return false;
            }
            $next++;
        }
        return true;
    }

    public static function isAssociative($array)
    {
        if (!is_array($array)) {
            return false;
        }
        foreach (array_keys($array) as $k => $v) {
            if ($k !== $v) {
                return true;
            }
        }
        return false;
    }

    public static function hyphenate($string)
    {
        $string = trim($string);
        $hyphenatedString = preg_replace("![^a-zA-Z0-9-]+!i", "-", $string);
        $hyphenatedString = trim(preg_replace('/-+/', '-', $hyphenatedString), '-');
        $hyphenatedString = strtolower($hyphenatedString);

        return $hyphenatedString;
    }

    public static function dehyphenate($string)
    {
        // if there is any hyphen already then replace it with underscore.
        $string = str_replace(':', '-', $string);
        $string = str_replace('-', ' ', $string);
        // replace all space characters with hyphen.
        $string = str_replace('_', '-', $string);
        return $string;
    }

    public static function isInArray($v, $arr)
    {
        foreach ($arr as $index => $value) {
            if (strcmp($value, $v) == 0) {
                return true;
            }
        }
        return false;
    }

    public static function isValidEmail($email)
    {
//        return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
//        return preg_match("/^[_.\da-z-]+@[a-z\d][a-z\d-]+\.+[a-z]{2,6}$/i", trim($email));
//        return preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", trim($email));
        return preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,3})$/", trim($email));
    }

    public static function is_mobileNumber($mobile)
    {
        $regex1 = '123456789';
        $regex2 = '1234567890';
        $regex3 = '0123456789';

        if (preg_match('/^([0-9])\1*$/', $mobile)) {
            return false;
        } elseif ($mobile == $regex1) {
            return false;
        } elseif ($mobile == $regex2) {
            return false;
        } elseif ($mobile == $regex3) {
            return false;
        } elseif (preg_match("/[^0-9]/", $mobile)) {
            return false;
        } else {
            return true;
        }
    }
    
    public static function formNoAccessErrorMessage($user, $bundle, $controller, $action){

        if(!empty($user))
            return $strMessage = "User " . $user->getName() ." does not have access to " . $action . " of " . $controller . "Controller in " . $bundle ;
        else
            //return $strMessage = "You don't have access to " . $action . " of " . $controller . "Controller in " . $bundle ;
            return $strMessage = "You are not a authorized user. Please login or contact administrator" ;

    }

    public static function getDisplayStatusValue($status){

        $displayVal = "De-Active";
        switch ($status){
            case 'Yes':
                $displayVal = 'Active';
                break;
            case 'No':
                $displayVal = 'De-Active';
                break;
            case 'Reject':
                $displayVal = 'Reject';
                break;
            case 'Approve':
                $displayVal = 'Approve';
                break;
            case 'Pending':
                $displayVal = 'Pending';
                break;
            case 'Reschedule':
                $displayVal = 'Reschedule';
                break;
            case 'Complete':
                $displayVal = 'Complete';
                break;
            case 'Verified':
                $displayVal = 'Verified';
                break;
            case 'Unverified':
                $displayVal = 'Unverified';
                break;
            case 'Pending Approval':
                $displayVal = 'Pending Approval';
                break;
        }
        return $displayVal;
    }

    public static function sendSMS($numbers, $message){

        $smsUrl = Utils::getContainer()->getParameter('sms_url');
        $userName = Utils::getContainer()->getParameter('sms_username');
        $password = Utils::getContainer()->getParameter('sms_password');
        $route = Utils::getContainer()->getParameter('sms_route');
        $senderId = Utils::getContainer()->getParameter('sms_sender_id');

        //$pass_url = "http://173.45.76.226:81/send.aspx?username=lacaco&pass=Lacaco123&route=trans1&senderid=LACACO&numbers=".$mob."&message=".$pass_msg;

        $message = urlencode($message);
        $smsUrl = $smsUrl.'?username='.$userName
            .'&pass='.$password
            .'&route='.$route
            .'&senderid='.$senderId
            .'&numbers='.$numbers[0]
            .'&message='.$message;


        /*try {
            $r = new \HttpRequest($smsUrl, \HttpRequest::METH_GET);
            $r->send();
            if ($r->getResponseCode() == 200) {

            }
        } catch (\Exception $ex) {
            echo $ex;
        }*/

        $ch = curl_init();

        curl_setopt($ch,CURLOPT_URL,$smsUrl);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

        $output=curl_exec($ch);
        //echo $output;
        curl_close($ch);
        return $output;

    }

    public static function mapProfessionalToExtension($number, $email, $extension){

        $mappingUrl = Utils::getContainer()->getParameter('agent_mapping_url');
        $authKey = Utils::getContainer()->getParameter('knowlarity_auth_key');

        //http://etsdom.kapps.in/webapi/lacaco/api/lacaco_agent_mapping.py?auth_key=51c41934-94b1-4be7-82c2-6531251a76ab&agent_list=+919167055512&extension=1&email_id=ojas.pipalia@gmail.com
        $mappingUrl = $mappingUrl.'?auth_key='.$authKey
            .'&agent_list='.$number
            .'&extension='.$extension
            .'&email_id='.$email;

        $ch = curl_init();

        curl_setopt($ch,CURLOPT_URL,$mappingUrl);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

        $output=curl_exec($ch);
        //echo $output;
        curl_close($ch);
        return $output;

    }

    public static function appendCountryCodeToMobileNo($mobileNo){

        if(strlen($mobileNo)==10){
            $mobileNo = '+91'.$mobileNo;
        }else if(strlen($mobileNo == 12)){
            $prefix = substr($mobileNo, 0, 2);
            if($prefix=='91'){
                $mobileNo = '+'.$mobileNo;
            }
        }/*else if(strlen($mobileNo == 13)){
            $prefix = substr($mobileNo, 0, 3);
            if($prefix!='+91'){
                $mobileNo = '+91'.$mobileNo;
            }
        }*/
        return $mobileNo;
    }

    public static function renderPagination($total, $page, $shown, $url)
    {
        $pages = ceil($total / $shown);
        $range_start = (($page >= 5) ? ($page - 3) : 1);
        $range_end = ((($page + 5) > $pages) ? $pages : ($page + 5));
        $firstPage = strtok($url, '?');

        if ($page > 1) {
            $r[] = '<li><a href="' . $firstPage . '" target="_self">&laquo; first</a></li>';
            $r[] = '<li><a rel="prev" href="' . $url . ($page - 1) . '" target="_self">&lsaquo; previous</a></li>';
            $r[] = (($range_start > 1) ? '<li><a> ... </a></li>' : '');
        }

        if ($range_end > 1) {
            foreach (range($range_start, $range_end) as $key => $value) {
                if ($value == ($page)) {
                    $r[] = '<li class="active"><a>' . $value . '</a></li>';
                } else {
                    $r[] = '<li><a href="' . $url . ($value) . '" target="_self">' . $value . '</a></li>';
                }
            }
        }

        if ((($page + 1) < $pages)) {
            $r[] = (($range_end < $pages) ? '<li><a> ... </a></li>' : '');
            $r[] = '<li><a rel="next" href="' . $url . ($page + 1) . '" target="_self">next &rsaquo;</a></li>';
            $r[] = '<li><a href="' . $url . ($pages) . '" target="_self">last &raquo;</a></li>';
        }

        return ((isset($r)) ? '<ul class="pagination pull-right">' . implode("\r\n", $r) . '</ul>' : '');
    }

    public static function callGeocodingApi($address){

        $authKey = Utils::getContainer()->getParameter('geolocation_api_key');

        $geolocationApiUrl = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($address)."&key=".$authKey;

        $ch = curl_init();

        curl_setopt($ch,CURLOPT_URL,$geolocationApiUrl);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

        $output=curl_exec($ch);

        //echo $output;
        curl_close($ch);
        return $output;
    }
}
