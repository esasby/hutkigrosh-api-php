<?php

use esas\hutkigrosh\wrappers\ConfigurationWrapper;

const _DESC = '_desc';
const _DEFAULT = '_default';

return array(
    ConfigurationWrapper::CONFIG_HG_SHOP_NAME => 'Название магазина',
    ConfigurationWrapper::CONFIG_HG_SHOP_NAME . _DESC => 'Произвольное название Вашего магазина',

    ConfigurationWrapper::CONFIG_HG_LOGIN => 'Логин',
    ConfigurationWrapper::CONFIG_HG_LOGIN . _DESC => 'Ваш логин для доступа к ХуткiГрош',

    ConfigurationWrapper::CONFIG_HG_PASSWORD => 'Пароль',
    ConfigurationWrapper::CONFIG_HG_PASSWORD . _DESC => 'Ваш пароль для доступа к ХуткiГрош',

    ConfigurationWrapper::CONFIG_HG_ERIP_ID => 'ЕРИП ID',
    ConfigurationWrapper::CONFIG_HG_ERIP_ID . _DESC => 'Уникальный идентификатор ЕРИП',

    ConfigurationWrapper::CONFIG_HG_SANDBOX => 'Sandbox',
    ConfigurationWrapper::CONFIG_HG_SANDBOX . _DESC => 'Режим *песочницы*. Если включен, то все счета буду выставляться в тестовой системе trial.hutkigrosh.by',

    ConfigurationWrapper::CONFIG_HG_ALFACLICK_BUTTON => 'Кнопка Alfaclick',
    ConfigurationWrapper::CONFIG_HG_ALFACLICK_BUTTON . _DESC => 'Если включена, то на итоговом экране клиенту отобразится кнопка для выставления счета в Alfaclick',

    ConfigurationWrapper::CONFIG_HG_WEBPAY_BUTTON => 'Кнопка Webpay',
    ConfigurationWrapper::CONFIG_HG_WEBPAY_BUTTON . _DESC => 'Если включена, то на итоговом экране клиенту отобразится кнопка для оплаты счета картой (переход на Webpay)',

    ConfigurationWrapper::CONFIG_HG_EMAIL_NOTIFICATION => 'Email оповещение',
    ConfigurationWrapper::CONFIG_HG_EMAIL_NOTIFICATION . _DESC => 'Если включено, то шлюз ХуткiГрош будет отправлять email оповещение клиенту о выставлении счета',

    ConfigurationWrapper::CONFIG_HG_SMS_NOTIFICATION => 'Sms оповещение',
    ConfigurationWrapper::CONFIG_HG_SMS_NOTIFICATION . _DESC => 'Если включено, то шлюз ХуткiГрош будет отправлять sms оповещение клиенту о выставлении счета',

    ConfigurationWrapper::CONFIG_HG_COMPLETION_TEXT => 'Текст успешного выставления счета',
    ConfigurationWrapper::CONFIG_HG_COMPLETION_TEXT . _DESC => 'Текст, отображаемый кленту после успешного выставления счета. Может содержать html. ' .
        'В тексте допустимо ссылаться на переменные @order_id, @order_number, @order_total, @order_currency, @order_fullname, @order_phone, @order_address',
    ConfigurationWrapper::CONFIG_HG_COMPLETION_TEXT . _DEFAULT => '<p>Счет №<strong>@order_number</strong> успешно выставлен в ЕРИП</p>
<p>Вы можете оплатить его наличными деньгами, пластиковой карточкой и электронными деньгами, в любом из отделений
    банков, кассах, банкоматах, платежных терминалах, в системе электронных денег, через Интернет-банкинг, М-банкинг,
    интернет-эквайринг</p>
<p>Для оплаты счета в ЕРИП необходимо:</p>
<ol>
    <li>Выберите дерево платежей ЕРИП</li>
    <li>Выберите услугу: <strong>Платежи &gt; Интернет магазины</strong></li>
    <li>Введите номер счета <strong>@order_number</strong></li>
    <li>Проверить корректность информации</li>
    <li>Совершить платеж.</li>
</ol>',

    ConfigurationWrapper::CONFIG_HG_PAYMENT_METHOD_NAME => 'Название способы оплаты',
    ConfigurationWrapper::CONFIG_HG_PAYMENT_METHOD_NAME . _DESC => 'Название, отображаемое клиенту, при выборе способа оплаты',
    ConfigurationWrapper::CONFIG_HG_PAYMENT_METHOD_NAME . _DEFAULT => 'Через систему *Расчет* (ЕРИП)',

    ConfigurationWrapper::CONFIG_HG_PAYMENT_METHOD_DETAILS => 'Описание способа оплаты',
    ConfigurationWrapper::CONFIG_HG_PAYMENT_METHOD_DETAILS . _DESC => 'Описание, отображаемое клиенту, при выборе способа оплаты',
    ConfigurationWrapper::CONFIG_HG_PAYMENT_METHOD_DETAILS . _DEFAULT => '«Хуткi Грош»™ — платежный сервис по выставлению счетов в АИС *Расчет* (ЕРИП). ' .
        'После выставления счета Вам будет доступна его оплата пластиковой карточкой и электронными деньгами, в любом из отделений банков, кассах, банкоматах, платежных терминалах, в системе электронных денег, через Интернет-банкинг, М-банкинг, интернет-эквайринг',

    ConfigurationWrapper::CONFIG_HG_BILL_STATUS_PENDING => 'Статус при выствылениии счета',
    ConfigurationWrapper::CONFIG_HG_BILL_STATUS_PENDING . _DESC => 'Какой статус выставить заказу при успешном выставлении счета в ЕРИП (идентификатор существующего статуса)',

    ConfigurationWrapper::CONFIG_HG_BILL_STATUS_PAYED => 'Статус при успешной оплате счета',
    ConfigurationWrapper::CONFIG_HG_BILL_STATUS_PAYED . _DESC => 'Какой статус выставить заказу при успешной оплате выставленного счета (идентификатор существующего статуса)',

    ConfigurationWrapper::CONFIG_HG_BILL_STATUS_FAILED => 'Статус при ошибке оплаты счета',
    ConfigurationWrapper::CONFIG_HG_BILL_STATUS_FAILED . _DESC => 'Какой статус выставить заказу при ошибке выставленния счета (идентификатор существующего статуса)',

    ConfigurationWrapper::CONFIG_HG_BILL_STATUS_CANCELED => 'Статус при отмене оплаты счета',
    ConfigurationWrapper::CONFIG_HG_BILL_STATUS_CANCELED . _DESC => 'Какой статус выставить заказу при отмене оплаты счета (идентификатор существующего статуса)',

    ConfigurationWrapper::CONFIG_HG_DUE_INTERVAL => 'Срок действия счета',
    ConfigurationWrapper::CONFIG_HG_DUE_INTERVAL . _DESC => 'Как долго счет, будет доступен в ЕРИП для оплаты',

    'hutkigrosh_alfaclick_label' => 'Выставить счет в Alfaclick',
    'hutkigrosh_alfaclick_msg_success' => 'Счет успешно выставлен в систему Alfaclick',
    'hutkigrosh_alfaclick_msg_unsuccess' => 'Ошибка выставления счета в систему Alfaclick',
    'hutkigrosh_webpay_msg_payed' => 'Счет успешно оплачен через сервис WebPay',
    'hutkigrosh_webpay_msg_failed' => 'Ошибка оплаты счета через сервис WebPay',
);