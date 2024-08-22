//SIDEBAR
const menuItems = document.querySelectorAll(".item");
//MESSAGES
const messagesNotification = document.querySelector("#messages-notifications");
const messages = document.querySelector(".messages");
const message = messages.querySelectorAll(".message");
const messageSearch = document.querySelector("#message-search");
//========SIDEBAR=========
//enlever active class pour toutes les items menus
const changeActiveItem = () => {
  menuItems.forEach((item) => {
    item.classList.remove("active");
  });
};
menuItems.forEach((item) => {
  item.addEventListener("click", (e) => {
    e.preventDefault();
    changeActiveItem();
    item.classList.add("active");
    if (item.id != "notifications") {
      document.querySelector(".notifications-popup").style.display = "none";
    } else {
      document.querySelector(".notifications-popup").style.display = "block";
      document.querySelector(
        "#notifications .notification-count"
      ).style.display = "none";
    }
  });
});

//========MESSAGES=========
// search chat
const searchMessage = () => {
  const val = messageSearch.value.toLowerCase();

  message.forEach((chat) => {
    let name = chat.querySelector("h5").textContent.toLowerCase();
    if (name.indexOf(val) != -1) {
      chat.style.display = "flex";
    } else {
      chat.style.display = "none";
    }
  });
};
messageSearch.addEventListener("keyup", searchMessage);
messagesNotification.addEventListener("click", (e) => {
  messages.style.boxShadow = "0 0 1rem var(--color-primary)";
  messagesNotification.querySelector(".notification-count").style.display =
    "none";
  setTimeout(() => {
    messages.style.boxShadow = "none";
  }, 2000);
});

$(".like_btn").click(function () {
  let user_id_v = $(this).data("userId");
  let post_id_v = $(this).data("postId");
  let button = this;
  $.ajax({
    url: "dao/ajax.php?follow",
    method: "post",
    dataType: "json",
    data: { user_id: user_id_v },
    success: function (reponse) {
      if (reponse.status) {
        $(button).attr("disabled", true);
        $(button).data("userId", 0);
        $(button).html('<i class="fa-solid fa-check"></i>');
      }
    },
  });
});
