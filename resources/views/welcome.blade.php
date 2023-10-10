<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            margin: 10px;
            cursor: pointer;
        }
    </style>
    <form id="book-form">
        @csrf

        @if($totalSeats)
            <div class="form-group">
                <label for="name">Total Seats Avialable: {{$totalSeats}}</label>
                <input type="number" class="form-control" id="seats" name="seats" min="1" max="{{$maximumSeatsInOneTime}}" required>
            </div>
            <button type="submit" class="btn btn-primary">Book</button>
        @else
            <label for="note" style="color: red">All seats are booked there is no avialable seats are left.</label>
        @endif
    </form>

    <div id="book-msg" style="display:none">
        <label id="msg"></label>
        <br><br>
        <label for="note" style="color: red">Please Refresh The Page for booking more tickets.</label>
    </div>

    <script>

        document.getElementById('book-form').addEventListener('submit', function (e) {
            e.preventDefault();

            let seats = document.getElementById('seats').value;

            var postData = {
                _token: "{{csrf_token()}}",
                seats: seats
            };

            $.ajax({
                type: 'POST',
                url: '/book-seats',
                data: postData,
                success: function (data) {
                    $('#book-form').hide();
                    $('#msg').html(data.msg);
                    $('#book-msg').show();
                },
                error: function (error) {
                    console.error(error);
                    alert('something went wrong..')
                }
            });

        });
    </script>
</body>
</html>