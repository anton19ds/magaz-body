<?php

use app\models\InfoStep;
use app\models\Product;
use yii\bootstrap5\Modal;

?>
<main>
    <section id="list-lessons">
        <div class="container">
            <?php echo $this->render('../components/left_menu_user.php', [
                'lang' => $lang,
                'active' => 'infoproduct'
            ]) ?>
            <div class="infoproducts__main">
                <div class="breadcrumbs">
                    <ul>
                        <li>
                            <a href="#">Инфопродукты</a>
                        </li>
                        <li>
                            <a href="#">Все инфопродукты</a>
                        </li>
                        <li class="active">
                            <a href="#">
                                <?= $product['productMeta']['productName'] ?>
                            </a>
                        </li>
                    </ul>
                </div>
                <h1>
                    <?= $product['productMeta']['productName'] ?>
                </h1>
                <div class="list_lessons">
                    <?php $keyS = 0; ?>
                    <?php foreach ($product['infoStep'] as $key => $item): ?>
                        <?php if (InfoStep::checkData($item['id'])) {
                            echo $this->render('complate-step', [
                                    'item' => $item,
                                    'lang' => $lang,
                                    'product_link' => $product_link
                            ]);
                            $keyS = $key + 1;
                        } else {
                            if($key == $keyS){
                                echo $this->render('active-step', [
                                    'item' => $item,
                                    'lang' => $lang,
                                    'product_link' => $product_link
                                ]);
                            }else{
                                echo $this->render('disabled-step',[
                                    'item' => $item,
                                    'lang' => $lang,
                                    'product_link' => $product_link
                                ]);
                            }
                            
                        } 
                        ?>
                        
                        
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
</main>