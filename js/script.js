
'use strict';

const form = document.querySelector('.gellery-create__form'),
      formGallery = document.querySelector('.gallery__form'),
      submitBtn = document.querySelector('.gellery-create__btn'),
      deleteWrapper = document.querySelector('.gallery__wrapper-btn'),
      deleteBtn = document.querySelector('.gallery__btn'),
      inputWrapper = document.querySelector('.gellery-create__input-wrapper'),
      galletyInner = document.querySelector('.gallety__inner'),
      success = document.querySelector('.gellery-create__success');

getAndPasteImages();

form.addEventListener('submit', event => {
  event.preventDefault();

  //console.log(form.file.value);

  const formData = new FormData(form);
  //console.log([...formData]);
  //formData.append('file[]', event.target.file);
  formData.append('upload', '');

  //console.log([...formData]);

  submitBtn.disabled = true;

  sendData('/php/set-files.php', formData).then(res => {
    form.reset();
    submitBtn.disabled = false;

    if (res.error.length > 0) {
      success.classList.add('hide');
      removeAllElements( document.querySelectorAll('.gellery-create__error') );

      res.error.forEach(item => {
        inputWrapper.insertAdjacentHTML('beforeEnd', `
          <span class="gellery-create__error">${item}</span>
        `);
      });
    }

    if (res.success) {
      removeAllElements( document.querySelectorAll('.gellery-create__error') );

      success.classList.remove('hide');
      success.textContent = res.success;

      getAndPasteImages();

      //disabledInput(formGallery, 'deleteAll');

      setTimeout(() => {
        success.classList.add('hide');
      }, 3000);
    }
    console.log(res);
  });
});

formGallery.addEventListener('submit', event => {
  event.preventDefault();

  //console.log(event.target);

  const formData = new FormData(formGallery);
  formData.append('delete', 1);

  deleteBtn.disabled = true;

  sendData('/php/get-files.php', formData).then(res => {
    form.reset();
    formGallery.reset();

    getAndPasteImages();
    removeAllElements( document.querySelectorAll('.gellery-create__error') );
    //disabledInput(formGallery, 'deleteAll');
  });
});

formGallery.addEventListener('change', event => {
  const formElemrnts = formGallery.elements;

  deleteBtn.disabled = true;

  for (let i = 0; i < formElemrnts.length; i++) {
    if (formElemrnts[i].type === 'checkbox' && formElemrnts[i].checked) {
      deleteBtn.disabled = false;
    }
  }
});


function sendData(url, formData) {
  return fetch(url, {
    method: 'POST',
    body: formData
  }).then(res => {
    if (!res.ok) {
      throw new Error(`Ошибка ${url} ${res}`);
    } else {
      return res;
    }
  }).then(res => res.json() )
    .then(data => {
      return data;
    });
}

function getData(url) {
  return fetch(url).then(res => {
    if (!res.ok) {
      throw new Error(`Ошибка ${url} ${res}`);
    } else {
      return res;
    }
  }).then(res => res.json() )
    .then(data => data);
}

function removeAllElements(elements) {
  elements.forEach(item => {
    item.remove();
  });

  return true;
}


function getAndPasteImages() {
  getData('/php/get-files.php').then(data => {
    galletyInner.innerHTML = '';

    function SortArray(x, y){
      return x.name.localeCompare(y.name);
    }

    if (data.length === 0) {
      deleteWrapper.classList.add('hide');

      galletyInner.insertAdjacentHTML('beforeEnd', `
        <p style="width: 100%; text-align: center;">Нет загруженных файлов</p>
      `);
    } else {
      deleteWrapper.classList.remove('hide');

      data.sort(SortArray).forEach((item, i) => {
        galletyInner.insertAdjacentHTML('beforeEnd', `
          <div class="gallety__card gallety-card">
            <div class="gallety-card__wrapper">
              <input class="gallety-card__input" type="checkbox" name="${item.name}">

              <img class="gallety-card__img" src="/upload/${item.name}" alt="${item.name}">

              <div class="gallety-card__inner">
                <time class="gallety-card__date">${item.date}</time>

                <span class="gallety-card__size">${sizeConvert(item.size, 1)}</span>
              </div>
            </div>
          </div>
        `);
      });
    }
  });
}

function sizeConvert(bytes, decimals = 2) {
    if (bytes === 0) return '0 Bytes';

    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

    const i = Math.floor(Math.log(bytes) / Math.log(k));

    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}
