<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> | Chat App </title>
    <link rel="stylesheet" href="<?= base_url('/assets/css/main.css') ?>">
    <link rel="stylesheet" href="<?= base_url('/assets/css/modal.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;600&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;600&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:wght@200;300;400;600&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body>
    <?php
    $this->db = \Config\Database::connect();
    $this->user = $this->db->table('user');
    $this->id = session('login')['id'];
    $user = $this->user->getWhere(['id' => $this->id])->getRow();
    ?>
    <div class="conteiner">
        <!-- Modal for Incoming Call -->
        <div id="offerModal" class="offer-modal">
            <div class="modal-content">
                <h2>Incoming Call</h2>
                <p>You have an incoming <span id="callType"></span> call from <span id="senderName"></span>.</p>
                <div id="receiverVideoContainer">
                    <video id="receiverVideo" autoplay></video>
                </div>
                <div class="modal-buttons">
                    <button id="acceptButton">Accept</button>
                    <button id="declineButton">Decline</button>
                </div>
            </div>
        </div>

        <!-- Backdrop with Blur Effect -->
        <div id="modalBackdrop" class="modal-backdrop"></div>
        <div class="main-box">
            <div class="right-box">
                <div class="right-header">
                    <div class="profile">
                        <?php if (!empty($user->file_loc)): ?>
                            <img src="<?= $user->file_loc ?>" alt="<?= $user->name ?>" title="<?= $user->name ?>">
                        <?php else: ?>
                            <img src="<?= base_url('/image/images.jpg') ?>" alt="<?= session('login')['name'] ?>">
                        <?php endif; ?>
                    </div>
                    <div class="header-name" onclick="getfrnd()">
                        <?= $user->name ?>
                    </div>
                    <div class="header-add" onclick="getlistfrnd()">
                        <button><i class="fa-solid fa-user-plus"></i></button>
                    </div>
                </div>
                <div class="right-context">
                    <!-- <button onclick="getfrnd()">g</button> -->
                    <div class="listeer">
                    </div>
                </div>
            </div>
            <div class="center-box" id="center_box">
            </div>
            <div class="left-box">
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="<?= base_url('/assets/js/calling.js') ?>"></script>
    <!-- <script>
        function timeSince(date) {
            const now = new Date();
            const seconds = Math.floor((now - date) / 1000);
            let interval = seconds / 31536000;

            if (interval > 1) {
                return Math.floor(interval) + " year" + (Math.floor(interval) > 1 ? "s" : "") + " ago";
            }
            interval = seconds / 2592000;
            if (interval > 1) {
                return Math.floor(interval) + " month" + (Math.floor(interval) > 1 ? "s" : "") + " ago";
            }
            interval = seconds / 86400;
            if (interval > 1) {
                return Math.floor(interval) + " day" + (Math.floor(interval) > 1 ? "s" : "") + " ago";
            }
            interval = seconds / 3600;
            if (interval > 1) {
                return Math.floor(interval) + " hour" + (Math.floor(interval) > 1 ? "s" : "") + " ago";
            }
            interval = seconds / 60;
            if (interval > 1) {
                return Math.floor(interval) + " minute" + (Math.floor(interval) > 1 ? "s" : "") + " ago";
            }
            return Math.floor(seconds) + " second" + (Math.floor(seconds) > 1 ? "s" : "") + " ago";
        }

        function updateTimes() {
            const messageElements = document.querySelectorAll('.message');
            messageElements.forEach((msg) => {
                const timeElement = msg.querySelector('.time');
                const messageTime = parseInt(msg.getAttribute('data-time'), 10);
                const timeAgo = timeSince(new Date(messageTime));
                timeElement.textContent = timeAgo;
            });
        }
        setInterval(updateTimes, 60000);

        const conn = new WebSocket('ws://localhost:8080');

        conn.onopen = () => {
            console.log('Connected to WebSocket server');
            const sender_id = <?= $this->id ?>;
            conn.send(JSON.stringify({ type: 'handshake', userId: sender_id }));
        };

        conn.onmessage = (e) => {
            const messageData = JSON.parse(e.data);
            let messageHTML = '';

            if (messageData.type === 'image') {
                messageHTML = `
            <div class="message rec" data-time="${messageData.time}">
                <div class="text">
                    <img src="${messageData.message}" alt="image" class="chat-image">
                    <span>${timeSince(messageData.time)}</span>
                </div>
            </div>`;
            } else if (messageData.type === 'msg') {
                const gettime = timeSince(messageData.time);
                messageHTML = `
            <div class="message rec" data-time="${messageData.time}">
                <div class="text">
                    <p>${messageData.message}</p>
                    <span>${gettime}</span>
                </div>
            </div>`;
            } else if (messageData.type === 'handshake') {
                // Handle handshake (if needed)
            }

            document.getElementById('messageBox').innerHTML += messageHTML;
            scrollToBottom();
            updateTimes();
        };

        function sendmsg(receiver_id) {
            const sender_id = <?= $this->id ?>;
            const message = $('#messageInput').val().trim();
            const currentTime = new Date().getTime();

            if (message === '') {
                alert('Please enter a message.');
                return;
            }
            const messageData = {
                sender: sender_id,
                receiver_id: receiver_id,
                message: message,
                type: 'msg',
                time: currentTime,
            };
            conn.send(JSON.stringify(messageData));
            $.ajax({
                type: 'POST',
                url: '<?= base_url('/sendMessage') ?>',
                data: {
                    receiver_id: receiver_id,
                    msg: message,
                },
                dataType: 'json',
                success: function (res) {
                    console.log("Message saved", res);
                },
                error: function (err) {
                    console.error("Error saving message", err);
                }
            });

            $('#messageInput').val('');
            const timeAgo = timeSince(currentTime);
            const messageHTML = `
        <div class="message own" data-time="${currentTime}">
            <div class="text">
                <p>${message}</p>
                <span class="time">${timeAgo}</span>
            </div>
        </div>`;

            document.getElementById('messageBox').innerHTML += messageHTML;
            scrollToBottom();
        }

        $('.file-btn').on('click', function () {
            const fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.accept = 'image/*';
            fileInput.click();

            fileInput.addEventListener('change', function (event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onloadend = function () {
                        const base64Image = reader.result;
                        const sender_id = <?= $this->id ?>;
                        const receiver_id = receiver_id;
                        const currentTime = new Date().getTime();

                        const messageData = {
                            sender: sender_id,
                            receiver_id: receiver_id,
                            message: base64Image,
                            type: 'image',
                            time: currentTime,
                        };
                        conn.send(JSON.stringify(messageData));

                        const messageHTML = `
                    <div class="message own" data-time="${currentTime}">
                        <div class="text">
                            <img src="${base64Image}" alt="image" class="chat-image">
                            <span>${timeSince(currentTime)}</span>
                        </div>
                    </div>`;

                        document.getElementById('messageBox').innerHTML += messageHTML;
                        scrollToBottom();
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script> -->

    <script>
        function show(id, type) {
            $.ajax({
                url: '<?= base_url('call/show/') ?>' + id + '/' + type,
                type: 'GET',
                dataType: 'json',
                success: function (res) {
                    $('#center_box').html(res);
                }
            })
        }
        function videoCall(id) {
            $.ajax({
                url: '<?= base_url('call/call/') ?>' + id,
                type: 'GET',
                dataType: 'json',
                success: function (res) {
                    $('#center_box').html(res);
                    // getMedia(true);
                    console.log("Call request sent, waiting for response...");
                    startCall(true, <?= $this->id ?>, id);
                }
            })
        }
        function call(id) {
            $.ajax({
                url: '<?= base_url('call/hcall/') ?>' + id,
                type: 'GET',
                dataType: 'json',
                success: function (res) {
                    $('#center_box').html(res);
                    console.log("Call request sent, waiting for response...");
                    startCall(false, <?= $this->id ?>, id); // false for audio-only call
                }
            })
        }

        //other 
        function getfrnd() {
            $.ajax({
                url: '<?= base_url('user-frined') ?>',
                type: 'GET',
                dataType: 'json',
                success: function (res) {
                    $('.listeer').html(res);
                }
            })
        }
        getfrnd();

        function block(id) {
            $.ajax({
                url: '<?= base_url('block/') ?>' + id,
                type: 'GET',
                dataType: 'json',
                success: function (res) {
                    sid_bar(id)
                }
            })
        }
        function unblock(id) {
            $.ajax({
                url: '<?= base_url('unblock/') ?>' + id,
                type: 'GET',
                dataType: 'json',
                success: function (res) {
                    sid_bar(id)
                }
            })
        }
        function sid_bar(id) {
            load_bar(id);
            $.ajax({
                url: '<?= base_url('side-bar/') ?>' + id,
                type: 'GET',
                dataType: 'json',
                success: function (res) {
                    $('.left-box').html(res);
                }
            })
        }
        function load_bar(id) {
            $.ajax({
                url: '<?= base_url('load-msg/') ?>' + id,
                type: 'GET',
                dataType: 'json',
                success: function (res) {
                    $('#center_box').html(res);
                    // scrollToBottom();
                }
            })
        }
        function frn(id) {
            $.ajax({
                url: '<?= base_url('rqst-sent/') ?>' + id,
                type: 'GET',
                dataType: 'json',
                success: function (res) {
                    getlistfrnd();
                }
            })
        }
        function frns(id) {
            $.ajax({
                url: '<?= base_url('add-sent/') ?>' + id,
                type: 'GET',
                dataType: 'json',
                success: function (res) {
                    getlistfrnd();
                }
            })
        }
        function getlistfrnd() {
            $.ajax({
                url: '<?= base_url('frined') ?>',
                type: 'GET',
                dataType: 'json',
                success: function (res) {
                    $('.listeer').html(res);
                }
            })
        }
        sid_bar(<?= $this->id ?>);

        $('#logout').on('click', function () {
            $.ajax({
                url: '<?= base_url('logout') ?>',
                type: 'GET',
                success: function (res) {
                    window.location.href = '/';
                }
            })
        })
    </script>
</body>

</html>