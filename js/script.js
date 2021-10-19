
'use strict';

const form = document.querySelector('.gellery-create__form'),
      submitBtn = document.querySelector('.gellery-create__btn');

form.addEventListener('submit', event => {
  event.preventDefault();
  const formData = new FormData(form);
  submitBtn.disabled = true;
  //console.log(formData.get('file[]'));

  fetch('/php/get-files.php', {
    method: 'POST',
    body: formData
  }).then( res => res.json() )
    .then(data => {
      console.log(data);
      form.reset();
      submitBtn.disabled = false;
    });
});
