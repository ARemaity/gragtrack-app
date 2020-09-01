var FlotchartsDemo = function() {
    var t = function() {
        function t() {
            return Math.floor(21 * Math.random()) + 20
        }
        var e = [
                [1, t()],
                [2, t()],
                [3, 2 + t()],
                [4, 3 + t()],
                [5, 5 + t()],
                [6, 10 + t()],
                [7, 15 + t()],
                [8, 20 + t()],
                [9, 25 + t()],
                [10, 30 + t()],
                [11, 35 + t()],
                [12, 25 + t()],
                [13, 15 + t()],
                [14, 20 + t()],
                [15, 45 + t()],
                [16, 50 + t()],
                [17, 65 + t()],
                [18, 70 + t()],
                [19, 85 + t()],
                [20, 80 + t()],
                [21, 75 + t()],
                [22, 80 + t()],
                [23, 75 + t()],
                [24, 70 + t()],
                [25, 65 + t()],
                [26, 75 + t()],
                [27, 80 + t()],
                [28, 85 + t()],
                [29, 90 + t()],
                [30, 95 + t()]
            ],
            o = [
                [1, t() - 5],
                [2, t() - 5],
                [3, t() - 5],
                [4, 6 + t()],
                [5, 5 + t()],
                [6, 20 + t()],
                [7, 25 + t()],
                [8, 36 + t()],
                [9, 26 + t()],
                [10, 38 + t()],
                [11, 39 + t()],
                [12, 50 + t()],
                [13, 51 + t()],
                [14, 12 + t()],
                [15, 13 + t()],
                [16, 14 + t()],
                [17, 15 + t()],
                [18, 15 + t()],
                [19, 16 + t()],
                [20, 17 + t()],
                [21, 18 + t()],
                [22, 19 + t()],
                [23, 20 + t()],
                [24, 21 + t()],
                [25, 14 + t()],
                [26, 24 + t()],
                [27, 25 + t()],
                [28, 26 + t()],
                [29, 27 + t()],
                [30, 31 + t()]
            ];
    };
    return {
        init: function() {
                t(),
                function() {
                    var t = [],
                        e = 250;

                    function o() {
                        for (t.length > 0 && (t = t.slice(1)); t.length < e;) {
                            var o = (t.length > 0 ? t[t.length - 1] : 50) + 10 * Math.random() - 5;
                            o < 0 && (o = 0), o > 100 && (o = 100), t.push(o)
                        }
                        for (var a = [], i = 0; i < t.length; ++i) a.push([i, t[i]]);
                        return a
                    }
                    var a = 30,
                        i = $.plot($("#m_flotcharts_liveusers"), [o()], {
                            series: {
                                shadowSize: 1
                            },
                            lines: {
                                show: !0,
                                lineWidth: .5,
                                fill: !0,
                                fillColor: {
                                    colors: [{
                                        opacity: .1
                                    }, {
                                        opacity: 1
                                    }]
                                }
                            },
                            yaxis: {
                                min: 0,
                                max: 100,
                                tickColor: "#eee",
                                tickFormatter: function(t) {
                                    return t + ""
                                }
                            },
                            xaxis: {
                                show: !1
                            },
                            colors: ["#8950fc"],
                            grid: {
                                tickColor: "#eee",
                                borderWidth: 0
                            }
                        });
                    ! function t() {
                        i.setData([o()]), i.draw(), setTimeout(t, a)
                    }()
                }()
        }
    }
}();
jQuery(document).ready(function() {
    FlotchartsDemo.init()
});