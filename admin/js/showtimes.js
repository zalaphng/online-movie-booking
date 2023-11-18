document.getElementById('theater-select').addEventListener('change', function () {
    var theaterId = this.value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById('screen-select').innerHTML = xhr.responseText;
        }
    };
    xhr.open('GET', 'exec/get_screen_names.php?theater_id=' + theaterId, true);
    xhr.send();
});

document.getElementById('edit-theater-select').addEventListener('change', function () {
    var theaterId = this.value;
    console.log("here");
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById('edit-screen-select').innerHTML = xhr.responseText;
        }
    };
    xhr.open('GET', 'exec/get_screen_names.php?theater_id=' + theaterId, true);
    xhr.send();
});