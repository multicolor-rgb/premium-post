const form = document.querySelector('#jsform');

if(form!==null){
console.log('test');
    form.querySelector('#jseditor').insertAdjacentHTML('beforebegin',`
     <input type="text" name="password-premium" class="form-control my-2 premiumpassword" placeholder="Access Password">`)

}