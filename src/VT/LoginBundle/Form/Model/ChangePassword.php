<?php 

namespace VT\LoginBundle\Form\Model;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

class ChangePassword
{
    /**
     * @SecurityAssert\UserPassword(
     *     message = "Wrong value for your current password"
     * )
     */
     protected $oldPassword;

    /**
     * @Assert\Length(
     *     min = 6,
     *     minMessage = "Password should by at least 6 chars long"
     * )
     */
     protected $newPassword;

     /**
     * Get oldPassword
     * @return mixed 
     */
     public function getOldPassword()
     {
         return $this->oldPassword;
     }
     
     /**
     * Set oldPassword
     * @return $this
     */
     public function setOldPassword($oldPassword)
     {
         $this->oldPassword = $oldPassword;
         return $this;
     }

     /**
     * Get newPassword
     * @return mixed 
     */
     public function getNewPassword()
     {
         return $this->newPassword;
     }
     
     /**
     * Set newPassword
     * @return $this
     */
     public function setNewPassword($newPassword)
     {
         $this->newPassword = $newPassword;
         return $this;
     }
}