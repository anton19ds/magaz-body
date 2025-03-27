<div class="prod_cart_item__img">
    <?php if (!empty($image)): ?>
        <?php $photoData = json_decode($image, true); ?>
        <?php
        $mainImage = null;
        foreach ($photoData['array'] as $photo) {
            if (isset($photo['main']) && $photo['main']) {
                $mainImage = "<img src=\"{$photo['value']}\" alt=\"\">";
            }
        }
        if (!$mainImage) {
            $mainImage = "<img src=\"{$photoData['array'][array_key_first($photoData['array'])]['value']}\" alt=\"\">";
        }
        ?>
        <?= $mainImage; ?>
    <?php else: ?>
        <img src="/adminStyle/assets/img/no-image.png" alt="">
    <?php endif; ?>
</div>