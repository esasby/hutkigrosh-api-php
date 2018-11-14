<?php

use esas\hutkigrosh\ConfigurationFields;
use esas\hutkigrosh\view\client\ViewFields;

const _DESC = '_desc';
const _DEFAULT = '_default';
const _ERROR_VALIDATION = 'error_validation_';


return array(
    ConfigurationFields::SHOP_NAME => 'Shop name',
    ConfigurationFields::SHOP_NAME . _DESC => 'Your shop short name',

    ConfigurationFields::LOGIN => 'Login',
    ConfigurationFields::LOGIN . _DESC => 'Hutkigrosh gateway login',

    ConfigurationFields::PASSWORD => 'Password',
    ConfigurationFields::PASSWORD . _DESC => 'Hutkigrosh gateway password',

    ConfigurationFields::ERIP_ID => 'ERIP ID',
    ConfigurationFields::ERIP_ID . _DESC => 'Your shop ERIP unique id',

    ConfigurationFields::SANDBOX => 'Sandbox',
    ConfigurationFields::SANDBOX . _DESC => 'Sandbox mode. If *true* then all requests will be sent to trial host',

    ConfigurationFields::ALFACLICK_BUTTON => 'Button Alfaclick',
    ConfigurationFields::ALFACLICK_BUTTON . _DESC => 'If *true* then customer will get *Add to Alfaclick* button on success page',

    ConfigurationFields::WEBPAY_BUTTON => 'Button Webpay',
    ConfigurationFields::WEBPAY_BUTTON . _DESC => 'If *true* then customer will get *Pay with car* button on success page',

    ConfigurationFields::EMAIL_NOTIFICATION => 'Email notification',
    ConfigurationFields::EMAIL_NOTIFICATION . _DESC => 'If *true* then Hutkigrosh gateway will sent email notification to customer',

    ConfigurationFields::SMS_NOTIFICATION => 'Sms notification',
    ConfigurationFields::SMS_NOTIFICATION . _DESC => 'If *true* then Hutkigrosh gateway will sent sms notification to customer',

    ConfigurationFields::COMPLETION_TEXT => 'Completion text',
    ConfigurationFields::COMPLETION_TEXT . _DESC => 'Text displayed to the client after the successful invoice. Can contain html. ' .
        'In the text you can refer to variables @order_id, @order_number, @order_total, @order_currency, @order_fullname, @order_phone, @order_address',
    ConfigurationFields::COMPLETION_TEXT . _DEFAULT => '<p>Bill #<strong>@order_number</strong> was successfully placed in ERIP</p>
<p>You can pay it in cash, a plastic card and electronic money, in any of the branches banks, cash departments, ATMs, payment terminals, in the system of electronic money, through Internet banking, M-banking, online acquiring</p>
<p>To pay an bill in ERIP:</p>
<ol>
    <li>Select the ERIP payment tree</li>
    <li>Select a service: <strong>@erip_path</strong></li>
    <li>Enter bill number <strong>@order_number</strong></li>
    <li>Verify information is correct</li>
    <li>Make a payment</li>
</ol>',

    ConfigurationFields::PAYMENT_METHOD_NAME => 'Payment method name',
    ConfigurationFields::PAYMENT_METHOD_NAME . _DESC => 'Name displayed to the customer when choosing a payment method',
    ConfigurationFields::PAYMENT_METHOD_NAME . _DEFAULT => 'AIS *Raschet* (ERIP)',

    ConfigurationFields::PAYMENT_METHOD_DETAILS => 'Payment method details',
    ConfigurationFields::PAYMENT_METHOD_DETAILS . _DESC => 'Description of the payment method that will be shown to the client at the time of payment',
    ConfigurationFields::PAYMENT_METHOD_DETAILS . _DEFAULT => 'Hutkigrosh™ — payment service for invoicing in AIS *Raschet* (ERIP). After invoicing you will be available for payment by a plastic card and electronic money, at any of the bank branches, cash desks, ATMs, payment terminals, in the electronic money system, through Internet banking, M-banking, Internet acquiring',

    ConfigurationFields::BILL_STATUS_PENDING => 'Bill status pending',
    ConfigurationFields::BILL_STATUS_PENDING . _DESC => 'Mapped status for pending bills',

    ConfigurationFields::BILL_STATUS_PAYED => 'Bill status payed',
    ConfigurationFields::BILL_STATUS_PAYED . _DESC => 'Mapped status for payed bills',

    ConfigurationFields::BILL_STATUS_FAILED => 'Bill status failed',
    ConfigurationFields::BILL_STATUS_FAILED . _DESC => 'Mapped status for failed bills',

    ConfigurationFields::BILL_STATUS_CANCELED => 'Bill status canceled',
    ConfigurationFields::BILL_STATUS_CANCELED . _DESC => 'Mapped status for canceled bills',

    ConfigurationFields::DUE_INTERVAL => 'Bill due interval (days)',
    ConfigurationFields::DUE_INTERVAL . _DESC => 'How many days new bill will be available for payment',

    ConfigurationFields::ERIP_PATH => 'ERIP PATH',
    ConfigurationFields::ERIP_PATH . _DESC => 'По какому пути клиент должен искать выставленный счет',

    ViewFields::ALFACLICK_TAB_LABEL => 'Add bill to «Alfa-click»',
    ViewFields::ALFACLICK_DETAILS => 'You can add bill to «Alfa-click» system (e-Invoicing)',
    ViewFields::ALFACLICK_BUTTON_LABEL => 'Add bill',
    ViewFields::ALFACLICK_MSG_SUCCESS => 'Bill was added to «Alfa-click»',
    ViewFields::ALFACLICK_MSG_UNSUCCESS => 'Can not add bill to «Alfa-click»',

    ViewFields::WEBPAY_TAB_LABEL => 'Pay with card',
    ViewFields::WEBPAY_DETAILS => 'You can pay bill with Visa, Mastercard or Belcard',
    ViewFields::WEBPAY_BUTTON_LABEL => 'Continue',
    ViewFields::WEBPAY_MSG_SUCCESS => 'Webpay: payment completed!',
    ViewFields::WEBPAY_MSG_UNSUCCESS => 'Webpay: payment failed!',
    ViewFields::WEBPAY_MSG_UNAVAILABLE => 'Sorry, operation currently not available',

    _ERROR_VALIDATION . esas\hutkigrosh\view\admin\validators\ValidatorNotEmpty::class => 'Value can not be empty',
    _ERROR_VALIDATION . esas\hutkigrosh\view\admin\validators\ValidatorInteger::class => 'Value had to be between %d and %d',
);