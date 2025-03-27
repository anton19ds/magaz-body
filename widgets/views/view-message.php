<?php
use app\models\User;
?>
<li class="nav-item dropdown hidden-caret">
    <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-bell"></i>
        <?php $count = 0;?>
        <?php if (!empty ($sortArray)): ?>
            <?php $count = $count + count($sortArray) ?>
        <span class="notification">
            <?= $count ?>
        </span>
        <?php endif; ?>
    </a>
    <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
        <li>
            <div class="dropdown-title">You have new notification</div>
        </li>
        <li>
            <div class="notif-scroll scrollbar-outer">
                <div class="notif-center">
                    <?php foreach ($sortArray as $item): ?>
                    <?php if(User::getUsername($item['user_id'])):?>                        
                        <a href="<?php if(isset($item['star'])){
                                        echo '/admin/user/user-rivers?id='.$item['user_id'];
                                    }else if(isset($item['type'])){
                                        echo '/admin/user/user-request?id='.$item['user_id'];
                                    }else if(isset($item['tasks_id'])){
                                        echo '/admin/user/user-tasks?id='.$item['user_id'];
                                    }else if(isset($item['summ'])){
                                        echo '/admin/user/balance?id='.$item['user_id'];
                                    }?>">
                            <div class="notif-icon notif-success"> <i class="fa fa-comment"></i>
                            
                            </div>
                            <div class="notif-content">
                                <span class="block">
                                    <?php if(isset($item['star'])){
                                        echo 'Новый отзыв';
                                    }else if(isset($item['type'])){
                                        echo 'Новыя заявка';
                                    }else if(isset($item['tasks_id'])){
                                        echo 'Выполненое задание';
                                    }else if(isset($item['summ'])){
                                        echo 'Запрос на вывод средств';
                                    }?>

                                </span>
                                <span class="time">
                                <?= User::getUsername($item['user_id'])?><br>
                                    <?= date('d.m.Y H:i',$item['date'])?>
                                </span>
                            </div>
                        </a>
                        <?php endif;?>
                    <?php endforeach; ?>
                </div>
            </div>
        </li>
        <!-- <li>
            <a class="see-all" href="javascript:void(0);">See all notifications<i class="fa fa-angle-right"></i>
            </a>
        </li> -->
    </ul>
</li>