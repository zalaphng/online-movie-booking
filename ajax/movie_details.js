
$(document).ready(function () {
    var todayDate = new Date().toISOString().split('T')[0];
    loadShowtimes(todayDate);

    $('.date-btn').click(function () {
        var selectedDate = $(this).data('date');
        loadShowtimes(selectedDate);
    });

    function loadShowtimes(date) {
        $.ajax({
            url: 'ajax/get_showtimes.php',
            method: 'GET',
            data: {date: date, movieId: movieId},
            success: function (response) {
                $('#showtimes-section').html(response);
            },
            error: function () {
                alert('Error fetching showtimes');
            }
        });
    }

    var todayDate = new Date().toISOString().split('T')[0];
    loadShowtimes(todayDate);

    $('.date-btn[data-date="' + todayDate + '"]').addClass('active');

    $('.date-btn').click(function () {
        var selectedDate = $(this).data('date');

        $('.date-btn').removeClass('active');

        $(this).addClass('active');

        loadShowtimes(selectedDate);
    });

// Xử lý select box

    $('#theaterSelect').change(function () {
        let selectedTheater = $(this).val();
        let selectedDate = $('.date-btn.active').data('date');

        if (typeof selectedDate === 'undefined') {
            selectedDate = todayDate;
        }

        console.log(selectedTheater + ' ' + selectedDate + ' ' + movieId);
        fetchShowtimes(selectedDate, selectedTheater, movieId);
    });

    // $('#theaterSelect').change(function () {
    //     let selectedTheater = $(this).val();
    //     let navbarDate = $('.date-btn.active');
    //     let selectedDate = navbarDate.data('date');
    //
    //     if (typeof selectedDate === 'undefined') {
    //         $('.date-btn:first').addClass('active');
    //         let navbarDate = $('.date-btn.active');
    //         selectedDate = navbarDate.data('date');
    //     }
    //
    //     console.log(selectedTheater + ' ' + selectedDate + ' ' + movieId);
    //     fetchShowtimes(selectedDate, selectedTheater, movieId);
    // });


    function fetchShowtimes(selectedDate, selectedTheater, movieId) {
        $.ajax({
            url: 'ajax/filter_showtimes.php',
            method: 'GET',
            data: {date: selectedDate, theater:selectedTheater, movieId: movieId},
            success: function (response) {
                console.log(response);
                $('#showtimes-section').html(response);
            },
            error: function () {
                alert('Error fetching showtimes');
            }
        });
    }
});



