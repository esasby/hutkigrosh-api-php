<?php
/**
 * Created by IntelliJ IDEA.
 * User: nikit
 * Date: 04.06.2019
 * Time: 12:43
 */
use esas\hutkigrosh\utils\htmlbuilder\Attributes as attribute;
use esas\hutkigrosh\utils\htmlbuilder\Elements as element;
use esas\hutkigrosh\utils\RequestParams;
use esas\hutkigrosh\view\client\elements\DivAlfaclick;

/** @var array $scriptData */
/** @var \esas\hutkigrosh\view\client\CompletionPanel $completionPanel */
$completionPanel = $this->scriptData["completionPanel"];
?>

<script type="text/javascript"
        src="http://ajax.microsoft.com/ajax/jQuery/jquery-1.11.0.min.js"></script>
<script style="display: none">
    jQuery(document).ready(function ($) {
        $('#alfaclick_button').click(function () {
            jQuery.post('<?= $completionPanel->getAlfaclickUrl() ?>',
                {
            <?= RequestParams::PHONE ?>:
            $('#phone').val(),
            <?= RequestParams::BILL_ID ?>:
            $('#billID').val()
        }
        ).
            done(function (result) {
                if ('ok' == result.trim()) {
                    $('#alfaclick_message').remove();
                    $('#alfaclick_details').after('<?=
                        element::div(
                            attribute::clazz($completionPanel->getCssClass4MsgSuccess()),
                            attribute::id("alfaclick_message"),
                            element::content($completionPanel->getAlfaclickMsgSuccess())
                        )?>');
                } else {
                    $('#alfaclick_message').remove();
                    $('#alfaclick_details').after('<?=
                        element::div(
                            attribute::clazz($completionPanel->getCssClass4MsgUnsuccess()),
                            attribute::id("alfaclick_message"),
                            element::content($completionPanel->getAlfaclickMsgUnsuccess())
                        )?>');
                }
            })
        })
    });
</script>