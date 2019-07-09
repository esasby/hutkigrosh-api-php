<?php
/**
 * Created by IntelliJ IDEA.
 * User: nikit
 * Date: 04.06.2019
 * Time: 12:43
 */

/** @var array $scriptData */
/** @var \esas\hutkigrosh\view\client\CompletionPanel $completionPanel */
$completionPanel = $this->scriptData["completionPanel"];
?>

<script type="text/javascript"
        src="http://ajax.microsoft.com/ajax/jQuery/jquery-1.11.0.min.js"></script>
<script style="display: none">
    var webpay_form_button = $('#webpay input[type="submit"]');
    webpay_form_button.attr('id', 'webpay_button');
    webpay_form_button.addClass('<?= $completionPanel->getCssClass4WebpayButton() ?>');
</script>