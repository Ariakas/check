<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Split the check</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/Fetch.js"></script>
    <script src="assets/js/Functions.js"></script>
    <script defer src="assets/js/script.js"></script>
</head>
<body>
    <div class="outer_container">
        <div class="inner_container">
            <form id="form" class="form">
                <h1>Split the check</h1>
                <label for="name">Name</label>
                <input type="text" id="name" placeholder="Name" required>
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Email" required>
                <button id="add_user">Add user</button>
            </form>
            <div class="to_pay">
                <h2>User to pay:</h2>
                <div id="table" class="table">
                    <div class="th">Name</div>
                    <div class="th">Email</div>
                    <div class="th">To&nbsp;pay</div>
                </div>
                <button id="reset">Reset</button>
                <p id="show_more_fractional">Tap me to read about fractional amounts</p>
            </div>
        </div>
    </div>

    <div id="loader" class="popup">
        <div class="center">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <div id="popup_text" class="popup">
        <div class="center">
            <button id="popup_text_close">
                <img src="assets/images/close-svgrepo-com.svg" alt="">
            </button>
            <p id="popup_text_message"></p>
        </div>
    </div>
</body>
</html>