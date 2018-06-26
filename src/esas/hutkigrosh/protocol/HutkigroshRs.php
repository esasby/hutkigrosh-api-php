<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 16.02.2018
 * Time: 12:47
 */

namespace esas\hutkigrosh\protocol;


class HutkigroshRs
{
    const ERROR_DEFAULT = '100';
    const ERROR_RESP_FORMAT = '101';
    const ERROR_ALFACLICK_BILL_NOT_ADDED = '102';
    const ERROR_CONFIG = '103';
    const ERROR_AUTH = '104';

    // Список ошибок
    const STATUS_ERRORS = array(
        '3221291009' => 'Общая ошибка сервиса',
        '3221291521' => 'Нет информации о счете',
        '3221291522' => 'Нет возможности удалить счет',
        '3221291523' => 'Общая ошибка выставления счета',
        '3221291524' => 'Не указан номер счета',
        '3221291525' => 'Счет не уникальный',
        '3221291526' => 'Счет уже выставлен, но срок оплаты прошел',
        '3221291527' => 'Счет выставлен и оплачен',
        '3221291528' => 'Не указано количество товаров/услуг в заказе',
        '3221291529' => 'Не указана сумма счета',
        '3221291530' => 'Не указано наименование товара',
        '3221291531' => 'Общая сумма счета меньше нуля',
        '3221291601' => 'Возвращены не все счета',
        '3221292033' => 'Общая ошибка установки курсов валют',
        '3221292034' => 'Не указан коэффициент к курсу НБ РБ',
        '3221292035' => 'Не определены курсы валют поставщика услуг',
        '3221292036' => 'Не установлен режим пересчета курсов валют',
        '3221292289' => 'Общая ошибка при получении курсов валют',
        '100' => 'Общая ошибка',
        '101' => 'Неверный ответ сервера',
        '102' => 'Ошибка выставления счета в Альфаклик',
        '103' => 'Ошибка конфигурации',
        '104' => 'Ошибка аторизации сервисом Hutkigrosh',
    );

    private $responseCode;
    private $responseMessage;

    public function __construct()
    {
        $this->responseCode = '0';
    }

    /**
     * @return mixed
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    /**
     * @param mixed $responseCode
     */
    public function setResponseCode($responseCode)
    {
        $this->responseCode = trim($responseCode);
        if (in_array($this->responseCode, self::STATUS_ERRORS)) {
            $this->responseMessage = self::STATUS_ERRORS[$this->responseCode];
        }
    }

    /**
     * @return mixed
     */
    public function getResponseMessage()
    {
        return $this->responseMessage;
    }

    /**
     * @param mixed $responseMessage
     */
    public function setResponseMessage($responseMessage)
    {
        if (!empty($responseMessage))
            $this->responseMessage = $responseMessage;
    }


    /**
     * Метод для упрощения проверка результат ответа
     * @return bool
     */
    public function hasError()
    {
        return $this->responseCode != '0';
    }
}