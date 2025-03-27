<?php
use yii\grid\GridView; ?>
<div class="row" id="tableProductList">
    <div class="col-md-12">
        <div class="card full-height">
            <div class="card-body">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        'id',
                        [
                            'attribute' => 'name',
                            'format' => 'raw',
                            'value' => function($model){
                                return "<a href='/admin/mail/update?id={$model->id}'>{$model->name}</a>";
                            }
                        ],
                        'date',
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>

