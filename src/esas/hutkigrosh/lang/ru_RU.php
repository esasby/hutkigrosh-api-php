<?php

use esas\hutkigrosh\ConfigurationFields;
use esas\hutkigrosh\ViewFields;

const _DESC = '_desc';
const _DEFAULT = '_default';

return array(
    ConfigurationFields::SHOP_NAME => 'Название магазина',
    ConfigurationFields::SHOP_NAME . _DESC => 'Произвольное название Вашего магазина',

    ConfigurationFields::LOGIN => 'Логин',
    ConfigurationFields::LOGIN . _DESC => 'Ваш логин для доступа к ХуткiГрош',

    ConfigurationFields::PASSWORD => 'Пароль',
    ConfigurationFields::PASSWORD . _DESC => 'Ваш пароль для доступа к ХуткiГрош',

    ConfigurationFields::ERIP_ID => 'ЕРИП ID',
    ConfigurationFields::ERIP_ID . _DESC => 'Уникальный идентификатор ЕРИП',

    ConfigurationFields::SANDBOX => 'Sandbox',
    ConfigurationFields::SANDBOX . _DESC => 'Режим *песочницы*. Если включен, то все счета буду выставляться в тестовой системе trial.hutkigrosh.by',

    ConfigurationFields::ALFACLICK_BUTTON => 'Кнопка Alfaclick',
    ConfigurationFields::ALFACLICK_BUTTON . _DESC => 'Если включена, то на итоговом экране клиенту отобразится кнопка для выставления счета в Alfaclick',

    ConfigurationFields::WEBPAY_BUTTON => 'Кнопка Webpay',
    ConfigurationFields::WEBPAY_BUTTON . _DESC => 'Если включена, то на итоговом экране клиенту отобразится кнопка для оплаты счета картой (переход на Webpay)',

    ConfigurationFields::EMAIL_NOTIFICATION => 'Email оповещение',
    ConfigurationFields::EMAIL_NOTIFICATION . _DESC => 'Если включено, то шлюз ХуткiГрош будет отправлять email оповещение клиенту о выставлении счета',

    ConfigurationFields::SMS_NOTIFICATION => 'Sms оповещение',
    ConfigurationFields::SMS_NOTIFICATION . _DESC => 'Если включено, то шлюз ХуткiГрош будет отправлять sms оповещение клиенту о выставлении счета',

    ConfigurationFields::COMPLETION_TEXT => 'Текст успешного выставления счета',
    ConfigurationFields::COMPLETION_TEXT . _DESC => 'Текст, отображаемый кленту после успешного выставления счета. Может содержать html. ' .
        'В тексте допустимо ссылаться на переменные @order_id, @order_number, @order_total, @order_currency, @order_fullname, @order_phone, @order_address',
    ConfigurationFields::COMPLETION_TEXT . _DEFAULT => '<p>Счет №<strong>@order_number</strong> успешно выставлен в ЕРИП</p>
<p>Вы можете оплатить его наличными деньгами, пластиковой карточкой и электронными деньгами, в любом из отделений
    банков, кассах, банкоматах, платежных терминалах, в системе электронных денег, через Интернет-банкинг, М-банкинг,
    интернет-эквайринг</p>
<p>Для оплаты счета в ЕРИП необходимо:</p>
<ol>
    <li>Выберите дерево платежей ЕРИП</li>
    <li>Выберите услугу: <strong>@erip_path</strong></li>
    <li>Введите номер счета <strong>@order_number</strong></li>
    <li>Проверить корректность информации</li>
    <li>Совершить платеж.</li>
</ol>',

    ConfigurationFields::PAYMENT_METHOD_NAME => 'Название способы оплаты',
    ConfigurationFields::PAYMENT_METHOD_NAME . _DESC => 'Название, отображаемое клиенту, при выборе способа оплаты',
    ConfigurationFields::PAYMENT_METHOD_NAME . _DEFAULT => 'Через систему *Расчет* (ЕРИП)',

    ConfigurationFields::PAYMENT_METHOD_DETAILS => 'Описание способа оплаты',
    ConfigurationFields::PAYMENT_METHOD_DETAILS . _DESC => 'Описание, отображаемое клиенту, при выборе способа оплаты',
    ConfigurationFields::PAYMENT_METHOD_DETAILS . _DEFAULT => '«Хуткi Грош»™ — платежный сервис по выставлению счетов в АИС *Расчет* (ЕРИП). ' .
        'После выставления счета Вам будет доступна его оплата пластиковой карточкой и электронными деньгами, в любом из отделений банков, кассах, банкоматах, платежных терминалах, в системе электронных денег, через Интернет-банкинг, М-банкинг, интернет-эквайринг',

    ConfigurationFields::BILL_STATUS_PENDING => 'Статус при выставлении счета',
    ConfigurationFields::BILL_STATUS_PENDING . _DESC => 'Какой статус выставить заказу при успешном выставлении счета в ЕРИП (идентификатор существующего статуса)',

    ConfigurationFields::BILL_STATUS_PAYED => 'Статус при успешной оплате счета',
    ConfigurationFields::BILL_STATUS_PAYED . _DESC => 'Какой статус выставить заказу при успешной оплате выставленного счета (идентификатор существующего статуса)',

    ConfigurationFields::BILL_STATUS_FAILED => 'Статус при ошибке оплаты счета',
    ConfigurationFields::BILL_STATUS_FAILED . _DESC => 'Какой статус выставить заказу при ошибке выставленния счета (идентификатор существующего статуса)',

    ConfigurationFields::BILL_STATUS_CANCELED => 'Статус при отмене оплаты счета',
    ConfigurationFields::BILL_STATUS_CANCELED . _DESC => 'Какой статус выставить заказу при отмене оплаты счета (идентификатор существующего статуса)',

    ConfigurationFields::DUE_INTERVAL => 'Срок действия счета (дней)',
    ConfigurationFields::DUE_INTERVAL . _DESC => 'Как долго счет, будет доступен в ЕРИП для оплаты',

    ConfigurationFields::ERIP_PATH => 'Путь в дереве ЕРИП',
    ConfigurationFields::ERIP_PATH . _DESC => 'По какому пути клиент должен искать выставленный счет',

    ViewFields::ALFACLICK_LABEL => 'Выставить счет в Alfaclick',
    ViewFields::ALFACLICK_MSG_SUCCESS => 'Счет успешно выставлен в систему Alfaclick',
    ViewFields::ALFACLICK_MSG_UNSUCCESS => 'Ошибка выставления счета в систему Alfaclick',

    ViewFields::WEBPAY_LABEL => 'Оплатить картой',
    ViewFields::WEBPAY_MSG_SUCCESS => 'Счет успешно оплачен через сервис WebPay',
    ViewFields::WEBPAY_MSG_UNSUCCESS => 'Ошибка оплаты счета через сервис WebPay',
);