<?php
use yii\helpers\Html;
use Yii;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>
        <?= Html::encode($this->title) ?>
    </title>
    <style media="all">
        /* -------------------------------------
                GLOBAL
            ------------------------------------- */
        * {
            margin: 0;
            padding: 0;
            font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
            box-sizing: border-box;
            font-size: 14px;
        }

        img {
            max-width: 100%;
        }

        body {
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: none;
            width: 100% !important;
            height: 100%;
            line-height: 1.6;
        }

        /* Let's make sure all tables have defaults */
        table td {
            vertical-align: top;
        }

        /* -------------------------------------
                BODY & CONTAINER
            ------------------------------------- */
        body {
            background-color: #f6f6f6;
        }

        .body-wrap {
            background-color: #f6f6f6;
            width: 100%;
        }

        .container {
            display: block !important;
            max-width: 1000px !important;
            margin: 0 auto !important;
            /* makes it centered */
            clear: both !important;
        }

        .content {
            max-width: 1000px;
            margin: 0 auto;
            display: block;
            padding: 20px;
        }

        /* -------------------------------------
                HEADER, FOOTER, MAIN
            ------------------------------------- */
        .main {
            background: #fff;
            border: 1px solid #e9e9e9;
            border-radius: 3px;
        }

        .content-wrap {
            padding: 20px;
        }

        .content-block {
            padding: 10px;
            width: 50%;
        }

        .header {
            width: 100%;
            margin-bottom: 20px;
        }

        .footer {
            width: 100%;
            clear: both;
            color: #999;
            padding: 20px;
        }

        .footer a {
            color: #999;
        }

        .footer p,
        .footer a,
        .footer unsubscribe,
        .footer td {
            font-size: 12px;
        }

        /* -------------------------------------
                GRID AND COLUMNS
            ------------------------------------- */
        .column-left {
            float: left;
            width: 50%;
        }

        .column-right {
            float: left;
            width: 50%;
        }

        /* -------------------------------------
                TYPOGRAPHY
            ------------------------------------- */
        h1,
        h2,
        h3 {
            font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
            color: #000;
            margin: 40px 0 0;
            line-height: 1.2;
            font-weight: 400;
        }

        h1 {
            font-size: 18px;
            font-weight: 500;
        }

        h2 {
            font-size: 24px;
        }

        h3 {
            font-size: 18px;
        }

        h4 {
            font-size: 14px;
            font-weight: 600;
        }

        p,
        ul,
        ol {
            margin-bottom: 10px;
            font-weight: normal;
        }

        p li,
        ul li,
        ol li {
            margin-left: 5px;
            list-style-position: inside;
        }

        /* -------------------------------------
                LINKS & BUTTONS
            ------------------------------------- */
        a {
            color: #348eda;
            text-decoration: underline;
        }

        .btn-primary {
            text-decoration: none;
            color: #FFF;
            background-color: #348eda;
            border: solid #348eda;
            border-width: 10px 20px;
            line-height: 2;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            display: inline-block;
            border-radius: 5px;
            text-transform: capitalize;
        }

        /* -------------------------------------
                OTHER STYLES THAT MIGHT BE USEFUL
            ------------------------------------- */
        .last {
            margin-bottom: 0;
        }

        .first {
            margin-top: 0;
        }

        .padding {
            padding: 10px 0;
        }

        .aligncenter {
            text-align: center;
        }

        .alignright {
            text-align: right;
        }

        .alignleft {
            text-align: left;
        }

        .clear {
            clear: both;
        }

        /* -------------------------------------
                Alerts
            ------------------------------------- */
        .alert {
            font-size: 16px;
            color: #fff;
            font-weight: 500;
            padding: 20px;
            text-align: center;
            border-radius: 3px 3px 0 0;
        }

        .alert a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            font-size: 16px;
        }

        .alert.alert-warning {
            background: #ff9f00;
        }

        .alert.alert-bad {
            background: #d0021b;
        }

        .alert.alert-good {
            background: #68b90f;
        }

        /* -------------------------------------
                                BODY & CONTAINER
            ------------------------------------- */
        body {
            background-color: #f4f5f6;
            margin: 0;
            padding: 0;
        }

        .body {
            background-color: #f4f5f6;
            width: 100%;
        }

        .container {
            margin: 0 auto !important;
            max-width: 1000px;
            padding: 0;
            padding-top: 24px;
            width: 1000px;
        }

        .content {
            box-sizing: border-box;
            display: block;
            margin: 0 auto;
            max-width: 1000px;
            padding: 0;
        }

        .center {
            text-align: center;
        }

        .logo {
            width: 50%;
        }

        /* -------------------------------------
                RESPONSIVE AND MOBILE FRIENDLY STYLES
            ------------------------------------- */
        @media only screen and (max-width: 640px) {

            h1,
            h2,
            h3,
            h4 {
                font-weight: 600 !important;
                margin: 20px 5px 5px !important;
            }

            h1 {
                font-size: 22px !important;
            }

            h2 {
                font-size: 18px !important;
            }

            h3 {
                font-size: 16px !important;
            }

            .container {
                width: 100% !important;
            }

            .content,
            .content-wrapper {
                padding: 10px !important;
            }

            /* -------------------------------------
                    BODY & CONTAINER
                ------------------------------------- */
            body {
                background-color: #f4f5f6;
                margin: 0;
                padding: 0;
            }

            .body {
                background-color: #f4f5f6;
                width: 100%;
            }

            .container {
                margin: 0 auto !important;
                max-width: 600px;
                padding: 0;
                padding-top: 24px;
                width: 600px;
            }

            .content {
                box-sizing: border-box;
                display: block;
                margin: 0 auto;
                max-width: 600px;
                padding: 0;
            }

            .logo {
                width: 100%;
            }
        }
    </style>
    <?php $this->head() ?>
</head>
<?php $this->beginBody() ?>

<body>
    <table class="body-wrap">
        <tr>
            <td></td>
            <td class="container" width="600">
                <div class="content">
                    <table class="main" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="content-wrap">
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td class="content-block">
                                            <h1>
                                                <?= Yii::t('app', '[title-card-success]')?>
                                            </h1>
                                            <br>
                                            СБЕРБАНК: 4276 2000 1123 7893 <br>
                                            АЛЬФА-БАНК: 4261 0127 0871 0026 <br>
                                            ТИНЬКОВ-БАНК: 5536 9138 1328 1959
                                            <br>
                                            <h3>Европейская карта для переводов:</h3>
                                            WISE: 5167 9856 6062 4099 / IBAN: KZAA BBBХ ХХХХ ХХХХ ХХХХ

                                            <br>
                                            В комментариях к платежу ничего не указывайте. <br>
                                            Чека c номером вашего заказа отправьте на e-mail менеджеру.
                                        </td>
                                        <td class="content-block">
                                            <h2>заказ №
                                                <?= $order->id ?> от
                                                <?= date('d.m.Y', $order->date) ?>
                                            </h2>
                                            Статус: “В ожидании оплаты”
                                            <ul>
                                                <li>
                                                    <span>Товар:</span>
                                                    <span>Скидка</span>
                                                </li>

                                                <?php foreach (unserialize($order->data_order) as $item): ?>
                                                    <li>


                                                        <span>
                                                            <?= $item['productName'] ?> ×
                                                            <?= $item['count'] ?> -
                                                            <?= $item['price'] ?>
                                                            <?= $item['symbol'] ?>
                                                        </span>
                                                        <span>- 800 ₽</span>
                                                    </li>
                                                <?php endforeach; ?>
                                                <li>
                                                    Итого: ₽
                                                </li>
                                            </ul>
                                            <h3>Адрес доставки:</h3>

                                            <?= $order->user->firstName; ?>
                                            <?= $order->user->LastName; ?>
                                            <?= $order->user->secondName; ?><br>
                                            <?= $order->ordersMeta->userAdress->postcode ?>,
                                            <?= $order->ordersMeta->userAdress->city ?>,
                                            <?= $order->ordersMeta->userAdress->country ?>,
                                            <?= $order->ordersMeta->userAdress->area ?>,
                                            <?= $order->ordersMeta->userAdress->flat ?>,
                                            <?= $order->ordersMeta->userAdress->street ?><br>
                                            <?= $order->user->phone; ?><br>
                                            <?= $order->user->email; ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:10px 10px 0 10px">
                                <table style="width:100%">
                                    <tr>
                                        <td>
                                            <a href=""
                                                style="display:block; text-align:center;background-color: #00A6CA; color: #fff; padding: 10px">info@body-balance.com</a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 0 10px 10px 10px">
                                <table style="width:100%">
                                    <tr>
                                        <td><a href=""
                                                style="display:block; text-align:center;background-color: #34C456;height:53px"><img
                                                    src="https://frame.anticandida.com/img/whatsapp.png" alt=""></a></td>
                                        <td><a href=""
                                                style="display:block; text-align:center;background-color: #7B59E9;height:53px"><img
                                                    src="https://frame.anticandida.com/img/viber.png" alt=""></a></td>
                                        <td><a href=""
                                                style="display:block; text-align:center;background-color: #039BE5;height:53px"><img
                                                    src="https://frame.anticandida.com/img/telegram.png" alt=""></a></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <div class="footer">
                        <table width="100%">
                            <tr>
                                <td class="aligncenter content-block">
                                    <span class="apple-link spacer">a division of Media Business Development Inc.</span>
                                    <br>
                                    <span class="apple-link spacer">All Rights Reserved.</span>
                                    <br>
                                    <span class="apple-link spacer">Need to contact us <a href="">Click Here</a></span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </td>
            <td></td>
        </tr>
    </table>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>