//屏幕雪花
!function() {
  function t() {
      e.width = window.innerWidth,
          // e.width = 200px;
          e.height = window.innerHeight,
              // e.height = 200px;
          o = Math.round(window.innerWidth * window.innerHeight / 1e4)
  }
  function n() {
      var t = window.innerWidth,
          d = window.innerHeight,
          c = e.getContext("2d");
      c.clearRect(0, 0, t, d),
          c.fillStyle = "rgba(255, 255, 255, 0.7)",
          c.beginPath(),
          a += .01;
      for (var u = 0; o > u; u++) {
          var l = r[u];
          c.moveTo(l.x, l.y),
              c.arc(l.x, l.y, l.radius, 0, 2 * Math.PI, !0),
              l.y += Math.cos(a) + l.radius / 2,
              l.x += Math.sin(a * l.direction),
          (l.x > t + 5 || -5 > l.x || l.y > d) && (u % 3 > 0 ? (r[u].x = Math.random() * t, r[u].y = -10) : Math.sin(a * l.direction) > 0 ? (r[u].x = -5, r[u].y = Math.random() * d) : (r[u].x = t + 5, r[u].y = Math.random() * d))
      }
      c.fill(),
          i(n)
  }
  var e = document.createElement("canvas"),
      i = requestAnimationFrame || msRequestAnimationFrame ||
          function(t) {
              setTimeout(t, 16)
          },
      a = 0,
      o = 0,
      r = [];
  t(),
      e.className = "snow",
      document.body.appendChild(e);
  for (var d = 0; o > d; d++) r.push({
      x: Math.random() * window.innerWidth,
      y: Math.random() * window.innerHeight,
      radius: 4 * Math.random() + 1,
      direction: 2 * Math.random() - .5
  });
  addEventListener("resize", t),
      i(n)
} ()