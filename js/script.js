
'use strict';

const form = document.querySelector('.gellery-create__form'),
      submitBtn = document.querySelector('.gellery-create__btn'),
      inputWrapper = document.querySelector('.gellery-create__input-wrapper'),
      success = document.querySelector('.gellery-create__success');

form.addEventListener('submit', event => {
  event.preventDefault();
  const formData = new FormData(form);
  submitBtn.disabled = true;
  //console.log(formData.get('file[]'));

  sendData('/php/get-files.php', formData).then(res => {
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

      setTimeout(() => {
        success.classList.add('hide');
      }, 3000);
    }
    console.log(res);
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

function removeAllElements(elements) {
  elements.forEach(item => {
    item.remove();
  });

  return true;
}
