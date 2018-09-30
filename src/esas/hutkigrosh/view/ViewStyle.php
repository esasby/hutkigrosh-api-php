<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 30.09.2018
 * Time: 12:20
 */

namespace esas\hutkigrosh\view;

/**
 * Класс для группмровки css свойств элементов на странице успешного выставления счета
 * Class ViewStyle
 * @package esas\hutkigrosh\view
 */
class ViewStyle
{
    private $msgSuccessClass;
    private $msgUnsuccessClass;

    private $alfaclickButtonClass;
    private $webpayButtonClass;

    /**
     * ViewStyle constructor.
     * @param $msgSuccessClass
     * @param $msgUnsuccessClass
     * @param $alfaclickButtonClass
     * @param $webpayButtonClass
     */
    public function __construct($msgSuccessClass = "", $msgUnsuccessClass = "", $alfaclickButtonClass = "", $webpayButtonClass = "")
    {
        $this->msgSuccessClass = $msgSuccessClass;
        $this->msgUnsuccessClass = $msgUnsuccessClass;
        $this->alfaclickButtonClass = $alfaclickButtonClass;
        $this->webpayButtonClass = $webpayButtonClass;
    }


    /**
     * @return mixed
     */
    public function getMsgSuccessClass()
    {
        return $this->msgSuccessClass;
    }

    /**
     * @param mixed $msgSuccessClass
     * @return ViewStyle
     */
    public function setMsgSuccessClass($msgSuccessClass)
    {
        $this->msgSuccessClass = $msgSuccessClass;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMsgUnsuccessClass()
    {
        return $this->msgUnsuccessClass;
    }

    /**
     * @param mixed $msgUnsuccessClass
     * @return ViewStyle
     */
    public function setMsgUnsuccessClass($msgUnsuccessClass)
    {
        $this->msgUnsuccessClass = $msgUnsuccessClass;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAlfaclickButtonClass()
    {
        return $this->alfaclickButtonClass;
    }

    /**
     * @param mixed $alfaclickButtonClass
     * @return ViewStyle
     */
    public function setAlfaclickButtonClass($alfaclickButtonClass)
    {
        $this->alfaclickButtonClass = $alfaclickButtonClass;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWebpayButtonClass()
    {
        return $this->webpayButtonClass;
    }

    /**
     * @param mixed $webpayButtonClass
     * @return ViewStyle
     */
    public function setWebpayButtonClass($webpayButtonClass)
    {
        $this->webpayButtonClass = $webpayButtonClass;
        return $this;
    }
    
    
}