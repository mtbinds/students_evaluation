<?php

function mo_ldap_show_licensing_page(){
	$active_tab = $_GET[ 'tab' ];
    echo '<style>.update-nag, .updated, .error, .is-dismissible, .notice, .notice-error { display: none; }</style>';
    ?>
    <style>
        *, *::after, *::before {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        html {
            font-size: 62.5%;
        }

        html * {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .pricing-container {
            font-size: 1.6rem;
            font-family: "Open Sans", sans-serif;
            color: #fff;
        }

        /* --------------------------------

        Main Components

        -------------------------------- */
        .cd-header{
            margin-top:100px;
        }
        .cd-header>h1{
            text-align: center;
            color: #FFFFFF;
            font-size: 3.2rem;
        }

        .cd-pricing-container {
            width: 90%;
            max-width: 1170px;
            margin: 4em auto;
        }
        @media only screen and (min-width: 768px) {
            .cd-pricing-container {
                margin: auto;
            }
            .cd-pricing-container.cd-full-width {
                width: 100%;
                max-width: none;
            }
        }

        .cd-pricing-switcher {
            text-align: center;
        }
        .cd-pricing-switcher .fieldset {
            display: inline-block;
            position: relative;
            border-radius: 50em;
            border: 1px solid #e97d68;
        }
        .cd-pricing-switcher input[type="radio"] {
            position: absolute;
            opacity: 0;
        }
        .cd-pricing-switcher label {
            position: relative;
            z-index: 1;
            display: inline-block;
            float: left;
            width: 155px;
            height: 40px;
            line-height: 40px;
            cursor: pointer;
            font-size: 1.4rem;
            color: #FFFFFF;
            font-size:18px;
        }

        .cd-pricing-switcher .cd-switch {
            /* floating background */
            position: absolute;
            top: 0px;
            left: 0px;
            height: 40px;
            width: 155px;
            background-color: black;
            border-radius: 50em;
            -webkit-transition: -webkit-transform 0.5s;
            -moz-transition: -moz-transform 0.5s;
            transition: transform 0.5s, transform 0.5s;
        }
        input#singlesite:checked ~ .cd-switch{
            transform: translate3d(0,0,0);
        }
        input#multisite:checked ~ .cd-switch {
            transform: translate3d(154px,0,0);
        }
        input#Add-ons:checked ~ .cd-switch {
           transform: translate3d(310px,0,0);
        }

        .no-js .cd-pricing-switcher {
            display: none;
        }

        .cd-pricing-list {
            margin: 2em 0 0;
        }
        .cd-pricing-list > li {
            position: relative;
            margin-bottom: 1em;
        }
        @media only screen and (min-width: 768px) {
            .cd-pricing-list {
                margin: 3em 0 0;
            }
            .cd-pricing-list:after {
                content: "";
                display: table;
                clear: both;
            }
            .cd-pricing-list > li {
                width: 25%;
                float: left;
            }
            .cd-has-margins .cd-pricing-list > li {
                width: 23.8%;
                float: left;
                margin-right: 1.5%;
            }
            .cd-has-margins .cd-pricing-list > li:last-of-type {
                margin-right: 0;
            }
        }

        .cd-pricing-wrapper {
            /* this is the item that rotates */
            overflow: show;
            position: relative;
        }



        .touch .cd-pricing-wrapper {
            /* fix a bug on IOS8 - rotating elements dissapear*/
            -webkit-perspective: 2000px;
            -moz-perspective: 2000px;
            perspective: 2000px;
        }
        .cd-pricing-wrapper.is-switched .is-visible {
            /* totate the tables - anticlockwise rotation */
            -webkit-transform: rotateY(180deg);
            -moz-transform: rotateY(180deg);
            -ms-transform: rotateY(180deg);
            -o-transform: rotateY(180deg);
            transform: rotateY(180deg);
            -webkit-animation: cd-rotate 0.5s;
            -moz-animation: cd-rotate 0.5s;
            animation: cd-rotate 0.5s;
        }
        .cd-pricing-wrapper.is-switched .is-hidden {
            /* totate the tables - anticlockwise rotation */
            -webkit-transform: rotateY(0);
            -moz-transform: rotateY(0);
            -ms-transform: rotateY(0);
            -o-transform: rotateY(0);
            transform: rotateY(0);
            -webkit-animation: cd-rotate-inverse 0.5s;
            -moz-animation: cd-rotate-inverse 0.5s;
            animation: cd-rotate-inverse 0.5s;
            opacity: 0;
        }
        .cd-pricing-wrapper.is-switched .is-hidden2 {
            /* totate the tables - anticlockwise rotation */
            -webkit-transform: rotateY(0);
            -moz-transform: rotateY(0);
            -ms-transform: rotateY(0);
            -o-transform: rotateY(0);
            transform: rotateY(0);
            -webkit-animation: cd-rotate-inverse 0.5s;
            -moz-animation: cd-rotate-inverse 0.5s;
            animation: cd-rotate-inverse 0.5s;
            opacity: 0;
        }
        .cd-pricing-wrapper.is-switched .is-selected {
            opacity: 1;
        }

        .cd-pricing-wrapper > li {
            background-color: #FFFFFF;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            /* Firefox bug - 3D CSS transform, jagged edges */
            outline: 1px solid transparent;
        }
        .cd-pricing-wrapper > li::after {
            /* subtle gradient layer on the right - to indicate it's possible to scroll */
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            height: 100%;
            width: 50px;
            pointer-events: none;
            background: -webkit-linear-gradient( right , #FFFFFF, rgba(255, 255, 255, 0));
            background: linear-gradient(to left, #FFFFFF, rgba(255, 255, 255, 0));
        }
        .cd-pricing-wrapper > li.is-ended::after {
            /* class added in jQuery - remove the gradient layer when it's no longer possible to scroll */
            display: none;
        }
        .cd-pricing-wrapper .is-visible {
            /* the front item, visible by default */
            position: relative;
            background-color: #f2f5f8;
        }
        .cd-pricing-wrapper .is-hidden {
            /* the hidden items, right behind the front one */
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            z-index: 1;
            -webkit-transform: rotateY(180deg);
            -moz-transform: rotateY(180deg);
            -ms-transform: rotateY(180deg);
            -o-transform: rotateY(180deg);
            transform: rotateY(180deg);
        }
        .cd-pricing-wrapper .is-hidden2 {
            /* the hidden items, right behind the front one */
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            z-index: 1;
            -webkit-transform: rotateY(180deg);
            -moz-transform: rotateY(180deg);
            -ms-transform: rotateY(180deg);
            -o-transform: rotateY(180deg);
            transform: rotateY(180deg);
        }
        .cd-pricing-wrapper .is-selected {
            /* the next item that will be visible */
            z-index: 3 !important;
        }
        @media only screen and (min-width: 768px) {
            .cd-pricing-wrapper > li::before {
                /* separator between pricing tables - visible when number of tables > 3 */
                content: '';
                position: absolute;
                z-index: 6;
                left: -1px;
                top: 50%;
                bottom: auto;
                -webkit-transform: translateY(-50%);
                -moz-transform: translateY(-50%);
                -ms-transform: translateY(-50%);
                -o-transform: translateY(-50%);
                transform: translateY(-50%);
                height: 50%;
                width: 1px;
                background-color: #b1d6e8;
            }
            .cd-pricing-wrapper > li::after {
                /* hide gradient layer */
                display: none;
            }
            .cd-popular .cd-pricing-wrapper > li {
                box-shadow: inset 0 0 0 15px #e97d68;
            }
            .cd-black .cd-pricing-wrapper > li {
                box-shadow: inset 0 0 0 3px #000000;
            }
            .cd-has-margins .cd-pricing-wrapper > li, .cd-has-margins .cd-popular .cd-pricing-wrapper > li {
                box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
            }
            .cd-secondary-theme .cd-pricing-wrapper > li {
                background: #3aa0d1;
                background: -webkit-linear-gradient( bottom , #3aa0d1, #3ad2d1);
                background: linear-gradient(to top, #3aa0d1, #3ad2d1);
            }
            .cd-secondary-theme .cd-popular .cd-pricing-wrapper > li {
                background: #e97d68;
                background: -webkit-linear-gradient( bottom , #e97d68, #e99b68);
                background: linear-gradient(to top, #e97d68, #e99b68);
                box-shadow: none;
            }
            :nth-of-type(1) > .cd-pricing-wrapper > li::before {
                /* hide table separator for the first table */
                display: none;
            }
            :nth-of-type(2) > .cd-pricing-wrapper > li::before {
                /* hide table separator for the first table */
                display: table-row;
            }
            .cd-has-margins .cd-pricing-wrapper > li {
                border-radius: 4px 4px 6px 6px;
            }
            .cd-has-margins .cd-pricing-wrapper > li::before {
                display: none;
            }
        }
        @media only screen and (min-width: 1500px) {
            .cd-full-width .cd-pricing-wrapper > li {
                padding: 2.5em 0;
            }
        }

        .no-js .cd-pricing-wrapper .is-hidden {
            position: relative;
            -webkit-transform: rotateY(0);
            -moz-transform: rotateY(0);
            -ms-transform: rotateY(0);
            -o-transform: rotateY(0);
            transform: rotateY(0);
            margin-top: 1em;
        }
        .no-js .cd-pricing-wrapper .is-hidden2 {
            position: relative;
            -webkit-transform: rotateY(0);
            -moz-transform: rotateY(0);
            -ms-transform: rotateY(0);
            -o-transform: rotateY(0);
            transform: rotateY(0);
            margin-top: 1em;
        }

        @media only screen and (min-width: 768px) {
            .cd-popular .cd-pricing-wrapper > li::before {
                /* hide table separator for .cd-popular table */
                display: none;
            }

            .cd-popular + li .cd-pricing-wrapper > li::before {
                /* hide table separator for tables following .cd-popular table */
                display: none;
            }
        }
        .cd-pricing-header {
            position: relative;

            height: 80px;
            padding: 1em;
            pointer-events: none;
            background-color: #3aa0d1;
            color: #FFFFFF;
        }
        .cd-pricing-header h2 {
            margin-bottom: 3px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .cd-popular .cd-pricing-header {
            background-color: #e97d68;
        }
        @media only screen and (min-width: 768px) {
            .cd-pricing-header {
                height: auto;
                padding: 1.9em 0.9em 1.6em;
                pointer-events: auto;
                text-align: center;
                color: #2f6062;
                background-color: transparent;
            }
            .cd-popular .cd-pricing-header {
                color: #e97d68;
                background-color: transparent;
            }
            .cd-secondary-theme .cd-pricing-header {
                color: #FFFFFF;
            }
            .cd-pricing-header h2 {
                font-size: 1.8rem;
                letter-spacing: 2px;
            }
        }

        .cd-popular .cd-duration {
            color: #f3b6ab;
        }


        @media only screen and (min-width: 768px) {
            .cd-value {
                font-size: 4rem;
                font-weight: 300;
            }

            .cd-contact {
                font-size: 3rem;

            }

            .cd-popular .cd-currency, .cd-popular .cd-duration {
                color: #e97d68;
            }
            .cd-secondary-theme .cd-currency, .cd-secondary-theme .cd-duration {
                color: #2e80a7;
            }
            .cd-secondary-theme .cd-popular .cd-currency, .cd-secondary-theme .cd-popular .cd-duration {
                color: #ba6453;
            }

        }
        .cd-pricing-body {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .is-switched .cd-pricing-body {
            /* fix a bug on Chrome Android */
            overflow: hidden;
        }
        @media only screen and (min-width: 768px) {
            .cd-pricing-body {
                overflow-x: visible;
            }
        }

        .cd-pricing-features {
            width: 600px;
        }
        .cd-pricing-features:after {
            content: "";
            display: table;
            clear: both;
        }
        .cd-pricing-features li {
            width: 100px;
            float: left;
            padding: 1.6em 1em;
            font-size: 1.4rem;
            text-align: center;
            white-space: initial;
            line-height:1.4em;

            text-overflow: ellipsis;
            color: black;
            overflow-wrap: break-word;
            margin: 0 !important;

        }
        .cd-pricing-features em {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: black;
        }
        @media only screen and (min-width: 768px) {
            .cd-pricing-features {
                width: auto;
                word-wrap: break-word;
            }
            .cd-pricing-features li {
                float: none;
                width: auto;
                padding: 1em;
                word-wrap: break-word;
            }
            .cd-popular .cd-pricing-features li {
                margin: 0 3px;
            }
            .cd-pricing-features li:nth-of-type(2n+1) {
                background-color: rgba(23, 61, 80, 0.06);
            }
            .cd-pricing-features em {
                display: inline-block;
                margin-bottom: 0;
                word-wrap: break-word;

            }
            .cd-has-margins .cd-popular .cd-pricing-features li, .cd-secondary-theme .cd-popular .cd-pricing-features li {
                margin: 0;
            }
            .cd-secondary-theme .cd-pricing-features li {
                color: #FFFFFF;
            }
            .cd-secondary-theme .cd-pricing-features li:nth-of-type(2n+1) {
                background-color: transparent;
            }
        }

        .cd-pricing-footer {
            position: absolute;
            z-index: 1;
            top: 0;
            left: 0;
            /* on mobile it covers the .cd-pricing-header */
            height: 80px;
            width: 100%;
        }
        .cd-pricing-footer::after {
            /* right arrow visible on mobile */
            content: '';
            position: absolute;
            right: 1em;
            top: 50%;
            bottom: auto;
            -webkit-transform: translateY(-50%);
            -moz-transform: translateY(-50%);
            -ms-transform: translateY(-50%);
            -o-transform: translateY(-50%);
            transform: translateY(-50%);
            height: 20px;
            width: 20px;
            background: url(../img/cd-icon-small-arrow.svg);
        }
        @media only screen and (min-width: 768px) {
            .cd-pricing-footer {
                position: relative;
                height: auto;

                text-align: center;
            }
            .cd-pricing-footer::after {
                /* hide arrow */
                display: none;
            }
            .cd-has-margins .cd-pricing-footer {
                padding-bottom: 0;
            }
        }

        .cd-select {
            position: relative;
            z-index: 1;
            display: block;
            height: 100%;
            /* hide button text on mobile */
            overflow: hidden;
            text-indent: 100%;
            white-space: nowrap;
            color: transparent;
        }
        @media only screen and (min-width: 768px) {
            .cd-select {
                position: static;
                display: inline-block;
                height: auto;
                padding: 1.3em 3em;
                color: #FFFFFF;
                border-radius: 2px;
                background-color: #0c1f28;
                font-size: 1.4rem;
                text-indent: 0;
                text-transform: uppercase;
                letter-spacing: 2px;
            }
            .no-touch .cd-select:hover {
                background-color: #112e3c;
            }
            .cd-popular .cd-select {
                background-color: #e97d68;
            }
            .no-touch .cd-popular .cd-select:hover {
                background-color: #ec907e;
            }
            .cd-secondary-theme .cd-popular .cd-select {
                background-color: #0c1f28;
            }
            .no-touch .cd-secondary-theme .cd-popular .cd-select:hover {
                background-color: #112e3c;
            }
            .cd-has-margins .cd-select {
                display: block;
                padding: 1.7em 0;
                border-radius: 0 0 4px 4px;
            }
        }
        /* --------------------------------

        xkeyframes

        -------------------------------- */


        .tab-content {
            margin-left: 0%!important;
            margin-top: 0%!important;

        }
        .tab-content>.active {
            width: 100% !important;
        }

        .tab-pane,.cd-pricing-container,.cd-pricing-switcher ,.cd-row,.cd-row>div{

        }


        .nav-pills>li{
            width:250px;
        }



        .nav-pills>li+li {
            margin-left: 0px;
        }

        .nav-pills>li.active>a, .nav-pills>li.active>a:hover, .nav-pills>li.active>a:focus,.nav-pills>li.active>a:active{
            color: #1e3334;
            background-color:white;
            height:47px;
        }

        .nav-pills>li>a:hover {
            color:#fff;
            background: #E97D68;
            height:46px;
        }

        .nav-pills>li>a:focus{
            color:#fff;
            background:grey;
            height:47px;

        }

        .nav-pills>li.active{
            background-color: #fff;
        }

        .nav-pills>li>a {
            border-radius: 0px;
            height:47px;
            border-color:#E85700;
            font-weight: 500;
            color: #d3f3d3;
            text-transform:uppercase;
        }


        .ui-slider .ui-slider-handle {
            position: absolute !important;
            z-index: 2 !important;
            width: 3.2em !important;
            height: 2.2em !important;
            cursor: default !important;
            margin: 0 -20px auto !important;
            text-align: center !important;
            line-height: 30px !important;
            color: #FFFFFF !important;
            font-size: 15px !important;
        }




        .ui-state-default,
        .ui-widget-content .ui-state-default {
            background: #393a40 !important;
        }
        .ui-slider .ui-slider-handle {width:2em;left:-.6em;text-decoration:none;text-align:center;}
        .ui-slider-horizontal .ui-slider-handle {
            margin-left: -0.5em !important;
        }

        .ui-slider .ui-slider-handle {
            cursor: pointer;
        }

        .ui-slider a,
        .ui-slider a:focus {
            cursor: pointer;
            outline: none;
        }

        .price, .lead p {
            font-weight: 600;
            font-size: 32px;
            display: inline-block;
            line-height: 60px;
        }



        .price-form label {
            font-weight: 200;
            font-size: 21px;
        }



        .ui-slider-horizontal .ui-slider-handle {
            top: -.6em !important;
        }
        /***********************ADDED BY SHAILESH************************/


        .pricing-tooltip .pricing-tooltiptext {
            visibility: hidden;
            background-color: black;
            line-height: 1.5em;
            font-size:12px;
            min-width: 300px;
            color: rgb(253, 252, 252);
            padding: 10px;
            border-radius: 6px;
            position: absolute;
            z-index: 5;
            text-align: center;
        }

        .pricing-tooltiptext .body{
            font-weight:100;
        }

        .pricing-tooltip:hover .pricing-tooltiptext {
            visibility: visible;
        }

        .cd-pricing-features>li>a{
            color:#E97D68;
        }


        .cd-row .col-md-4, .cd-row .col-md-6 {
            padding-left: 30px!important;
            font-size: 16px;
            padding: 4px;
        }

        .cd-row .col-md-6 {
            width: 60.33333333%;
        }



        .ribbon .ribbon-content:before, .ribbon .ribbon-content:after {
            content: "";
            position: absolute;
            display: block;
            border-style: solid;
            border-color: #804f7c transparent transparent transparent;
            bottom: -1em;
        }
        .ribbon .ribbon-content:before {
            left: 0;
            border-width: 0em 0 0 1em;
        }
        .ribbon .ribbon-content:after {
            right: 0;
            border-width: 0em 1em 0 0;
        }

        .cd-pricing-wrapper:hover .is-visible{
            -webkit-transform: scale(1);
            -ms-transform: scale(1);
            transform: scale(1);

        }
        /*.is-visible:hover {*/
            /*background: #cf4f3e;*/
        /*}*/

        .recommended .table-buy .pricing-action:hover {
            background: #228799;
        }



        .cd-popular :hover #singlesite_tab.is-visible{

            -webkit-transform: scale(1.03);
            -moz-transform: scale(1.03);
            transform: scale(1.03);
            -webkit-transition: all 0.3s;
            -moz-transition: all 0.3s;
            transition: all 0.3s;
            z-index:2;
        }
        .cd-black :hover #singlesite_tab.is-visible{
            -webkit-transform: scale(1.03);
            -moz-transform: scale(1.03);
            transform: scale(1.03);
            -webkit-transition: all 0.3s;
            -moz-transition: all 0.3s;
            transition: all 0.3s;
            z-index:2;
        }
        .cd-popular :hover #multisite_tab.is-visible{
            -webkit-transform: scale(1.03);
            -moz-transform: scale(1.03);
            transform: scale(1.03);
            -webkit-transition: all 0.3s;
            -moz-transition: all 0.3s;
            transition: all 0.3s;
            z-index:2;
        }
        .cd-black :hover #multisite_tab.is-visible{
            -webkit-transform: scale(1.03);
            -moz-transform: scale(1.03);
            transform: scale(1.03);
            -webkit-transition: all 0.3s;
            -moz-transition: all 0.3s;
            transition: all 0.3s;
            z-index:2;
        }


   </style>
    <div style="text-align: center; font-size: 14px; color: white; padding-top: 4px; padding-bottom: 4px; border-radius: 16px;"></div>
    <input type="hidden" id="mo_license_plan_selected" value="licensing_plan" />
    <div class="tab-content">
        <div class="tab-pane active text-center" id="cloud">
            <div class="cd-pricing-container cd-has-margins"><br>
                <h1 style="font-size: 32px ; text-align:center;">Choose Your Licensing Plan</h1>
                <h4 style="font-size: 20px ; text-align:center;color: red">Are you not able to choose your plan? <a href="<?php echo add_query_arg( array( 'tab' => 'feature_request' ), htmlentities( $_SERVER['REQUEST_URI'] ) ); ?>">(Contact Us)</a></h4>
                <br>
                <div class="cd-pricing-switcher">
                    <p class="fieldset" style="background-color: #e97d68;">
                         <?php if(isset($active_tab) && $active_tab == 'add_on'){?>
                            <input type="radio" name="sitetype" value="singlesite" id="singlesite">
                            <label for="singlesite">Single Site</label>
                            <input type="radio" name="sitetype" value="multisite" id="multisite">
                            <label for="multisite">Multisite Network</label>
                            <input type="radio" name="sitetype" value="Add-ons" id="Add-ons" checked>
                            <label for="Add-ons">Add-Ons</label>
                            <span class="cd-switch"></span>
                        <?php }else {?>
                        <input type="radio" name="sitetype" value="singlesite" id="singlesite" checked>
                        <label for="singlesite">Single Site</label>
                        <input type="radio" name="sitetype" value="multisite" id="multisite">
                        <label for="multisite">Multisite Network</label>
                        <input type="radio" name="sitetype" value="Add-ons" id="Add-ons">
                        <label for="Add-ons">Add-Ons</label>
                        <span class="cd-switch"></span><?php }?>
                    </p>
                </div>

                <script>


                    jQuery(document).ready(function(){
                        jQuery("#popover").popover({ trigger: "hover" });
                        jQuery("#popover1").popover({ trigger: "hover" });
                        jQuery("#popover2").popover({ trigger: "hover" });
                        jQuery("#popover3").popover({ trigger: "hover" });
                        jQuery("#popover4").popover({ trigger: "hover" });
                        jQuery("#popover5").popover({ trigger: "hover" });
                        jQuery("#popoverfree").popover({ trigger: "focus" });

                    });

                </script>
                <!-- .cd-pricing-switcher -->

                <input type="hidden" value="<?php echo Mo_Ldap_Local_Util::is_customer_registered()?>" id="mo_customer_registered">
                <ul class="cd-pricing-list cd-bounce-invert" >
                    <li class="cd-popular">

                        <ul class="cd-pricing-wrapper"  style="height: 500px";>

                            <li id="singlesite_tab" data-type="singlesite" class="mosslp is-visible cd-singlesite" style="border: <?php echo $sssborder; ?> ">
                                <header class="cd-pricing-header" style="height: 230px">

                                        <h2 style="margin-bottom: 10px" >Free<span style="font-size:0.5em"></span></h2>
                                        <h3 style="color:black;"><br /><br /></h3>
                                        <div class="cd-price">
                                            <b style="font-size: large">You are automatically on this plan</b>
                                        </div><br><br>

                                    </header> <!-- .cd-pricing-header -->
                                </a>
                                <footer class="cd-pricing-footer">
                                    <a class="cd-select">Active Plan</a>
                                </footer><br>
<!--                                <b style="color: coral;">See the free Plugin features list below</b>-->
                                <div class="cd-pricing-body">
                                    <ul class="cd-pricing-features">
                                        <li style="font-size: medium">Unlimited Authentications</li>
                                        <li style="font-size: medium">User Auto Registration</li>
                                        <li style="font-size: medium">No Role Mapping</li>
                                        <li style="font-size: medium">Single LDAP Directory Configuration</li>
                                        <li style="font-size: medium">Search User by Single Username Attribute <br></li>
                                        <li style="font-size: medium">Single Search Base</li>
                                        <li style="font-size: medium">Username Mapping</li>
                                        <!--                                        <li style="background: black; color: #FFFFFF; padding: 4px 7px; ">Additional Features</li>-->
                                        <li style="font-size: medium"><br></li>
                                        <li style="font-size: medium"><br><br></li>
                                        <li style="font-size: medium"><br><br></li>
                                        <li style="font-size: medium"><br><br><br></li>

                                    </ul>
                                </div> <!-- .cd-pricing-body -->
                            </li>

                            <li id="multisite_tab" data-type="multisite" class="momslp is-hidden" style="border: <?php echo $mspborder; ?>">
                                <header class="cd-pricing-header" style="height: 282px">

                                        <h2 style="margin-bottom: 10px" >Free<span style="font-size:0.5em"></span></h2>
                                        <h3 style="color:black;"><br><br /><br /><br /></h3>
                                        <div class="cd-price" >
                                            <b style="font-size: large">You are automatically on this plan</b>

                                        </div><br><br><br><br>

                                    </header>
                                </a>
                                <!-- .cd-pricing-header -->
                                <footer class="cd-pricing-footer">
                                    <a class="cd-select">Active Plan</a>
                                </footer><br>
<!--                                <b style="color: coral;">See the Multisite Premium Plugin features list below</b>-->
                                <div class="cd-pricing-body">

                                    <ul class="cd-pricing-features">
                                        <li style="font-size: medium">Unlimited Authentications</li>
                                        <li style="font-size: medium">User Auto Registration</li>
                                        <li style="font-size: medium">No Role Mapping</li>
                                        <li style="font-size: medium">Single LDAP Directory Configuration</li>
                                        <li style="font-size: medium">Search User by Single Username Attribute <br></li>
                                        <li style="font-size: medium">Single Search Base</li>
                                        <li style="font-size: medium">Username Mapping</li>
                                        <!--                                        <li style="background: black; color: #FFFFFF; padding: 4px 7px; ">Additional Features</li>-->
                                        <li style="font-size: medium"><br></li>
                                        <li style="font-size: medium"><br><br></li>
                                        <li style="font-size: medium"><br><br></li>
                                        <li style="font-size: medium"><br><br><br></li>

                                    </ul>
                                </div> <!-- .cd-pricing-body -->
                            </li>
                            <li id="add-on_tab" data-type="Add-ons" class="momslp1 is-hidden2 noHover" style=" border: <?php echo $mspborder; ?>; width: 250%">
                                <div class="is-add-on">
                                    <header class="cd-pricing-header" style="height: 130px">

                                        <h2 style="margin-bottom: 10px" >Add-Ons</h2>
                                        <h3 style="text-align: center;">(Supported only with <b style="color:red">Advanced Role Mapping</b> and <b style="color: red">Multiple LDAP Directories</b> Plans)</h3>
                                        <h4 style="text-align: center; color: red">(Add-Ons need to be purchased separately)</h4>

                                    </header><br>
                                    <!--                                <b style="color: coral;">See the Multisite Premium Plugin features list below</b>-->
                                    <div class="cd-pricing-body">

                                        <ul class="cd-pricing-features">
                                            <li style="height: 135px"><h3>1.Auto-Login domain accounts using Kerberos/NTLM SSO -</h3>
                                                <p>Allow auto-login into WordPress website if accessed from within the domain. </p>
                                            </li>
                                            <li><h3>2.Directory Sync Add-on -</h3>
                                                <p>Wordpress users will be synced with LDAP and vice versa. Schedules can be configured for the sync to run at a specific time and after a specific interval.</p>
                                            </li>
                                            <li style="height: 135px"><h3>3.Sync BuddyPress Groups Add-on -</h3>
                                                <p>Assign BuddyPress groups to users based on group membership in LDAP. This is available after separate purchase.</p>
                                            </li>
                                            <li style="height: 135px"><h3>4.LDAP Search Widget Add-on -</h3>
                                                <p>You can search your directory users on your website. These are available after separate purchase.<br>Please contact us if you want this functionality.</p></li>
                                            <li style="height: 135px"><h3>5.BuddyPress Extended Profiles Add-on -</h3>
                                                <p>Integration with BuddyPress to sync extended profile of users with LDAP attributes upon login.<br>Please contact us if you want this functionality.</p>
                                            </li>


                                            <li style="height: 135px"><h3>6.Gravity Forms Integration -</h3>
                                                <p>Populate Gravity Form fields with information from LDAP. This is available after separate purchase. Please contact us if you want this functionality.
                                                </p>
                                            </li>
                                            <li style="height: 135px"><h3>7.eMember Add-on -</h3>
                                                <p>Login to eMember profiles with LDAP Credentials. This is available after separate purchase.<br> Please contact us if you want this functionality.</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>

                        </ul> <!-- .cd-pricing-wrapper -->
                    </li>
                    <li class="cd-black">

                        <ul class="cd-pricing-wrapper">

                            <li id="singlesite_tab" data-type="singlesite" class="mosslp is-visible" style="border: <?php echo $sssborder; ?> height=600px; ">
                                <header class="cd-pricing-header" style="height: 230px">

                                    <h2 style="margin-bottom: 10px" >Custom Attribute Mapping<br/><br/><br></h2>
                                        <div class="cd-price" >
                                            <span id="basic_total_price" style="font-weight: bolder;font-size: xx-large"> $99</span><br>
                                            <span id="basic_total_price1" style="font-weight: bolder;font-size: large"> (One Time Payment)</span>
                                        </div><br>
                                        <div id="Basic_no_of_instances_drop_down_div" name="Basic_no_of_instances_drop_down_div">
                                            <select style="width: 90%;" id="basic_no_of_instances_drop_down" name="basic_no_of_instances_drop_down">
                                                <option value="1">1 instance </option>
                                                <option value="2">2 instances</option>
                                                <option value="3">3 instances</option>
                                                <option value="4">4 instances</option>
                                                <option value="5">5 instances</option>
                                                <option value="6" >6 instances</option>
                                                <option value="7" >7 instances</option>
                                                <option value="8">8 instances</option>
                                                <option value="9">9 instances</option>
                                                <option value="10">10 instances</option>
                                                <option value="15">15 instances</option>
                                                <option value="20">20 instances</option>
                                                <option value="30">30 instances</option>
                                                <option value="40">40 instances</option>
                                                <option value="50">50 instances</option>
                                                <option value="100">100 instances</option>
                                                <option value="500">unlimited instances</option>
                                            </select>
                                        </div>

                                    </header> <!-- .cd-pricing-header -->
                                </a>
                                <footer class="cd-pricing-footer">
                                    <a href="#" class="cd-select" onclick="upgradeform('wp_ldap_intranet_custom_attribute_mapping_plan')" >Upgrade Now</a>
                                </footer><br>
<!--                                <b style="color: coral;">See the Standard Plugin features list below</b>-->
                                <div class="cd-pricing-body">
                                    <ul class="cd-pricing-features">
                                        <li style="font-size: medium">Unlimited Authentications</li>
                                        <li style="font-size: medium">User Auto Registration</li>
                                        <li style="font-size: medium">Default Role Mapping</li>
                                        <li style="font-size: medium">Single LDAP Directory configuration</li>
                                        <li style="font-size: medium">Search User by Multiple Username Attributes</li>
                                        <li style="font-size: medium">Single Search Base</li>
                                        <li style="font-size: medium">Custom attribute Mapping</li>
                                        <li style="font-size: medium"> TLS connection<br></li>
                                        <!--                                        <li style="background: #e97d68; color: #FFFFFF; padding: 4px 7px; ">Additional Features</li>-->
                                        <li style="font-size: medium"><br><br/></li>
                                        <li style="font-size: medium"><br><br></li>
                                        <li style="font-size: medium"><br><br><br></li>
                                         </ul>

                                </div> <!-- .cd-pricing-body -->
                            </li>
                            <li id="multisite_tab" data-type="multisite" class="momslp is-hidden" style="border: <?php echo $mspborder; ?>">
                                 <header class="cd-pricing-header" style="height: 282px">

                                     <h2 style="margin-bottom: 10px" >Custom Attribute Mapping<br/><br/><br></h2>
                                        <div class="cd-price" >
                                            <span id="multisite_basic_total_price" style="font-weight: bolder;font-size: xx-large">$99</span><br/>
                                            <span id="multisite_basic_total_price1" style="font-weight: bolder;font-size: large">(One Time Payment)</span>
<!---->
<!--                                            <span class="cd-currency">$</span>-->
<!--                                            <span class="cd-value">99*</span></span>-->

                                        </div><br>
										<div id="multisite_basic_no_of_instances_drop_down_div" name="multisite_basic_no_of_instances_drop_down_div">
<!--                                         <h3 style="margin-bottom: 10px" > For 1 instance<br/></h3>-->
                                            <select style="width: 90%;" id="multisite_basic_no_of_instances_drop_down" name="multisite_basic_no_of_instances_drop_down">
                                                <option value="1">1 instance </option>
                                                <option value="2">2 instances</option>
                                                <option value="3">3 instances</option>
                                                <option value="4">4 instances</option>
                                                <option value="5">5 instances</option>
                                                <option value="6">6 instances</option>
                                                <option value="7">7 instances</option>
                                                <option value="8">8 instances</option>
                                                <option value="9">9 instances</option>
                                                <option value="10">10 instances</option>
                                                <option value="15">15 instances</option>
                                                <option value="20">20 instances</option>
                                                <option value="30">30 instances</option>
                                                <option value="40">40 instances</option>
                                                <option value="50">50 instances</option>
                                                <option value="100">100 instances</option>
                                                <option value="500">unlimited instances</option>
                                            </select>

                                        </div>
                                        <br/>
                                        <div id="multisite_basic_number_of_subsites_dropdown_div" name="standard_no_of_instances_drop_down_div">
                                            <select style="width: 90%" id="standard_number_of_subsites_dropdown" name="standard_number_of_subsites_dropdown">
                                                <option>Number of Subsites</option>
                                                <option value="3">$45 - Upto 3 Subsites / Instance</option>
                                                <option value="5">$60 - Upto 5 Subsites / Instance</option>
                                                <option value="10">$120 - Upto 10 Subsites / Instance</option>
                                                <option value="15">$160 - Upto 15 Subsites / Instance</option>
                                                <option value="20">$200 - Upto 20 Subsites / Instance</option>
                                                <option value="30">$240 - Upto 30 Subsites / Instance</option>
                                                <option value="40">$280 - Upto 40 Subsites / Instance</option>
                                                <option value="50">$320 - Upto 50 Subsites / Instance</option>
                                                <option value="100">$360 - Upto 100 Subsites / Instance</option>
                                                <option value="200">$400 - Upto 200 Subsites / Instance</option>
                                                <option value="300">$440 - Upto 300 Subsites / Instance</option>
                                                <option value="400">$480 - Upto 400 Subsites / Instance</option>
                                                <option value="500">$520 - Upto 500 Subsites / Instance</option>
                                                <option value="1000">$999 - Unlimited Subsites / Instance</option>
                                            </select>
                                        </div>

                                    </header>
                                </a>
                                <!-- .cd-pricing-header -->
                                <footer class="cd-pricing-footer">
                                    <a href="#" class="cd-select" onclick="upgradeform('wp_ldap_intranet_custom_attribute_mapping_multisite_plan')" >Upgrade Now</a>
                                </footer><br>
<!--                                <b style="color: coral;">See the Multisite Premium Plugin features list below</b>-->
                                <div class="cd-pricing-body">

                                    <ul class="cd-pricing-features">
                                        <li style="font-size: medium">Unlimited Authentications</li>
                                        <li style="font-size: medium">User Auto Registration</li>
                                        <li style="font-size: medium">Default Role Mapping</li>
                                        <li style="font-size: medium">Single LDAP Directory configuration</li>
                                        <li style="font-size: medium">Search User by Multiple Username Attributes</li>
                                        <li style="font-size: medium">Single Search Base</li>
                                        <li style="font-size: medium">Custom attribute Mapping</li>
                                        <li style="font-size: medium"> TLS connection<br></li>
                                        <!--                                        <li style="background: #e97d68; color: #FFFFFF; padding: 4px 7px; ">Additional Features</li>-->
                                        <li style="font-size: medium"><br><br/></li>
                                        <li style="font-size: medium"><br><br></li>
                                        <li style="font-size: medium"><br><br><br></li>

                                    </ul>

                                </div> <!-- .cd-pricing-body -->
                            </li>
                            <li data-tyoe="Add-ons" class="momslp1 is-hidden2" style="border: <?php echo $mspborder; ?>; width: 80%; left: 150%">
                                <header class="cd-pricing-header" style="height: 130px">

                                    <h2 style="margin-bottom: 10px" >Price</h2>

                                </header><br>
                                <!--                                <b style="color: coral;">See the Multisite Premium Plugin features list below</b>-->
                                <div class="cd-pricing-body">

                                    <ul class="cd-pricing-features">
                                        <li style="height: 135px"><br><h3>$99</h3><br><p> </p></li>
                                        <li style="lenght= 200px"><br><h3>$99</h3><br><p> </p></li>
                                        <li style="height: 135px"><br><br><h3>$99</h3><p> </p></li>
                                        <li style="height: 135px"><br><h3>$99</h3><br><p> </p></li>
                                        <li style="height: 135px"><br><h3>$99</h3><br><p> </p></li>
                                        <li style="height: 135px"><br><h3>$99</h3><br><p> </p></li>
                                        <li style="height: 135px"><br><h3>$99</h3><p> </p></li>

                                    </ul>
                                </div>
                            </li>

                        </ul> <!-- .cd-pricing-wrapper -->
                    </li>

                    <li class="cd-popular">
                        <ul class="cd-pricing-wrapper">
                            <li id="singlesite_tab" data-type="singlesite" class="mosslp is-visible" style="border: <?php echo $sspborder; ?>">
                                <header class="cd-pricing-header" style="height: 230px">
                                        <h2 style="margin-bottom: 10px">Advanced Role Mapping<br/><br/></h2>
                                        <div class="cd-price" ><br>
                                            <span id="plus_total_price" style="font-weight: bolder;font-size: xx-large">$179</span><br/>
                                            <span id="plus_total_price1" style="font-weight: bolder;font-size: large">(One Time Payment)</span>
<!--                                            <span class="cd-currency">$</span>-->
<!--                                            <span class="cd-value">179*</span>-->

                                        </div><br>
                                        <div id="plus_no_of_instances_drop_down_div" name="plus_no_of_instances_drop_down_div">
<!--                                            <h3 style="margin-bottom: 10px" > For 1 instance<br/></h3>-->
                                            <select style="width: 90%;" id="plus_no_of_instances_drop_down" name="plus_no_of_instances_drop_down">
                                                <option value="1">1 instance </option>
                                                <option value="2" >2 instances</option>
                                                <option value="3" >3 instances</option>
                                                <option value="4" >4 instances</option>
                                                <option value="5" >5 instances</option>
                                                <option value="6" >6 instances</option>
                                                <option value="7" >7 instances</option>
                                                <option value="8" >8 instances</option>
                                                <option value="9" >9 instances</option>
                                                <option value="10">10 instances</option>
                                                <option value="15">15 instances</option>
                                                <option value="20">20 instances</option>
                                                <option value="30">30 instances</option>
                                                <option value="40">40 instances</option>
                                                <option value="50">50 instances</option>
                                                <option value="100">100 instances</option>
                                                <option value="500">unlimited instances</option>
                                            </select>
                                  </div>
                                    </header> <!-- .cd-pricing-header -->
                                </a>
                                <footer class="cd-pricing-footer">
                                    <a href="#" class="cd-select" onclick="upgradeform('wp_ldap_intranet_premium_plan')" >Upgrade Now</a>
                                </footer><br>
<!--                                <b>See the Premium Plugin features list below</b>-->
                                <div class="cd-pricing-body">
                                    <ul class="cd-pricing-features">
                                        <li style="font-size: medium">Unlimited Authentications</li>
                                        <li style="font-size: medium">User Auto Registration</li>
                                        <li style="font-size: medium">Advanced Role Mapping</li>
                                        <li style="font-size: medium">Single LDAP Directory configuration</li>
                                        <li style="font-size: medium">Custom Search Filter with Group Restriction</li>
                                        <li style="font-size: medium">Multiple Search Bases</li>
                                        <!--                                        <li style="background: black; color: #FFFFFF; padding: 4px 7px; ">Additional Features</li>-->
                                        <li style="font-size: medium">Custom Attribute Mapping</li>
                                        <li style="font-size: medium"> TLS connection<br></li>
                                        <!--                                        <li style="background: #e97d68; color: #FFFFFF; padding: 4px 7px; ">Additional Features</li>-->
                                        <li style="font-size: medium">WP to LDAP updates of user profile<br></li>
                                        <li style="font-size: medium">Support for customization/integration</li>
                                        <li style="font-size: medium">Add-on Supported<br>(Separate Purchase)<br><br></li>
                                        <!--                                        <li style="background: black; color: #FFFFFF; padding: 4px 7px; ">Additional Features</li>-->


                                    </ul>
                                </div> <!-- .cd-pricing-body -->
                            </li>
                            <li id="multisite_tab" data-type="multisite" class="momslp is-hidden" style="border: <?php echo $mseborder; ?>">
                               
                                    <header class="cd-pricing-header" style="height: 282px">

                                        <h2 style="margin-bottom: 10px">Advanced Role Mapping<br/><br/></h2>
                                     <div class="cd-price" >
                                        <div class="cd-price" ><br>
                                            <span id="multisite_plus_total_price" style="font-weight: bolder;font-size: xx-large">$179</span><br/>
                                            <span id="multisite_plus_total_price1" style="font-weight: bolder;font-size: large">(One Time Payment)</span>
<!---->
<!--                                            <span class="cd-currency">$</span>-->
<!--                                            <span class="cd-value">179*</span>-->

                                        </div><br>
                                        <div id="multisite_plus_no_of_instances_drop_down_div" name="multisite_plus_no_of_instances_drop_down_div">
<!--                                            <h3 style="margin-bottom: 10px" > For 1 instance<br/></h3>-->
                                            <select style="width: 90%;" id="multisite_plus_no_of_instances_drop_down" name="multisite_plus_no_of_instances_drop_down">
                                                <option value="1">1 instance </option>
                                                <option value="2">2 instances</option>
                                                <option value="3">3 instances</option>
                                                <option value="4">4 instances</option>
                                                <option value="5">5 instances</option>
                                                <option value="6">6 instances</option>
                                                <option value="7">7 instances</option>
                                                <option value="8">8 instances</option>
                                                <option value="9">9 instances</option>
                                                <option value="10">10 instances</option>
												<option value="15">15 instances</option>
                                                <option value="20">20 instances</option>
                                                <option value="30">30 instances</option>
                                                <option value="40">40 instances</option>
                                                <option value="50">50 instances</option>
                                                <option value="100">100 instances</option>
                                                <option value="500">unlimited instances</option>
                                            </select>

                                        </div>
                                        <br/>
                                        <div id="multisite_plus_number_of_subsites_dropdown_div" name="multisite_plus_number_of_subsites_dropdown_div">
                                            <select style="width: 90%" id="multisite_plus_number_of_subsites_dropdown" name="multisite_plus_number_of_subsites_dropdown">
                                                <option>Number of Subsites</option>
                                                <option value="3">$45 - Upto 3 Subsites / Instance</option>
                                                <option value="5">$60 - Upto 5 Subsites / Instance</option>
                                                <option value="10">$120 - Upto 10 Subsites / Instance</option>
                                                <option value="15">$160 - Upto 15 Subsites / Instance</option>
                                                <option value="20">$200 - Upto 20 Subsites / Instance</option>
                                                <option value="30">$240 - Upto 30 Subsites / Instance</option>
                                                <option value="40">$280 - Upto 40 Subsites / Instance</option>
                                                <option value="50">$320 - Upto 50 Subsites / Instance</option>
                                                <option value="100">$360 - Upto 100 Subsites / Instance</option>
                                                <option value="200">$400 - Upto 200 Subsites / Instance</option>
                                                <option value="300">$440 - Upto 300 Subsites / Instance</option>
                                                <option value="400">$480 - Upto 400 Subsites / Instance</option>
                                                <option value="500">$520 - Upto 500 Subsites / Instance</option>
                                                <option value="1000">$999 - Unlimited Subsites / Instance</option>
                                            </select>
                                        </div>


                                    </header> <!-- .cd-pricing-header -->
                                </a>
                                <footer class="cd-pricing-footer">
                                    <a href="#" class="cd-select" onclick="upgradeform('wp_ldap_intranet_multisite_premium_plan')" >Upgrade Now</a>
                                </footer><br>
<!--                                <b>See the Multisite Enterprise Plugin features list below</b>-->
                                <div class="cd-pricing-body">
                                    <ul class="cd-pricing-features">
                                        <li style="font-size: medium">Unlimited Authentications</li>
                                        <li style="font-size: medium">User Auto Registration</li>
                                        <li style="font-size: medium">Advanced Role Mapping</li>
                                        <li style="font-size: medium">Single LDAP Directory configuration</li>
                                        <li style="font-size: medium">Custom Search Filter with Group Restriction</li>
                                        <li style="font-size: medium">Multiple Search Bases</li>
                                        <!--                                        <li style="background: black; color: #FFFFFF; padding: 4px 7px; ">Additional Features</li>-->
                                        <li style="font-size: medium">Custom Attribute Mapping</li>
                                        <li style="font-size: medium"> TLS connection<br></li>
                                        <!--                                        <li style="background: #e97d68; color: #FFFFFF; padding: 4px 7px; ">Additional Features</li>-->
                                        <li style="font-size: medium">WP to LDAP updates of user profile<br></li>
                                        <li style="font-size: medium">Support for customization/integration</li>
                                        <li style="font-size: medium">Add-on Supported<br>(Separate Purchase)<br><br></li>
                                        <!--                                        <li style="background: black; color: #FFFFFF; padding: 4px 7px; ">Additional Features</li>-->

                                    </ul>
                                </div> <!-- .cd-pricing-body -->
                            </li>
                            <li data-tyoe="Add-ons" class="momslp1 is-hidden2" style="border: <?php echo $mspborder; ?>; width: 80%; left: 130%">
                                <header class="cd-pricing-header" style="height: 130px">

                                    <h2 style="margin-bottom: 10px" >Buy</h2>

                                </header><br>
                                <!--                                <b style="color: coral;">See the Multisite Premium Plugin features list below</b>-->
                                <div class="cd-pricing-body">

                                    <ul class="cd-pricing-features">
                                        <li style="height: 135px"><br><br><a target="_blank" href="https://auth.miniorange.com/moas/login?redirectUrl=https://auth.miniorange.com/moas/initializepayment&requestOrigin=wp_ntlm_sso_plan">Buy</a><br><br><br><br></li>
                                        <li><br><p> </p><a target="_blank" href="https://auth.miniorange.com/moas/login?redirectUrl=https://auth.miniorange.com/moas/initializepayment&requestOrigin=wp_directory_sync_plan">Buy</a><br><br><br><br></li>
                                        <li style="height: 135px"><br><br><a target="_blank" href="https://auth.miniorange.com/moas/login?redirectUrl=https://auth.miniorange.com/moas/initializepayment&requestOrigin=wp_ldap_intranet_buddypress_extended_profiles_plan">Buy</a><br><br><br></li>
                                        <li style="height: 135px"><br><br><a target="_blank" href="https://www.miniorange.com/contact">Contact Us</a><br><br><br><p> </p></li>
                                        <li style="height: 135px"><br><br><a target="_blank" href="https://www.miniorange.com/contact">Contact Us</a><br><br><br><p> </p></li>
                                        <li style="height: 135px"><br><br><a target="_blank" href="https://www.miniorange.com/contact">Contact Us</a><br><br><br></li>
                                        <li style="height: 135px"><br><br><a target="_blank" href="https://www.miniorange.com/contact">Contact Us</a><br><br></li>

                                    </ul>
                                </div>
                            </li>

                        </ul> <!-- .cd-pricing-wrapper -->
                    </li>

                    <li class="cd-black">
                        <ul class="cd-pricing-wrapper">
                            <li id="singlesite_tab" data-type="singlesite" class="mosslp is-visible" style="border: <?php echo $sseborder; ?>">
                                 <header class="cd-pricing-header" style="height: 230px">
                                        <h2 style="margin-bottom:10px;">Multiple LDAP directories<br/><br/></h2>
                                        <div class="cd-price" ><br>
                                            <span id="pro_total_price" style="font-weight: bolder;font-size: xx-large">$249</span><br/>
                                            <span id="pro_total_price1" style="font-weight: bolder;font-size: large">(One Time Payment)</span>


<!--                                            <span class="cd-currency">$</span>-->
<!--                                            <span class="cd-value">499*</span></span>-->

                                        </div><br>
                                        <div id="pro_no_of_instances_drop_down_div" name="pro_no_of_instances_drop_down_div">
<!--                                            <h3 style="margin-bottom: 10px" > For 1 instance<br/><br/><br></h3>-->
                                            <select style="width: 90%;" id="pro_no_of_instances_drop_down" name="pro_no_of_instances_drop_down">
                                                <option value="1">1 instance </option>
                                                <option value="2">2 instances</option>
                                                <option value="3">3 instances</option>
                                                <option value="4">4 instances</option>
                                                <option value="5">5 instances</option>
                                                <option value="6">6 instances</option>
                                                <option value="7">7 instances</option>
                                                <option value="8">8 instances</option>
                                                <option value="9">9 instances</option>
                                                <option value="10">10 instances</option>
                                                <option value="15">15 instances</option>
                                                <option value="20">20 instances</option>
                                                <option value="30">30 instances</option>
                                                <option value="40">40 instances</option>
                                                <option value="50">50 instances</option>
                                                <option value="100">100 instances</option>
                                                <option value="500" >unlimited instances</option>
                                            </select>

                                        </div>
                                    </header> <!-- .cd-pricing-header -->
                                <footer class="cd-pricing-footer">
                                    <a class="cd-select" href="#" onclick="upgradeform('wp_ldap_intranet_multiple_ldap_directories_plan')">Upgrade now</a>
                                </footer><br>
<!--                                <b style="color: coral;">See the Enterprise Plugin features list below</b>-->
                                <div class="cd-pricing-body">
                                    <ul class="cd-pricing-features">
                                        <li style="font-size: medium">Unlimited Authentications</li>
                                        <li style="font-size: medium">User Auto Registration</li>
                                        <li style="font-size: medium">Advanced Role Mapping</li>
                                        <li style="font-size: medium">Multiple LDAP Directories Configuration</li>
                                        <li style="font-size: medium">Custom Search Filter with Group Restriction<br></li>
                                        <li style="font-size: medium">Multiple Search Bases</li>
                                        <!--                                        <li style="background: black; color: #FFFFFF; padding: 4px 7px; ">Additional Features</li>-->
                                        <li style="font-size: medium">Custom Attribute Mapping</li>
                                        <li style="font-size: medium"> TLS connection<br></li>
                                        <!--                                        <li style="background: #e97d68; color: #FFFFFF; padding: 4px 7px; ">Additional Features</li>-->
                                        <li style="font-size: medium">WP to LDAP updates of user profile<br></li>
                                        <li style="font-size: medium">Support for customization/integration)</li>
                                        <li style="font-size: medium">Add-on Supported<br>(One free add-on of customer's choice(save $29))</li>
<!--                                        <li style="background: black; color: #FFFFFF; padding: 4px 7px; ">Additional Features</li>-->

                                        </ul>
                                </div> <!-- .cd-pricing-body -->

                            </li>

                            <li id="multisite_tab"  data-type="multisite" class="momslp is-hidden" style="border: <?php echo $msbborder; ?>">
                                <a id="popover5" data-toggle="popover" title="<h3>Why should I choose this plan?</h3>" data-placement="top" data-html="true"
                                   data-content="<p>We are Single Sign-On experts. Talk to us for your Single Sign-On requirement. Our technical lead will contact you and will help you in designing the SSO architecture for you.</p>">
                                    <header class="cd-pricing-header" style="height: 282px">
                                        <h2 style="margin-bottom:10px;">Multiple LDAP directories<br/><br/></h2>
                                        <div class="cd-price" ><br>
                                            <span id="multiple_pro_total_price" style="font-weight: bolder;font-size: xx-large">$249</span><br/>
                                            <span id="multiple_pro_total_price" style="font-weight: bolder;font-size: large">(One Time Payment)</span>


<!--                                            <span class="cd-currency">$</span>-->
<!--                                            <span class="cd-value">249</span>-->

                                        </div><br>
                                        <div id="pro_multiple_no_of_instances_drop_down_div" name="pro_multiple_no_of_instances_drop_down_div">
<!--                                            <h3 style="margin-bottom: 10px" > For 1 instance<br/></h3>-->
                                            <select style="width: 90%;" id="pro_multiple_no_of_instances_drop_down" name="pro_multiple_no_of_instances_drop_down">
                                                <option value="1">1 instance </option>
                                                <option value="2">2 instances</option>
                                                <option value="3">3 instances</option>
                                                <option value="4">4 instances</option>
                                                <option value="5">5 instances</option>
                                                <option value="6">6 instances</option>
                                                <option value="7">7 instances</option>
                                                <option value="8">8 instances</option>
                                                <option value="9">9 instances</option>
                                                <option value="10">10 instances</option>
                                                <option value="15">15 instances</option>
                                                <option value="20">20 instances</option>
                                                <option value="30">30 instances</option>
                                                <option value="40">40 instances</option>
                                                <option value="50">50 instances</option>
                                                <option value="100">100 instances</option>
                                                <option value="500">unlimited instances</option>
                                            </select>

                                        </div>
                                        <br/>
                                        <div id="pro_multiple_number_of_subsites_dropdown_div" name="pro_multiple_no_of_instances_drop_down_div">
                                            <select style="width: 90%" id="pro_multiple_number_of_subsites_dropdown" name="pro_multiple_number_of_subsites_dropdown">
												<option>Number of Subsites</option>
                                                <option value="3">$45 - Upto 3 Subsites / Instance</option>
                                                <option value="5">$60 - Upto 5 Subsites / Instance</option>
                                                <option value="10">$120 - Upto 10 Subsites / Instance</option>
                                                <option value="15">$160 - Upto 15 Subsites / Instance</option>
                                                <option value="20">$200 - Upto 20 Subsites / Instance</option>
                                                <option value="30">$240 - Upto 30 Subsites / Instance</option>
                                                <option value="40">$280 - Upto 40 Subsites / Instance</option>
                                                <option value="50">$320 - Upto 50 Subsites / Instance</option>
                                                <option value="100">$360 - Upto 100 Subsites / Instance</option>
                                                <option value="200">$400 - Upto 200 Subsites / Instance</option>
                                                <option value="300">$440 - Upto 300 Subsites / Instance</option>
                                                <option value="400">$480 - Upto 400 Subsites / Instance</option>
                                                <option value="500">$520 - Upto 500 Subsites / Instance</option>
                                                <option value="1000">$999 - Unlimited Subsites / Instance</option>
                                            </select>
                                        </div>
                                    </header> <!-- .cd-pricing-header -->
                                </a>
                                <footer class="cd-pricing-footer">
                                    <a href="#" class="cd-select" onclick="upgradeform('wp_ldap_intranet_multiple_directories_multisite_plan')" >Upgrade Now</a>
                                </footer><br>
<!--                                <b>See the Business Plan features list below</b>-->
                                <div class="cd-pricing-body">
                                    <ul class="cd-pricing-features">
                                        <li style="font-size: medium">Unlimited Authentications</li>
                                        <li style="font-size: medium">User Auto Registration</li>
                                        <li style="font-size: medium">Advanced Role Mapping</li>
                                        <li style="font-size: medium">Multiple LDAP Directories Configuration</li>
                                        <li style="font-size: medium">Custom Search Filter with Group Restriction<br></li>
                                        <li style="font-size: medium">Multiple Search Bases</li>
                                        <!--                                        <li style="background: black; color: #FFFFFF; padding: 4px 7px; ">Additional Features</li>-->
                                        <li style="font-size: medium">Custom Attribute Mapping</li>
                                        <li style="font-size: medium"> TLS connection<br></li>
                                        <!--                                        <li style="background: #e97d68; color: #FFFFFF; padding: 4px 7px; ">Additional Features</li>-->
                                        <li style="font-size: medium">WP to LDAP updates of user profile<br></li>
                                        <li style="font-size: medium">Support for customization/integration)</li>
                                        <li style="font-size: medium">Add-on Supported<br>(One free add-on of customer's choice(save $29))</li>
                                    </ul>
                                </div> <!-- .cd-pricing-body -->
                            </li>
                        </ul> <!-- .cd-pricing-wrapper -->
                    </li>

                </ul> <!-- .cd-pricing-list -->
            </div> <!-- .cd-pricing-container -->

    </div>

    <!-- Modal -->
    <br/><br/>

    <form style="display:none;" id="loginform"
          action="<?php echo esc_url(get_option( 'mo_ldap_local_host_name' ) . '/moas/login'); ?>"
          target="_blank" method="post">
        <input type="email" name="username" value="<?php echo esc_attr(get_option( 'mo_ldap_local_admin_email' )); ?>"/>
        <input type="text" name="redirectUrl"
               value="<?php echo esc_url(get_option( 'mo_ldap_local_host_name' ) . '/moas/initializepayment'); ?>"/>
        <input type="text" name="requestOrigin" id="requestOrigin"/>
    </form>
        <a  id="mo_backto_ldap_accountsetup_tab" style="display:none;" href="<?php echo add_query_arg( array( 'tab' => 'account' ), htmlentities( $_SERVER['REQUEST_URI'] ) ); ?>">Back</a>
    <br/><div style="margin-left: 60px">
    <h3>Steps to upgrade to premium plugin -</h3>
    <p>1. You will be redirected to miniOrange Login Console. Enter your password with which you created an account with us. After that you will be redirected to payment page.</p>
    <p>2. Enter you card details and complete the payment. On successful payment completion, you will see the link to download the premium plugin.</p>
    <p>3. Once you download the premium plugin, just unzip it and replace the folder with existing plugin. </p>
    <b>Note: Do not delete the plugin from the Wordpress Admin Panel and upload the plugin using zip. Your saved settings will get lost.</b>
    <p>4. From this point on, do not update the plugin from the Wordpress store. We will notify you when we upload a new version of the plugin.</p>
    <br>
            <h3>10 Days Return Policy -</h3>
    <p>If the premium plugin you purchased is not working as advertised and you’ve attempted to resolve any feature issues with our support team, which couldn't get resolved, we will refund the whole amount within 10 days of the purchase. Please email us at <a href="mailto:info@miniorange.com">info@miniorange.com</a> for any queries regarding the return policy.<br>
    </p><br>
        </div>
    </div>
    <style>


        .table-onpremisetable2 th {
            background-color: #fcfdff;

            text-align: center;
            vertical-align:center;
        }

        .table-onpremisetable2 td {
            background-color: #fcfdff;

            text-align: center;
            vertical-align:center;
        }



        h1 {
            margin: .67em 0;
            font-size: 2em;
        }
        .tab-content-plugins-pricing div {
            background: #173d50;
        }

    </style>
    <script>

        function upgradeform(planType) {
            jQuery('#requestOrigin').val(planType);
            if(jQuery('#mo_customer_registered').val()==1)
                jQuery('#loginform').submit();
            else{
                location.href = jQuery('#mo_backto_ldap_accountsetup_tab').attr('href');
            }

        }

        <?php if(isset($active_tab) && $active_tab == 'add_on'){?>
        this.value = 'Add-ons';
        if(this.value == 'Add-ons'){
            jQuery('.mosslp').removeClass('is-hidden is-visible').addClass('is-hidden');
            jQuery('.momslp').addClass('is-hidden2 is-selected').removeClass('is-hidden is-visible ');
            jQuery('.momslp1').addClass('is-visible is-selected').removeClass('is-hidden2 ')

        }
		
		jQuery("input[name=sitetype]:radio").change(function() {

            if (this.value == 'singlesite') {
                jQuery('.mosslp').removeClass('is-hidden').addClass('is-visible');
                jQuery('.momslp').addClass('is-hidden is-selected').removeClass('is-visible ');
                jQuery('.momslp1').addClass('is-hidden2 is-selected').removeClass('is-visible ');

            }else if(this.value == 'multisite'){
                jQuery('.mosslp').removeClass('is-visible').addClass('is-hidden');
                jQuery('.momslp').addClass('is-visible is-selected').removeClass('is-hidden is-hidden2');
                jQuery('.momslp1').addClass('is-hidden2 is-selected').removeClass('is-visible ');
            }

            else if(this.value == 'Add-ons'){
                jQuery('.mosslp').removeClass('is-hidden is-visible').addClass('is-hidden');
                jQuery('.momslp').addClass('is-hidden2 is-selected').removeClass('is-hidden is-visible ');
                jQuery('.momslp1').addClass('is-visible is-selected').removeClass('is-hidden2 ')

            }
        });

        <?php }else {?>
        jQuery("input[name=sitetype]:radio").change(function() {

            if (this.value == 'singlesite') {
                jQuery('.mosslp').removeClass('is-hidden').addClass('is-visible');
                jQuery('.momslp').addClass('is-hidden is-selected').removeClass('is-visible ');
                jQuery('.momslp1').addClass('is-hidden2 is-selected').removeClass('is-visible ');

            }else if(this.value == 'multisite'){
                jQuery('.mosslp').removeClass('is-visible').addClass('is-hidden');
                jQuery('.momslp').addClass('is-visible is-selected').removeClass('is-hidden is-hidden2');
                jQuery('.momslp1').addClass('is-hidden2 is-selected').removeClass('is-visible ');
            }

            else if(this.value == 'Add-ons'){
                jQuery('.mosslp').removeClass('is-hidden is-visible').addClass('is-hidden');
                jQuery('.momslp').addClass('is-hidden2 is-selected').removeClass('is-hidden is-visible ');
                jQuery('.momslp1').addClass('is-visible is-selected').removeClass('is-hidden2 ')

            }
        });
        <?php }?>

        jQuery('#basic_no_of_instances_drop_down_div').change(function () {
            var selected_instance_index = jQuery("#basic_no_of_instances_drop_down").prop('selectedIndex');
            showTotalPrice("enterprise",selected_instance_index,null);
        });
        jQuery('#plus_no_of_instances_drop_down').change(function () {
            var selected_instance_index = jQuery("#plus_no_of_instances_drop_down").prop('selectedIndex');
            showTotalPrice("enterprise",selected_instance_index,null);
        });

       
    </script>
    <?php
}