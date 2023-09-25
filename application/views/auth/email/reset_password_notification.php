<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/data/logo/') . $settings['favicon']; ?>">
    <title>Notifikasi Reset Password - Website <?= $settings['application_name']; ?></title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/niceadmin/" />
</head>

<body style="margin:0px; background: #f8f8f8; ">
    <div width="100%" style="background: #f8f8f8; padding: 0px 0px; font-family:arial; line-height:28px; height:100%;  width: 100%; color: #514d6a;">
        <div style="max-width: 900px; padding:10px;  margin: 0px auto; font-size: 14px">
            <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                <tbody>
                    <tr>
                        <td style="background:#cf2424; padding:20px; color:#fff; text-align:center; border-top-right-radius: 10px;border-top-left-radius: 10px;">
                            <h3>Reset Password Berhasil - Website <?= $settings['application_name']; ?></h3>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div style="padding: 30px 40px; background: #fff; box-shadow: 0 0 10px #e7e7e7; border-bottom-right-radius: 10px;border-bottom-left-radius: 10px;">
                <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                    <tbody>
                        <tr>
                            <td>
                                <p>Halo <?= ucwords($users['first_name'] . ' ' . $users['last_name']) ?>,</p>
                                <p>Kata sandi Anda telah berhasil diubah pada <?= dateIndo(date("Y-m-d")) . " pukul " . date("H:i"); ?>. Sekarang, Anda bisa langsung menggunakan kata sandi baru Anda untuk masuk ke website YKI Cabang Jawa Timur.
                                </p>
                                <p>Selamat datang kembali!</p>
                                <p>Silahkan gunakan kata sandi baru untuk masuk ke website <?= $settings['application_name']; ?> dengan tautan di bawah ini.
                                </p>
                                <p><b><?= base_url('auth') ?></b></p>
                                <hr>
                                <p>Jika Anda merasa tidak mengubah kata sandi, silahkan segera <a href="<?= base_url('#message_us'); ?>">hubungi kami</a></p>
                                <b>Hormat kami,</b><br>
                                <b>- Tim Administrator <?= $settings['application_name']; ?></b>
                                <br><small><?= date("d-m-Y H:i:s") ?> </small>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div align="center" style="margin-left:auto; margin-right:auto; margin-top: 10px; margin-bottom: 20px;">
                <a target="_blank" href="<?= $settings['instagram_link']; ?>" style="text-decoration: none; margin-right: 0.5rem;">
                    <img border="0" vspace="0" hspace="0" style="padding: 0; margin: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: inline-block; color: #000000;" alt="Instagram YKI Jatim" title="Instagram YKI Jatim" width="44" height="44" src="<?= base_url('assets/data/icons/icons8-instagram.png') ?>">
                </a>
                <a target="_blank" href="<?= $settings['facebook_link']; ?>" style="text-decoration: none; margin-right: 0.5rem;">
                    <img border="0" vspace="0" hspace="0" style="padding: 0; margin: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: inline-block; color: #000000;" alt="Facebook YKI Jatim" title="Facebook YKI Jatim" width="44" height="44" src="<?= base_url('assets/data/icons/icons8-facebook.png') ?>">
                </a>
                <a target="_blank" href="<?= $settings['youtube_link']; ?>" style="text-decoration: none; margin-right: 0.5rem;">
                    <img border="0" vspace="0" hspace="0" style="padding: 0; margin: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: inline-block; color: #000000;" alt="Youtube YKI Jatim" title="Youtube YKI Jatim" width="44" src="<?= base_url('assets/data/icons/icons8-youtube.png') ?>">
                </a>
                <a target="_blank" href="<?= $settings['tiktok_link']; ?>" style="text-decoration: none; margin-right: 0.5rem;">
                    <img border="0" vspace="0" hspace="0" style="padding: 0; margin: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: inline-block; color: #000000;" alt="Tiktok YKI Jatim" title="Tiktok YKI Jatim" width="44" src="<?= base_url('assets/data/icons/icons8-tiktok.png') ?>">
                </a>
                <a target="_blank" href="<?= $settings['twitter_link']; ?>" style="text-decoration: none; margin-right: 0.5rem;">
                    <img border="0" vspace="0" hspace="0" style="padding: 0; margin: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: inline-block; color: #000000;" alt="Twitter YKI Jatim" title="Twitter YKI Jatim" width="44" height="44" src="<?= base_url('assets/data/icons/icons8-twitter.png') ?>">
                </a>
            </div>
            <p align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 13px; font-weight: 400; line-height: 150%; padding-bottom: 20px; color: #999999; font-family: sans-serif;" class="footer">
                Email ini terkirim secara otomatis oleh website <?= $settings['application_name']; ?> © 2023 <?= (date('Y') != 2023) ? ' - ' . date('Y') : ''; ?>
            </p>
        </div>
    </div>
</body>

</html>