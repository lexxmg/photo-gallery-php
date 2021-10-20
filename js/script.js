
'use strict';

const form = document.querySelector('.gellery-create__form'),
      formGallery = document.querySelector('.gallery__form'),
      submitBtn = document.querySelector('.gellery-create__btn'),
      inputWrapper = document.querySelector('.gellery-create__input-wrapper'),
      galletyInner = document.querySelector('.gallety__inner'),
      success = document.querySelector('.gellery-create__success');

getAndPasteImages();

form.addEventListener('submit', event => {
  event.preventDefault();
  const formData = new FormData(form);
  submitBtn.disabled = true;
  //console.log(formData.get('file[]'));

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

      setTimeout(() => {
        removeAllElements( document.querySelectorAll('.gellery-create__error') );
      }, 5000);
    }

    if (res.success) {
      removeAllElements( document.querySelectorAll('.gellery-create__error') );

      success.classList.remove('hide');
      success.textContent = res.success;

      getAndPasteImages();

      setTimeout(() => {
        success.classList.add('hide');
      }, 3000);
    }
    console.log(res);
  });
});

formGallery.addEventListener('submit', event => {
  event.preventDefault();

  const formData = new FormData(formGallery);

  sendData('/php/get-files.php', formData).then(res => {
    form.reset();

    getAndPasteImages();
  });
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
    .then(data => data);
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

    if (data.length === 0) {
      galletyInner.insertAdjacentHTML('beforeEnd', `
        <p style="width: 100%; text-align: center;">Нет загруженных файлов</p>
      `);
    } else {
      data.forEach((item, i) => {
        galletyInner.insertAdjacentHTML('beforeEnd', `
          <div class="gallety__card gallety-card">
            <div class="gallety-card__wrapper">
              <input class="gallety-card__input" type="checkbox" name="${item.name}">

              <img class="gallety-card__img" src="/upload/${item.name}" alt="${item.name}">

              <time class="gallety-card__date">${item.date}</time>
            </div>
          </div>
        `);
      });
    }
  });
}
