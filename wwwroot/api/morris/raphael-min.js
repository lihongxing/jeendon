var r = null;
window.PR_SHOULD_USE_CONTINUATION = !0, function () {
    function e(e) {
        function t(e) {
            var t = e.charCodeAt(0);
            if (92 !== t)return t;
            var i = e.charAt(1);
            return (t = u[i]) ? t : i >= "0" && "7" >= i ? parseInt(e.substring(1), 8) : "u" === i || "x" === i ? parseInt(e.substring(2), 16) : e.charCodeAt(1)
        }

        function i(e) {
            return 32 > e ? (16 > e ? "\\x0" : "\\x") + e.toString(16) : (e = String.fromCharCode(e), "\\" === e || "-" === e || "]" === e || "^" === e ? "\\" + e : e)
        }

        function n(e) {
            var n = e.substring(1, e.length - 1).match(/\\u[\dA-Fa-f]{4}|\\x[\dA-Fa-f]{2}|\\[0-3][0-7]{0,2}|\\[0-7]{1,2}|\\[\S\s]|[^\\]/g),
                e = [], r = "^" === n[0], s = ["["];
            r && s.push("^");
            for (var r = r ? 1 : 0, o = n.length; o > r; ++r) {
                var a = n[r];
                if (/\\[bdsw]/i.test(a)) s.push(a); else {
                    var l, a = t(a);
                    o > r + 2 && "-" === n[r + 1] ? (l = t(n[r + 2]), r += 2) : l = a, e.push([a, l]), 65 > l || a > 122 || (65 > l || a > 90 || e.push([32 | Math.max(65, a), 32 | Math.min(l, 90)]), 97 > l || a > 122 || e.push([-33 & Math.max(97, a), -33 & Math.min(l, 122)]))
                }
            }
            for (e.sort(function (e, t) {
                return e[0] - t[0] || t[1] - e[1]
            }), n = [], o = [], r = 0; e.length > r; ++r)a = e[r], a[0] <= o[1] + 1 ? o[1] = Math.max(o[1], a[1]) : n.push(o = a);
            for (r = 0; n.length > r; ++r)a = n[r], s.push(i(a[0])), a[1] > a[0] && (a[1] + 1 > a[0] && s.push("-"), s.push(i(a[1])));
            return s.push("]"), s.join("")
        }

        function r(e) {
            for (var t = e.source.match(/\[(?:[^\\\]]|\\[\S\s])*]|\\u[\dA-Fa-f]{4}|\\x[\dA-Fa-f]{2}|\\\d+|\\[^\dux]|\(\?[!:=]|[()^]|[^()[\\^]+/g), r = t.length, a = [], l = 0, h = 0; r > l; ++l) {
                var c = t[l];
                "(" === c ? ++h : "\\" === c.charAt(0) && (c = +c.substring(1)) && (h >= c ? a[c] = -1 : t[l] = i(c))
            }
            for (l = 1; a.length > l; ++l)-1 === a[l] && (a[l] = ++s);
            for (h = l = 0; r > l; ++l)c = t[l], "(" === c ? (++h, a[h] || (t[l] = "(?:")) : "\\" === c.charAt(0) && (c = +c.substring(1)) && h >= c && (t[l] = "\\" + a[c]);
            for (l = 0; r > l; ++l)"^" === t[l] && "^" !== t[l + 1] && (t[l] = "");
            if (e.ignoreCase && o)for (l = 0; r > l; ++l)c = t[l], e = c.charAt(0), c.length >= 2 && "[" === e ? t[l] = n(c) : "\\" !== e && (t[l] = c.replace(/[A-Za-z]/g, function (e) {
                    return e = e.charCodeAt(0), "[" + String.fromCharCode(-33 & e, 32 | e) + "]"
                }));
            return t.join("")
        }

        for (var s = 0, o = !1, a = !1, l = 0, h = e.length; h > l; ++l) {
            var c = e[l];
            if (c.ignoreCase) a = !0; else if (/[a-z]/i.test(c.source.replace(/\\u[\da-f]{4}|\\x[\da-f]{2}|\\[^UXux]/gi, ""))) {
                o = !0, a = !1;
                break
            }
        }
        for (var u = {b: 8, t: 9, n: 10, v: 11, f: 12, r: 13}, d = [], l = 0, h = e.length; h > l; ++l) {
            if (c = e[l], c.global || c.multiline)throw Error("" + c);
            d.push("(?:" + r(c) + ")")
        }
        return RegExp(d.join("|"), a ? "gi" : "g")
    }

    function t(e, t) {
        function i(e) {
            switch (e.nodeType) {
                case 1:
                    if (n.test(e.className))break;
                    for (var l = e.firstChild; l; l = l.nextSibling)i(l);
                    l = e.nodeName.toLowerCase(), ("br" === l || "li" === l) && (r[a] = "\n", o[a << 1] = s++, o[1 | a++ << 1] = e);
                    break;
                case 3:
                case 4:
                    l = e.nodeValue, l.length && (l = t ? l.replace(/\r\n?/g, "\n") : l.replace(/[\t\n\r ]+/g, " "), r[a] = l, o[a << 1] = s, s += l.length, o[1 | a++ << 1] = e)
            }
        }

        var n = /(?:^|\s)nocode(?:\s|$)/, r = [], s = 0, o = [], a = 0;
        return i(e), {a: r.join("").replace(/\n$/, ""), d: o}
    }

    function i(e, t, i, n) {
        t && (e = {a: t, e: e}, i(e), n.push.apply(n, e.g))
    }

    function n(t, n) {
        function s(e) {
            for (var t = e.e, r = [t, "pln"], c = 0, u = e.a.match(o) || [], d = {}, p = 0, f = u.length; f > p; ++p) {
                var m, g = u[p], y = d[g], v = void 0;
                if ("string" == typeof y) m = !1; else {
                    var b = a[g.charAt(0)];
                    if (b) v = g.match(b[1]), y = b[0]; else {
                        for (m = 0; h > m; ++m)if (b = n[m], v = g.match(b[1])) {
                            y = b[0];
                            break
                        }
                        v || (y = "pln")
                    }
                    !(m = y.length >= 5 && "lang-" === y.substring(0, 5)) || v && "string" == typeof v[1] || (m = !1, y = "src"), m || (d[g] = y)
                }
                if (b = c, c += g.length, m) {
                    m = v[1];
                    var L = g.indexOf(m), x = L + m.length;
                    v[2] && (x = g.length - v[2].length, L = x - m.length), y = y.substring(5), i(t + b, g.substring(0, L), s, r), i(t + b + L, m, l(y, m), r), i(t + b + x, g.substring(x), s, r)
                } else r.push(t + b, y)
            }
            e.g = r
        }

        var o, a = {};
        (function () {
            for (var i = t.concat(n), s = [], l = {}, h = 0, c = i.length; c > h; ++h) {
                var u = i[h], d = u[3];
                if (d)for (var p = d.length; --p >= 0;)a[d.charAt(p)] = u;
                u = u[1], d = "" + u, l.hasOwnProperty(d) || (s.push(u), l[d] = r)
            }
            s.push(/[\S\s]/), o = e(s)
        })();
        var h = n.length;
        return s
    }

    function s(e) {
        var t = [], i = [];
        e.tripleQuotedStrings ? t.push(["str", /^(?:'''(?:[^'\\]|\\[\S\s]|''?(?=[^']))*(?:'''|$)|"""(?:[^"\\]|\\[\S\s]|""?(?=[^"]))*(?:"""|$)|'(?:[^'\\]|\\[\S\s])*(?:'|$)|"(?:[^"\\]|\\[\S\s])*(?:"|$))/, r, "'\""]) : e.multiLineStrings ? t.push(["str", /^(?:'(?:[^'\\]|\\[\S\s])*(?:'|$)|"(?:[^"\\]|\\[\S\s])*(?:"|$)|`(?:[^\\`]|\\[\S\s])*(?:`|$))/, r, "'\"`"]) : t.push(["str", /^(?:'(?:[^\n\r'\\]|\\.)*(?:'|$)|"(?:[^\n\r"\\]|\\.)*(?:"|$))/, r, "\"'"]), e.verbatimStrings && i.push(["str", /^@"(?:[^"]|"")*(?:"|$)/, r]);
        var s = e.hashComments;
        return s && (e.cStyleComments ? (s > 1 ? t.push(["com", /^#(?:##(?:[^#]|#(?!##))*(?:###|$)|.*)/, r, "#"]) : t.push(["com", /^#(?:(?:define|e(?:l|nd)if|else|error|ifn?def|include|line|pragma|undef|warning)\b|[^\n\r]*)/, r, "#"]), i.push(["str", /^<(?:(?:(?:\.\.\/)*|\/?)(?:[\w-]+(?:\/[\w-]+)+)?[\w-]+\.h(?:h|pp|\+\+)?|[a-z]\w*)>/, r])) : t.push(["com", /^#[^\n\r]*/, r, "#"])), e.cStyleComments && (i.push(["com", /^\/\/[^\n\r]*/, r]), i.push(["com", /^\/\*[\S\s]*?(?:\*\/|$)/, r])), e.regexLiterals && i.push(["lang-regex", /^(?:^^\.?|[+-]|[!=]={0,2}|#|%=?|&&?=?|\(|\*=?|[+-]=|->|\/=?|::?|<<?=?|>{1,3}=?|[,;?@[{~]|\^\^?=?|\|\|?=?|break|case|continue|delete|do|else|finally|instanceof|return|throw|try|typeof)\s*(\/(?=[^*/])(?:[^/[\\]|\\[\S\s]|\[(?:[^\\\]]|\\[\S\s])*(?:]|$))+\/)/]), (s = e.types) && i.push(["typ", s]), e = ("" + e.keywords).replace(/^ | $/g, ""), e.length && i.push(["kwd", RegExp("^(?:" + e.replace(/[\s,]+/g, "|") + ")\\b"), r]), t.push(["pln", /^\s+/, r, " \r\n	 "]), i.push(["lit", /^@[$_a-z][\w$@]*/i, r], ["typ", /^(?:[@_]?[A-Z]+[a-z][\w$@]*|\w+_t\b)/, r], ["pln", /^[$_a-z][\w$@]*/i, r], ["lit", /^(?:0x[\da-f]+|(?:\d(?:_\d+)*\d*(?:\.\d*)?|\.\d\+)(?:e[+-]?\d+)?)[a-z]*/i, r, "0123456789"], ["pln", /^\\[\S\s]?/, r], ["pun", /^.[^\s\w"$'./@\\`]*/, r]), n(t, i)
    }

    function o(e, t, i) {
        function n(e) {
            switch (e.nodeType) {
                case 1:
                    if (s.test(e.className))break;
                    if ("br" === e.nodeName) r(e), e.parentNode && e.parentNode.removeChild(e); else for (e = e.firstChild; e; e = e.nextSibling)n(e);
                    break;
                case 3:
                case 4:
                    if (i) {
                        var t = e.nodeValue, l = t.match(o);
                        if (l) {
                            var h = t.substring(0, l.index);
                            e.nodeValue = h, (t = t.substring(l.index + l[0].length)) && e.parentNode.insertBefore(a.createTextNode(t), e.nextSibling), r(e), h || e.parentNode.removeChild(e)
                        }
                    }
            }
        }

        function r(e) {
            function t(e, i) {
                var n = i ? e.cloneNode(!1) : e, r = e.parentNode;
                if (r) {
                    var r = t(r, 1), s = e.nextSibling;
                    r.appendChild(n);
                    for (var o = s; o; o = s)s = o.nextSibling, r.appendChild(o)
                }
                return n
            }

            for (; !e.nextSibling;)if (e = e.parentNode, !e)return;
            for (var i, e = t(e.nextSibling, 0); (i = e.parentNode) && 1 === i.nodeType;)e = i;
            h.push(e)
        }

        for (var s = /(?:^|\s)nocode(?:\s|$)/, o = /\r\n?|\n/, a = e.ownerDocument, l = a.createElement("li"); e.firstChild;)l.appendChild(e.firstChild);
        for (var h = [l], c = 0; h.length > c; ++c)n(h[c]);
        t === (0 | t) && h[0].setAttribute("value", t);
        var u = a.createElement("ol");
        u.className = "linenums";
        for (var t = Math.max(0, 0 | t - 1) || 0, c = 0, d = h.length; d > c; ++c)l = h[c], l.className = "L" + (c + t) % 10, l.firstChild || l.appendChild(a.createTextNode(" ")), u.appendChild(l);
        e.appendChild(u)
    }

    function a(e, t) {
        for (var i = t.length; --i >= 0;) {
            var n = t[i];
            x.hasOwnProperty(n) ? c.console && console.warn("cannot override language handler %s", n) : x[n] = e
        }
    }

    function l(e, t) {
        return e && x.hasOwnProperty(e) || (e = /^\s*</.test(t) ? "default-markup" : "default-code"), x[e]
    }

    function h(e) {
        var i = e.h;
        try {
            var n = t(e.c, e.i), r = n.a;
            e.a = r, e.d = n.d, e.e = 0, l(i, r)(e);
            var s = /\bMSIE\s(\d+)/.exec(navigator.userAgent), s = s && 8 >= +s[1], i = /\n/g, o = e.a, a = o.length,
                n = 0, h = e.d, u = h.length, r = 0, d = e.g, p = d.length, f = 0;
            d[p] = a;
            var m, g;
            for (g = m = 0; p > g;)d[g] !== d[g + 2] ? (d[m++] = d[g++], d[m++] = d[g++]) : g += 2;
            for (p = m, g = m = 0; p > g;) {
                for (var y = d[g], v = d[g + 1], b = g + 2; p >= b + 2 && d[b + 1] === v;)b += 2;
                d[m++] = y, d[m++] = v, g = b
            }
            d.length = m;
            var L, x = e.c;
            x && (L = x.style.display, x.style.display = "none");
            try {
                for (; u > r;) {
                    var C, w = h[r + 2] || a, S = d[f + 2] || a, b = Math.min(w, S), O = h[r + 1];
                    if (1 !== O.nodeType && (C = o.substring(n, b))) {
                        s && (C = C.replace(i, "\r")), O.nodeValue = C;
                        var _ = O.ownerDocument, E = _.createElement("span");
                        E.className = d[f + 1];
                        var T = O.parentNode;
                        T.replaceChild(E, O), E.appendChild(O), w > n && (h[r + 1] = O = _.createTextNode(o.substring(b, w)), T.insertBefore(O, E.nextSibling))
                    }
                    n = b, n >= w && (r += 2), n >= S && (f += 2)
                }
            } finally {
                x && (x.style.display = L)
            }
        } catch (k) {
            c.console && console.log(k && k.stack ? k.stack : k)
        }
    }

    var c = window, u = ["break,continue,do,else,for,if,return,while"],
        d = [[u, "auto,case,char,const,default,double,enum,extern,float,goto,int,long,register,short,signed,sizeof,static,struct,switch,typedef,union,unsigned,void,volatile"], "catch,class,delete,false,import,new,operator,private,protected,public,this,throw,true,try,typeof"],
        p = [d, "alignof,align_union,asm,axiom,bool,concept,concept_map,const_cast,constexpr,decltype,dynamic_cast,explicit,export,friend,inline,late_check,mutable,namespace,nullptr,reinterpret_cast,static_assert,static_cast,template,typeid,typename,using,virtual,where"],
        f = [d, "abstract,boolean,byte,extends,final,finally,implements,import,instanceof,null,native,package,strictfp,super,synchronized,throws,transient"],
        m = [f, "as,base,by,checked,decimal,delegate,descending,dynamic,event,fixed,foreach,from,group,implicit,in,interface,internal,into,is,let,lock,object,out,override,orderby,params,partial,readonly,ref,sbyte,sealed,stackalloc,string,select,uint,ulong,unchecked,unsafe,ushort,var,virtual,where"],
        d = [d, "debugger,eval,export,function,get,null,set,undefined,var,with,Infinity,NaN"],
        g = [u, "and,as,assert,class,def,del,elif,except,exec,finally,from,global,import,in,is,lambda,nonlocal,not,or,pass,print,raise,try,with,yield,False,True,None"],
        y = [u, "alias,and,begin,case,class,def,defined,elsif,end,ensure,false,in,module,next,nil,not,or,redo,rescue,retry,self,super,then,true,undef,unless,until,when,yield,BEGIN,END"],
        u = [u, "case,done,elif,esac,eval,fi,function,in,local,set,then,until"],
        v = /^(DIR|FILE|vector|(de|priority_)?queue|list|stack|(const_)?iterator|(multi)?(set|map)|bitset|u?(int|float)\d*)\b/,
        b = /\S/, L = s({
            keywords: [p, m, d, "caller,delete,die,do,dump,elsif,eval,exit,foreach,for,goto,if,import,last,local,my,next,no,our,print,package,redo,require,sub,undef,unless,until,use,wantarray,while,BEGIN,END" + g, y, u],
            hashComments: !0,
            cStyleComments: !0,
            multiLineStrings: !0,
            regexLiterals: !0
        }), x = {};
    a(L, ["default-code"]), a(n([], [["pln", /^[^<?]+/], ["dec", /^<!\w[^>]*(?:>|$)/], ["com", /^<\!--[\S\s]*?(?:--\>|$)/], ["lang-", /^<\?([\S\s]+?)(?:\?>|$)/], ["lang-", /^<%([\S\s]+?)(?:%>|$)/], ["pun", /^(?:<[%?]|[%?]>)/], ["lang-", /^<xmp\b[^>]*>([\S\s]+?)<\/xmp\b[^>]*>/i], ["lang-js", /^<script\b[^>]*>([\S\s]*?)(<\/script\b[^>]*>)/i], ["lang-css", /^<style\b[^>]*>([\S\s]*?)(<\/style\b[^>]*>)/i], ["lang-in.tag", /^(<\/?[a-z][^<>]*>)/i]]), ["default-markup", "htm", "html", "mxml", "xhtml", "xml", "xsl"]), a(n([["pln", /^\s+/, r, " 	\r\n"], ["atv", /^(?:"[^"]*"?|'[^']*'?)/, r, "\"'"]], [["tag", /^^<\/?[a-z](?:[\w-.:]*\w)?|\/?>$/i], ["atn", /^(?!style[\s=]|on)[a-z](?:[\w:-]*\w)?/i], ["lang-uq.val", /^=\s*([^\s"'>]*(?:[^\s"'/>]|\/(?=\s)))/], ["pun", /^[/<->]+/], ["lang-js", /^on\w+\s*=\s*"([^"]+)"/i], ["lang-js", /^on\w+\s*=\s*'([^']+)'/i], ["lang-js", /^on\w+\s*=\s*([^\s"'>]+)/i], ["lang-css", /^style\s*=\s*"([^"]+)"/i], ["lang-css", /^style\s*=\s*'([^']+)'/i], ["lang-css", /^style\s*=\s*([^\s"'>]+)/i]]), ["in.tag"]), a(n([], [["atv", /^[\S\s]+/]]), ["uq.val"]), a(s({
        keywords: p,
        hashComments: !0,
        cStyleComments: !0,
        types: v
    }), ["c", "cc", "cpp", "cxx", "cyc", "m"]), a(s({keywords: "null,true,false"}), ["json"]), a(s({
        keywords: m,
        hashComments: !0,
        cStyleComments: !0,
        verbatimStrings: !0,
        types: v
    }), ["cs"]), a(s({keywords: f, cStyleComments: !0}), ["java"]), a(s({
        keywords: u,
        hashComments: !0,
        multiLineStrings: !0
    }), ["bsh", "csh", "sh"]), a(s({
        keywords: g,
        hashComments: !0,
        multiLineStrings: !0,
        tripleQuotedStrings: !0
    }), ["cv", "py"]), a(s({
        keywords: "caller,delete,die,do,dump,elsif,eval,exit,foreach,for,goto,if,import,last,local,my,next,no,our,print,package,redo,require,sub,undef,unless,until,use,wantarray,while,BEGIN,END",
        hashComments: !0,
        multiLineStrings: !0,
        regexLiterals: !0
    }), ["perl", "pl", "pm"]), a(s({
        keywords: y,
        hashComments: !0,
        multiLineStrings: !0,
        regexLiterals: !0
    }), ["rb"]), a(s({
        keywords: d,
        cStyleComments: !0,
        regexLiterals: !0
    }), ["js"]), a(s({
        keywords: "all,and,by,catch,class,else,extends,false,finally,for,if,in,is,isnt,loop,new,no,not,null,of,off,on,or,return,super,then,throw,true,try,unless,until,when,while,yes",
        hashComments: 3,
        cStyleComments: !0,
        multilineStrings: !0,
        tripleQuotedStrings: !0,
        regexLiterals: !0
    }), ["coffee"]), a(n([], [["str", /^[\S\s]+/]]), ["regex"]);
    var C = c.PR = {
        createSimpleLexer: n,
        registerLangHandler: a,
        sourceDecorator: s,
        PR_ATTRIB_NAME: "atn",
        PR_ATTRIB_VALUE: "atv",
        PR_COMMENT: "com",
        PR_DECLARATION: "dec",
        PR_KEYWORD: "kwd",
        PR_LITERAL: "lit",
        PR_NOCODE: "nocode",
        PR_PLAIN: "pln",
        PR_PUNCTUATION: "pun",
        PR_SOURCE: "src",
        PR_STRING: "str",
        PR_TAG: "tag",
        PR_TYPE: "typ",
        prettyPrintOne: c.prettyPrintOne = function (e, t, i) {
            var n = document.createElement("pre");
            return n.innerHTML = e, i && o(n, i, !0), h({h: t, j: i, c: n, i: 1}), n.innerHTML
        },
        prettyPrint: c.prettyPrint = function (e) {
            function t() {
                for (var i, s = c.PR_SHOULD_USE_CONTINUATION ? u.now() + 250 : 1 / 0; n.length > p && s > u.now(); p++) {
                    var a = n[p], l = a.className;
                    if (m.test(l) && !g.test(l)) {
                        for (var x = !1, C = a.parentNode; C; C = C.parentNode)if (L.test(C.tagName) && C.className && m.test(C.className)) {
                            x = !0;
                            break
                        }
                        if (!x) {
                            a.className += " prettyprinted";
                            var w, l = l.match(f);
                            if (x = !l) {
                                for (var x = a, C = void 0, S = x.firstChild; S; S = S.nextSibling)var O = S.nodeType, C = 1 === O ? C ? x : S : 3 === O ? b.test(S.nodeValue) ? x : C : C;
                                x = (w = C === x ? void 0 : C) && v.test(w.tagName)
                            }
                            x && (l = w.className.match(f)), l && (l = l[1]), i = y.test(a.tagName) ? 1 : (x = (x = a.currentStyle) ? x.whiteSpace : document.defaultView && document.defaultView.getComputedStyle ? document.defaultView.getComputedStyle(a, r).getPropertyValue("white-space") : 0) && "pre" === x.substring(0, 3), x = i, (C = (C = a.className.match(/\blinenums\b(?::(\d+))?/)) ? C[1] && C[1].length ? +C[1] : !0 : !1) && o(a, C, x), d = {
                                h: l,
                                c: a,
                                j: C,
                                i: x
                            }, h(d)
                        }
                    }
                }
                n.length > p ? setTimeout(t, 250) : e && e()
            }

            for (var i = [document.getElementsByTagName("pre"), document.getElementsByTagName("code"), document.getElementsByTagName("xmp")], n = [], s = 0; i.length > s; ++s)for (var a = 0, l = i[s].length; l > a; ++a)n.push(i[s][a]);
            var i = r, u = Date;
            u.now || (u = {
                now: function () {
                    return +new Date
                }
            });
            var d, p = 0, f = /\blang(?:uage)?-([\w.]+)(?!\S)/, m = /\bprettyprint\b/, g = /\bprettyprinted\b/,
                y = /pre|xmp/i, v = /^code$/i, L = /^(?:pre|code|xmp)$/i;
            t()
        }
    };
    "function" == typeof define && define.amd && define("google-code-prettify", [], function () {
        return C
    })
}();