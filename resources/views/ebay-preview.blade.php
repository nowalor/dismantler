<!DOCTYPE html>
<html lang="de">
<head>
    <meta name="copyright" content="WEBMARX">
    <meta name="author" content="WEBMARX - Digitale Full-Service E-Commerce Agentur">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
        @import url(https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css);
        @import url(https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css);
        @import url(https://fonts.bunny.net/css?family=open-sans:400,400i,700,700i);

        /* Copyright 2024 HTML/CSS by webmarx | https://www.ebay.de/str/webmarx | eBay Auktionsvorlage Avis v. 1.2 */

        .bg {margin:0; padding:30px 0; background: rgb(255,255,255); background: -moz-radial-gradient(center, ellipse cover,  rgba(255,255,255,1) 31%, rgba(178,178,178,1) 100%); background: -webkit-radial-gradient(center, ellipse cover,  rgba(255,255,255,1) 31%,rgba(178,178,178,1) 100%); background: radial-gradient(ellipse at center,  rgba(255,255,255,1) 31%,rgba(178,178,178,1) 100%); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#b2b2b2',GradientType=1 );}
        .row {margin:0; padding:0;}

        /* HEADER */
        .logo {height:120px; margin:0; padding:0; border:1px solid #ececec; box-shadow:2px 2px 0px #ccc; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; background: #fff; text-align:center; overflow:hidden}
        .logo h1, .logo h2 {margin:22px 0 0 0; padding:0; display:block; font-family: 'Open Sans', sans-serif; color:#555; font-size:40px; font-weight:700; line-height:38px; text-transform:uppercase; text-align: center;}
        .logo h2 {margin:0; padding:0; color:#3591d7; font-weight:300;}
        .logo img {max-width:95%; max-height:120px; width:auto; height:auto; margin:19px auto; padding:0;}

        /* NAVIGATION */
        .right-logo {max-width:73.5%; height:120px; margin:0 0 0 1.5%; padding:1.2% 1%}
        .topheader {margin:0; padding:0;}
        .topheader ul {margin:0 -0.8%; padding:0;}
        .topheader ul li {margin:0; padding:0 5px; float:left; width:25%; list-style-type: none;}
        .topheader ul li a {display:block; font-family: 'Open Sans', sans-serif; font-weight:700; color:#fff; font-size:14px; margin:0; padding:10px 0; text-decoration:none; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; background:#3591d7; text-align: center}

        /* MENUBAR & BOX */
        .box {background: #fff;  border:1px solid #ececec; box-shadow:2px 2px 0px #ccc; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px;} .menubox {margin:20px 0;}

        /* SUCHE */
        .header-suche {padding:0; margin:0 0 10px 0; border:none; float:left; text-align: left}
        .header-suche a {color:#a8a8a8!important; text-decoration: none!important;}
        .suchfeld {width:763px; height:40px; margin:0; float:left; font-family: 'Open Sans', sans-serif; font-size:14px; background:#f8f8f8; color:#a8a8a8; line-height:40px; margin:0; padding:0 20px; border:1px solid #eaeaea; box-shadow: inset 1px 1px 1px #ddd; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; text-align: left}
        .suchbutton {float:right; width:50px; height:50px; border:1px solid #3591d7; width:40px; height:40px; background:#3591d7!important; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; color:#fff; font-size:16px; text-align:center; margin:0 0 0 8px; padding:0;}
        .suchbutton i {line-height:40px; color:#fff; font-size:18px;}
        .suchbutton:hover {border:1px solid #555; background:#555; color:#fff}

        /* MENUBAR & BOX */
        .box {background: #fff; border:1px solid #ececec; box-shadow:2px 2px 0px #ccc; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px;}

        /* KATEGORIEN */
        ul.menu {width:100%; margin:0; padding:0; position: relative; height:60px;}
        ul.menu li {float:left; height:60px; line-height:60px; list-style-type:none; margin:0; padding:0; font-family: 'Open Sans', sans-serif; font-weight:700; font-size:14px; text-transform: uppercase; border-left:1px dotted #dedede; text-align:center}
        ul.menu li a {display:block; color:#555; padding:0 30px;}
        ul.menu li a i {line-height:60px;}
        ul.menu li a:hover {margin:0; text-decoration:none; color:#3591d7; background:none}
        ul.menu li.home {width:60px; line-height:60px; background:#fff; border:none; padding:0;}
        ul.menu li.home a {color:#3591d7; font-size:30px; margin:0; padding:0; line-height: 60px;}
        ul.menu li.home a:hover {color:#555}

        /* DROPDOWN*/
        ul.menu ul {display:none; position:absolute; top:60px; z-index:6; list-style-type: none; box-shadow:0 5px 10px rgba(0,0,0,0.1); margin:0; padding:0;}
        ul.menu li:hover > ul {display:inherit;}
        ul.menu ul li, ul.menu ul li:first-child {width:auto; max-height:50px; float:none; display:block; position: relative; font-weight:700; color:#555; text-transform: uppercase; padding:0; margin:0; font-family: 'Open Sans', sans-serif; font-size:14px; background:#fff; list-style-type: none; line-height:50px; border:none}
        ul.menu ul li a, ul.menu ul li:first-child a {display:block; margin:0; font-family: 'Open Sans', sans-serif; font-size:14px; padding:0 20px; font-weight:700; color:#555!important; text-transform: uppercase; text-align: left;}
        ul.menu ul li:hover, ul.menu ul li:hover:first-child {background:#3591d7;}
        ul.menu ul li:hover a {color:#fff!important;}

        /* RESPONSIVE MENU */
        ul.resmenu {margin:0; padding:0; width:100%;}
        ul.resmenu li {display:block; float:left; margin:0; padding:0; width:25%; background:none; list-style-type: none; line-height: 40px}
        ul.resmenu li a {display:block; text-align:center; font-size:20px; color:#3591d7; background:none; text-decoration: none; margin:0; padding:10px 0; text-align: center;}
        ul.resmenu li a:hover {color:#555}

        /* ARTIKELBILDER */
        img {max-width:100%; height:auto}
        .artikelbilder.galerie {display:inline-block; position:relative; width:100%; height:auto;}
        .artikelbilder.galerie > .anker {display:none;}
        .artikelbilder.galerie > ul {position:relative; z-index:1; font-size:0; line-height:0; margin:0 auto; padding:0; height:auto; overflow:hidden; white-space:nowrap;}
        .artikelbilder.galerie > ul > .slide.img img {width:100%; height:auto;}
        .artikelbilder.galerie > ul > .slide {position:relative; display:inline-block; width:100%; height:auto; overflow:hidden; line-height: normal; white-space: normal; vertical-align:top; -webkit-box-sizing:border-box; -moz-box-sizing:border-box; box-sizing:border-box; -webkit-transform:translate3d(0, 0, 0); transform:translate3d(0, 0, 0);}
        /* Thumbnails */
        .artikelbilder.galerie > .thumb {position:absolute; left:0; width:100%; height:auto; z-index:6; text-align:center;}
        .artikelbilder.galerie > .thumb > div {margin-left:-50%; width:100%;}
        .artikelbilder.galerie > .thumb > label {position:relative; display:inline-block; cursor:pointer;}
        .artikelbilder.galerie > .thumb {bottom:5px; margin-bottom:5px;}
        .artikelbilder.galerie > .thumb > label {border-radius:50%; margin:0 5px; padding:9px; background:none;}
        .artikelbilder.galerie > .thumb > label > .anker {position:absolute; left:50%; top:50%; margin-left:-2px; margin-top:-2px; background: transparent; border-radius: 50%; padding: 2px;}
        .artikelbilder.galerie > .thumb > label:hover > .anker,
        .artikelbilder.galerie > #slide1:checked~.thumb > label.pic1>.anker, .artikelbilder.galerie > #slide2:checked~.thumb > label.pic2>.anker,
        .artikelbilder.galerie > #slide3:checked~.thumb > label.pic3>.anker, .artikelbilder.galerie > #slide4:checked~.thumb > label.pic4>.anker,
        .artikelbilder.galerie > #slide5:checked~.thumb > label.pic5>.anker, .artikelbilder.galerie > #slide6:checked~.thumb > label.pic6>.anker,
        .artikelbilder.galerie > #slide7:checked~.thumb > label.pic7>.anker, .artikelbilder.galerie > #slide8:checked~.thumb > label.pic8>.anker,
        .artikelbilder.galerie > #slide9:checked~.thumb > label.pic9>.anker, .artikelbilder.galerie > #slide10:checked~.thumb > label.pic10>.anker,
        .artikelbilder.galerie > #slide11:checked~.thumb > label.pic11>.anker, .artikelbilder.galerie > #slide12:checked~.thumb > label.pic12>.anker,
        .artikelbilder.galerie > #slide13:checked~.thumb > label.pic13>.anker, .artikelbilder.galerie > #slide14:checked~.thumb > label.pic14>.anker,
        .artikelbilder.galerie > #slide15:checked~.thumb > label.pic15>.anker, .artikelbilder.galerie > #slide16:checked~.thumb > label.pic16>.anker {background:none;}
        .artikelbilder.galerie {height: auto; max-height: auto; margin-bottom:0; text-align: center;}
        .artikelbilder.galerie img {border-radius: 3px;}
        .artikelbilder.galerie .thumb {position:relative; width: 100%; text-align: left; margin-top: 10px;}
        .artikelbilder.galerie > .thumb > label {box-sizing: border-box; border-radius: none; margin: 0 auto; padding:5px; background: none; text-align: center;}
        .artikelbilder.galerie > .thumb > label img {margin:0 auto; max-height:115px; width:auto; border:2px solid #ddd}
        .artikelbilder.galerie > #slide1:checked~.thumb > label.pic1> img, .artikelbilder.galerie > #slide2:checked~.thumb > label.pic2> img,
        .artikelbilder.galerie > #slide3:checked~.thumb > label.pic3> img, .artikelbilder.galerie > #slide4:checked~.thumb > label.pic4> img,
        .artikelbilder.galerie > #slide5:checked~.thumb > label.pic5> img, .artikelbilder.galerie > #slide6:checked~.thumb > label.pic6> img,
        .artikelbilder.galerie > #slide7:checked~.thumb > label.pic7> img, .artikelbilder.galerie > #slide8:checked~.thumb > label.pic8> img,
        .artikelbilder.galerie > #slide9:checked~.thumb > label.pic9> img, .artikelbilder.galerie > #slide10:checked~.thumb > label.pic10> img,
        .artikelbilder.galerie > #slide11:checked~.thumb > label.pic11> img, .artikelbilder.galerie > #slide12:checked~.thumb > label.pic12> img {border:2px solid #3591d7;}
        .artikelbilder.galerie > ul > .slide.img img {width: auto; max-width: 100%; max-height: 100%; margin:0 auto;}
        .artikelbilder.galerie > ul > .slide {text-align:center;}
        .artikelbilder.galerie img {box-shadow: none; width:100%; height:auto; max-width:100%;}
        /* Original-Bild */
        .artikelbilder.galerie > #slide1:checked~ul > .slide.pic1, .artikelbilder.galerie > #slide2:checked~ul > .slide.pic2,
        .artikelbilder.galerie > #slide3:checked~ul > .slide.pic3, .artikelbilder.galerie > #slide4:checked~ul > .slide.pic4,
        .artikelbilder.galerie > #slide5:checked~ul > .slide.pic5, .artikelbilder.galerie > #slide6:checked~ul > .slide.pic6,
        .artikelbilder.galerie > #slide7:checked~ul > .slide.pic7, .artikelbilder.galerie > #slide8:checked~ul > .slide.pic8,
        .artikelbilder.galerie > #slide9:checked~ul > .slide.pic9, .artikelbilder.galerie > #slide10:checked~ul > .slide.pic10,
        .artikelbilder.galerie > #slide11:checked~ul > .slide.pic11, .artikelbilder.galerie > #slide12:checked~ul > .slide.pic12,
        .artikelbilder.galerie > #slide13:checked~ul > .slide.pic13, .artikelbilder.galerie > #slide14:checked~ul > .slide.pic14,
        .artikelbilder.galerie > #slide15:checked~ul > .slide.pic15, .artikelbilder.galerie > #slide16:checked~ul > .slide.pic16 {opacity:1; z-index:2;}
        /* Animations */
        .artikelbilder.galerie > ul > .slide {display:inline-block; position:absolute; left: 0; top: 0; opacity: 0; z-index: 1; -webkit-transition: opacity 1250ms ease; transition: opacity 1250ms ease; -webkit-transform: rotate(0deg); transform: rotate(0deg);}
        @-webkit-keyframes fade {
            0%, 37.254901960784316%, 100% {opacity: 0;}
            12.254901960784315%,25% {opacity: 1;}
            0%,24.999% {z-index: 2;}
            25.001%,100% {z-index: 1;}
        }
        @keyframes fade {
            0%, 37.254901960784316%, 100% {opacity: 0;}
            12.254901960784315%,25% {opacity: 1;}
            0%,24.999% {z-index: 2;}
            25.001%,100% {z-index: 1;}
        }
        /* Größe */
        .artikelbilder.galerie {max-width:500px;}
        .artikelbilder.galerie > ul {height:500px;}
        .artikelbilder.galerie > ul > .slide.img img {max-height:500px; width:auto; margin:0 auto;}
        .artikelbilder.galerie > .thumb > label img {max-height:100px; width:auto; margin:0 auto;}
        @media (min-width:992px) and (max-width: 1200px) {
            .artikelbilder.galerie {max-width:400px;}
            .artikelbilder.galerie > ul {height:400px;}
            .artikelbilder.galerie > ul > .slide.img img {max-height:400px; width:auto; margin:0 auto;}
            .artikelbilder.galerie > .thumb > label img {max-height:80px; width:auto; margin:0 auto;}
        }
        @media (max-width: 768px) {
            .artikelbilder.galerie {max-width:300px;}
            .artikelbilder.galerie > ul {height:300px;}
            .artikelbilder.galerie > ul > .slide.img img {max-height:300px; width:auto; margin:0 auto;}
            .artikelbilder.galerie > .thumb > label img {max-height:60px; width:auto; margin:0 auto;}
        }

        /* ARTIKELBESCHREIBUNG */
        .artpic {margin:0; padding:30px 0; text-align: center}
        .artdsc {margin:0; padding:20px; padding-left:0; text-align:left; font-family: 'Open Sans', sans-serif; font-weight:400; font-size:14px;}
        .artdsc h1 {font-family: 'Open Sans', sans-serif; font-weight:700; font-size: 24px; color:#3591d7; text-align:left; text-transform: uppercase; margin:0; padding:10px 0 10px 0; line-height:28px}
        .artdsc h2 {font-family: 'Open Sans', sans-serif; font-weight:700; font-size: 20px; color:#555; text-align:left; text-transform: uppercase; margin:0; padding:20px 0 10px 0; line-height:24px}
        .artdsc h3 {font-family: 'Open Sans', sans-serif; font-weight:700; font-size: 30px; color:#555; text-align:center; margin:0; padding:30px 0 20px 0;}
        .artdsc span {font-size:12px; color:#999; font-weight:700}
        .artdsc ul, .tab-content ul, .footbox ul {margin:10px 0; padding:0; font-size:14px; border:none; border-bottom:none;}
        .artdsc ul li, .tab-content ul li, .footbox ul li {list-style-type:none; background:none; margin:1px 0; padding:9px 12px; border-bottom:1px dotted #e6e6e6; line-height:20px}
        .artdsc ul li:before, .tab-content ul li:before, .footbox ul li:before {font-family: 'FontAwesome'; content: '\f105'; font-size:14px; padding-right:10px; color:#3591d7;}

        /* VARIANTEN */
        span.var {display:inline-block; min-width:60px; padding:10px; margin:4px 5px; color:#777; text-align: center; cursor: default; background: none; box-shadow:0 5px 10px rgba(0,0,0,0.05);}

        /* BUTTONS */
        a.skb {display:block; font-family: 'Open Sans', sans-serif; font-weight:700; font-size:18px; background:#3591d7; margin:20px 0 0 0; padding:10px; color:#fff; text-decoration: none; text-align:center; border:none; box-shadow: 2px 2px 2px #ccc; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px;}
        a.beo, a.fsb {width:49%; display:inline-block; font-family: 'Open Sans', sans-serif; font-weight:700; font-size:14px; background:#3591d7; margin:10px 0; padding:10px; color:#fff; text-decoration: none; text-align:center; border:none; box-shadow: 2px 2px 2px #ccc; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px;}
        a.fsb {float:right}
        a.skb i {color:#fff; font-size:18px}
        a.skb i, a.fsb i, a.beo i {color:#fff; font-size:14px}

        /* CROSS SELLING */
        .crosswrapper {margin:20px 0; padding:0;}
        .crosswrapper .box {max-width:32%; min-height:180px; background-color:#fff!important; margin:0 1%; padding:0;}
        .crosswrapper div.box:first-child {margin-left:0;}
        .crosswrapper div.box:last-child {margin-right:0;}
        .crosswrapper .box img {float:right; margin:0;}
        .crosswrapper .box h1 {font-size:18px; line-height:18px; font-weight:700; color:#333; margin:30px 0 0 0; padding:0; text-align:left;}
        .crosswrapper .box h2 {font-size:24px; line-height:24px; font-weight:700; color:#888; margin:0; padding:0; text-align:left;}
        .crosswrapper .box a {color:#fff; text-decoration: none!important;}
        .crosswrapper .box h3 {display:inline-block; background:#3591d7; color:#fff; padding:10px 20px; margin:20px 0 0 0; font-size:14px; font-weight:700; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; text-align:center}

        /* TABS */
        .tabs {margin:0; padding:10px; background:#fff; text-align: left}
        .tabs input[type=radio] {display:none}
        .tabs label {display:block; float:left; font-family: 'Open Sans', sans-serif; color:#666; font-size:14px; font-weight:700; text-decoration: none; text-align:center; cursor:pointer; background:none; padding:18px 30px; margin:0}
        .tabs label span {display:inline-block}
        .tab-content {display:none; width:100%; float:left; padding:15px; box-sizing:border-box; background:#fff; border-top:5px solid #3591d7; margin-top:-5px; font-family: 'Open Sans', sans-serif; font-size:14px}
        .tab-content h1 {font-family: 'Open Sans', sans-serif; color:#555; background:none; border:none; font-size:18px; font-weight:700; border-bottom:1px dotted #ddd; margin:0 0 10px 0; padding:10px 0}
        .tab-content h2 {font-family: 'Open Sans', sans-serif; color:#3591d7; background:none; border:none; font-size:18px; font-weight:700; margin:0 0 10px 0; padding:10px 0}
        .tab-content h3 {font-family: 'Open Sans', sans-serif; color:#555; background:none; border:none; font-size:16px; font-weight:700; margin:0 0 10px 0; padding:10px 0}
        .tab-content h4 {font-family: 'Open Sans', sans-serif; color:#3591d7; background:none; border:none; font-size:16px; font-weight:700; margin:0 0 10px 0; padding:10px 0}
        .tab-content h5 {font-family: 'Open Sans', sans-serif; color:#555; background:none; border:none; font-size:14px; font-weight:700; margin:0 0 10px 0; padding:10px 0}
        .tab-content h6 {font-family: 'Open Sans', sans-serif; color:#3591d7; background:none; border:none; font-size:14px; font-weight:700; margin:0 0 10px 0; padding:10px 0}
        .tabs [id^="tab"]:checked + label {background:#3591d7; color:#fff; -webkit-border-top-left-radius: 5px; -webkit-border-top-right-radius: 5px; -moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px; border-top-left-radius: 5px; border-top-right-radius: 5px;}
        #tab1:checked ~ #tab-content1,#tab2:checked ~ #tab-content2,#tab3:checked ~ #tab-content3,#tab4:checked ~ #tab-content4 {display:block}
        .tabs:after {content:''; display:table; clear:both}

        /* TABLE */
        .tab-content table {margin:20px 0; cursor: default; font-family: 'Open Sans', sans-serif; color:#555; font-size:14px;}
        .tab-content table tr {border-bottom:1px solid #eaeaea;}
        .tab-content table tr:nth-child(odd) {background:#f5f5f5;}
        .tab-content table tr:last-child {border-bottom:none;}
        .tab-content table td {padding:10px;}
        .tab-content table td:first-child {font-weight:700; border-right:1px solid #eaeaea;}

        /* STYLES */
        blockquote, code, mark, small, kbd {font-family: 'Open Sans', sans-serif; font-size:14px}
        blockquote {display:block; margin:20px 0; padding:20px; color:#3f3f3f; background:#f5f5f5; border-left:4px solid #3591d7;}
        code {display:block; margin:20px 0; padding:20px; color:#fff; background:#363636; border-left:4px solid #3591d7;}
        mark {color:#3f3f3f; background:#fff0ce;}
        small {font-size:11px; color:#999; font-weight:400}
        kbd {box-shadow:none; font-weight:400; font-weight:700; background:#3591d7;}

        /* BUTTONS */
        .button-a, .button-b {display:block; font-family: 'Open Sans', sans-serif; font-weight:700; font-size:14px; background:#3591d7!important; margin:5px; padding:15px 10px; color:#fff; text-decoration: none; text-align:center; border:none; box-shadow: 2px 2px 2px #ccc; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px;}
        .button-a {width:15.3%;}
        .button-b {width:13%;}
        .button-a:hover, .button-b:hover {text-decoration: none;}

        /* FOOTER */
        .footerwrapper {margin:20px 0; margin-bottom:0; padding:0;}
        .footerwrapper .box {max-width:32%; min-height:230px; background-color:#fff!important; margin:0 1%; padding:10px 20px; text-align:left; font-family: 'Open Sans', sans-serif; font-weight:400; font-size:14px;}
        .footerwrapper div.box:first-child {margin-left:0;}
        .footerwrapper div.box:last-child {margin-right:0;}
        .footerwrapper .box h1 {font-family: 'Open Sans', sans-serif; color:#555; font-size:18px; font-weight:700; border-bottom:1px solid #3591d7; margin:10px 0; padding:8px 0; text-align:center}
        .footerwrapper .box i, .footerwrapper .box a {color:#3591d7}
        .footerwrapper .box a:hover {color:#555; text-decoration:none}
        .footerwrapper .box a.nws i {color:#fff; font-size:16px; padding-right:15px}
        .footerwrapper .box a.nws {display:inline-block; margin:0; display:block; background:#3591d7; font-size:14px; padding:10px; color:#fff; text-decoration:none; text-align:center; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; margin-top:20px;}
        .footerwrapper .box a.nws:hover {background:#555; color:#fff}

        .footerwrapper .box ul {margin:0; padding:0;}
        .footerwrapper .box ul li {margin:0; padding:5px; list-style-type:none; border-bottom:1px dotted #ccc;}
        .footerwrapper .box ul li a {color:#555; text-decoration: none;}
        .footerwrapper .box ul li a:hover {color:#3591d7; text-decoration: none;}
        .footerwrapper .box ul li a i {color:#3591d7; text-decoration: none; margin: 0 5px 0 0;}

        /* ANIMATION */
        .soh {display: inline-block; vertical-align: middle; -webkit-transform: translateZ(0); transform: translateZ(0); box-shadow: 0 0 1px rgba(0, 0, 0, 0); -webkit-backface-visibility: hidden; backface-visibility: hidden; -moz-osx-font-smoothing: grayscale; position: relative; background: #e1e1e1; -webkit-transition-property: color; transition-property: color; -webkit-transition-duration: 0.3s; transition-duration: 0.3s;}
        .soh:before {content: ""; position: absolute; z-index: -1; top: 0; bottom: 0; left: 0; right: 0; background: #555; -webkit-transform: scaleX(0); transform: scaleX(0); -webkit-transform-origin: 50%; transform-origin: 50%; -webkit-transition-property: transform; transition-property: transform; -webkit-transition-duration: 0.3s; transition-duration: 0.3s; -webkit-transition-timing-function: ease-out; transition-timing-function: ease-out; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px;}
        .soh:hover, .soh:focus, .soh:active {color: white;}
        .soh:hover:before, .soh:focus:before, .soh:active:before {-webkit-transform: scaleX(1); transform: scaleX(1);}
        .btn {background:#3591d7; color:#fff; font-weight: 700; display:block; margin:20px 0; max-width:200px; padding:10px 0; border:none}

        /* MEDIA QUERY */
        @media (min-width:992px) and (max-width: 1200px) {
            .logo img {margin:15px auto 0 auto;}
            .right-logo {padding:1.5% 1%}
            .suchfeld {width:620px}
            ul.menu li a {padding:0 15px;}
            .crosswrapper .box h1, .crosswrapper .box h2 {padding-left:10px; font-size:14px}
            .crosswrapper .box h2 {font-size:14px; line-height:18px;}
            .crosswrapper .box h3 {font-size:12px; line-height:12px; margin-left:10px; padding:8px 13px;}
            .button-a {width:14.9%;}
            .button-b {width:12.6%;}
        }

        @media (min-width:768px) and (max-width: 992px) {
            .right-logo {max-width:100%; margin:15px 0 0 0; padding:2% 1.5%;}
            .suchfeld {width:648px}
            ul.menu li a {font-size:11px; padding:0 9px;}
            ul.menu li ul li a, ul.menu li ul li:first-child a {font-size:11px;}
            .crosswrapper {margin:0; padding:0;}
            .crosswrapper .box {max-width:100%; margin:20px 0;}
            .footerwrapper .box {max-width:100%; margin:0 0 20px 0; min-height:auto; height:auto; padding:0 20px 20px 20px;}
            .artdsc {margin:30px; margin-top:0; padding:0}
            .tabs label {padding:15px 10px 20px 10px; font-size:13px;}
            .button-a, .button-b {font-size:11px;}
            .button-a {width:14.5%;}
            .button-b {width:12.2%;}
        }

        @media (max-width: 768px) {
            .bg {padding:10px 0; margin:0}
            .header {margin:0 auto; padding:0;}
            .artdsc {margin:0; padding:0 20px 10px 20px;}
            a.beo, a.fsb {font-size:12px;}
            .tabs {margin:20px 0 10px 0;}
            .tabs label {width:100%; padding:20px 0; font-size:14px}
            .tabs label span {display:inline-block}
            .tabs [id^="tab"]:checked + label {-webkit-border-radius:0px!important; -moz-border-radius:0px!important; border-radius:0px!important;}
            .button-a {width:100%;}
            .button-b {width:100%;}
            .crosswrapper .box {max-width:100%; margin:20px 0;}
            .footerwrapper .box {max-width:100%; margin:0 0 20px 0; min-height:auto; height:auto; padding:0 20px 20px 20px;}
        }
    </style>
</head>
<body>

<!-- Hintergrund --><div class="container-fluid bg">
    <!-- Wrapper --><div class="container">

        <!-- Header --><div class="row header">

            <!-- Logo --><div class="col-md-3 logo"><h1>Shop</h1><h2>Name</h2></div>

            <!-- Right-Logo --><div class="col-md-9 box right-logo hidden-xs">

                <!-- Suche --><div class="header-suche"><a target="_blank" href="https://www.ebay.de/sch/autoteile.dk/m.html?_nkw=&_armrs=1&_ipg=&_from="><div class="suchfeld">Shop durchsuchen...</div><div class="suchbutton soh"><i class="fa fa-search"></i></div></a></div>

                <!-- Topheader --><div class="topheader">
                    <ul>
                        <li><a class="soh" target="_blank" href="https://www.ebay.de/str/makure">Unser Shop</a></li>
                        <li><a class="soh" target="_blank" href="https://www.ebay.de/str/makure?_tab=1">Über Uns</a></li>
                        <li><a class="soh" target="_blank" href="https://www.ebay.de/str/makure?_tab=2">Bewertungen</a></li>
                        <li><a class="soh" target="_blank" href="https://www.ebay.de/contact/sendmsg?message_type_id=14&recipient=autoteile.dk">Kontakt</a></li>
                    </ul>
                    <!-- Topheader --></div>

                <!-- Right-Logo --></div>

            <!-- Header --></div>

        <!-- Menubar --><div class="row box menubox">

            <!-- Kategorien --><ul class="menu hidden-xs">
                <li class="home"><a target="_blank" href="https://www.ebay.de/str/makure"><i class="fa fa-home"></i></a></li>
                <li><a target="_blank" href="https://www.ebay.de/str/makure">Kategorie 1</a></li>
                <li><a target="_blank" href="https://www.ebay.de/str/makure">Kategorie 2</a></li>
                <li><a target="_blank" href="https://www.ebay.de/str/makure">Kategorie 3</a></li>
                <li><a target="_blank" href="https://www.ebay.de/str/makure">Kategorie 4</a></li>
                <li><a target="_blank" href="https://www.ebay.de/str/makure">Kategorie 5</a></li>
                <li><a target="_blank" href="https://www.ebay.de/str/makure">Kategorie 6</a></li>
                <li><a target="_blank" href="https://www.ebay.de/str/makure">Kategorie 7</a></li>
                <!-- Kategorien --></ul>

            <!-- Responsive --><ul class="resmenu hidden-lg hidden-md hidden-sm">
                <li><a target="_blank" href="https://www.ebay.de/str/makure"><i class="fa fa-home"></i></a></li>
                <li><a target="_blank" href="https://www.ebay.de/str/makure?_tab=1"><i class="fa fa-user"></i></a></li>
                <li><a target="_blank" href="https://www.ebay.de/str/makure?_tab=2"><i class="fa fa-star"></i></a></li>
                <li><a target="_blank" href="https://www.ebay.de/contact/sendmsg?message_type_id=14&recipient=autoteile.dk"><i class="fa fa-envelope"></i></a></li>
                <!-- Responsive --></ul>

            <!-- Menubar --></div>

        <!-- Artikelbeschreibung --><div class="row box">

            <!-- Artikelbilder --><div class="col-md-6 artpic"><div class="artikelbilder galerie">

                    <input name="switch" id="slide1" class="anker slide" type="radio" checked="">
                    <input name="switch" id="slide2" class="anker slide" type="radio">
                    <input name="switch" id="slide3" class="anker slide" type="radio">
                    <input name="switch" id="slide4" class="anker slide" type="radio">

                    <ul>
                        <li class="pic1 img slide"><img src="https://via.placeholder.com/500/eeeeee/999?text=Grafik-1"></li>
                        <li class="pic2 img slide"><img src="https://via.placeholder.com/500/eeeeee/999?text=Grafik-2"></li>
                        <li class="pic3 img slide"><img src="https://via.placeholder.com/500/eeeeee/999?text=Grafik-3"></li>
                        <li class="pic4 img slide"><img src="https://via.placeholder.com/500/eeeeee/999?text=Grafik-4"></li>
                    </ul>

                    <!-- Thumbnails --><div class="thumb">
                        <label class="pic1 col-xs-3" for="slide1"><span class="anker"></span>
                            <img src="https://via.placeholder.com/500/eeeeee/999?text=Grafik-1"></label>
                        <label class="pic2 col-xs-3" for="slide2"><span class="anker"></span>
                            <img src="https://via.placeholder.com/500/eeeeee/999?text=Grafik-2"></label>
                        <label class="pic3 col-xs-3" for="slide3"><span class="anker"></span>
                            <img src="https://via.placeholder.com/500/eeeeee/999?text=Grafik-3"></label>
                        <label class="pic4 col-xs-3" for="slide4"><span class="anker"></span>
                            <img src="https://via.placeholder.com/500/eeeeee/999?text=Grafik-4"></label>
                        <!-- Thumbnails --></div>

                    <!-- Artikelbilder --></div></div>

            <!-- Artikeldetails --><div class="col-md-6 artdsc">
                <h1>Artikelbeschreibung</h1>
                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>

                <h2>Artikeldetails</h2>
                <ul>
                    <li>Merkmal 1</li>
                    <li>Merkmal 2</li>
                    <li>Merkmal 3</li>
                </ul>

                <h2>Varianten</h2>
                <span class="var">S</span>
                <span class="var">M</span>
                <span class="var">L</span>
                <span class="var">8 GB</span>
                <span class="var">16 GB</span>
                <span class="var">32 GB</span>
                <span class="var">64 GB</span>

                <h3>nur 0,00 € <span>(inkl. MwSt.)</span></h3>

                <!-- SOFORT KAUFEN -->
                <a class="skb soh" target="_blank" href="https://www.ebay.de/bin/ctb?item=ITEM_ID"><i class="fa fa-shopping-basket"></i> Sofort-Kaufen</a>

                <!-- FRAGE STELLEN -->
                <a class="fsb soh" target="_blank" href="https://www.ebay.de/contact/sendmsg?message_type_id=14&recipient=autoteile.dk"><i class="fa fa-question-circle"></i> Frage stellen</a>

                <!-- Artikeldetails --></div>

            <!-- Artikelbeschreibung --></div>

        <!-- Cross-Selling --><div class="row crosswrapper hidden-xs">

            <div class="col-md-4 box">
                <div class="row">
                    <div class="col-xs-6">
                        <h1>Marke</h1>
                        <h2>Produkt 1</h2>
                        <a target="_blank" href="https://www.ebay.de/str/makure">
                            <h3 class="soh">zum Angebot</h3>
                        </a>
                    </div>
                    <div class="col-xs-6">
                        <img src="https://via.placeholder.com/150x180/eeeeee/999?text=Grafik" class="img-responsive">
                    </div>
                </div>
            </div>

            <div class="col-md-4 box">
                <div class="row">
                    <div class="col-xs-6">
                        <h1>Marke</h1>
                        <h2>Produkt 2</h2>
                        <a target="_blank" href="https://www.ebay.de/str/makure">
                            <h3 class="soh">zum Angebot</h3>
                        </a>
                    </div>
                    <div class="col-xs-6">
                        <img src="https://via.placeholder.com/150x180/eeeeee/999?text=Grafik" class="img-responsive">
                    </div>
                </div>
            </div>

            <div class="col-md-4 box">
                <div class="row">
                    <div class="col-xs-6">
                        <h1>Marke</h1>
                        <h2>Produkt 3</h2>
                        <a target="_blank" href="https://www.ebay.de/str/makure">
                            <h3 class="soh">zum Angebot</h3>
                        </a>
                    </div>
                    <div class="col-xs-6">
                        <img src="https://via.placeholder.com/150x180/eeeeee/999?text=Grafik" class="img-responsive">
                    </div>
                </div>
            </div>
            <!-- Cross-Selling --></div>

        <!-- Tabs --><div class="tabs box">

            <input type="radio" name="tabs" id="tab1" checked="">
            <label for="tab1"><span>Information</span></label>
            <input type="radio" name="tabs" id="tab2">
            <label for="tab2"><span>Zahlung</span></label>
            <input type="radio" name="tabs" id="tab3">
            <label for="tab3"><span>Versand</span></label>
            <input type="radio" name="tabs" id="tab4">
            <label for="tab4"><span>Sonstiges</span></label>

            <div id="tab-content1" class="tab-content">
                <h1>Überschrift</h1>
                Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor.

                <ul>
                    <li>Merkmal</li>
                    <li>Merkmal</li>
                    <li>Merkmal</li>
                </ul>
            </div>

            <div id="tab-content2" class="tab-content">
                <h1>Zahlung</h1>
                Bieten Sie Ihren Kunden verschiedene Zahlungsoptionen an. Sie können hierfür z.B. die im Ordner "Grafiken" zur Verfügung gestellten Bilder verwenden.
            </div>

            <div id="tab-content3" class="tab-content">
                <h1>Versandoptionen</h1>
                Bieten Sie Ihren Kunden verschiedene Versandoptionen an. Sie können hierfür z.B. die im Ordner "Grafiken" zur Verfügung gestellten Bilder verwenden.
            </div>

            <div id="tab-content4" class="tab-content">
                <h1>Hinweis</h1>
                <blockquote>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est.</blockquote>
                <h1>Wichtig</h1>
                <code>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est.</code>
                <h1>Highlight</h1>
                <mark>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est.</mark>
                <br><br>
                <h1>Fußnote</h1>
                <small>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est.</small>
                <br><br>
                <h1>Tags</h1>
                Nutzen Sie die Möglichkeit einzelne <kbd>Wörter</kbd> oder <kbd>Merkmale</kbd> hervorzuheben und so <kbd>Tags</kbd> zu erstellen.
            </div>

            <!-- Tabs --></div>

        <!-- Footer --><div class="row footerwrapper hidden-xs">

            <div class="col-md-4 box">
                <h1>Links</h1>
                <ul>
                    <li><a target="_blank" href="https://www.ebay.de/str/makure"><i class="fa fa-home"></i> Alle Angebote</a></li>
                    <li><a target="_blank" href="https://www.ebay.de/str/makure?_tab=1"><i class="fa fa-user"></i> Über Uns</a></li>
                    <li><a target="_blank" href="https://www.ebay.de/str/makure?_tab=2"><i class="fa fa-star"></i> Bewertungen</a></li>
                    <li><a target="_blank" href="https://www.ebay.de/contact/sendmsg?message_type_id=14&recipient=autoteile.dk"><i class="fa fa-envelope"></i> Kontakt</a></li>
                </ul>
            </div>

            <div class="col-md-4 box">
                <h1>Überschrift</h1>
                <p>Die Inhalte der Vorlage können nach eigenem Belieben angepasst werden. Nutzen Sie diesen Platz z.B. um weitere Hinweise für Ihre Kunden darzustellen oder um Ihr Unternehmen sowie Ihre Angebote und Services vorzustellen.</p>
            </div>

            <div class="col-md-4 box">
                <h1>Kontakt</h1>
                <p>Haben Sie Fragen zu unseren Angeboten? Kontaktieren Sie uns gerne über das eBay Kontaktformular.</p>
                <a class="nws" target="_blank" href="https://www.ebay.de/contact/sendmsg?message_type_id=14&recipient=autoteile.dk"><i class="fa fa-comments-o fa-fw"></i> eBay Nachricht</a>
            </div>

            <!-- Footer --></div>

        <!-- Wrapper --></div>
    <!-- Hintergrund --></div>
</body>
</html>
