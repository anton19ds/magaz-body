<?php
function uprav($data)
{
    return str_replace("\\n", "<br/>", $data);
}
$protokol = "https";
$SERVER_NAME = '';
$SERVER_POST = '';
$data = "";
$get = "";
$opeation = "CREATE_ORDER";
$merchantId = trim($merchantId);
$data .= "$merchantId|$opeation";
$orderId = trim($orderId);
$data .= "|$orderId";
$data .= "|$price";
    $data .= "|$currency";
    $get .= "&CURRENCY=$currency";
    $data .= "|$flag";
    $get = "MERCHANTNUMBER=" . urlencode(trim($merchantId)) . "&OPERATION=$opeation&ORDERNUMBER=" . urlencode($orderId)
        . "&AMOUNT=" . trim($price) . "&DEPOSITFLAG=$flag";
    if (isset($currency) && trim($currency) != "") {
        $get .= "&CURRENCY=$currency";
    }
    if ((isset($ordersend) && $ordersend == 1)) {
        if (!isset($merordernum) || trim($merordernum) == "") {
            $popis[] = "Neni zadano cislo objednavky obchodnika / Merchant Order Number not set";
            $merordernum = "";
        } else {
            $merordernum = trim($merordernum);
            $data .= "|$merordernum";
            $get .= "&MERORDERNUM=" . urlencode(trim($merordernum));
        }
    } else {
        $merordernum = "";
        $ordersend = 0;
    }
    if (isset($source) && $source == "wallet") {
        $url = trim("$protokol://$SERVER_NAME:$SERVER_PORT" . SubStr($SCRIPT_NAME, 0, StrRPos($SCRIPT_NAME, "/")) . "/index.php?action=responseMps");
    } else {
        $url = "https://frame.anticandida.com/cs/sets-data";
    }
    $data .= "|$url";
    $get .= "&URL=" . urlencode($url);

    if (isset($descsend) && $descsend == 1) {
        if (!isset($desc) || trim($desc) == "") {
            $desc = "";
        }
        $desc = trim($desc);
        $desc = htmlentities($desc);
        $data .= "|$desc";
        $get .= "&DESCRIPTION=" . urlencode(trim($desc));
    } else {
        $desc = "";
        $descsend = 0;
    }

    if (isset($mdsend) && $mdsend == 1) {
        if (!isset($md) || trim($md) == "") {
            $md = "";
        }
        $md = trim($md);
        $md = htmlentities($md);
        $data .= "|$md";
        $get .= "&MD=" . urlencode(trim($md));
    } else {
        $md = "";
        $mdsend = 0;
    }


if (!isset($paymuzo) || trim($paymuzo) == "" || trim($paymuzo) == "|") {
    $popis[] = "Neni zadana adresa serveru / Target server not set";
    $paymuzo = "|";
} else {
    $_SESSION['paymuzo'] = $paymuzo;
    $split = explode("|", $paymuzo, 2);
    if (sizeof($split) >= 1) {
        $paymuzo = $split[0];
    }
}
if (isset($source) && $source == "wallet") {
    $_SESSION["source"] = $source;
    if (isset($paymethodId)) {
        $paymethod = $paymethodId;
    }
    if (isset($paymethod)) {
        $_SESSION["paymethod"] = $paymethod;
        $data .= "|$paymethod";
        $get .= "&PAYMETHOD=$paymethod";
    }
    $itemIds = array();
    if (isset($useCart) && $useCart == 1) {
        $_SESSION["useCart"] = $useCart;
        $cartIsUsed = false;
        $cart = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><additionalInfoRequest xmlns=\"http://gpe.cz/gpwebpay/additionalInfo/request\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" version=\"2.0\">";
        if (
            (isset($vatUsed) && $vatUsed == 1) || (isset($shippingUsed) && $shippingUsed == 1) || (isset($handlingUsed) && $handlingUsed == 1)
            || (isset($itemUsed) && sizeof($itemUsed) > 0)
            || (isset($useCart) && trim($useCart == 1))
        ) {
            $cartData = "<shoppingCartInfo>";
            if (isset($vatUsed) && $vatUsed == 1) {
                $cartIsUsed = true;
                $cartData .= "<taxAmount>" . getAmountInSmallest($itemVat) . "</taxAmount>";
                $_SESSION["vUsed"] = 1;
            }
            if (isset($shippingUsed) && $shippingUsed == 1) {
                $cartIsUsed = true;
                $cartData .= "<shippingAmount>" . getAmountInSmallest($itemShipping) . "</shippingAmount>";
                $_SESSION["sUsed"] = 1;
            }
            if (isset($handlingUsed) && $handlingUsed == 1) {
                $cartIsUsed = true;
                $cartData .= "<handlingAmount>" . getAmountInSmallest($itemHandling) . "</handlingAmount>";
                $_SESSION["hUsed"] = 1;
            }
            $cartAmount = 0;
            $cartAmountUsed = false;
            $cartItems = "";
            if (
                (isset($itemCodeN) && trim($itemCodeN) != '') || (isset($itemDescN) && trim($itemDescN) != '') || (isset($itemQuantityN) && trim($itemQuantityN) != '') || (isset($itemPriceN) && trim($itemPriceN) != '')
                || (isset($itemClassN) && trim($itemClassN) != '') || (isset($itemTypeN) && trim($itemTypeN) != '') || (isset($itemUrlN) && trim($itemUrlN) != '')
            ) {
                $cartIsUsed = true;
                if (isset($itemQuantityN) && cislo($itemQuantityN) && isset($itemPriceN) && cislo($itemPriceN)) {
                    $itemPriceN = trim(strtr($itemPriceN, ",", "."));
                    $cartAmount += $itemQuantityN * $itemPriceN;
                    $cartAmountUsed = true;
                }
                $cartItems .= "<shoppingCartItem>";

                if (isset($itemCodeN) && trim($itemCodeN) != '') {
                    $cartItems .= "<itemCode>" . substr(trim($itemCodeN), 0, 20) . "</itemCode>";
                }

                $cartItems .= "<itemDescription>" . substr(trim($itemDescN), 0, 50) . "</itemDescription>";
                $cartItems .= "<itemQuantity>" . substr(trim($itemQuantityN), 0, 12) . "</itemQuantity>";
                $cartItems .= "<itemUnitPrice>" . getAmountInSmallest($itemPriceN) . "</itemUnitPrice>";

                if (isset($itemClassN) && trim($itemClassN) != '') {
                    $cartItems .= "<itemClass>" . substr(trim($itemClassN), 0, 20) . "</itemClass>";
                }
                if (isset($itemTypeN) && trim($itemTypeN) != '') {
                    $cartItems .= "<itemType>" . substr(trim($itemTypeN), 0, 20) . "</itemType>";
                }
                if (isset($itemUrlN) && trim($itemUrlN) != '') {
                    $cartItems .= "<itemImageUrl>" . substr(trim($itemUrlN), 0, 200) . "</itemImageUrl>";
                }

                $cartItems .= "</shoppingCartItem>";
            }
            if (isset($itemCartCount) && $itemCartCount > 0) {
                for ($i = 0; $i < $itemCartCount; $i++) {
                    $isData = false;
                    $eval = "if (isset(\$itemUsed$i) && \$itemUsed$i==1){\$isData = true;}";
                    eval ($eval);
                    if ($isData) {
                        $cartIsUsed = true;
                        eval ("\$itemId=\$itemId$i;");
                        eval ("\$itemCode=\$itemCode$i;");
                        eval ("\$itemDesc=\$itemDesc$i;");
                        eval ("\$itemQuantity=\$itemQuantity$i;");
                        eval ("\$itemPrice=\$itemPrice$i;");
                        eval ("\$itemClass=\$itemClass$i;");
                        eval ("\$itemType=\$itemType$i;");
                        eval ("\$itemUrl=\$itemUrl$i;");

                        $itemIds[$itemId] = $itemId;

                        if (isset($itemQuantity) && cislo($itemQuantity) && isset($itemPrice) && cislo($itemPrice)) {
                            $itemPrice = trim(strtr($itemPrice, ",", "."));
                            $cartAmount += $itemQuantity * $itemPrice;
                            $cartAmountUsed = true;
                        }
                        $cartItems .= "<shoppingCartItem>";

                        if (isset($itemCode) && trim($itemCode) != '') {
                            $cartItems .= "<itemCode>" . substr(trim($itemCode), 0, 20) . "</itemCode>";
                        }

                        $cartItems .= "<itemDescription>" . substr(trim($itemDesc), 0, 50) . "</itemDescription>";
                        $cartItems .= "<itemQuantity>" . substr(trim($itemQuantity), 0, 12) . "</itemQuantity>";
                        $cartItems .= "<itemUnitPrice>" . getAmountInSmallest($itemPrice) . "</itemUnitPrice>";

                        if (isset($itemClass) && trim($itemClass) != '') {
                            $cartItems .= "<itemClass>" . substr(trim($itemClass), 0, 20) . "</itemClass>";
                        }
                        if (isset($itemType) && trim($itemType) != '') {
                            $cartItems .= "<itemType>" . substr(trim($itemType), 0, 20) . "</itemType>";
                        }
                        if (isset($itemUrl) && trim($itemUrl) != '') {
                            $cartItems .= "<itemImageUrl>" . substr(trim($itemUrl), 0, 200) . "</itemImageUrl>";
                        }

                        $cartItems .= "</shoppingCartItem>";

                    }
                }
            }
            if ($cartAmountUsed) {
                $cartData .= "<cartAmount>" . getAmountInSmallest($cartAmount) . "</cartAmount>";
            }
            if ($cartItems != "") {
                $cartData .= "<shoppingCartItems>";
                $cartData .= $cartItems;
                $cartData .= "</shoppingCartItems>";
            }
            $cartData .= "</shoppingCartInfo>";
        }
        if ($cartIsUsed) {
            $cart .= $cartData;
        }
        //echo "returnShipping:".$returnShipping;
        if (
            (isset($returnShipping) && $returnShipping == 1) || (isset($returnLoyality) && $returnLoyality == 1)
            || (isset($shippingRestriction) && trim($shippingRestriction) != "") || (isset($requestDeferredAuthorization) && $requestDeferredAuthorization == 1)
        ) {
            $cart .= "<walletDetails>";
            if (isset($returnShipping) && $returnShipping == 1) {
                $cart .= "<requestShippingDetails>true</requestShippingDetails>";
                $_SESSION["rShipping"] = 1;
            }
            if (isset($returnLoyality) && $returnLoyality == 1) {
                $cart .= "<requestLoyaltyProgram>true</requestLoyaltyProgram>";
                $_SESSION["rLoyality"] = 1;
            }
            if (isset($shippingRestriction) && trim($shippingRestriction) != "") {
                $cart .= "<shippingLocationRestriction>" . trim($shippingRestriction) . "</shippingLocationRestriction>";
                $_SESSION["sRestriction"] = trim($shippingRestriction);
            }
            if (isset($requestDeferredAuthorization) && $requestDeferredAuthorization == 1) {
                $cart .= "<requestDeferredAuthorization>true</requestDeferredAuthorization>";
                $_SESSION["rDeferredAuthorization"] = 1;
            }
            $cart .= "</walletDetails>";
        }
        $cart .= '</additionalInfoRequest>';
        //echo $cart;flush();
        if (sizeof($itemIds) > 0) {
            $_SESSION["itemIds"] = $itemIds;
        }
        $data .= "|" . trim($cart);
    } else {
        $_SESSION["useCart"] = 0;
    }
}
$_SESSION['cesta'] = $paymuzo;
if (defined("SAVE_SIGNATURE_TO_FILE") && SAVE_SIGNATURE_TO_FILE) {
    $filePath = (defined("SAVE_SIGNATURE_FILE_PATH") && trim(SAVE_SIGNATURE_FILE_PATH) != "") ? strftime(SAVE_SIGNATURE_FILE_PATH) : "signature.sign";
    if (strpos($filePath, "@ORDERID@") !== false) {
        $filePath = str_replace("@ORDERID@", $orderId, $filePath);
    }
    $f = fopen($filePath, "w");
    fwrite($f, $signature);
    fclose($f);
    $filePath = (defined("SAVE_SIGNATURE_FILE_PATH_ENCODED") && trim(SAVE_SIGNATURE_FILE_PATH_ENCODED) != "") ? strftime(SAVE_SIGNATURE_FILE_PATH_ENCODED) : "signatureEnc.sign";
    if (strpos($filePath, "@ORDERID@") !== false) {
        $filePath = str_replace("@ORDERID@", $orderId, $filePath);
    }
    $f = fopen($filePath, "w");
    fwrite($f, urlencode($signature));
    fclose($f);
}
$get .= "&DIGEST=" . urlencode($signature);
$path = $paymuzo . "?" . $get;
?>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
    <tr valign="top">
        <td valign="top">
            <div id="main-bottom" align="center">
                <div class="formboxDiv">
                    <form action="<?= $paymuzo ?>" method="post" accept-charset="UTF-8"
                        enctype="application/x-www-form-urlencoded">
                        <table border="0" cellspacing="0" cellpadding="0" class="fmTab">
                            <tbody>
                                <tr class="fmTabBody">
                                    <td align="left">
                                        <div class="formboxDiv">
                                            <table cellspacing="0" cellpadding="0" class="fmTabSect">
                                                <tbody>
                                                    <tr class="fmTabBody">
                                                        <td class="fmTabSecBorderLeft">&nbsp;</td>
                                                        <td align="center">
                                                            <table border="0" cellspacing="0" cellpadding="0"
                                                                width="100%" align="center">
                                                                <tr>
                                                                    <td nowrap="nowrap" colspan="2"
                                                                        style="text-align:right;">
                                                                        <input type="submit" value="Odeslat / Submit" />
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                                <?php if (!isset($popis) || sizeof($popis) == 0) { ?>
                                    <tr>
                                        <td class="formboxSeparator">Link pro zaplaceni metodou GET / GET method link:
                                            <a href="<?= $path ?>">Link</a><br />
                                            <textarea readonly cols="100" rows="5"><?= $path ?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="formboxSeparator" valign="top" style="text-align: top;">
                                            <b><?= $paymuzo ?></b><br />
                                            <br />
                                            MERCHANTNUMBER=<input type="text" value="<?= $merchantId ?>" readonly
                                                disabled />
                                            <br />
                                            <input type="text" value="<?= $merchantId ?>" name="MERCHANTNUMBER" />
                                            <br>
                                            OPERATION=<input type="text" value="<?= $opeation ?>" readonly disabled /><br />
                                            <input type="text" value="<?= $opeation ?>" name="OPERATION" />
                                            <br>
                                            ORDERNUMBER=<input type="text" value="<?= $orderId ?>" readonly
                                                disabled /><br />
                                            <input type="text" value="<?= $orderId ?>" name="ORDERNUMBER" />
                                            <br>
                                            AMOUNT=<input type="text" value="<?= $price ?>" readonly disabled /><br />

                                            <input type="text" value="<?= $price ?>" name="AMOUNT" />
                                            <br>

                                            <?php if (isset($currency) && $currency != "") { ?>
                                                CURRENCY=<input type="text" value="<?= $currency ?>" readonly disabled /><br />
                                                <input type="hidden" value="<?= $currency ?>" name="CURRENCY" />
                                                <?= htmlentities("<input type=\"text\" value=\"<?=\$currency?>\" name=\"CURRENCY\"/>"); ?><br />
                                            <?php } ?>

                                            <?php if (isset($flag)) { ?>
                                                DEPOSITFLAG=<input type="text" value="<?= $flag ?>" readonly disabled /><br />
                                                <input type="hidden" value="<?= $flag ?>" name="DEPOSITFLAG" />
                                            <?php } ?>

                                            <?
                                            if (isset($ordersend) && $ordersend == 1) {
                                                echo "MERORDERNUM=<input type=\"text\" value=\"$merordernum\" readonly disabled/>";
                                                echo "<input type=\"hidden\" value=\"$merordernum\" name=\"MERORDERNUM\"/><br/>";
                                            }
                                            ?>

                                            <input type="hidden" value="<?= $url ?>" name="URL" />
                                            <?= htmlentities("<input type=\"text\" value=\"<?=\$url?>\" name=\"URL\"/>"); ?><br />
                                            <?
                                            if (isset($descsend) && $descsend == 1) {
                                                echo "<input type=\"text\" value=\"$desc\" name=\"DESCRIPTION\"/><br/>";
                                            }
                                            ?>

                                            <?
                                            if (isset($mdsend) && $mdsend == 1) {
                                                echo "<input type=\"text\" value=\"$md\" name=\"MD\"/><br/>";
                                            }
                                            ?>
                                            <textarea disabled readonly cols="100"
                                                rows="5"><?= $signature ?></textarea>
                                            <input type="hidden" value="<?= $signature ?>" name="DIGEST" /><br />
                                            <input type="submit" value="Odeslat / Submit" /><br />
                                        <td class="formboxSeparator"></td>
                                    </tr>
                                <?php } else { ?>
                                    <tr>
                                        <td class="formboxSeparator" align="right">
                                            <input type="button" value="Zpet/Back" />
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </td>
    </tr>
</table>