import './bootstrap';
import '@fortawesome/fontawesome-free/css/all.css';
import '@fortawesome/fontawesome-free/js/all.js';
import Alpine from 'alpinejs';
import jQuery from 'jquery';
window.$ = jQuery;

window.Alpine = Alpine;

Alpine.start();

$(document).ready(function() {
  // フォームの入力状態をチェックして背景色を変更する関数
  function checkForm() {
    var allFieldsFilled = true;

    // 必須項目が全て入力されているかチェックする
    $('.js-required-form').each(function() {
      if ($(this).val() === '') {
        allFieldsFilled = false;
        return false; // ループを抜ける
      }
    });

    var checkboxChecked = $('.js-required-check').prop('checked');

    if (allFieldsFilled && (typeof checkboxChecked === 'undefined' || checkboxChecked)) {
      $('.register-button').addClass('bg-main').removeClass('bg-gray');
    } else {
      $('.register-button').addClass('bg-gray').removeClass('bg-main');
    }
  }

  // フォームの入力状態が変更されたときに背景色を変更する
  $('.js-required-form, .js-required-check').on('input change', function() {
    checkForm();
  });

  // ページ読み込み時にも背景色をチェックする
  checkForm();
});


$(document).ready(function() {
  // チェックボックスの状態を監視してテキストのクラスを変更する関数
  function updateTextClass() {
    var my_checkbox_checked = $('#my_checkbox').prop('checked');

    if (my_checkbox_checked) {
      $('.js-check-box').addClass('text-main');
    } else {
      $('.js-check-box').removeClass('text-main');
    }
  }

  // チェックボックスの状態が変更されたときにテキストのクラスを更新する
  $('#my_checkbox').on('change', function() {
    updateTextClass();
  });

  // ページ読み込み時にもテキストのクラスをチェックする
  updateTextClass();
});

//カテゴリーアクティブ処理
$(function () {
  $('.js-category').on('click', function () {
    $('.category-active').removeClass('category-active');
    $(this).addClass('category-active');
  });

  $('.like-toggle').on('click', function () {
    $(this).toggleClass('liked');
  });
});

//やり取りページカテゴリー表示切り替え
$(document).ready(function() {
  // 初期表示設定
  $(".js-liked-seeking").show();
  $(".js-liked-my-seeking, .js-connected-user").hide();

  // クリックイベント
  $(".js-category").click(function() {
      var target = $(this).data('target'); // data-target属性を取得

      // 全部非表示にしてから、選択されたカテゴリだけ表示
      $(".js-liked-seeking, .js-liked-my-seeking, .js-connected-user").hide();
      $("." + target).show();
  });
});

//やり取りページカテゴリー表示切り替え
$(document).ready(function() {
  // 初期表示設定
  $(".js-all-seeking").show();
  $(".js-man-seeking, .js-woman-seeking").hide();

  // クリックイベント
  $(".js-category").click(function() {
      var target = $(this).data('target'); // data-target属性を取得

      // 全部非表示にしてから、選択されたカテゴリだけ表示
      $(".js-all-seeking, .js-man-seeking, .js-woman-seeking").hide();
      $("." + target).show();
  });
});