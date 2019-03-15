<?php

use esas\hutkigrosh\ConfigurationFields;
use esas\hutkigrosh\view\client\ViewFields;

const _DESC = '_desc';
const _DEFAULT = '_default';
const _ERROR_VALIDATION = 'error_validation_';


return array(
    ConfigurationFields::shopName() => 'Shop name',
    ConfigurationFields::shopName() . _DESC => 'Your shop short name',

    ConfigurationFields::login() => 'Login',
    ConfigurationFields::login() . _DESC => 'Hutkigrosh gateway login',

    ConfigurationFields::password() => 'Password',
    ConfigurationFields::password() . _DESC => 'Hutkigrosh gateway password',

    ConfigurationFields::eripId() => 'ERIP ID',
    ConfigurationFields::eripId() . _DESC => 'Your shop ERIP unique id',

    ConfigurationFields::eripTreeId() => 'ERIP Tree code',
    ConfigurationFields::eripTreeId() . _DESC => 'ERIP Tree code',

    ConfigurationFields::sandbox() => 'Sandbox',
    ConfigurationFields::sandbox() . _DESC => 'Sandbox mode. If *true* then all requests will be sent to trial host trial.hgrosh.by',

    ConfigurationFields::instructionsSection() => 'Section Instructions',
    ConfigurationFields::instructionsSection() . _DESC => 'If *true* then customer will see step-by-step instructions to pay bill with ERIP',

    ConfigurationFields::qrcodeSection() => 'Section QR-code',
    ConfigurationFields::qrcodeSection() . _DESC => 'If *true* then customer will be able to pay bill with QR-code',

    ConfigurationFields::alfaclickSection() => 'Section Alfaclick',
    ConfigurationFields::alfaclickSection() . _DESC => 'If *true* then customer will get *Add to Alfaclick* button on success page',

    ConfigurationFields::webpaySection() => 'Section Webpay',
    ConfigurationFields::webpaySection() . _DESC => 'If *true* then customer will get *Pay with car* button on success page',

    ConfigurationFields::notificationEmail() => 'Email notification',
    ConfigurationFields::notificationEmail() . _DESC => 'If *true* then Hutkigrosh gateway will sent email notification to customer',

    ConfigurationFields::notificationSms() => 'Sms notification',
    ConfigurationFields::notificationSms() . _DESC => 'If *true* then Hutkigrosh gateway will sent sms notification to customer',

    ConfigurationFields::completionText() => 'Completion text',
    ConfigurationFields::completionText() . _DESC => 'Text displayed to the client after the successful invoice. Can contain html. ' .
        'In the text you can refer to variables @order_id, @order_number, @order_total, @order_currency, @order_fullname, @order_phone, @order_address',
    ConfigurationFields::completionText() . _DEFAULT => '<p>Bill #<strong>@order_number</strong> was successfully placed in ERIP</p>
<p>You can pay it in cash, a plastic card and electronic money, in any bank, cash departments, ATMs, payment terminals, in the system of electronic money, through Internet banking, M-banking, online acquiring</p>',

    ConfigurationFields::completionCssFile() => 'Completion page CSS file',
    ConfigurationFields::completionCssFile() . _DESC => 'Optional CSS file path for completion page',

    ConfigurationFields::paymentMethodName() => 'Payment method name',
    ConfigurationFields::paymentMethodName() . _DESC => 'Name displayed to the customer when choosing a payment method',
    ConfigurationFields::paymentMethodName() . _DEFAULT => 'AIS *Raschet* (ERIP)',

    ConfigurationFields::paymentMethodDetails() => 'Payment method details',
    ConfigurationFields::paymentMethodDetails() . _DESC => 'Description of the payment method that will be shown to the client at the time of payment',
    ConfigurationFields::paymentMethodDetails() . _DEFAULT => 'Hutkigrosh™ — payment service for invoicing in AIS *Raschet* (ERIP). After invoicing you will be available for payment by a plastic card and electronic money, at any of the bank branches, cash desks, ATMs, payment terminals, in the electronic money system, through Internet banking, M-banking, Internet acquiring',

    ConfigurationFields::billStatusPending() => 'Bill status pending',
    ConfigurationFields::billStatusPending() . _DESC => 'Mapped status for pending bills',

    ConfigurationFields::billStatusPayed() => 'Bill status payed',
    ConfigurationFields::billStatusPayed() . _DESC => 'Mapped status for payed bills',

    ConfigurationFields::billStatusFailed() => 'Bill status failed',
    ConfigurationFields::billStatusFailed() . _DESC => 'Mapped status for failed bills',

    ConfigurationFields::billStatusCanceled() => 'Bill status canceled',
    ConfigurationFields::billStatusCanceled() . _DESC => 'Mapped status for canceled bills',

    ConfigurationFields::dueInterval() => 'Bill due interval (days)',
    ConfigurationFields::dueInterval() . _DESC => 'How many days new bill will be available for payment',

    ConfigurationFields::eripPath() => 'ERIP PATH',
    ConfigurationFields::eripPath() . _DESC => 'По какому пути клиент должен искать выставленный счет',

    ViewFields::INSTRUCTIONS_TAB_LABEL => 'Payment instructions',
    ViewFields::INSTRUCTIONS => '<p>To pay an bill in ERIP:</p>
<ol>
    <li>Select the ERIP payment tree</li>
    <li>Select a service: <strong>@erip_path</strong></li>
    <li>Enter bill number <strong>@order_number</strong></li>
    <li>Verify information is correct</li>
    <li>Make a payment</li>
</ol>',

    ViewFields::QRCODE_TAB_LABEL => 'Pay with QR-code',
    ViewFields::QRCODE_DETAILS => '<p>You can pay this bill by QR-code:</p>
<div align="center">@qr_code</div>
<p>To get information about mobile apps with QR-code payment support please visit <a href="http://pay.raschet.by/" target="_blank"style="color: #8c2003;"><span>this link</span></a></p>',


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
    _ERROR_VALIDATION . esas\hutkigrosh\view\admin\validators\ValidatorNumeric::class => 'Value had to be numeric',
    _ERROR_VALIDATION . esas\hutkigrosh\view\admin\validators\ValidatorEmail::class => 'Wrong email format',
);