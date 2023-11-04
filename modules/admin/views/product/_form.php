<?php
use app\models\Product;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="row">
    <div class="col-md-8">
        <div class="card full-height">
            <div class="card-header">
                <div class="card-title">Добавление нового товара</div>
            </div>
            <div class="card-body">
                <input type="hidden" value="<?= Url::base(true); ?>" id="urlSite">

                <div class="row">
                    <?php foreach ($arrayData as $key => $value): ?>
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
                    <?php endforeach; ?>
                </div>
                <?php if (!isset($lang)): ?>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <?= $form->field($model, 'price')->textInput() ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'sale')->textInput() ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'col')->textInput() ?>
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
                            <a href="<?php echo ($lang ? "/". $lang : "")."/".$meta['link'];?>"><?php echo ($lang ? "/". $lang : "")."/".$meta['link'];?></a>
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
                        <label for="">Картинки товара</label>
                        <div class="img-prew">
                            <?php if (!empty($meta['image'])): ?>
                                <?php $imageArray = json_decode($meta['image'], true) ?>
                                <div class="col-md-12 mt-3">
                                    <div class="img-prew">
                                        <div class="row g-1">
                                            <?php foreach ($imageArray['array'] as $key => $value): ?>
                                                <div class="col-3 img-element-<?= $key?>" data-id="<?= $key?>">
                                                <span class="remove-image" data-id="<?= $key?>"><i class="far fa-times-circle" style="color:red"></i></span>
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


                <div class="col-md-12 mt-3">
                    <label for="">Текстовые параметры 1</label>
                    <input type="text" name="productMeta[params_sale]" id="params_sale"
                        value="<?= (isset($meta['params_sale']) && $meta['params_sale'] ? $meta['params_sale'] : '') ?>"
                        class="form-control">
                </div>
                <div class="col-md-12 mt-3">
                    <label for="">Текстовые параметры 2</label>
                    <input type="text" name="productMeta[params_sale_2]" id="params_sale_2"
                        value="<?= (isset($meta['params_sale_2']) && $meta['params_sale_2'] ? $meta['params_sale_2'] : '') ?>"
                        class="form-control">
                </div>

                <?php if (!isset($lang)): ?>

                    <div class="col-md-12 mt-3">
                        <input type="hidden" name="productMeta[image-ser]" id="imageListInputSer"
                            value="<?= (isset($meta['image-ser']) && $meta['image-ser'] ? htmlspecialchars($meta['image-ser']) : '') ?>">
                        <span class="open-image-ser btn btn-success">Добавить сертификат</span>
                    </div>


                    <div class="col-md-12 mt-3">
                        <label for="">Сертификаты товара</label>
                        <div class="img-prew-ser">
                            <?php if (!empty($meta['image-ser'])): ?>
                                <?php $imageArray = json_decode($meta['image-ser'], true) ?>
                                <div class="col-md-12 mt-3">
                                    <div class="img-prew-ser">
                                        <div class="row g-1">
                                            <?php foreach ($imageArray['array'] as $key => $value): ?>
                                                <div class="col-3 img-element-<?= $key?>" data-id="<?= $key?>">
                                                <span class="remove-image" data-id="<?= $key?>"><i class="far fa-times-circle" style="color:red"></i></span>
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
                        <label for="">Тип продукт</label>
                        <?= Html::dropDownList('productMeta[type]', (isset($meta['type']) ? $meta['type'] : ''), Product::getLabelType(), ['class' => 'form-control']) ?>

                    </div>
                    <div class="col-md-12 mt-1">
                        <?= $form->field($model, 'active')->dropDownList(Product::getLabelStatus()) ?>
                    </div>
                    <div class="col-md-12 mt-1">
                        <?= $form->field($model, 'upsale')->dropDownList(Product::getUpsaleStatus()) ?>
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
          var urlLink = rus_to_latin(val);
          var link = "<a href=\""+urlLink+"\">"+urlLink+"</a>";
          $(".linkUrl").html(link);
          $("#productMetalink").val(urlLink);
        });
');

?>