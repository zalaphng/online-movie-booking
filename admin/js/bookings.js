let price = 0;

document.getElementById('showtime-select').addEventListener('change', function () {
    var theaterId = this.value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
             price = xhr.responseText;
        }
    };
    xhr.open('GET', 'exec/get_price_booking.php?showtime_id=' + theaterId, true);
    xhr.send();
    priceUpdate(price)
    console.log("price: "+ price)
});

document.getElementById('total-seat').addEventListener('keyup', function () {
    priceUpdate(price)
});

function priceUpdate(price) {
    var totalseatInput = document.getElementById("total-seat");
    var priceInput = document.getElementById("price");

    console.log(price);

    if (!isNaN(totalseatInput.value) && price !== null) {
        var totalPrice = parseInt(totalseatInput.value) * parseInt(price);
        priceInput.value = totalPrice;
    }
}

// let price = 0;
//
// document.getElementById('showtime-select').addEventListener('change', function () {
//     // Gọi priceUpdate trước để đảm bảo rằng giá trị mới của price sẽ được hiển thị ngay lập tức
//     priceUpdate(price);
//
//     // Gửi yêu cầu AJAX để lấy giá trị mới của price
//     var theaterId = this.value;
//     var xhr = new XMLHttpRequest();
//     xhr.onreadystatechange = function () {
//         if (xhr.readyState == 4 && xhr.status == 200) {
//             price = xhr.responseText;
//             // Gọi lại priceUpdate để cập nhật giá trị mới của price
//             priceUpdate(price);
//             console.log("price: " + price);
//         }
//     };
//     xhr.open('GET', 'exec/get_price_booking.php?showtime_id=' + theaterId, true);
//     xhr.send();
// });
//
// document.getElementById('total-seat').addEventListener('keyup', function () {
//     priceUpdate(price);
// });
//
// function priceUpdate(price) {
//     var totalseatInput = document.getElementById("total-seat");
//     var priceInput = document.getElementById("price");
//
//     console.log(price);
//
//     if (!isNaN(totalseatInput.value) && price !== null) {
//         var totalPrice = parseInt(totalseatInput.value) * parseInt(price);
//         priceInput.value = totalPrice;
//     }
// }
