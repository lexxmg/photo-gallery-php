
<h1 class="gellary-title">Галлерея</h1>

<form action="" class="gallery__form">
    <div class="gallety__inner">
        <?php foreach ( preg_grep('/^([^.])/', scandir($_SERVER['DOCUMENT_ROOT'] . '/upload') ) as $key => $item): ?>
            <div class="gallety__card gallety-card">
              <input class="gallety-card__input" type="checkbox" name="card">

              <img class="gallety-card__img" src="<?='/upload/' . $item?>" alt="">

              <time class="gallety-card__date">
                <?=date('m.d.Y H:i:s' ,filectime($_SERVER['DOCUMENT_ROOT'] . '/upload/' . $item) )?>
              </time>
            </div>
        <?php endforeach; ?>
    </div>

    <button class="gallery__btn">удалить</button>
</form>
