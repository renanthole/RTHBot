/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************!*\
  !*** ./resources/js/chat.js ***!
  \******************************/
jQuery(function () {
  var baseUrl = "/api/chat";
  function sendMessage(id, chat, phone, message) {
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: "".concat(baseUrl, "/new"),
        method: "POST",
        data: {
          device: id,
          chat: chat,
          phone: phone,
          message: message
        },
        dataType: "JSON",
        beforeSend: function beforeSend() {
          $("#message").val('');
          $(".overlay").removeClass("d-none");
        },
        success: function success(data) {
          setTimeout(function () {
            $(".overlay").addClass("d-none");
            resolve(data.data);
          }, 1000);
        },
        error: function error(xhr, status, _error) {
          $(".overlay").addClass("d-none");
          reject(_error);
        }
      });
    });
  }
  function getMessages(chat) {
    $.ajax({
      url: "/chats/" + chat,
      type: "GET",
      dataType: "html",
      beforeSend: function beforeSend() {
        $(".overlay").removeClass("d-none");
      },
      success: function success(data) {
        $(".overlay").addClass("d-none");
        $("#messages").html(data);
      }
    });
  }
  $("#setMessage").on("click", function (e) {
    e.preventDefault();
    var id = $(this).data("id");
    var chat = $("#chat").val();
    var phone = $("#phone").val();
    var message = $("#message").val();
    sendMessage(id, chat, phone, message);
    getMessages(chat);
  });
  setInterval(function () {
    var chat = $("#chat").val();
    getMessages(chat);
  }, 5000);
});
/******/ })()
;