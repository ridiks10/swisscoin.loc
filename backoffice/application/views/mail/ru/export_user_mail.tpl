<html xmlns="https://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="https://fonts.googleapis.com/css?family=Droid+Serif" rel="stylesheet" type="text/css">
    <style>
        margin: 0px;
        padding: 0px;
    </style>
</head>
<body>
<div style="width:80%;padding:40px;border: solid 10px #D0D0D0;margin:50px auto;">
    <div style="width:100%;margin:15px 0 0 0;">
        <h1 style="font: normal 20px Tahoma, Geneva, sans-serif;">
            Дорогой
            <font color="#e10000">
                {if !empty($user_detail->user_detail_name) && !empty($user_detail->user_detail_second_name)}
                    {$user_detail->user_detail_name} {$user_detail->user_detail_second_name},
                {else}
                    {$user->user_name},
                {/if}
            </font>
        </h1>
        <br />
        <p style="font: normal 12px Tahoma, Geneva, sans-serif;text-align:justify;color:#212121;line-height:23px;">
            Спасибо, что пользуютесь SWISSCOIN.  Для Вас был создан аккаунт на нашем сайте Academy.
        </p>
        <p style="font: normal 12px Tahoma, Geneva, sans-serif;text-align:justify;color:#212121;line-height:23px;">
            Вы можете зайти на сайт Academy при помощи Вашего имени пользователя и пароля, сгенерированного ниже.
        </p>
        <p style="font: normal 12px Tahoma, Geneva, sans-serif;text-align:justify;color:#212121;line-height:23px;">
            Прямая ссылка на Academy: <a href="http://goo.gl/XooQm7">Перейти</a></font>
        </p>
        <p style="font: normal 12px Tahoma, Geneva, sans-serif;text-align:justify;color:#212121;line-height:23px;">
            Ссылка на Academy через Backoffice: <a href="http://goo.gl/XooQm7">Перейти</a></font>
        </p>
        <div style="width:400px;height:225px;margin:16px auto;border: solid 1px #d0d0d0;border-radius: 10px; clear: both;">
            <h2 style="color:#C70716;font:normal 16px Tahoma, Geneva, sans-serif;line-height:34px;margin:10px 0 0 22px;float:left;padding-left: 0px;">LOGIN DETAILS</h2>
            <div style="clear:both;"></div>
            <ul style="display:block;margin:14px 0 0 -36px;float:left;">
                <li style="list-style:none;font:normal 15px Tahoma, Geneva, sans-serif;color:#212121;margin:5px 0 0 20px;border:1px solid #ccc;background:#fff;width:300px;padding:5px;"><span style="width:150px;float:left;"> Ссылка для логина</span><font color="#025BB9"> : <a href="http://goo.gl/XooQm7">Перейти</a></font></li>
                <li style="list-style:none;font:normal 15px Tahoma, Geneva, sans-serif;color:#212121;margin:5px 0 0 20px;border:1px solid #ccc;background:#fff;width:300px;padding:5px;"><span style="width:150px;float:left;">Имя пользователя</span><font color="#e10000"> : {$user->user_name}</font></li>
                <li style="list-style:none;font:normal 15px Tahoma, Geneva, sans-serif;color:#212121;margin:5px 0 0 20px;border:1px solid #ccc;background:#fff;width:300px;padding:5px;"><span style="width:150px;float:left;">Ваш пароль</span><font color="#e10000"> : {$password}</font></li>
            </ul>
        </div>
        <div style="clear: both;"></div>
        <p style="font: normal 12px Tahoma, Geneva, sans-serif;text-align:justify;color:#212121;line-height:23px;">
            После ввода сгенерированного пароля не забудьте, пожалуйста, его изменить.
        </p>
        <p style="font: normal 12px Tahoma, Geneva, sans-serif;text-align:justify;color:#212121;line-height:23px;">
            Ваша команда SWISSCOIN
        </p>
        <p><br /><br /></p>
    </div>
</div>
</body>
</html>