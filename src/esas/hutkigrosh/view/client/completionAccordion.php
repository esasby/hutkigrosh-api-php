<?php
/** @var \esas\hutkigrosh\view\client\CompletionPanel $viewData */
/** @var \esas\hutkigrosh\view\client\ViewStyle $viewStyle */
/** Определяем какой tab раскрыть */
if ('' != $viewData->getWebpayStatus()) {
    $webpayTabChecked = 'checked="checked"';
    $instractionTabChecked = "";
} else {
    $webpayTabChecked = ""; // заполняем пустым, чтобы в opencart не отображался notice
    $instractionTabChecked = 'checked="checked"';
}

use esas\hutkigrosh\utils\RequestParams; ?>


<div id="hutkigrosh" class="wrapper <?= $viewStyle->getParentDivClass() ?>">
    <div id="completion-text" class="<?= $viewStyle->getCompletionTextDivClass() ?>">
        <?php echo $viewData->getCompletionText() ?>
    </div>
    <?php if ($viewData->isInstructionsSectionEnabled()) { ?>
        <div id="tab-instructions" class="tab">
            <input id="input-instructions" type="checkbox" name="tabs2" <?= $instractionTabChecked ?>>
            <label for="input-instructions" class="<?= $viewStyle->getTabLabelClass() ?>">
                <?= $viewData->getInstructionsTabLabel() ?>
            </label>
            <div class="tab-content <?= $viewStyle->getTabContentClass() ?>">
                <div id="hutkigrosh_instructions_text">
                    <?php echo $viewData->getInstructionsText() ?>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if ($viewData->isQRCodeSectionEnabled()) { ?>
        <div id="tab-qrcode" class="tab">
            <input id="input-qrcode" type="checkbox" name="tabs2">
            <label for="input-qrcode" class="<?= $viewStyle->getTabLabelClass() ?>">
                <?= $viewData->getQRCodeTabLabel() ?>
            </label>
            <div class="tab-content <?= $viewStyle->getTabContentClass() ?>">
                <div id="qrcode_details">
                    <?= $viewData->getQRCodeDetails() ?>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if ($viewData->isWebpaySectionEnabled()) { ?>
        <div id="tab-webpay" class="tab">
            <input id="input-webpay" type="checkbox" name="tabs2" <?= $webpayTabChecked ?>>
            <label for="input-webpay" class="<?= $viewStyle->getTabLabelClass() ?>">
                <?= $viewData->getWebpayTabLabel() ?>
            </label>
            <div class="tab-content <?= $viewStyle->getTabContentClass() ?>">
                <div id="webpay_details">
                    <?= $viewData->getWebpayDetails() ?>
                    <br/><br/>
                    <img src="<?= \esas\hutkigrosh\utils\ResourceUtils::getImageUrl('ps_icons.png') ?>" alt="">
                </div>
                <?php if ('payed' == $viewData->getWebpayStatus()) { ?>
                    <div class="<?= $viewStyle->getMsgSuccessClass() ?>"
                         id="webpay_message"><?= $viewData->getWebpayMsgSuccess() ?></div>
                <?php } elseif ('failed' == $viewData->getWebpayStatus()) { ?>
                    <div class="<?= $viewStyle->getMsgUnsuccessClass() ?>"
                         id="webpay_message"><?= $viewData->getWebpayMsgUnsuccess() ?></div>
                <?php } ?>
                <?php if ("" != $viewData->getWebpayForm()) { ?>
                    <div id="webpay">
                        <?php echo $viewData->getWebpayForm(); ?>
                    </div>
                <?php } else { ?>
                    <div id="webpay_message_unavailable"><?= $viewData->getWebpayMsgUnavailable() ?></div>
                <?php } ?>

                <script type="text/javascript"
                        src="http://ajax.microsoft.com/ajax/jQuery/jquery-1.11.0.min.js"></script>
                <script>
                    var webpay_form_button = $('#webpay input[type="submit"]');
                    webpay_form_button.attr('id', 'webpay_button');
                    webpay_form_button.addClass('<?= $viewStyle->getWebpayButtonClass() ?>');
                </script>
            </div>
        </div>
    <?php } ?>

    <?php if ($viewData->isAlfaclickSectionEnabled()) { ?>
        <div id="tab-alfaclick" class="tab">
            <input id="input-alfaclick" type="checkbox" name="tabs2">
            <label for="input-alfaclick" class="<?= $viewStyle->getTabLabelClass() ?>">
                <?= $viewData->getAlfaclickTabLabel() ?>
            </label>
            <div class="tab-content <?= $viewStyle->getTabContentClass() ?>">
                <div id="alfaclick_details"><?= $viewData->getAlfaclickDetails() ?></div>
                <div id="alfaclick_form">
                    <input type="hidden" value="<?= $viewData->getAlfaclickBillID() ?>" id="billID"/>
                    <input type="tel" maxlength="20" value="<?= $viewData->getAlfaclickPhone() ?>" id="phone"/>
                    <a class="<?= $viewStyle->getAlfaclickButtonClass() ?>"
                       id="alfaclick_button"><?= $viewData->getAlfaclickButtonLabel() ?></a>
                </div>
                <script type="text/javascript"
                        src="http://ajax.microsoft.com/ajax/jQuery/jquery-1.11.0.min.js"></script>
                <script>
                    jQuery(document).ready(function ($) {
                        $('#alfaclick_button').click(function () {
                            jQuery.post('<?= $viewData->getAlfaclickUrl() ?>',
                                {
                            <?= RequestParams::PHONE ?>:
                            $('#phone').val(),
                            <?= RequestParams::BILL_ID ?>:
                            $('#billID').val()
                        }
                        ).
                            done(function (result) {
                                if (result.trim() == 'ok') {
                                    $('#alfaclick_message').remove();
                                    $('#alfaclick_details').after('<div class="<?= $viewStyle->getMsgSuccessClass() ?>" id="alfaclick_message"><?= $viewData->getAlfaclickMsgSuccess() ?></div>');
                                } else {
                                    $('#alfaclick_message').remove();
                                    $('#alfaclick_details').after('<div class="<?= $viewStyle->getMsgUnsuccessClass() ?>" id="alfaclick_message"><?= $viewData->getAlfaclickMsgUnsuccess() ?></div>');
                                }
                            })
                        })
                    });
                </script>
            </div>
        </div>
    <?php } ?>
    <style>
        /* Acordeon styles */
        .tab {
            position: relative;
            margin-bottom: 1px;
            width: 100%;
            /*color: #fff;*/
            overflow: hidden;
        }

        .tab > input {
            position: absolute;
            opacity: 0;
            z-index: -1;
        }

        .tab > label {
            position: relative;
            display: block;
            padding: 0 0 0 1em;
            /*font-weight: bold;*/
            line-height: 3;
            cursor: pointer;
        }

        .tab-content {
            max-height: 0;
            overflow: hidden;
            -webkit-transition: max-height .35s;
            -o-transition: max-height .35s;
            transition: max-height .35s;
        }

        .tab-content p {
            margin: 1em;
        }

        .tab-content div {
            margin: 1em;
        }

        /* :checked */
        .tab > input:checked ~ .tab-content {
            max-height: 100vh;
        }

        /* Icon */
        .tab > label::after {
            position: absolute;
            right: 0;
            top: 0;
            display: block;
            width: 3em;
            height: 3em;
            line-height: 3;
            text-align: center;
            -webkit-transition: all .35s;
            -o-transition: all .35s;
            transition: all .35s;
        }

        .tab > input[type=checkbox] + label::after {
            content: "+";
        }

        .tab > input[type=radio] + label::after {
            content: "\25BC";
        }

        .tab > input[type=checkbox]:checked + label::after {
            transform: rotate(315deg);
        }

        .tab > input[type=radio]:checked + label::after {
            transform: rotateX(180deg);
        }

        <?= $viewStyle->getAdditionalCss() ?>
    </style>
</div>