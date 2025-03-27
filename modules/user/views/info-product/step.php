<?php
use app\models\Product;
use yii\bootstrap5\Modal;

?>
<link href="/css/comon.min.css" rel="stylesheet">
<link href="/css/icon.css" rel="stylesheet">
<link href="/css/media-art.css" rel="stylesheet">

<!-- <link href="https://anticandida.com/css/width-content.css" rel="stylesheet"> -->
<main>
    <section id="lesson">
        <div class="container">
            <?php echo $this->render('../components/left_menu_user.php', [
                'lang' => $lang,
                'active' => 'infoproduct'
            ]) ?>
            <div class="infoproducts__main">
                <div class="breadcrumbs">
                    <ul>
                        <li>
                            <a href="https://anticandida.com/<?= $lang; ?>/user/info-product"
                                data-link="/<?= $lang; ?>/user/info-product" class="referInfoc">
                                <?= Yii::t('app', 'info-products') ?>
                            </a>
                        </li>
                        <li>
                            <a href="https://anticandida.com/<?= $lang; ?>/user/info-product/<?= $product->getParam('link', $lang); ?>"
                                class="referInfoc"
                                data-link="/<?= $lang; ?>/user/info-product/<?= $product->getParam('link', $lang); ?>">
                                <?= $product->getParam('shortName', $lang); ?>
                            </a>
                        </li>
                        <li>
                            <a href="https://anticandida.com/<?= $lang ?>/user/info-product/list/<?= $step->category->id; ?>"
                                class="referInfoc"
                                data-link="/<?= $lang ?>/user/info-product/list/<?= $step->category->id; ?>">
                                <?= $step->category->title; ?>
                            </a>
                        </li>
                        <!-- <li class="active">
                            <a href="#"></a>
                        </li> -->
                    </ul>
                </div>
                <div id="content">
                    <?= $content; ?>
                </div>
                <?php if ($step->disc == 1 || $step->disc == 2): ?>


                    <form action="#" method="post" class="agree_condition">
                        <div class="agree_condition__item">
                            <div>
                                <input type="checkbox" class="agree_cond__checkbox" id="agree_cond__checkbox1" value="yes"
                                    <?= ($step->getDescs() ? 'checked readonly disabled' : '') ?>>
                                <label for="agree_cond__checkbox1"></label>
                            </div>
                            <p>
                                <?= Yii::t('app', 'disclaimer-1') ?>
                            </p>
                        </div>
                        <div class="agree_condition__item">
                            <div>
                                <input type="checkbox" class="agree_cond__checkbox" id="agree_cond__checkbox2" value="yes"
                                    <?= ($step->getDescs() ? 'checked readonly disabled' : '') ?>>
                                <label for="agree_cond__checkbox2"></label>
                            </div>
                            <p>
                                <?= Yii::t('app', 'disclaimer-2') ?>
                            </p>
                        </div>
                        <div class="agree_condition__item">
                            <p>
                                <?= Yii::t('app', 'disclaimer-3') ?>
                            </p>
                        </div>
                        <?php if (!$step->getDescs()): ?>
                            <p class="agree_condition__submit">
                                <input type="submit" name="submit_agree" id="submit_agree"
                                    value="<?= Yii::t('app', 'disclaimer-4') ?>" data-id="<?php echo $step->id ?>">
                            </p>
                        <?php else: ?>
                            <p class="agree_condition__submit">
                                <input type="submit" name="#" value="<?= Yii::t('app', 'disclaimer-5') ?>" id="smnu_agred"
                                    readonly disabled>
                            </p>
                        <?php endif; ?>
                        <p class="agree_condition__submit">
                            <?php if ($nexStep): ?>
                                <input type="submit" name="submit_agree" value="Продолжить">
                                <a href="/<?= $lang ?>/user/info-product/list/<?= $product_link; ?>/<?= $nexStep['id'] ?>">
                                    <!-- Потвердить прохождение и Перейти к следующему -->
                                </a>
                            <?php endif; ?>
                        </p>
                    </form>

                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<?php
$this->registerJs('
$("#content img").each(function(e){
    $(this).attr("src", "https://anticandida.com"+$(this).data("src"))
});

$("video source").each(function(e){
    var dattSrc = $(this).attr("src");
    var tag = "<video src=\'https://anticandida.com"+dattSrc+"\'></video>";
    $(this).closest(".img-wrap").html(tag);
});

$("#content div").each(function(e){
    $(this).attr("contenteditable", "false")
});
$(document).on("click", "img", function(e){
    if($("#element").data("link") !== undefined && $(this).data("link").length > 0){
        var link = $(this).data("link");
        if(link != ""){
            window.open(link, "_blank");
        }
    }
});


$(document).on("click", "#submit_agree", function(e){
    e.preventDefault();
    $(".agree_cond__checkbox").removeClass("error");
    if($("#agree_cond__checkbox2").is(":checked") && $("#agree_cond__checkbox1").is(":checked")){
        var id = $(this).data("id");
        $.post("/user/update-step", {id: id}, function Success(data){
            if(data){
                document.location = document.location;
            }
        });
    }
    if(!$("#agree_cond__checkbox2").is(":checked")){
        $("#agree_cond__checkbox2").addClass("error");
    }
    if(!$("#agree_cond__checkbox1").is(":checked")){
        $("#agree_cond__checkbox1").addClass("error");
    }
});
$(".author_img").each(function(e){
    var img = $(this).css("background-image");
    var repImg = img.replace("frame.", "");
    $(this).css("background-image", repImg);
})
$(".articles-content-data .lyser").each(function(index, e){
$(this).css("background-image", $(this).data("src"));
})
$(".img-wrap-in-col.lyser").each(function(index, e){
$(this).css("background-image", $(this).data("src"));
console.log($(this).data("src"));
})
  
');
?>
<style>
    .gall-img-template .asp-gall {
        justify-content: space-between;
    }

    .gall-img-template .asp-gall>div {
        flex: none;
    }

    .block-share-default.element-bord,
    .block-share-default,
    .block-share {
        display: none;
    }

    * {
        cursor: default;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    #smnu_agred {
        background: radial-gradient(circle, rgb(133 167 54) 43%, rgba(122, 150, 57, 1) 88%);
        border-radius: 3px;
        font-size: 14px;
        padding: 7px 15px;
        color: #fff;
        width: fit-content;
        height: 40px;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        transition: 0.3s ease;
        font-weight: 500;
        min-width: 200px;
    }
    .content-text-redactor {
    margin-bottom: 15px;
}
    .add-te a,
    .block-qout a,
    .articles-content a {
        font-weight: 500;
        color: #00a6ca;
    }

    #mainH1,
    .block-tex-title.element-bord h2 {
        font-size: 32px;
        line-height: 38px;
        font-weight: 500;
        margin-bottom: 25px;
    }

    h2.tit_elm {
        margin-top: 70px;
        margin-bottom: 25px;
    }

    span.gap-text {
        display: block;
        width: 100%;
        height: 10px;
    }

    .add-te a:hover,
    .block-qout a:hover {
        margin-left: -3px;
        margin-right: -3px;
        color: #fff;
        background: #00a6ca;
        padding-left: 3px;
        padding-right: 3px;
        border-radius: 2px;
    }

    .agree_condition__submit input {
        background: #00A6CA;
        border-radius: 3px;
        font-size: 14px;
        padding: 7px 15px;
        color: #fff;
        width: fit-content;
        min-width: 200px;
        height: 40px;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        transition: 0.3s ease;
        font-weight: 500;
    }

    .agree_cond__checkbox.error+label::before {
        border: 1px solid red;
    }

    img[data-link] {
        cursor: pointer;
    }
</style>

<script>
    window.addEventListener('load', function (event) {
        var h2 = document.getElementById('lesson').offsetHeight;
        parent.postMessage({
            heInfoproduct: h2,
        }, '*');
    });
</script>

<?php $this->registerJs('
var click = 0;
$(document).on("click", ".right-slig", function (e) {
  let step = $(this).attr("data-step");
  arrayTo = $(this).closest(".block-slider-gal").find(".flort div").toArray();
  var prevImg = $(this).siblings("img");
  if (!!step) {
    step = Number(step) + 1;
    $(this).attr("data-step", step);
  } else {
    step = 0;
    $(this).attr("data-step", step);
    var path = encodeURI("https://anticandida.com/gallery/" + $(arrayTo[1]).attr("data-src"));
    prevImg.attr("src", path);
  }
  // click = click + 1;
  if (arrayTo.length > step && step != 0) {
    prevImg.attr("src", "https://anticandida.com/gallery/" + $(arrayTo[step]).attr("data-src"));
  } else {
    prevImg.attr("src", "https://anticandida.com/gallery/" + $(arrayTo[0]).attr("data-src"));
    step = 0;
    $(this).attr("data-step", step);
  }
});

$(document).on("click", ".left-slig", function (e) {
  var prevImg = $(this).siblings("img");
  let step = $(this).attr("data-step");
  arrayTo = $(this).closest(".block-slider-gal").find(".flort div").toArray();

  if (!!step) {
    step = Number(step) + 1;
    $(this).attr("data-step", step);
  } else {
    step = 0;
    $(this).attr("data-step", step);
    prevImg.attr("src", "https://anticandida.com/gallery/" + $(arrayTo[1]).attr("data-src"));
  }
  steps = arrayTo.length - step;
  if (arrayTo.length > step && step != 0) {
    prevImg.attr("src", "https://anticandida.com/gallery/" + $(arrayTo[steps]).attr("data-src"));
  } else {
    prevImg.attr("src", "https://anticandida.com/gallery/" + $(arrayTo[0]).attr("data-src"));
    step = 0;
    $(this).attr("data-step", step);
  }
});

$(document).on("click", ".img-werst", function (e) {
    var src = $(this).data("src");
    var id = $(this).data("id");
    $(".prew-img")
      .find("img[data-id=" + id + "]")
      .attr("src", "https://anticandida.com/gallery/" + src);
    $(".prew-img")
      .find("img[data-id=" + id + "]")
      .attr("data-src", src);
  });

$(document).on("click", ".referInfoc", function(e){
    e.preventDefault();
    var dataLink = $(this).data("link");
    parent.postMessage({
        linkData : dataLink,
    }, "*");
})



$(document).on("click", ".accardion-title", function (e) {
  if ($(this).hasClass("opens")) {
    $(this).removeClass("opens");
    $(this).next("div").css("display", "none");
  } else {
    $(this).addClass("opens");
    $(this).next("div").css("display", "block");
  }
});

    $(".del-elem-accr").remove();
    $(".add-alem-accr").remove();
    var galca = "<div class=\"galca\"><span></span><span></span></div>";
    $(".accardion-title").append(galca);






    if ($(".inf.data-param").length) {
    if ($("#tagLang").val() != "ru") {
        var set = {
            Январь: "'.Yii::t('app', 'january').'",
            Февраль: "'.Yii::t('app', 'february').'",
            Март: "'.Yii::t('app', 'march').'",
            Апрель: "'.Yii::t('app', 'april').'",
            Май: "'.Yii::t('app', 'may').'",
            Июнь: "'.Yii::t('app', 'june').'",
            Июль: "'.Yii::t('app', 'july').'",
            Августа: "'.Yii::t('app', 'august').'",
            Сентябрь: "'.Yii::t('app', 'september').'",
            Октябрь: "'.Yii::t('app', 'october').'",
            Ноябрь: "'.Yii::t('app', 'november').'",
            Декабрь: "'.Yii::t('app', 'december').'"
        };
        var text = $(".inf.data-param").text();
        var replaced = "";
        $.each(set, function (index, val) {
            if (text.indexOf(index) > 0) {
                replaced = text.replace(index, val);
            }
        });
        $(".inf.data-param").text(replaced);
    }
}
') ?>