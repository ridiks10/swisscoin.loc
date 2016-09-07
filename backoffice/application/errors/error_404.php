<!DOCTYPE html>
<!-- Template Name: Clip-One - Responsive Admin Template build with Twitter Bootstrap 3 Version: 1.0 Author: ClipTheme -->
<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
    <!--<![endif]-->
    <!-- start: HEAD -->
    <head>
        <title><?php echo ERROR_PAGE_TITLE; ?> | Page not found</title>
        <!-- start: META -->
        <meta charset="utf-8" />
        <!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- end: META -->


        <style>
            /* ---------------------------------------------------------------------- */
            /*	404 and 500 errors
             /* ---------------------------------------------------------------------- */
            body {
                color: #000000;
                direction: ltr;
                font-family: 'Open+Sans',sans-serif;
                font-size: 13px;
            }
            body.error-full-page {
                background: #ffffff !important;
            }
            body.error-full-page .page-error {
                margin-top: 60px;
            }
            .page-error {
                text-align: center;
            }
            .page-error .error-number {
                display: block;
                font-size: 158px;
                font-weight: 300;
                letter-spacing: -10px;
                line-height: 128px;
                margin-top: 0;
                text-align: center;
            }
            .page-error .error-details {
                display: block;
                padding-top: 0;
                text-align: center;
            }
            .page-error .error-details .btn-return {
                margin: 10px 0;
            }
            .page-error .error-details h3 {
                margin-top: 0;
            }
            body.error-full-page {
                overflow: hidden;
            }
            .error-full-page img {
                display: none;
            }

            .error-full-page #canvas {
                position: absolute;
                top: 0px;
                left: 0px;
            }
            .error-full-page #sound {
                position: absolute;
                width: 30%;
                height: 30%;
                overflow-y: auto;
                margin-left: 35%;
                -moz-border-radius: 15px;
                border-radius: 15px;
                opacity: 0.3;
                margin-top: 5%;
            }
            .error-full-page .video {
                position: absolute;
                width: 90%;
                height: 80%;
                margin-left: 5%;
                margin-top: 5%;
            }
            .teal {
                color: #569099;
            }
            .page-error .error-details .btn-return {
                margin: 10px 0;
            }
            .btn {
                transition: all 0.3s ease 0s !important;
            }
            .btn-teal {
                background-color: #569099;
                border-color: #4D8189;
                color: #FFFFFF;
            }
            .btn {
                font-family: 'Open Sans';
            }
            .btn {
                -moz-user-select: none;
                background-image: none;
                border: 1px solid rgba(0, 0, 0, 0);
                border-radius: 4px;
                cursor: pointer;
                display: inline-block;
                font-size: 14px;
                font-weight: normal;
                line-height: 1.42857;
                margin-bottom: 0;
                padding: 6px 12px;
                text-align: center;
                vertical-align: middle;
                white-space: nowrap;
            }
            a, a:focus, a:hover, a:active {
                outline: 0 none !important;
            }
            a {
                color: #428BCA;
                text-decoration: none;
            }
            p {
                margin: 0 0 10px;    
                line-height: 2;
            }
            .page-error .error-details h3 {
                margin-top: 0;
            }
            h1, h2, h3 {
                font-family: 'Raleway',sans-serif;
            }
            h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
                color: inherit;
                font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
                font-weight: 500;
                line-height: 1.1;
            }
            /* ---------------------------------------------------------------------- */
            /*	Inline Editor
             /* ---------------------------------------------------------------------- */
        </style>
    </head>

    <!-- end: HEAD -->
    <!-- start: BODY -->
    <body class="error-full-page">
        <div id="sound" style="z-index: -1;"></div>
        <img id="background" src="" />
        <div id="cholder">
            <canvas id="canvas"></canvas>
        </div>
        <!-- start: PAGE -->
        <div class="container">
            <div class="row">
                <!-- start: 404 -->
                <div class="col-sm-12 page-error">
                    <div class="error-number teal">
                        404
                    </div>
                    <div class="error-details col-sm-6 col-sm-offset-3">
                        <h3>Oops! You are stuck at 404</h3>
                        <p>
                            Unfortunately the page you were looking for could not be found.
                            <br>
                            It may be temporarily unavailable, moved or no longer exist.
                            <br>
                            Check the URL you entered for any mistakes and try again.
                            <br>
                            <a href="<?php echo ERROR_PAGE_RETURN_URL; ?> " class="btn btn-teal btn-return">
                                Return home
                            </a>
                            <!-- Change this link when uploading to server -->
                    </div>
                </div>
                <!-- end: 404 -->
            </div>
        </div>
        <!-- end: PAGE -->

    </body>
    <!-- end: BODY -->
</html>