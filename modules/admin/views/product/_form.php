<?php
use app\models\Category;
use app\models\Product;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="row">
    <div class="col-md-8">
        <div class="card full-height">
            <div class="card-header">
                <div class="card-title">Редактирование товара</div>
            </div>
            <div class="card-body">
                <input type="hidden" value="<?= Url::base(true); ?>" id="urlSite">
                <div class="row">
                    <?php foreach ($arrayData as $key => $value): ?>
                        <?php if ($key != 'with-this-product'): ?>
                            <?php if ($key == 'productName' || $key == 'shortName'): ?>
                                <div class="col-md-6">
                                    <div class="form-group field-product-<?= $key ?>">
                                        <label class="control-label" for="product-<?= $key ?>">
                                            <?= $value ?>
                                        </label>
                                        <?= Html::textInput(
                                            'productMeta[' . $key . ']',
                                            (isset($meta[$key]) ? $meta[$key] : ''),
                                            ['class' => 'form-control', 'id' => 'productMeta' . $key]
                                        ); ?>
                                    </div>
                                </div>
                            <?php elseif ($key == 'visible'): ?>
                                <div class="col-md-12">
                                    <div class="form-group field-product-<?= $key ?>">
                                        <label class="control-label" for="product-<?= $key ?>">
                                            <?= $value ?>
                                        </label>
                                        <?= Html::DropDownList('productMeta[' . $key . ']', (isset($meta[$key]) ? $meta[$key] : ""), [1 => 'Отображать', 2 => 'Скрыть'], ['class' => 'form-control']) ?>
                                    </div>
                                </div>
                            <?php elseif ($key == 'description'): ?>
                                <div class="form-group field-product-<?= $key ?>">
                                    <label class="control-label" for="product-<?= $key ?>">
                                        <?= $value ?>
                                    </label>
                                    <?= Html::textArea('productMeta[' . $key . ']', (isset($meta[$key]) ? $meta[$key] : ""), ['class' => 'form-control', 'rows' => 6]); ?>
                                </div>
                                <?php elseif ($key == 'content'): ?>
                                <div class="form-group field-product-<?= $key ?>">
                                    <label class="control-label" for="product-<?= $key ?>">
                                        <?= $value ?>
                                    </label>
                                    <?= Html::textInput(
                                            'productMeta[' . $key . ']',
                                            (isset($meta[$key]) ? $meta[$key] : ''),
                                            ['class' => 'form-control', 'id' => 'productMeta' . $key]
                                        ); ?>
                                </div>
                            <?php else: ?>
                                <div class="col-md-12">
                                    <div class="form-group field-product-<?= $key ?>">
                                        <label class="control-label" for="product-<?= $key ?>">
                                            <?= $value ?>
                                        </label>
                                        <?= Html::textInput(
                                            'productMeta[' . $key . ']',
                                            (isset($meta[$key]) ? $meta[$key] : ''),
                                            ['class' => 'form-control', 'id' => 'productMeta' . $key]
                                        ); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <?php if (!isset($lang)): ?>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3">
                                <?= $form->field($model, 'price')->textInput(); ?>
                                <?php if (isset($meta['type']) && ($meta['type'] == Product::TYPE_SIMPLE || $meta['type'] == Product::TYPE_MADE)): ?>
                                    <?php foreach ($pricePacData as $key => $value): ?>
                                        <div class="col-md-12">
                                            <div class="form-group field-product-<?= $key ?>">
                                                <label class="control-label" for="product-<?= $key ?>">
                                                    <?= $value ?>
                                                </label>
                                                <?= Html::textInput(
                                                    'productMeta[' . $key . ']',
                                                    (isset($meta[$key]) ? $meta[$key] : ''),
                                                    ['class' => 'form-control', 'id' => 'productMeta' . $key]
                                                ); ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                            </div>
                            <div class="col-md-3">
                                <?= $form->field($model, 'sale')->textInput() ?>
                            </div>
                            <div class="col-md-3">
                                <?= $form->field($model, 'col')->textInput() ?>
                            </div>
                            <div class="col-md-3">
                                <?= $form->field($model, 'sort')->textInput(['type' => 'number']) ?>
                            </div>
                            <div class="col-md-3">
                                <?= $form->field($model, 'category')->dropDownList(['0' => 'Без категории', '' => ArrayHelper::map(Category::find()->asArray()->all(), 'id', 'title')])->label('Сортировка в магазине по категориям') ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    $raite = array(
                        1 => 1,
                        2 => 2,
                        3 => 3,
                        4 => 4,
                        5 => 5,
                    );
                    ?>
                    <?= $form->field($model, 'raite')->radioList($raite, ['class' => 'selectgroup w-100']); ?>
                <?php endif; ?>
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-info']) ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card full-height">
            <div class="card-body">
                <div class="col-md-12">
                    <label for=""><strong> Постоянная ссылка:</strong></label>
                    <div class="linkUrl">
                        <?php if (isset($meta['link'])): ?>
                            <a href="<?php echo ($lang ? "/" . $lang : "") . "/" . $meta['link']; ?>">
                                <?php echo ($lang ? "/" . $lang : "") . "/" . $meta['link']; ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if (!isset($lang)): ?>
                    <div class="col-md-12 mt-3">
                        <input type="hidden" name="productMeta[image]" id="imageListInput"
                            value="<?= (isset($meta['image']) && $meta['image'] ? htmlspecialchars($meta['image']) : '') ?>">
                        <span class="open-image btn btn-success">Добавить изображение</span>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="img-prew">
                            <?php if (!empty($meta['image'])): ?>
                                <?php $imageArray = json_decode($meta['image'], true) ?>
                                <div class="col-md-12 mt-3">
                                    <div class="img-prew">
                                        <div class="row g-1">
                                            <?php foreach ($imageArray['array'] as $key => $value): ?>
                                                <div class="col-3 img-element-<?= $key ?>" data-id="<?= $key ?>">
                                                    <span class="remove-image" data-id="<?= $key ?>"><i class="far fa-times-circle"
                                                            style="color:red"></i></span>
                                                    <label class="imagecheck mb-1">
                                                        <figure class="imagecheck-figure">
                                                            <img src="<?= $value['value'] ?>" alt="заголовок"
                                                                class="imagecheck-image">
                                                            <?php if (isset($value['main']) && $value['main']) {
                                                                $vdCheck = "checked=checked";
                                                            } else {
                                                                $vdCheck = "";
                                                            } ?>
                                                            <label for="main-image-<?= $key ?>">
                                                                <input type="radio" name="set-main-image"
                                                                    value="<?php echo $key; ?>" id="main-image-<?php echo $key; ?>"
                                                                    <?php echo $vdCheck; ?> class="data-main-image">
                                                                Main
                                                            </label>
                                                        </figure>
                                                    </label>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (isset($meta['type']) && $meta['type'] == Product::TYPE_MADE): ?>
                    <?php
                    echo '<div class="form-group field-product-active"><label for="" class="control-label">Привязаные товары (Сборный)</label></div>';
                    echo Select2::widget([
                        'name' => 'productMeta[product]',
                        'data' => $model->getProductSimpleList(),
                        'value' => (isset($meta['product']) ? json_decode($meta['product'], true) : ''),
                        'options' => [
                            'placeholder' => 'Привязаные товары ...',
                            'multiple' => true
                        ],
                    ]);
                    ?>
                <?php endif; ?>
                <div class="col-md-12 mt-3">
                    <div class="row">
                        <div class="col-10">
                            <div class="strong">Текстовые параметры 1 <span class="plus ff-orm" style="color:green"
                                    data-param='params_text_1'><strong><i class="fa fa-plus" aria-hidden="true"></i>
                                    </strong></span></div>
                        </div>
                        <div class="col-2">

                        </div>
                    </div>
                    <br>
                    <?php if (!empty($meta['params_text_1'])) {
                        $params_text_1 = unserialize($meta['params_text_1']);
                        ?>
                        <?php foreach ($params_text_1 as $key => $value): ?>
                            <div class="row params_text_1 params_text_1-<?= $key ?> got-data" data-set="<?= $key ?>">
                                <div class="col-md-6">
                                    <input type="text" name="productMeta[params_text_1][<?= $key ?>][1]"
                                        value="<?= $value[1] ?>" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="productMeta[params_text_1][<?= $key ?>][2]"
                                        value="<?= $value[2] ?>" class="form-control">
                                </div>
                            </div>
                            <br>
                        <?php endforeach; ?>
                    <?php } else { ?>
                        <div class="row params_text_1 params_text_1-0 got-data" data-set="0">
                            <div class="col-md-6">
                                <input type="text" name="productMeta[params_text_1][0][1]" value="" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="productMeta[params_text_1][0][2]" value="" class="form-control">
                            </div>
                        </div>
                        <br>
                    <?php } ?>


                </div>
                <div class="col-md-12 mt-3">
                    <div class="col-md-12">
                        <div class="strong">Текстовые параметры 2
                            <span class="plus ff-orm" style="color:green" data-param="params_text_2"><strong><i
                                        class="fa fa-plus" aria-hidden="true"></i>
                                </strong></span>
                        </div>
                    </div>
                    <?php if (!empty($meta['params_text_2'])):
                        $params_text_1 = unserialize($meta['params_text_2']);
                        ?>
                        <?php foreach ($params_text_1 as $key => $value): ?>
                            <div class="row params_text_2 params_text_2-<?= $key ?> got-data" data-set="<?= $key ?>">
                                <div class="col-md-6">
                                    <input type="text" name="productMeta[params_text_2][<?= $key ?>][1]"
                                        value="<?= $value[1] ?>" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="productMeta[params_text_2][<?= $key ?>][2]"
                                        value="<?= $value[2] ?>" class="form-control">
                                </div>
                            </div>
                            <br>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="row params_text_2 params_text_2-0 got-data" data-set="0">
                            <div class="col-md-6">
                                <input type="text" name="productMeta[params_text_2][0][1]" value="" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="productMeta[params_text_2][0][2]" value="" class="form-control">
                            </div>
                        </div>
                        <br>
                    <?php endif; ?>
                </div>


                <div class="col-md-12 mt-3">
                    <div class="col-md-12">
                        <div class="strong">С этим товаром берут (Выводится в карточке товара)</div>
                    </div>
                    <?php
                    echo Select2::widget([
                        'name' => 'productMeta[with-this-product]',
                        'data' => $model->getProductSimpleListRef(),
                        'value' => (isset($meta['with-this-product']) && !empty($meta['with-this-product']) ? json_decode($meta['with-this-product'], true) : ''),
                        'options' => [
                            'placeholder' => 'Привязаные товары ...',
                            'multiple' => true
                        ],
                    ]);
                    ?>
                </div>




                <?php if (!isset($lang)): ?>
                    <div class="col-md-12 mt-3">
                        <input type="hidden" name="productMeta[image-ser]" id="imageListInputSer"
                            value="<?= (isset($meta['image-ser']) && $meta['image-ser'] ? htmlspecialchars($meta['image-ser']) : '') ?>">
                        <span class="open-image-ser btn btn-success">Добавить сертификат</span>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="img-prew-ser">
                            <?php if (!empty($meta['image-ser'])): ?>
                                <?php $imageArray = json_decode($meta['image-ser'], true) ?>
                                <div class="col-md-12 mt-3">
                                    <div class="img-prew-ser">
                                        <div class="row g-1">
                                            <?php foreach ($imageArray['array'] as $key => $value): ?>
                                                <div class="col-3 img-element-<?= $key ?>" data-id="<?= $key ?>">
                                                    <span class="remove-image" data-id="<?= $key ?>"><i class="far fa-times-circle"
                                                            style="color:red"></i></span>
                                                    <label class="imagecheck mb-1">
                                                        <figure class="imagecheck-figure">
                                                            <img src="<?= $value['value'] ?>" alt="заголовок"
                                                                class="imagecheck-image">
                                                        </figure>
                                                    </label>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!isset($lang)): ?>
                    <div class="col-md-12 mt-1">
                        <div class="form-group field-product-active">
                            <label for="" class="control-label">Тип продукта (Партнерка)</label>
                            <?= Html::dropDownList('productMeta[type]', (isset($meta['type']) ? $meta['type'] : ''), Product::getLabelType(), ['class' => 'form-control']) ?>
                        </div>
                    </div>
                    <?php if ($model->getType() == 'info'): ?>
                        <div class="col-md-12 mt-1">
                            <?php
                            echo '<label class="form-label">Срок активности инфокурса (В днях)</label>';
                            // echo DatePicker::widget([
                            //     'name' => 'date-info',
                            //     'type' => DatePicker::TYPE_INPUT,
                            //     'value' => isset($meta['date-info']) && !empty($meta['date-info']) ? $meta['date-info'] : date('d-m-Y'),
                            //     'pluginOptions' => [
                            //         'autoclose' => true,
                            //         'format' => 'dd-M-yyyy'
                            //     ]
                            // ]);
                            ?>
                            <input type="text" name="productMeta[date-info]" id="date-info"
                                value="<?= (isset($meta['date-info']) && $meta['date-info'] ? $meta['date-info'] : '') ?>"
                                class="form-control">
                        </div>
                    <?php endif; ?>

                    <div class="col-md-12 mt-1">
                        <?= $form->field($model, 'active')->dropDownList(Product::getLabelStatus()) ?>
                    </div>
                    <div class="col-md-12 mt-1">
                        <?= $form->field($model, 'upsale')->dropDownList(Product::getUpsaleStatus())->label('Рекомендуемые товары в корзине') ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php
$this->registerJs('
        $("#productMetaproductName").change(function(e){
          var val = $(this).val();
          if($("#productMetalink").val() == ""){
            var urlLinktext = rus_to_latin(val);
            var urlLink = urlLinktext.toLowerCase();
            var link = "<a href=\""+urlLink+"\">"+urlLink+"</a>";
            $(".linkUrl").html(link);
            $("#productMetalink").val(urlLink);
          }
          
        });
');

?>