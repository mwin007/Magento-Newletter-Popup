<?php
/**
 * NewsletterPopup Subscribers Collection
 *
 * @category   MartinNguyen
 * @package    MartinNguyen_NewsletterPopup
 * @author     Martin Nguyen
 */

class MartinNguyen_NewsletterPopup_Model_Mysql4_Subscriber_Collection extends Mage_Newsletter_Model_Mysql4_Subscriber_Collection
{
    /**
     * Adds customer info to select
     *
     * @return Mage_Newsletter_Model_Resource_Subscriber_Collection
     */
    
    public function showCustomerDob()
    {
        $adapter = $this->getConnection();
        $customer = Mage::getModel('customer/customer');
        $dob   = $customer->getAttribute('dob');

        $this->getSelect()
            ->joinLeft(
                array('customer_dob_table'=>$dob->getBackend()->getTable()),
                $adapter->quoteInto('customer_dob_table.entity_id=main_table.customer_id
                 AND customer_dob_table.attribute_id = ?', (int)$dob->getAttributeId()),
                array('customer_dob'=>'value')
            );
            
        return $this;
    }
}
