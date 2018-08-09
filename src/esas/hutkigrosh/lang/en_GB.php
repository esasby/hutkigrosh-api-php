<?php

use esas\hutkigrosh\wrappers\ConfigurationWrapper;

const _DESC = '_desc';
const _DEFAULT = '_default';

return array(
    ConfigurationWrapper::CONFIG_HG_SHOP_NAME => 'Shop name',
    ConfigurationWrapper::CONFIG_HG_SHOP_NAME . _DESC => 'Your shop short name',

    ConfigurationWrapper::CONFIG_HG_LOGIN => 'Login',
    ConfigurationWrapper::CONFIG_HG_LOGIN . _DESC => 'Hutkigrosh gateway login',

    ConfigurationWrapper::CONFIG_HG_PASSWORD => 'Password',
    ConfigurationWrapper::CONFIG_HG_PASSWORD . _DESC => 'Hutkigrosh gateway password',

    ConfigurationWrapper::CONFIG_HG_ERIP_ID => 'ERIP ID',
    ConfigurationWrapper::CONFIG_HG_ERIP_ID . _DESC => 'Your shop ERIP unique id',

    ConfigurationWrapper::CONFIG_HG_SANDBOX => 'Sandbox',
    ConfigurationWrapper::CONFIG_HG_SANDBOX . _DESC => 'Sandbox mode. If *true* then all requests will be sent to trial host',

    ConfigurationWrapper::CONFIG_HG_ALFACLICK_BUTTON => 'Button Alfaclick',
    ConfigurationWrapper::CONFIG_HG_ALFACLICK_BUTTON . _DESC => 'If *true* then customer will get *Add to Alfaclick* button on success page',

    ConfigurationWrapper::CONFIG_HG_WEBPAY_BUTTON => 'Button Webpay',
    ConfigurationWrapper::CONFIG_HG_WEBPAY_BUTTON . _DESC => 'If *true* then customer will get *Pay with car* button on success page',

    ConfigurationWrapper::CONFIG_HG_EMAIL_NOTIFICATION => 'Email notification',
    ConfigurationWrapper::CONFIG_HG_EMAIL_NOTIFICATION . _DESC => 'If *true* then Hutkigrosh gateway will sent email notification to customer',

    ConfigurationWrapper::CONFIG_HG_SMS_NOTIFICATION => 'Sms notification',
    ConfigurationWrapper::CONFIG_HG_SMS_NOTIFICATION . _DESC => 'If *true* then Hutkigrosh gateway will sent sms notification to customer',

    ConfigurationWrapper::CONFIG_HG_COMPLETION_TEXT => 'Completion text',
    ConfigurationWrapper::CONFIG_HG_COMPLETION_TEXT . _DESC => 'Text displayed to the client after the successful invoice. Can contain html. ' .
        'In the text you can refer to variables @order_id, @order_number, @order_total, @order_currency, @order_fullname, @order_phone, @order_address',
    ConfigurationWrapper::CONFIG_HG_COMPLETION_TEXT . _DEFAULT => '<p>Bill #<strong>@order_number</strong> was successfully placed in ERIP</p>
<p>You can pay it in cash, a plastic card and electronic money, in any of the branches
     banks, cash departments, ATMs, payment terminals, in the system of electronic money, through Internet banking, M-banking,
     online acquiring</p>
<p>To pay an bill in ERIP:</p>
<ol>
    <li>Select the ERIP payment tree</li>
    <li>Select a service: <strong>Payments &gt; Online stores</strong></li>
    <li>Enter bill number <strong>@order_number</strong></li>
    <li>Verify information is correct</li>
    <li>Make a payment</li>
</ol>',

    ConfigurationWrapper::CONFIG_HG_PAYMENT_METHOD_NAME => 'Payment method name',
    ConfigurationWrapper::CONFIG_HG_PAYMENT_METHOD_NAME . _DESC => 'Name displayed to the customer when choosing a payment method',
    ConfigurationWrapper::CONFIG_HG_PAYMENT_METHOD_NAME . _DEFAULT => 'AIS *Raschet* (ERIP)',

    ConfigurationWrapper::CONFIG_HG_PAYMENT_METHOD_DETAILS => 'Payment method details',
    ConfigurationWrapper::CONFIG_HG_PAYMENT_METHOD_DETAILS . _DESC => 'Description of the payment method that will be shown to the client at the time of payment',
    ConfigurationWrapper::CONFIG_HG_PAYMENT_METHOD_DETAILS . _DEFAULT => 'Hutkigrosh™ — payment service for invoicing in AIS *Raschet* (ERIP). After invoicing you will be available for payment by a plastic card and electronic money, at any of the bank branches, cash desks, ATMs, payment terminals, in the electronic money system, through Internet banking, M-banking, Internet acquiring',

    ConfigurationWrapper::CONFIG_HG_BILL_STATUS_PENDING => 'Bill status pending',
    ConfigurationWrapper::CONFIG_HG_BILL_STATUS_PENDING . _DESC => 'Mapped status for pending bills',

    ConfigurationWrapper::CONFIG_HG_BILL_STATUS_PAYED => 'Bill status payed',
    ConfigurationWrapper::CONFIG_HG_BILL_STATUS_PAYED . _DESC => 'Mapped status for payed bills',

    ConfigurationWrapper::CONFIG_HG_BILL_STATUS_FAILED => 'Bill status failed',
    ConfigurationWrapper::CONFIG_HG_BILL_STATUS_FAILED . _DESC => 'Mapped status for failed bills',

    ConfigurationWrapper::CONFIG_HG_BILL_STATUS_CANCELED => 'Bill status canceled',
    ConfigurationWrapper::CONFIG_HG_BILL_STATUS_CANCELED . _DESC => 'Mapped status for canceled bills',

    ConfigurationWrapper::CONFIG_HG_DUE_INTERVAL => 'Bill due interval (days)',
    ConfigurationWrapper::CONFIG_HG_DUE_INTERVAL . _DESC => 'How many days new bill will be availible for payment',

    'hutkigrosh_alfaclick_label' => 'Add bill ti Alfaclick',
    'hutkigrosh_alfaclick_msg_success' => 'Bill was added to Alfaclick',
    'hutkigrosh_alfaclick_msg_unsuccess' => 'Can not add bill to Alfaclick',
    'hutkigrosh_webpay_msg_payed' => 'Webpay: payment completed!',
    'hutkigrosh_webpay_msg_failed' => 'Webpay: payment failed!',
);