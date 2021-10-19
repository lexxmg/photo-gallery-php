
<?php

if ( isset($_POST['delete']) ) {
    $arrFiles = preg_grep( '/^([^.])/', scandir($pathToUpload) );
    
    if ( isset($_POST['deleteAll']) ) {
        foreach ($arrFiles as $key => $value) {
            unlink($pathToUpload . '/' . $value);
        }
    } else {
        foreach ($_POST as $i => $item) {
            foreach ($arrFiles as $j => $value) {
                if ($i === $value) {
                    unlink($pathToUpload . '/' . $value);
                }
            }
        }
    }
}

?>

<h1 class="gellary-title">Галлерея</h1>

<form class="gallery__form" action="" method="post">
    <div class="gallety__inner">
        <?php foreach ( preg_grep('/^([^.])/', scandir($_SERVER['DOCUMENT_ROOT'] . '/upload') ) as $key => $item): ?>
            <div class="gallety__card gallety-card">
              <div class="gallety-card__wrapper">
                <input class="gallety-card__input" type="checkbox" name="<?=$item?>">

                <img class="gallety-card__img" src="<?='/upload/' . $item?>" alt="<?=$item?>">

                <time class="gallety-card__date">
                  <?=date('m.d.Y H:i:s' ,filectime($_SERVER['DOCUMENT_ROOT'] . '/upload/' . $item) )?>
                </time>
              </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="gallery__wrapper-btn">
      <label class="gallery__label">Удалить всё:
        <input class="gallery__input" type="checkbox" name="deleteAll">
      </label>

      <button class="gallery__btn" name="delete">удалить</button>
    </div>
</form>
