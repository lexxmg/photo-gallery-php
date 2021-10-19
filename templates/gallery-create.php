
<?php
const MAX_SIZE = 2 * 1024 * 1024;
const MAX_COUNT = 6;
const VALID_FORMAT = ['image/jpeg', 'image/png', 'image/jpg'];

$acceptStr = '';

foreach (VALID_FORMAT as $key => $value) {
    $acceptStr = $acceptStr . $value . ', ';
}

$success = '';
$error = [];

var_dump( !empty($error) );
var_dump( isset($error) );

if ( isset($_POST['upload']) ) {
    //echo 'была нажата кнопка';
    //var_dump($_FILES['file']);
    if ( !empty($_FILES['file']['name']) ) {
        if ( $_FILES['file']['name'][0] === '' ) {
            $error[] = 'Нужно выбрать хотя бы один файл!';
        } else if ( count($_FILES['file']['name']) > MAX_COUNT ) {
            $error[] = 'Можно загрузить максимум ' . MAX_COUNT . ' файлов!';
        } else {
            foreach ($_FILES['file']['type'] as $i => $item) {
                if ($_FILES['file']['size'][$i] > MAX_SIZE) {
                    $success = '';
                    $error[] = 'Размер файла не може привышать 2Mb ' . $_FILES['file']['name'][$i];
                    //break;
                }

                foreach (VALID_FORMAT as $j => $value) {
                    $err = true;

                    if ($item === $value) {
                        $err = false;
                        break;
                    }
                }

                if ($err) {
                    $error[] = 'Не допустимый формат файла! ' . $_FILES['file']['name'][$i];
                }
            }
        }

        if ( empty($error) ) {
            foreach ($_FILES['file']['error'] as $key => $value) {
                if ( $value === UPLOAD_ERR_OK ) {
                    $tmp_name = $_FILES['file']['tmp_name'][$key];
                    // basename() может предотвратить атаку на файловую систему;
                    // может быть целесообразным дополнительно проверить имя файла
                    $name = basename($_FILES['file']['name'][$key]);
                    //$name = $_FILES['file']['name'][$key];
                    $name = preg_replace('/[^\w-]/', '_', $name);
                    move_uploaded_file($tmp_name, "$pathToUpload/$name" );
                    $success = 'Файлы успешно загруженны';
                } else {
                    $error[] = "Произошла ошибка $value, повторите попытку позже.";
                    break;
                }
            }
        }
    }
}

?>

<h1 class="gellery-create-tiile">Загрузить фото</h1>

<form class="gellery-create__form" name="myForm" action="" method="post" enctype="multipart/form-data">
  <div class="gellery-create__input-wrapper">
    <input class="gellery-create__input"
      id="file"
      type="file"
      name="file[]"
      accept="<?=substr($acceptStr, 0, -2)?>"
      multiple
    >
    <label class="gellery-create__label" for="file">Выберете файл</label>

    <?php if ( !empty($error) ): ?>
        <?php foreach ($error as $key => $value): ?>
            <span class="gellery-create__error"><?=$value?></span>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if ($success): ?>
        <span class="gellery-create__success"><?=$success?></span>
    <?php endif; ?>
  </div>

  <button class="gellery-create__btn" name="upload">Загрузить</button>
</form>
