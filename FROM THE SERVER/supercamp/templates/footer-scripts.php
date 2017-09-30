<script>/*<![CDATA[*/
    (function (w, a, b, d, s) {
        w[a] = w[a] || {};
        w[a][b] = w[a][b] || {
                q: [], track: function (r, e, t) {
                    this.q.push({r: r, e: e, t: t || +new Date});
                }
            };
        var e = d.createElement(s);
        var f = d.getElementsByTagName(s)[0];
        e.async = 1;
        e.src = '//marketing.quantumlearning.com/cdnr/92/acton/bn/tracker/16721';
        f.parentNode.insertBefore(e, f);
    })(window, 'ActOn', 'Beacon', document, 'script');
    ActOn.Beacon.track();
    /*]]>*/</script>


<!-- new Google call tracking for 2016 -->
<script type="text/javascript">// <![CDATA[
    (function (a, e, c, f, g, b, d) {
        var h = {ak: "937954316", cl: "79NYCJ2_6WEQjJigvwM"};
        a[c] = a[c] || function () {
                (a[c].q = a[c].q || []).push(arguments)
            };
        a[f] || (a[f] = h.ak);
        b = e.createElement(g);
        b.async = 1;
        b.src = "https://www.gstatic.com/wcm/loader.js";
        d = e.getElementsByTagName(g)[0];
        d.parentNode.insertBefore(b, d);
        a._googWcmGet = function (b, d, e) {
            a[c](2, b, h, d, null, new Date, e)
        }
    })(window, document, "_googWcmImpl", "_googWcmAk", "script");
    var callback = function (formatted_number, unformatted_number) { // formatted_number: number to display, in same formatting as number
        // number passed to _googWcmGet(). e.g // '1-800-444-5555' in this case // unformatted_number: number to display without any formatting // formatting. e.g. '18004445555'. This is the number // that will be used in the &ldquo;tel:&rdquo; link'18004445555'
        //some wordpress elements only allow us to set the id so we check for id
        var e = document.getElementById("number_link");
        if (e != null) if (e != undefined) {
            e.href = "tel:" + unformatted_number;
            e.innerHTML = "";
            e.appendChild(document.createTextNode(formatted_number));
        }
        var e2 = document.getElementById("phone_number_link_2");
        if (e2 != null) if (e2 != undefined) {
            e2.href = "tel:" + unformatted_number;
            e2.innerHTML = "";
            e2.appendChild(document.createTextNode(formatted_number));
        }
        //some wordpress elements  allow us to set the class so we check the class
        var scPhoneButtons = document.getElementsByClassName("sc800number");
        var i;
        for (i = 0; i < scPhoneButtons.length; i++) {
            scPhoneButtons[i].href = "tel:" + unformatted_number;
            scPhoneButtons[i].innerHTML = "";
            scPhoneButtons[i].appendChild(document.createTextNode(formatted_number));
        }
    };
    // ]]></script>
<script type="text/javascript">// <![CDATA[
    $ = jQuery.noConflict();
    $(document).ready(function () {
        _googWcmGet(callback, '(800)228-5327');
    });
    //$(document).ready(function(){ callback('800-228-5327','8002285327'); });
    // ]]>
</script>
