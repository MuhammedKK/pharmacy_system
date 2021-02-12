// Confirm Delete Button
$(".confirm").click(function(e) {
    e.preventDefault();
    return confirm("are you sure ?");
});

/* Calculate Sales Bill */

let itemName = $("#items option:selected").text(); // Try To make It With Vanilla JS In The Future
let quantity = $("#quantity");
let price = $("#price");
let dis = $("#discount");
let total = document.querySelector("#total");
let billCost = $("#billCost").val();

dis.on("keyup", () => {
    total.value = (quantity.val() * price.val()) - dis.val();
    console.log(total);
});

























// // Item Class
// class item {
//     constructor(itemName, quantity, price, discount) {
//         this.itemName   = itemName;
//         this.quantity   = quantity;
//         this.price      = price;
//         this.discount   = discount;
//     }
// }

// let myItem = new item("Muhammed", 20, 30, 10);
// console.log(myItem);
// // // Bill Class

// class bill {
//     static displayItems() {
//         let rows = document.querySelectorAll(".bill tr");
//         console.log(rows.forEach(row => bill.AddItem(row)))
//         // rows.forEach(row => bill.AddItem(row));
//     }
//     static AddItem(item) {
//         let billTable = document.querySelector(".bill");
//         let total = $("#total");
//         let count = 0;
//         let tr = `
//             <tr>
//                 <td>${count++}</td>
//                 <td>${item.itemName}</td>
//                 <td>${item.quantity}</td>
//                 <td>${item.price}</td>
//                 <td>${item.discount}</td>
//                 <td>${total.val(item.quantity * item.price - item.discount)}</td>
//             </tr>
//         `;
//         billTable.append(tr);
//     }
// }
// console.log(bill.AddItem(myItem));

// // button to add item

// document.addEventListener("DOMContentLoaded", bill.displayItems());

// document.querySelector(".add").addEventListener("submit", (e) => {
//     e.preventDefault();
//     // Take A Copy Of Class
//     let itemName = $("#items option:selected").text(); // Try To make It With Vanilla JS In The Future
//     $("#items").on("change", function () {
//         itemName = $("#items option:selected").text();
//     });
//     let quantity = $("#quantity");
//     let price = $("#price");
//     let discount = $("#discount");
//     let item = new item(itemName, quantity, price, discount);

//     bill.AddItem(item);
// });









































// // get table grid
// let table = $("table"); // Table Of Items 
// let countNo = 0;    // Total Items Number
// let totalBillCost = 0;
// let x = 0;

// // function to calculate total
// let calcTotal = (total) => {
//     totalBillCost += total;
//     return totalBillCost;
// };

// // get bill inputs
// let itemName = $("#items option:selected").text(); // Try To make It With Vanilla JS In The Future
// $("#items").on("change", function () {
//     itemName = $("#items option:selected").text();
// });

// let quantity = $("#quantity");
// let price = $("#price");
// let discount = $("#discount");
// let total = $("#total").val();
// let billCost = $("#billCost");

// // add tr to table with the date on click
// $(".add").click((e) => {
//     e.preventDefault();
//     let tr = `
//         <tr>
//             <td>${countNo++}</td>
//             <td>${itemName}</td>
//             <td>${quantity.val()}</td>
//             <td>${price.val()}</td>
//             <td>${discount.val()}</td>
//             <td>${total = quantity.val() * price.val() - discount.val()}</td>
//         </tr>
//     `;
//     table.append(tr);
//     billCost.val(calcTotal(total));
//     // Empty Inputs
//     quantity.val("");
//     price.val("");
//     discount.val("");
    
//     x = billCost.val();
// });

