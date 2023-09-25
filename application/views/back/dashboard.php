<!--<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> Dashboard</h4>-->
<?php if ($this->session->flashdata('dashboard')) echo '<div class="col-lg-12 text-center">' . $this->session->flashdata('dashboard') . '</div>'; ?>

<div class="row justify-content-center">
    <div class="col-lg-4 mb-3">
        <div class="card">
            <div class="card-header dashboard">
                <div>
                    <h2 class="fw-bolder mb-0">Hi, <?= ucwords(user_data(get_sess_data('id_user'))['username'] ?? '') ?></span></h2>
                    <p class="card-text"><?= ucwords(get_sess_data('role_user') ?? '') ?></p>
                </div>
                <div class="avatar type_room p-50 m-0">
                    <div class="avatar-content">
                        <?php $stateNum = rand(0, 5);
                        $states = ['success', 'danger', 'warning', 'info', 'primary', 'secondary'];
                        $state = $states[$stateNum];
                        $initials = (!empty(user_data(get_sess_data('id_user'))['username'])) ? get_initials(user_data(get_sess_data('id_user'))['username']) : get_initials("User");
                        $result = '<span class="avatar-initial rounded-circle bg-label-' . $state . '">' . $initials . '</span>';
                        echo $result;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    function eraseCookie(name) {
        document.cookie = name + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    }

    const ucwords = (str) =>
        str.replace(
            /(^\w|\s\w)(\S*)/g,
            (_, m1, m2) => m1.toUpperCase() + m2.toLowerCase()
        );

    function convertUnixToDateFormat(unixTimestamp) {
        const dateObj = new Date(unixTimestamp * 1000);

        const bulan = [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember",
        ];

        return `${dateObj.getDate().toString().padStart(2, "0")} ${bulan[dateObj.getMonth()]} ${dateObj.getFullYear()}`;
    }
</script>