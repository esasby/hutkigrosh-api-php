<?php

namespace esas\hutkigrosh\protocol;

use \Exception;
use Throwable;

/**
 * HootkiGrosh class
 *
 * @author Alex Yashkin <alex.yashkin@gmail.com>
 */
class HutkigroshProtocol
{
    private static $cookies_file;

    private $base_url; // url api

    private $ch; // curl object
    private $response; // тело ответа
    private $status; // код статуса

    public $cookies_dir;

    // api url
    const API_URL = 'https://www.hutkigrosh.by/API/v1/'; // рабочий
    const API_URL_TEST = 'https://trial.hgrosh.by/API/v1/'; // тестовый

    // Список статусов счета
    private $purch_item_status = array(
        'NotSet' => 'Не установлено',
        'PaymentPending' => 'Ожидание оплаты',
        'Outstending' => 'Просроченный',
        'DeletedByUser' => 'Удален',
        'PaymentCancelled' => 'Прерван',
        'Payed' => 'Оплачен',
    );

    /**
     * @param bool $is_test Использовать ли тестовый api
     */
    public function __construct($is_test = false)
    {
        if ($is_test) {
            $this->base_url = self::API_URL_TEST;
        } else {
            $this->base_url = self::API_URL;
        }

        if (!isset(self::$cookies_file)) {
            self::$cookies_file = 'cookies-' . time() . '.txt';
        }

        $this->setCookiesDir(dirname(__FILE__));
    }

    /**
     * Задать путь к папке, где будет находиться файл cookies
     *
     * @param string $dir
     */
    public function setCookiesDir($dir)
    {
        $dir = rtrim($dir, '\\/');
        if (is_dir($dir)) {
            $this->cookies_dir = $dir;
        } else {
            $this->cookies_dir = dirname(__FILE__);
        }
    }

    /**
     * Аутентифицирует пользователя в системе
     *
     * @return LoginRs
     */
    public function apiLogIn(LoginRq $loginRq)
    {
        $resp = new LoginRs();
        if (empty($loginRq->getUsername()) || empty($loginRq->getPassword())) {
            $resp->setResponseCode(999); //todo в справочник
            $resp->setResponseMessage("Ошибка конфигурации! Не задан login или password");
            return $resp;
        }
        // формируем xml
        $Credentials = new \SimpleXMLElement("<Credentials></Credentials>");
        $Credentials->addAttribute('xmlns', 'http://www.hutkigrosh.by/api');
        $Credentials->addChild('user', $loginRq->getUsername());
        $Credentials->addChild('pwd', $loginRq->getPassword());

        $xml = $Credentials->asXML();

        // запрос
        $res = $this->requestPost('Security/LogIn', $xml);

        // проверим, верны ли логин/пароль
        if ($res && !preg_match('/true/', $this->response)) {
            $resp->setResponseCode(999); //todo в справочник
            $resp->setResponseMessage('Ошибка авторизации');
        }
        return $resp;
    }

    /**
     * Завершает сессию
     * @return bool
     */
    public function apiLogOut()
    {
        $res = $this->requestPost('Security/LogOut');
        // удалим файл с cookies
        $cookies_path = $this->cookies_dir . DIRECTORY_SEPARATOR . self::$cookies_file;
        if (is_file($cookies_path)) {
            @unlink($cookies_path);
        }
        return $res; //todo переделать в Rs
    }

    /**
     * Добавляет новый счет в систему
     *
     * @return BillNewRs
     */
    public function apiBillNew(BillNewRq $billNewRq)
    {
        $resp = new BillNewRs();
        try {// формируем xml
            $Bill = new \SimpleXMLElement("<Bill></Bill>");
            $Bill->addAttribute('xmlns', 'http://www.hutkigrosh.by/api/invoicing');
            $Bill->addChild('eripId', $billNewRq->getEripId());
            $Bill->addChild('invId', $billNewRq->getInvId());
            $Bill->addChild('dueDt', date('c', strtotime('+1 day'))); // +1 день
            $Bill->addChild('addedDt', date('c'));
            $Bill->addChild('fullName', $billNewRq->getFullName());
            $Bill->addChild('mobilePhone', $billNewRq->getMobilePhone());
            $Bill->addChild('notifyByMobilePhone', $billNewRq->isNotifyByMobilePhone() ? "true" : "false");
            if (!empty($billNewRq->getEmail())) {
                $Bill->addChild('email', $billNewRq->getEmail()); // опционально
                $Bill->addChild('notifyByEMail', $billNewRq->isNotifyByEMail() ? "true" : "false");
            }
            if (!empty($billNewRq->getFullAddress())) {
                $Bill->addChild('fullAddress', $billNewRq->getFullAddress()); // опционально
            }
            $Bill->addChild('amt', (float)$billNewRq->getAmount());
            $Bill->addChild('curr', $billNewRq->getCurrency());
            $Bill->addChild('statusEnum', 'NotSet');
            // Список товаров/услуг
            if (!empty($billNewRq->getProducts())) {
                $products = $Bill->addChild('products');
                foreach ($billNewRq->getProducts() as $pr) {
                    $ProductInfo = $products->addChild('ProductInfo');
                    if (!empty($pr->getInvId())) {
                        $ProductInfo->addChild('invItemId', $pr->getInvId()); // опционально
                    }
                    $ProductInfo->addChild('desc', $pr->getName());
                    $ProductInfo->addChild('count', $pr->getCount());
                    if (!empty($pr->getUnitPrice())) {
                        $ProductInfo->addChild('amt', $pr->getUnitPrice()); // опционально
                    }
                }
            }

            $xml = $Bill->asXML();
            // запрос
            $res = $this->requestPost('Invoicing/Bill', $xml);
            if ($res) {
                $array = $this->responseToArray();

                if (is_array($array) && isset($array['status']) && isset($array['billID'])) {
                    $resp->setResponseCode($array['status']);
                    $resp->setBillId($array['billID']);
                } else {
                    $resp->setResponseCode(HutkigroshRs::ERROR_RESP_FORMAT);
                }
            } else {
                $resp->setResponseCode(HutkigroshRs::ERROR_DEFAULTT);
            }
        } catch (Throwable $e) {
            //TODO добавить логировангие
            $resp->setResponseCode(HutkigroshRs::ERROR_DEFAULT);
        }
        return $resp;
    }

    /**
     * Добавляет новый счет в систему БелГазПромБанк
     *
     * @param array $data
     *
     * @return bool|string
     */
    public function apiBgpbPay($data)
    {
        // формируем xml
        $Bill = new \SimpleXMLElement("<BgpbPayParam></BgpbPayParam>");
        $Bill->addAttribute('xmlns', 'http://www.hutkigrosh.by/API/PaymentSystems');
        $Bill->addChild('billId', $data['billId']);
//        $products = $Bill->addChild('orderData');
//        $products->addChild('eripId',$data['eripId']);
//        $products->addChild('spClaimId',$data['spClaimId']);
//        $products->addChild('amount', $data['amount']);
//        $products->addChild('currency', '933');
//        $products->addChild('clientFio', $data['clientFio']);
//        $products->addChild('clientAddress', $data['clientAddress']);
//        $products->addChild('trxId');
        $Bill->addChild('returnUrl', htmlspecialchars($data['returnUrl']));
        $Bill->addChild('cancelReturnUrl', htmlspecialchars($data['cancelReturnUrl']));
        $Bill->addChild('submitValue', 'Оплатить картой на i24.by(БГПБ)');

        $xml = $Bill->asXML();
        // запрос
        $this->requestPost('Pay/BgpbPay', $xml);
        $responseXML = simplexml_load_string($this->response);
        return $responseXML->form->__toString();
    }


    /**
     * Добавляет новый счет в систему AllfaClick
     *
     * @param array $data
     *
     * @return AlfaclickRs
     */
    public function apiAlfaClick(AlfaclickRq $alfaclickRq)
    {
        $resp = new AlfaclickRs();
        try {
            // формируем xml
            $Bill = new \SimpleXMLElement("<AlfaClickParam></AlfaClickParam>");
            $Bill->addAttribute('xmlns', 'http://www.hutkigrosh.by/API/PaymentSystems');
            $Bill->addChild('billId', $alfaclickRq->getBillId());
            $Bill->addChild('phone', $alfaclickRq->getPhone());
            $xml = $Bill->asXML();
            // запрос
            $this->requestPost('Pay/AlfaClick', $xml);
            $responseXML = simplexml_load_string($this->response); // 0 – если произошла ошибка, billId – если удалось выставить счет в AlfaClick
            if (intval($responseXML->__toString()) == '0') {
                $resp->setResponseCode(HutkigroshRs::ERROR_ALFACLICK_BILL_NOT_ADDED);
            }
        } catch (Throwable $e) {
            //TODO добавить логировангие
            $resp->setResponseCode(HutkigroshRs::ERROR_DEFAULT);
        }
        return $resp;
    }

    /**
     * Получение формы виджета для оплаты картой
     *
     * @param WebPayRq $webPayRq
     * @return WebPayRs
     */

    public function apiWebPay(WebPayRq $webPayRq)
    {
        $resp = new WebPayRs();
        try {// формируем xml
            $Bill = new \SimpleXMLElement("<WebPayParam></WebPayParam>");
            $Bill->addAttribute('xmlns', 'http://www.hutkigrosh.by/API/PaymentSystems');
            $Bill->addChild('billId', $webPayRq->getBillId());
            $Bill->addChild('returnUrl', htmlspecialchars($webPayRq->getReturnUrl()));
            $Bill->addChild('cancelReturnUrl', htmlspecialchars($webPayRq->getCancelReturnUrl()));
            $Bill->addChild('submitValue', "Pay with card");
            $xml = $Bill->asXML();
            // запрос
            $res = $this->requestPost('Pay/WebPay', $xml);
            if ($res) {
                $responseXML = simplexml_load_string($this->response, null, LIBXML_NOCDATA);
                if (isset($responseXML->status)) {
                    $resp->setResponseCode($responseXML->status);
                    $resp->setHtmlForm($responseXML->form->__toString());
                } else {
                    $resp->setResponseCode(HutkigroshRs::ERROR_RESP_FORMAT);
                }
            } else {
                $resp->setResponseCode(HutkigroshRs::ERROR_DEFAULTT);
            }
        } catch (Throwable $e) {
            $resp->setResponseCode(HutkigroshRs::ERROR_DEFAULT);
        }
        return $resp;
    }


    /**
     * Извлекает информацию о выставленном счете
     *
     * @param BillInfoRq $billInfoRq
     *
     * @return BillInfoRs
     */
    public function apiBillInfo(BillInfoRq $billInfoRq)
    {
        $resp = new BillInfoRs();
        try {// запрос
            $res = $this->requestGet('Invoicing/Bill(' . $billInfoRq->getBillId() . ')');
            if (!$res) {
                throw new Exception("Wrong message format", HutkigroshRs::ERROR_RESP_FORMAT);
            }
            $array = $this->responseToArray();
            if (empty($array)) {
                throw new Exception("Wrong message format", HutkigroshRs::ERROR_RESP_FORMAT);
            }
            $resp->setResponseCode($array['status']);
            $resp->setInvId($array["bill"]["invId"]);
            $resp->setEripId($array["bill"]["eripId"]);
            $resp->setFullName($array["bill"]["fullName"]);
            $resp->setFullAddress($array["bill"]["fullAddress"]);
            $resp->setAmount($array["bill"]["amt"]);
            $resp->setCurrency($array["bill"]["curr"]);
            $resp->setEmail($array["bill"]["email"]);
            $resp->setMobilePhone($array["bill"]["mobilePhone"]);
            $resp->setStatus($array["bill"]["statusEnum"]);
            //todo переложить продукты
        } catch (Throwable $e) {
            if (empty($e->getCode()))
                $resp->setResponseCode(HutkigroshRs::ERROR_DEFAULT);
            else
                $resp->setResponseCode($e->getCode());
            $resp->setResponseMessage($e->getMessage());
        }
        return $resp;
    }

    /**
     * Удаляет выставленный счет из системы
     *
     * @param string $bill_id
     *
     * @return bool|mixed
     */
    public function apiBillDelete($bill_id)
    {
        $res = $this->requestDelete('Invoicing/Bill(' . $bill_id . ')');

        if ($res) {
            $array = $this->responseToArray();

            if (is_array($array) && isset($array['status']) && isset($array['purchItemStatus'])) {
                $this->status = (int)$array['status'];
                $purchItemStatus = trim($array['purchItemStatus']); // статус счета

                // есть ошибка
                if ($this->status > 0) {
                    $this->error = $this->getStatusError($this->status);
                    return false;
                }

                return $purchItemStatus;
            } else {
                $this->error = 'Неверный ответ сервера';
            }
        }

        return false;
    }

    /**
     * Возвращает статус указанного счета
     *
     * @param string $bill_id
     *
     * @return bool|mixed
     */
    public function apiBillStatus($bill_id)
    {
        $res = $this->requestGet('Invoicing/BillStatus(' . $bill_id . ')');

        if ($res) {
            $array = $this->responseToArray();

            if (is_array($array) && isset($array['status']) && isset($array['purchItemStatus'])) {
                $this->status = (int)$array['status'];
                $purchItemStatus = trim($array['purchItemStatus']); // статус счета

                // есть ошибка
                if ($this->status > 0) {
                    $this->error = $this->getStatusError($this->status);
                    return false;
                }

                return $purchItemStatus;
            } else {
                $this->error = 'Неверный ответ сервера';
            }
        }

        return false;
    }

    /**
     * Получить текст ошибки
     *
     * @return string
     */
    public function getError()
    {
        return 'Счет не выставлен! Произошла ошибка: ' . $this->error . '. <br> Повторите заказ.';
    }

    /**
     * Ответ сервера в исходном виде
     *
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Статус ответа
     *
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Статус счета
     *
     * @param string $status
     *
     * @return string
     */
    public function getPurchItemStatus($status)
    {
        return (isset($this->purch_item_status[$status])) ? $this->purch_item_status[$status] : 'Статус не определен';
    }

    /**
     * Подключение GET
     *
     * @param string $path
     * @param string $data
     *
     * @return bool
     */
    private function requestGet($path, $data = '')
    {
        return $this->connect($path, $data, 'GET');
    }

    /**
     * Подключение POST
     *
     * @param string $path
     * @param string $data
     *
     * @return bool
     */
    private function requestPost($path, $data = '')
    {
        return $this->connect($path, $data, 'POST');
    }

    /**
     * Подключение DELETE
     *
     * @param string $path
     * @param string $data
     *
     * @return bool
     */
    private function requestDelete($path, $data = '')
    {
        return $this->connect($path, $data, 'DELETE');
    }

    /**
     * Подключение GET, POST или DELETE
     *
     * @param string $path
     * @param string $data Сформированный для отправки XML
     * @param string $request
     *
     * @return bool
     */
    private function connect($path, $data = '', $request = 'GET')
    {
        $headers = array('Content-Type: application/xml', 'Content-Length: ' . strlen($data));

        $this->ch = curl_init();

        curl_setopt($this->ch, CURLOPT_URL, $this->base_url . $path);
        curl_setopt($this->ch, CURLOPT_HEADER, false); // включение заголовков в выводе
        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($this->ch, CURLOPT_VERBOSE, true); // вывод доп. информации в STDERR
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false); // не проверять сертификат узла сети
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, false); // проверка существования общего имени в сертификате SSL
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true); // возврат результата вместо вывода на экран
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers); // Массив устанавливаемых HTTP-заголовков
        if ($request == 'POST') {
            curl_setopt($this->ch, CURLOPT_POST, true);
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);
        }
        if ($request == 'DELETE') {
            curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }

        $cookies_path = $this->cookies_dir . DIRECTORY_SEPARATOR . self::$cookies_file;

        // если файла еще нет, то создадим его при залогинивании и будем затем использовать при дальнейших запросах
        if (!is_file($cookies_path)) {
            if (!is_writable($this->cookies_dir)) {
                $this->error = 'Cookie file[' . $cookies_path . '] is not writable! Check permissions for directory[' . $this->cookies_dir . ']';
                return false;
            }
            curl_setopt($this->ch, CURLOPT_COOKIEJAR, $cookies_path);
        }
        curl_setopt($this->ch, CURLOPT_COOKIEFILE, $cookies_path);

        $this->response = curl_exec($this->ch);

        if (curl_errno($this->ch)) {
            $this->error = curl_error($this->ch);
            curl_close($this->ch);
            return false;
        } else {
            curl_close($this->ch);
            return true;
        }
    }

    /**
     * Преобразуем XML в массив
     *
     * @return mixed
     */
    private function responseToArray()
    {
        $response = trim($this->response);
        $array = array();
        // проверим, что это xml
        if (preg_match('/^<(.*)>$/', $response)) {
            $xml = simplexml_load_string($response);
            $array = json_decode(json_encode($xml), true);
        }
        return $array;
    }

    /**
     * Описание ошибки на основе ее кода в ответе
     *
     * @param string $status
     *
     * @return string
     */
    public static function getStatusError($status)
    {
        return (isset(self::STATUS_ERRORS[$status])) ? self::STATUS_ERRORS[$status] : 'Неизвестная ошибка';
    }

    public function getStatusResponce()
    {
        return $this->status;
    }
}