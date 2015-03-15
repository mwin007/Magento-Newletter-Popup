<?php
class MartinNguyen_NewsletterPopup_Model_System_Config_Source_Dropdown_Visibility
{
	/**
	 * returns Option Array for the visibility mode
	 * 
	 * @return array
	 */
    public function toOptionArray()
    {
        return array(
            array(
                'value' => 0,
                'label' => 'everyone',
            ),
            array(
                'value' => 1,
                'label' => 'logged-in users only',
            ),
            array(
                'value' => 2,
                'label' => 'guests only',
            )
        );
    }
}