<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Split the check</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/Fetch.js"></script>
    <script defer src="assets/js/script.js"></script>
</head>
<body>
    <div class="outer_container">
        <div class="inner_container">
            <div class="form">
                <h1>Split the check</h1>
                <label for="name">Name</label>
                <input type="text" id="name" placeholder="Name">
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Email">
                <button id="add_user">Add user</button>
            </div>
            <div class="to_pay">
                <h2>User to pay:</h2>
                <div id="table" class="table">
                    <div class="th">Name</div>
                    <div class="th">Email</div>
                    <div class="th">To&nbsp;pay</div>
                </div>
                <button id="reset">Reset</button>
                <p>* in case of fractional amounts just tap on the user who should pay more :)</p>
            </div>
        </div>
    </div>

    <div id="loader">
        <div class="center">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</body>
</html>