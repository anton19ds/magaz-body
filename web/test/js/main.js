
// кнопка - подробнее и ее контент
const btnCard  = document.querySelectorAll(".btn_card");
const contentCard = document.getElementById("card-dropdown-1");
for (let i = 0; i < btnCard.length; i++) {
btnCard[i].addEventListener("click", function() {
contentCard.classList.toggle('active');
});
}

// const btnCard  = document.querySelectorAll(".btn_card");
// const contentCard = document.querySelectorAll(".card-dropdown");
// for (let i = 0; i < btnCard.length; i++) {
// btnCard[i].addEventListener("click", function() {
// 	for(var i = 0; i < contentCard.length; i++){
//         contentCard[i].classList.toggle('active');
//     }
// });
// }

// кнопка - количество и ее контент
const btnQuantity = document.querySelectorAll(".btn_quantity");
const contentQuantity = document.getElementById("quantity-dropdown-1");
for (let i = 0; i < btnQuantity.length; i++) {
btnQuantity[i].addEventListener("click", function() {
contentQuantity.classList.toggle('active');
btnQuantity[i].classList.toggle('active');
});
}






