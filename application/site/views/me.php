<!DOCTYPE html>
<head>
    <?php include_once VIEWPATH . 'inc/head.php'; ?>
    <?php
    echo static_file('css/me.css');
    echo static_file('css/bubbly-button.css');
    ?>
</head>

<body>
<?php include_once VIEWPATH . 'inc/sakura.php'; ?>
<div class="ne-wrap">
    <div>
    <H1 style="text-align: center">その年に一緒に見たアニメ | <a href="/">Sakura</a></H1>
    </div>
    <div class="hat"></div>
    <div class="ban">
        <img src="<?php echo $index['cover']; ?> " width="100%" alt="" style="border: 3px solid rgb(255,230,229); border-radius:3px">
    </div>
    <div class="list f-cb">
        <div class="box">
            <h3>Tags</h3>
            <?php foreach ($tagName as $v): ?>
                <a href="<?php echo site_url('me/tag/' . $v['title']); ?> "><?php echo $v['title']; ?></a>
            <?php endforeach; ?>
        </div>
        <div class="box">
            <h3>New</h3>
            <?php foreach ($article as $k => $v): ?>
                <a href="<?php echo site_url('me/aimer/' . $v['id']); ?> "><?php echo $v['title']; ?></a>
            <?php endforeach; ?>
        </div>
        <div class="box">
            <h3>Archives</h3>
            <?php foreach ($date as $month => $article): ?>
                <a href="<?php echo site_url('me/date/' . $article[0]['months']); ?> "><?php echo $month; ?></a>
            <?php endforeach; ?>
        </div>
        <div class="box">
    			<h3>Links</h3>
                <?php if (!empty($index['link'])): ?>
                    <?php foreach ($index['link'] as $value): ?>
                        <a href="<?php echo $value['url'] ?>" target="_blank"><?php echo $value['name'] ?></a>
                    <?php endforeach;?>
                <?php endif;?>
    		</div>

    </div>

</div>

<script>
</script>
<script src="https://adomikao.com/wp-content/themes/sparkling/inc/js/customs.min.js" async="" defer=""></script>
<script>(function (T, h, i, n, k, P, a, g, e) {
        g = function () {
            P = h.createElement(i);
            a = h.getElementsByTagName(i)[0];
            P.src = k;
            P.charset = "utf-8";
            P.async = 1;
            a.parentNode.insertBefore(P, a)
        };
        T["ThinkPageWeatherWidgetObject"] = n;
        T[n] || (T[n] = function () {
            (T[n].q = T[n].q || []).push(arguments)
        });
        T[n].l = +new Date();
        if (T.attachEvent) {
            T.attachEvent("onload", g)
        } else {
            T.addEventListener("load", g, false)
        }
    }(window, document, "script", "tpwidget", "//widget.seniverse.com/widget/chameleon.js"))</script>
<script>tpwidget("init", {
        "flavor": "bubble",
        "location": "WTMKQ069CCJ7",
        "geolocation": "enabled",
        "position": "top-left",
        "margin": "10px 10px",
        "language": "zh-chs",
        "unit": "c",
        "theme": "chameleon",
        "uid": "U18B0DF804",
        "hash": "78d059be9e9137cea99bf6381d783124"
    });
    tpwidget("show");</script>
<script>
    var animateButton = function (e) {

        e.preventDefault;
        //reset animation
        e.target.classList.remove('animate');

        e.target.classList.add('animate');
        setTimeout(function () {
            e.target.classList.remove('animate');
        }, 700);
    };

    var classname = document.getElementsByClassName("bubbly-button");

    for (var i = 0; i < classname.length; i++) {
        classname[i].addEventListener('click', animateButton, false);
    }
</script>
<script>
    var c = document.getElementById("c");
    var ctx = c.getContext("2d");
    var cw = c.width = window.innerWidth;
    var ch = c.height = window.innerHeight;
    var cx = cw / 2,
        cy = ch / 2;
    var rad = Math.PI / 180;
    var A = 360 / 5;
    var R = 150;
    var delta = 20;
    var howMany = 50;

    var flowersRy = [];
    var colors = ["hsl(2,70%,90%)", "hsl(2,80%,90%)", "hsl(2,90%,90%)", "hsl(2,100%,90%)", "hsl(2,70%,85%)", "hsl(2,80%,85%)", "hsl(2,90%,85%)", "hsl(2,100%,85%)", "hsl(2,70%,95%)", "hsl(2,80%,95%)", "hsl(2,90%,95%)", "hsl(2,100%,95%)", "hsl(2,100%,100%)"];

    function flower() {
        var maxW = cw > 1200 ? 1250 : cw;
        this.pm = Math.random() < 0.5 ? -1 : 1; //plus or minus
        this.cx = ~~(Math.random() * maxW) + 1;
        this.cy = ~~(Math.random() * ch / 2) + 1;
        this.R = randomIntFromInterval(20, 50);
        this.color = colors[~~(Math.random() * colors.length)];
        this.delta = ~~(Math.random() * 90) + 1;
        this.pm = Math.random() < 0.5 ? -1 : 1; //plus or minus
        this.speedX = 2 + Math.random();
        this.speedY = 1.01 + Math.random() / 50;
        this.drift = this.pm + this.speedX;
        this.fall = this.speedY;
    }

    function init() {

        for (var i = 0; i < howMany; i++) {
            createFlower();

        }
        requestId = window.requestAnimationFrame(updateFlowers);
    }

    function updateFlowers() {
        ctx.clearRect(0, 0, cw, ch);

        for (var i = 0; i < flowersRy.length; i++) {
            if (i % 2 == 0 || i % 3 == 0 || flowersRy[i].cy > 200 || cx < 100) {
                flowersRy[i].cx += flowersRy[i].drift;
                flowersRy[i].cy *= flowersRy[i].fall;
                flowersRy[i].delta += 1;
            } else {
                var pm = Math.random() < 0.5 ? -1 : 1;
                flowersRy[i].cx += pm / 5;
                //flowersRy[i].cy += pm/10;
                flowersRy[i].delta += pm / 10;
            }
            drawFlower(flowersRy[i].cx, flowersRy[i].cy, flowersRy[i].R, flowersRy[i].color, flowersRy[i].delta);
        }

        requestId = window.requestAnimationFrame(updateFlowers);
    }

    function createFlower() {
        var l = flowersRy.length
        flowersRy[l] = new flower();
        drawFlower(flowersRy[l].cx, flowersRy[l].cy, flowersRy[l].R, flowersRy[l].color, flowersRy[l].delta);
    }

    function drawFlower(cx, cy, R, color, delta) {

        ctx.fillStyle = color
        var R1 = R * 1.3;
        for (var a = 0; a < 5; a++) {

            drawPetal(cx, cy, a, R, R1, color, delta)
            drawAnthers(cx, cy, a, R, R1, delta);
        }
    }

    function drawAnthers(cx, cy, a, R, R1, delta) {
        ctx.save();
        ctx.strokeStyle = "#fff";
        ctx.shadowBlur = 5;
        ctx.shadowOffsetX = 1;
        ctx.shadowOffsetY = 1;
        ctx.shadowColor = "#333";

        var ax0 = cx + R / 3 * Math.cos((a * A + 2 * A / 6 + delta) * rad);
        var ay0 = cy + R / 3 * Math.sin((a * A + 2 * A / 6 + delta) * rad);
        var ax1 = cx + R / 2 * Math.cos((a * A + 3 * A / 6 + delta) * rad);
        var ay1 = cy + R / 2 * Math.sin((a * A + 3 * A / 6 + delta) * rad);
        var ax2 = cx + R / 3 * Math.cos((a * A + 4 * A / 6 + delta) * rad);
        var ay2 = cy + R / 3 * Math.sin((a * A + 4 * A / 6 + delta) * rad);

        if (R > 40) {
            var ary = [{
                x: ax0,
                y: ay0
            }, {
                x: ax1,
                y: ay1
            }, {
                x: ax2,
                y: ay2
            }]; // anthers array
        } else {
            var ary = [{
                x: ax1,
                y: ay1
            }];
        }

        ctx.beginPath();
        for (var i = 0; i < ary.length; i++) {
            ctx.moveTo(cx, cy);
            ctx.lineTo(ary[i].x, ary[i].y);
            ctx.arc(ary[i].x, ary[i].y, 2, 0, 2 * Math.PI)
        }
        ctx.stroke();
        ctx.restore();
    }

    function drawPetal(cx, cy, a, R, R1, color, delta) {
        ctx.strokeStyle = "#d9d9d9";
        ctx.fillStyle = color;

        var x0 = cx + R * Math.cos((a * A + delta) * rad);
        var y0 = cy + R * Math.sin((a * A + delta) * rad);

        var x1 = cx + R1 * Math.cos((a * A + 2 * A / 6 + delta) * rad);
        var y1 = cy + R1 * Math.sin((a * A + 2 * A / 6 + delta) * rad);

        var x2 = cx + R * Math.cos((a * A + 3 * A / 6 + delta) * rad);
        var y2 = cy + R * Math.sin((a * A + 3 * A / 6 + delta) * rad);

        var x3 = cx + R1 * Math.cos((a * A + 4 * A / 6 + delta) * rad);
        var y3 = cy + R1 * Math.sin((a * A + 4 * A / 6 + delta) * rad);

        var x4 = cx + R * Math.cos((a * A + A + delta) * rad);
        var y4 = cy + R * Math.sin((a * A + A + delta) * rad);

        // petal
        ctx.beginPath();
        ctx.moveTo(cx, cy);
        ctx.quadraticCurveTo(x0, y0, x1, y1);
        ctx.lineTo(x2, y2);
        ctx.lineTo(x3, y3);
        ctx.quadraticCurveTo(x4, y4, cx, cy);
        ctx.fill();
        ctx.stroke();
    }

    function randomIntFromInterval(mn, mx) {
        return ~~(Math.random() * (mx - mn + 1) + mn);
    }

    window.addEventListener("load", init, false);
</script>
</body>
</html>