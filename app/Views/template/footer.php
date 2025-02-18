<script>
    function showModal(url, title) {
        $('#modal_mdl').on('shown.bs.modal', function () {
            $('.selectpicker').selectpicker('refresh');
        });
        $('#modal_mdl').modal('show', {
            backdrop: 'true',
            show: true
        });
        $.ajax({
            url: url,
            success: function (response) {
                $('#modal_mdl .modal-title').html(title);
                $('#modal_mdl .modal-body').html(response);
            }
        });
    }
</script>
<script>
    $(document).ready(function () {
        $(function () {
            var start = moment().startOf('year');
            var end = moment().endOf('year');

            function cb(start, end) {
                $('#reportrange').val(start.format('Do MMM YYYY') + ' - ' + end.format('Do MMM YYYY'));
                // getCountDetails();
                // get_telecall(0);
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'This Year': [moment().startOf('year'), moment().endOf('year')],
                    'Last 5 Years': [moment().subtract(5, 'years').startOf('year'), moment().subtract(0, 'month').endOf('month')]
                },
                locale: {
                    format: 'Do MMM YYYY'
                }
            }, cb);

            cb(start, end);
        });
    });
</script>
<script>
    function showModal(url, title) {
        $('#modal_md').on('shown.bs.modal', function () {
            $('.selectpicker').selectpicker('refresh');
        });
        $('#modal_md').modal('show', {
            backdrop: 'true',
            show: true
        });
        $.ajax({
            url: url,
            success: function (response) {
                $('#modal_md .modal-title').html(title);
                $('#modal_md .modal-body').html(response);
            }
        });
    }
</script>

<script>
    $(document).ready(function () {
        $.ajax({
            method: 'GET',
            url: '<?= base_url('profile') ?>',
            dataType: 'json',
            success: function (res) {
                if (res.code == 10) {
                    $('#profile').html(res.img);
                }
            }
        });
    });
</script>
<script>
    // $('.sj').on('click', function () {
    setTimeout(() => {
        $.ajax({
            method: 'GET',
            url: '<?= base_url('indentity') ?>',
            dataType: 'json',
            success: function (response) {
                if (response == 10) {
                    // $('.cok').attr('src', response.barcode_image_url);
                }
                console.log(response);
            }
        });
    }, 3000);
    // });

</script>
<script>
    $(document).ready(function () {
        $(window).click(function (event) {
            if ($(event.target).is("#myModal")) {
                $("#myModal").hide();
                cardval()
                booo()
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        $.ajax({
            method: 'GET',
            url: '<?= base_url('profile') ?>',
            dataType: 'json',
            success: function (res) {
                if (res.code == 10) {
                    $('#profile').html(res.img);
                }
            }
        });
    });
  $('#logout').on('click', function () {
        $.ajax({
            method: 'POST',
            url: '<?= base_url('logout') ?>',
            dataType: 'json',
            success: function (res) {
                if (res == 10) {
                    window.location.href = '/';
                }
            }
        });
    });
</script>
<script>
    function showToast(type, message) {
        const toast = $('<div class="maintoast"></div>');
        let icon;
        if (type === 'success') {
            toast.addClass('success');
            icon = '✔';
        } else if (type === 'warning') {
            toast.addClass('warning');
            icon = '⚠';
        } else if (type === 'error') {
            toast.addClass('error');
            icon = '❌';
        }
        toast.html(`
        <div class="icon">${icon}</div>
        <div class="msg">${message}</div>
        <button class="offtoast" onclick="closeToast(this)">X</button>
      `);
        $('#toast-container').append(toast);
        setTimeout(function () {
            toast.addClass('show');
        }, 10);
        setTimeout(function () {
            toast.removeClass('show');
            setTimeout(function () {
                toast.remove();
            }, 500);
        }, 3000);
    }
    function closeToast(button) {
        const toast = $(button).closest('.maintoast');
        toast.removeClass('show');
        setTimeout(function () {
            toast.remove();
        }, 500);
    }
</script>
</body>

</html>