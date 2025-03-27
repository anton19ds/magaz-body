<div class="prc_char__quantity">
    <div class="prc_quantity-minus <?= ($cart['data'][$item->id]['count'] > 1 ? 'active' : '') ?> minus-tov-cart"
        data-id="<?= $item['id'] ?>" data-pjax=0>
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="0.5" y="0.5" width="23" height="23" rx="11.5" fill="white" />
            <rect x="0.5" y="0.5" width="23" height="23" rx="11.5"
                stroke="<?= ($cart['data'][$item->id]['count'] > 1 ? '#00A6CA' : '#CACACA') ?>" />
            <path d="M6 12H18" stroke="<?= ($cart['data'][$item->id]['count'] > 1 ? '#00A6CA' : '#CACACA') ?>"
                stroke-width="2" />
        </svg>
    </div>
    <span class="prc_quantity-number">
        <?= $cart['data'][$item->id]['count'] ?>
    </span>
    <div class="prc_quantity-plus plus-tov-cart" data-id="<?= $item['id'] ?>" data-pjax=0>
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="0.5" y="0.5" width="23" height="23" rx="11.5" fill="white" />
            <rect x="0.5" y="0.5" width="23" height="23" rx="11.5" stroke="#00A6CA" />
            <path d="M6 12H12M18 12H12M12 12V6M12 12V18" stroke="#00A6CA" stroke-width="2" />
        </svg>
    </div>
</div>