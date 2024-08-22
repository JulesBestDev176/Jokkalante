const menuItems = document.querySelectorAll(".item");
const sections = document.querySelectorAll(".section");
//MESSAGES

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

//pour suivre un utilisateur
// $(".followbtn").click(function () {
//   let user_id_v = $(this).data("userId");
//   let button = this;
//   $.ajax({
//     url: "dao/ajax.php?follow",
//     method: "post",
//     dataType: "json",
//     data: { user_id: user_id_v },
//     success: function (reponse) {
//       if (reponse.status) {
//         $(button).attr("disabled", true);
//         $(button).data("userId", 0);
//         $(button).html('<i class="fa-solid fa-check"></i>');
//       }
//     },
//   });
// });
