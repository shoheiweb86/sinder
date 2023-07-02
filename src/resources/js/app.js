import './bootstrap';
import '@fortawesome/fontawesome-free/css/all.css';
import '@fortawesome/fontawesome-free/js/all.js';
import Alpine from 'alpinejs';
import jQuery from 'jquery';
window.$ = jQuery;

window.Alpine = Alpine;

Alpine.start();


//新規登録フォームチェック
$(document).ready(function() {
  // フォームの入力状態をチェックして背景色を変更する関数
  function checkFormLogin() {
    var name = $('#name').val();
    var email = $('#email').val();
    var password = $('#password').val();
    var passwordConfirmation = $('#password_confirmation').val();
    var checkboxChecked = $('#myCheckbox').prop('checked');

    if (name !== '' && email !== '' && password !== '' && passwordConfirmation !== '' && checkboxChecked) {
      $('.register-button').addClass('bg-main').removeClass('bg-gray');
    } else {
      $('.register-button').addClass('bg-gray').removeClass('bg-main');
    }
  }

  // フォームの入力状態が変更されたときに背景色を変更する
  $('#name, #email, #password, #password_confirmation, #myCheckbox').on('input change', function() {
    checkFormLogin();
  });

  // ページ読み込み時にも背景色をチェックする
  checkFormLogin();
});