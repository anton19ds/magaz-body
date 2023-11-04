<?php if($item){
  $item_list = json_decode($item, true);
  foreach($item_list as $elem){
        echo "<img src='".$elem[1]['value']."' style='max-width:100px'>";
  }
  
}?>