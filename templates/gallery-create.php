
<h1 class="gellery-create-tiile">Загрузить фото</h1>

<form class="gellery-create__form" name="myForm" action="" method="post" enctype="multipart/form-data">
  <div class="gellery-create__input-wrapper">
    <input class="gellery-create__input"
      id="file"
      type="file"
      name="file[]"
      accept="<?=implode(', ', VALID_FORMAT)?>"
      multiple
    >
    <label class="gellery-create__label" for="file">Выберете файл</label>

    <span class="gellery-create__success hide">success</span>
  </div>

  <button class="gellery-create__btn" name="upload">Загрузить</button>
</form>
