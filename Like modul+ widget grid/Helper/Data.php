<?php

class Magedoc_Like_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Return IP address from which the user is viewing the current page.
     *
     * @return string
     */
    public function getClientIp(){
        $ip = $_SERVER['REMOTE_ADDR'];
        return $ip;
    }

    /**
     * Subtract 24 hours from the current day
     * @param datetime('Y-m-d H:i:s') $today
     * @return datetime('Y-m-d H:i:s')
     */
    public function startDate($today)
    {
        $startDate = new DateTime($today);
        $startDate->sub(new DateInterval('PT24H'));
        $result = $startDate->format('Y-m-d H:i:s') . "\n";
        return $result;
    }
}
