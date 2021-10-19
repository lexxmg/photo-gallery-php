
'use strict';

const form = document.querySelector('.gellery-create__form'),
      submitBtn = document.querySelector('.gellery-create__btn');

form.addEventListener('submit', event => {
  event.preventDefault();
  //const formData = new FormData(form);
  submitBtn.disabled = true;
  console.log(new FormData(form));

  fetch('/php/get-files.php', {
    method: 'POST',
    body: new FormData(form)
  }).then( res => res.json() )
    .then(data => {
      console.log(data);
      submitBtn.disabled = false;
    });
});
