<?php
/**
 * Newsletter Management
 *
 * @category   MartinNguyen
 * @package    MartinNguyen_NewsletterPopup
 * @author     Martin Nguyen
 */

include_once("Mage/Newsletter/controllers/ManageController.php");

/**
 * Just make sure to provide the class so the old actions 
 * are available with the overwritten routing of this extension
 */
class MartinNguyen_NewsletterPopup_ManageController extends Mage_Newsletter_ManageController
{
    
}
