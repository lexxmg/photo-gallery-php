
<h1 class="gellery-create-tiile">Загрузить фото</h1>

<form class="gellery-create__form" name="myForm" action="" method="post" enctype="multipart/form-data">
  <div class="gellery-create__input-wrapper">
    <input class="gellery-create__input" id="file" type="file" name="file[]" multiple>
    <label for="file" class="gellery-create__label">Выберете файл</label>

    <?php if ($error): ?>
        <span class="gellery-create__error"><?=$error?></span>
    <?php endif; ?>

    <?php if ($success): ?>
        <span class="gellery-create__success"><?=$success?></span>
    <?php endif; ?>
  </div>

  <button class="gellery-create__btn" name="upload">Загрузить</button>
</form>
