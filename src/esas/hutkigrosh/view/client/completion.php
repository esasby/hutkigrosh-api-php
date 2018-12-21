<?php /** @var \esas\hutkigrosh\view\client\CompletionPanel $viewData */?>
<?php /** @var \esas\hutkigrosh\view\client\ViewStyle $viewStyle */?>
<!--DEPRECATED-->
<div id="hutkigrosh" class="<?= $viewStyle->getParentDivClass() ?>">
	<div id="hutkigrosh_completion_text" class="<?= $viewStyle->getCompletionTextDivClass() ?>">
		<?php echo $viewData->getCompletionText() ?>
	</div>
    <div id="hutkigrosh_buttons" class="<?= $viewStyle->getButtonsDivClass() ?>">
        <?php if ($viewData->isWebpaySectionEnabled()) { ?>
            <?php if ('payed' == $viewData->getWebpayStatus()) { ?>
            <div class="<?= $viewStyle->getMsgSuccessClass() ?>"
                 id="hutkigrosh_message"><?= $viewData->getWebpayMsgSuccess() ?></div>
        <?php } elseif ('failed' == $viewData->getWebpayStatus()) { ?>
            <div class="<?= $viewStyle->getMsgUnsuccessClass() ?>"
                 id="hutkigrosh_message"><?= $viewData->getWebpayMsgUnsuccess() ?></div>
        <?php } ?>
            <div id="webpay">
                <?php echo $viewData->getWebpayForm() ?>
            </div>
            <script type="text/javascript" src="http://ajax.microsoft.com/ajax/jQuery/jquery-1.11.0.min.js"></script>
            <script>
                var webpay_form_button = $('#webpay input[type="submit"]');
                webpay_form_button.addClass('<?= $viewStyle->getWebpayButtonClass() ?>');
            </script>
        <?php } ?>
        <?php if ($viewData->isAlfaclickSectionEnabled()) { ?>
            <div id="alfaclick">
                <input type="hidden" value="<?= $viewData->getAlfaclickBillID() ?>" id="billID"/>
                <input type="tel" maxlength="20" value="<?= $viewData->getAlfaclickPhone() ?>" id="phone"/>
                <a class="<?= $viewStyle->getAlfaclickButtonClass() ?>"
                   id="alfaclick_button"><?= $viewData->getAlfaclickLabel() ?></a>
            </div>
            <script type="text/javascript" src="http://ajax.microsoft.com/ajax/jQuery/jquery-1.11.0.min.js"></script>
            <script>
                jQuery(document).ready(function ($) {
                    $('#alfaclick_button').click(function () {
                        jQuery.post('<?= $viewData->getAlfaclickUrl() ?>',
                            {
                                phone: $('#phone').val(),
                                billid: $('#billID').val()
                            }
                        ).done(function (result) {
                            if (result.trim() == 'ok') {
                                $('#hutkigrosh_message').remove();
                                $('#hutkigrosh_buttons').before('<div class="<?= $viewStyle->getMsgSuccessClass() ?>" id="hutkigrosh_message"><?= $viewData->getAlfaclickMsgSuccess() ?></div>');
                            } else {
                                $('#hutkigrosh_message').remove();
                                $('#hutkigrosh_buttons').before('<div class="<?= $viewStyle->getMsgUnsuccessClass() ?>" id="hutkigrosh_message"><?= $viewData->getAlfaclickMsgUnsuccess() ?></div>');
                            }
                        })
                    })
                });
            </script>
        <?php } ?>
    </div>
</div>