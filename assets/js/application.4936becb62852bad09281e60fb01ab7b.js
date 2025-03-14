/*! For license information please see application.js.LICENSE.txt */
(() => {
    var e, t = {
            357: () => {
                ! function(e) {
                    "use strict";
                    e.ajaxSetup({
                        headers: {
                            "X-CSRF-TOKEN": e('meta[name="csrf-token"]').attr("content")
                        }
                    });
                    var t = e("#contactForm"),
                        o = e("#sendMessage");
                    t.length && o.on("click", (function(n) {
                        n.preventDefault();
                        var a = t.serializeArray(),
                            i = getConfig.baseURL + "/contact-us/send";
                        o.prop("disabled", !0), e.ajax({
                            url: i,
                            type: "POST",
                            data: a,
                            dataType: "json",
                            beforeSend: function() {
                                JsLoadingOverlay.show()
                            }
                        }).done((function(n) {
                            JsLoadingOverlay.hide(), o.prop("disabled", !1), e.isEmptyObject(n.error) ? (t.trigger("reset"), window.grecaptcha && grecaptcha.reset(), toastr.success(n.success)) : toastr.error(n.error)
                        })).fail((function(e, t, o) {
                            JsLoadingOverlay.hide(), toastr.error(o)
                        }))
                    }));
                    var n = e(".download-file");
                    n.length && n.on("click", (function(t) {
                        t.preventDefault();
                        var o = e(this).data("id"),
                            n = getConfig.baseURL + "/" + o + "/download/create";
                        e.ajax({
                            url: n,
                            type: "POST",
                            dataType: "json",
                            success: function(t) {
                                e.isEmptyObject(t.error) ? window.location = t.download_link : toastr.error(t.error)
                            }
                        })
                    }))
                }(jQuery)
            },
            124: (e, t, o) => {
                o(229), o(357), o(219), o(291), o(972), o(973)
            },
            972: () => {
                var e = $("#uploads-chart");
                if (e.length) {
                    var t = {
                        initUploads: function() {
                            this.uploadsChartsData()
                        },
                        uploadsChartsData: function() {
                            var e = getConfig.baseURL + "/user/dashboard/charts/uploads";
                            $.ajax({
                                method: "GET",
                                url: e
                            }).done((function(e) {
                                t.createUploadsCharts(e)
                            }))
                        },
                        createUploadsCharts: function(t) {
                            var o = t.suggestedMax,
                                n = t.uploadsChartLabels,
                                a = t.uploadsChartData;
                                
                            window.Chart && new Chart(e, {
                                type: "bar",
                                data: {
                                    labels: n,
                                    datasets: [{
                                        label: "Uploads",
                                        data: a,
                                        fill: !0,
                                        tension: .3,
                                        backgroundColor: getConfig.primaryColor,
                                        borderColor: getConfig.primaryColor
                                    }]
                                },
                                options: {
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    plugins: {
                                        legend: {
                                            display: !1
                                        }
                                    },
                                    scales: {
                                        y: {
                                            suggestedMax: o
                                        }
                                    }
                                }
                            }).render()
                        }
                    };
                    t.initUploads()
                }
            },
            973: () => {
                var e = $("#views-chart");
                if (e.length) {
                    var t = {
                        initUploads: function() {
                            this.uploadsChartsData()
                        },
                        uploadsChartsData: function() {
                            var e = getConfig.baseURL + "/user/dashboard/charts/views";
                            $.ajax({
                                method: "GET",
                                url: e
                            }).done((function(e) {
                                t.createUploadsCharts(e)
                            }))
                        },
                        createUploadsCharts: function(t) {
                            var o = t.suggestedMax,
                                n = t.uploadsChartLabels,
                                a = t.uploadsChartData;
                                
                            window.Chart && new Chart(e, {
                                type: "bar",
                                data: {
                                    labels: n,
                                    datasets: [{
                                        label: "Views",
                                        data: a,
                                        fill: !0,
                                        tension: .3,
                                        backgroundColor: getConfig.primaryColor,
                                        borderColor: getConfig.primaryColor
                                    }]
                                },
                                options: {
                                    responsive: !0,
                                    maintainAspectRatio: !1,
                                    plugins: {
                                        legend: {
                                            display: !1
                                        }
                                    },
                                    scales: {
                                        y: {
                                            suggestedMax: o
                                        }
                                    }
                                }
                            }).render()
                        }
                    };
                    t.initUploads()
                }
            },
            291: () => {
                ! function(e) {
                    "use strict";
                    var t = e(".uploadbox"),
                        o = e("[data-upload-btn]"),
                        n = e(".dz-dragbox");
                    if (t.length) {
                        var a = function() {
                                var o = e(".uploadbox-drag"),
                                    n = e(".uploadbox-wrapper");
                                h.files.length > 0 ? (o.addClass("inactive"), n.addClass("active"), e("body").addClass("overflow-hidden"), k.removeClass("d-none"), t.addClass("active"), h.files.length == parseInt(c.maxUploadFiles) ? v.removeClass("show") : v.addClass("show")) : (o.removeClass("inactive"), n.removeClass("active"), k.addClass("d-none"), b.prop("disabled", !1), y.removeClass("d-none"), v.removeClass("show"))
                            },
                            i = function() {
                                n.removeClass("show")
                            },
                            r = function(e) {
                                var t = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : 2;
                                if (0 === e) return "0 " + c.translation.formatSizes[0];
                                var o = 1024,
                                    n = t < 0 ? 0 : t,
                                    a = c.translation.formatSizes,
                                    i = Math.floor(Math.log(e) / Math.log(o));
                                return parseFloat((e / Math.pow(o, i)).toFixed(n)) + " " + a[i]
                            },
                            l = function() {
                                var e = document.querySelectorAll(".btn-copy");
                                e && e.forEach((function(e) {
                                    new ClipboardJS(e).on("success", (function() {
                                        toastr.success(getConfig.copiedToClipboardSuccess)
                                    }))
                                }))
                            },
                            s = JSON.stringify(uploadConfig),
                            c = JSON.parse(s);
                        o.on("click", (function() {
                            t.addClass("active"), e("body").addClass("overflow-hidden")
                        })), t.find(".btn-close").on("click", (function() {
                            h.getQueuedFiles().length > 0 || h.getUploadingFiles().length > 0 ? confirm(c.closeUploadBoxAlert) && (h.removeAllFiles(!0), t.removeClass("active"), e("body").removeClass("overflow-hidden")) : (h.removeAllFiles(!0), t.removeClass("active"), e("body").removeClass("overflow-hidden"))
                        }));
                        var d = getConfig.baseURL + "/upload",
                            u = document.querySelector("#upload-previews");
                        u.id = "";
                        var f = u.innerHTML;
                        u.parentNode.removeChild(u);
                        var p = {
                                headers: {
                                    "X-CSRF-TOKEN": e('meta[name="csrf-token"]').attr("content")
                                },
                                url: d,
                                method: "POST",
                                paramName: "file",
                                filesizeBase: 1024,
                                maxFiles: parseInt(c.maxUploadFiles),
                                maxFilesize: parseInt(c.maxFileSize),
                                acceptedFiles: c.types.accepted,
                                previewTemplate: f,
                                previewsContainer: "#dropzone",
                                autoProcessQueue: !1,
                                clickable: "[data-dz-click]",
                                parallelUploads: parseInt(c.maxUploadFiles),
                                timeout: 0,
                                chunking: !0,
                                forceChunking: !0,
                                chunkSize: parseInt(c.chunkSize),
                                retryChunks: !0
                            },
                            m = Object.assign({}, p, dropzoneOptions);
                        Dropzone.autoDiscover = !1;
                        var h = new Dropzone("#dropzone-wrapper", m),
                            v = e(".upload-more-btn"),
                            y = e(".uploadbox-wrapper-form"),
                            b = e(".upload-files-btn"),
                            g = e(".upload-auto-delete");
                        b.on("click", (function(e) {
                            (e.preventDefault(), h.files.length > 0) ? "" != c.filesDuration && g.find(":selected").data("action") > c.filesDuration ? toastr.error(c.filesDurationError) : (b.prop("disabled", !0), y.addClass("d-none"), v.removeClass("show"), h.processQueue()): toastr.error(c.nofilesAttachedError)
                        }));
                        var k = e(".reset-upload-box");
                        k.on("click", (function() {
                            h.removeAllFiles(!0)
                        })), h.on("addedfile", (function(t) {
                            if (h.files.length <= c.maxUploadFiles)
                                if (c.types.accepted.split(",").includes(t.type)) {
                                    var o, n;
                                    if (this.files.length)
                                        for (o = 0, n = this.files.length; o < n - 1; o++) this.files[o].name === t.name && (this.removeFile(t), toastr.error(c.fileDuplicateError));
                                    0 == t.size && (toastr.error(c.emptyFilesError), this.removeFile(t)), "" != c.maxFileSize && t.size > c.maxFileSize && (toastr.error(c.exceedTheAllowedSizeError), this.removeFile(t)), "" != c.clientReminingSpace && t.size > c.clientReminingSpace && (toastr.error(c.clientReminingSpaceError), this.removeFile(t)), a(), h.files.length == parseInt(c.maxUploadFiles) && v.removeClass("show");
                                    var i = e(t.previewElement),
                                        l = i.find(".dz-size"),
                                        s = i.find(".dz-file-edit"),
                                        d = i.find("[data-dz-edit]"),
                                        u = i.find(".dz-edit .fas"),
                                        f = i.find(".dz-file-edit-close"),
                                        p = i.find(".dz-file-edit-submit"),
                                        m = i.find(".file-password");
                                    l.html(r(t.size)), m.on("input", (function() {
                                        m.removeClass("is-invalid")
                                    })), d.on("click", (function() {
                                        "" != m.val() && m.attr("fill-status", !0), m.prop("disabled", !1), s.addClass("active")
                                    })), f.on("click", (function() {
                                        "" == m.val() ? (m.prop("disabled", !0), m.attr("fill-status", !1), u.removeClass("fa-lock"), u.addClass("fa-lock-open")) : "false" == m.attr("fill-status") && (m.val(""), m.prop("disabled", !0), u.removeClass("fa-lock"), u.addClass("fa-lock-open")), m.removeClass("is-invalid"), s.removeClass("active")
                                    })), p.on("click", (function() {
                                        "" == m.val() ? m.addClass("is-invalid") : (u.addClass("fa-lock"), u.removeClass("fa-lock-open"), s.removeClass("active"))
                                    }))
                                } else this.removeFile(t), toastr.error(c.unacceptableFileTypesError);
                            else this.removeFile(t)
                        })), h.on("sending", (function(t, o, n) {
                           
                            var a = e(t.previewElement),
                                i = a.find(".dz-remove"),
                                r = a.find(".dz-edit"),
                                l = a.find(".file-password");
                            n.append("size", t.size), n.append("type", t.type), l.length && n.append("password", l.val()), n.append("upload_auto_delete", e(".upload-auto-delete").val()), n.append("nsfw", $(".nsfw").is(":checked")), n.append("watermark", e(".watermark").val()),n.append("Wsize", e(".size").val()),n.append("dmca", e(".dmca").val()), i.remove(), r.remove()
                        })), h.on("removedfile", (function() {
                            a()
                        })), h.on("uploadprogress", (function(t, o) {
                            e(t.previewElement).find(".dz-upload-precent").html(o.toFixed(0) + "%")
                        })), h.on("error", (function(e) {
                            var t = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : null;
                            toastr.error(t)
                        })), h.on("complete", (function(t) {
                            if ("success" == t.status) {
                                var o = e(t.previewElement),
                                    n = JSON.parse(t.xhr.response);
                                    function getFileExtension(filename) {
                                        var ext = filename.substring(filename.lastIndexOf('.') + 1);
                                        var allowedExtensions = ['mp4', 'webm', 'mov', 'MOV'];
                                        if(allowedExtensions.includes(ext)){
                                            return true;
                                        }
                                        return false;
                                      }
                                     var redditor = n.direct_link;
                                    if(getFileExtension(n.file_name)){
                                        var url2 = n.direct_link;
                                        var filename = url2.substring(url2.lastIndexOf('/') + 1);
                                        redditor = "http://local/stashpicz/httpdocs/images/thumbnails/" + "thumbnail-" + filename + ".gif";
        
                                    } else {
                                        

// Create a new XMLHttpRequest object
var xhr = new XMLHttpRequest();

// Prepare the AJAX request
xhr.open("GET", n.direct_link, true);

// Set the appropriate headers if needed
// xhr.setRequestHeader("Content-Type", "application/json");

// Set up the callback function to handle the response
xhr.onreadystatechange = function() {
  if (xhr.readyState === 4 && xhr.status === 200) {
    // Request was successful
    var response = xhr.responseText;
    // Handle the response here
    console.log(response);
  } else if (xhr.readyState === 4 && xhr.status !== 200) {
    // Request failed or returned an error
    console.log("Request failed with status: " + xhr.status);
  }
};

// Send the AJAX request
xhr.send();

                                    } 
                                if ("success" == n.type) o.find(".dz-preview-container").append('<div class="mt-3"><label class="form-label">' + c.translation.shareLink + '</label><div class="form-button"><input id="shareLink' + n.file_id + '" type="text" class="form-control form-control-md" value="' + n.file_link + '" readonly /><button class="btn-copy" data-clipboard-target="#shareLink' + n.file_id + '"><i class="fa-regular fa-clone"></i></button></div></div><div class="mt-3"><label class="form-label">' + c.translation.redditLink + '</label><div class="form-button"><input id="redditLink' + n.file_id + '" type="text" class="form-control form-control-md" value="' + redditor + '" readonly /><button class="btn-copy" data-clipboard-target="#redditLink' + n.file_id + '"><i class="fa-regular fa-clone"></i></button></div></div><div class="mt-3"> <label class="form-label">' + c.translation.htmlCode + '</label> <div class="textarea-btn"> <textarea id="htmlCode' + n.file_id + '" class="form-control" rows="3" readonly><a target="_blank" href="' + n.file_link + '"><img  src="' + n.direct_link + '" alt="' + n.file_name + '"/></a></textarea> <button class="btn btn-primary btn-copy" data-clipboard-target="#htmlCode' + n.file_id + '">' + c.translation.copy + '</button> </div> </div><div class="mt-3"><a href="' + n.file_link + '" target="_blank" class="btn btn-primary btn-md w-100"><i class="fa-solid fa-up-right-from-square me-2"></i>' + c.translation.openLink + "</a></div>"), l();
                                else o.removeClass("dz-success"), o.addClass("dz-error"), toastr.error(n.msg)
                            }
                        })), h.on("dragover", (function() {
                            n.addClass("show")
                        })), h.on("dragleave", i), h.on("drop", i)
                    }
                }(jQuery)
            },
            229: () => {
                function e(t) {
                    return e = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(e) {
                        return typeof e
                    } : function(e) {
                        return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
                    }, e(t)
                }! function(t) {
                    var o = {};

                    function n(e) {
                        if (o[e]) return o[e].exports;
                        var a = o[e] = {
                            i: e,
                            l: !1,
                            exports: {}
                        };
                        return t[e].call(a.exports, a, a.exports, n), a.l = !0, a.exports
                    }
                    n.m = t, n.c = o, n.d = function(e, t, o) {
                        n.o(e, t) || Object.defineProperty(e, t, {
                            enumerable: !0,
                            get: o
                        })
                    }, n.r = function(e) {
                        "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(e, Symbol.toStringTag, {
                            value: "Module"
                        }), Object.defineProperty(e, "__esModule", {
                            value: !0
                        })
                    }, n.t = function(t, o) {
                        if (1 & o && (t = n(t)), 8 & o) return t;
                        if (4 & o && "object" === e(t) && t && t.__esModule) return t;
                        var a = Object.create(null);
                        if (n.r(a), Object.defineProperty(a, "default", {
                                enumerable: !0,
                                value: t
                            }), 2 & o && "string" != typeof t)
                            for (var i in t) n.d(a, i, function(e) {
                                return t[e]
                            }.bind(null, i));
                        return a
                    }, n.n = function(e) {
                        var t = e && e.__esModule ? function() {
                            return e.default
                        } : function() {
                            return e
                        };
                        return n.d(t, "a", t), t
                    }, n.o = function(e, t) {
                        return Object.prototype.hasOwnProperty.call(e, t)
                    }, n.p = "", n(n.s = 0)
                }({
                    "./src/js-loading-overlay.js": function(e, t) {
                        function o(e, t) {
                            for (var o = 0; o < t.length; o++) {
                                var n = t[o];
                                n.enumerable = n.enumerable || !1, n.configurable = !0, "value" in n && (n.writable = !0), Object.defineProperty(e, n.key, n)
                            }
                        }
                        var n = function() {
                            function e() {
                                ! function(e, t) {
                                    if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
                                }(this, e), this.options = {
                                    overlayBackgroundColor: "#fffffff2",
                                    overlayOpacity: .6,
                                    spinnerIcon: "ball-spin-clockwise",
                                    spinnerColor: getConfig.primaryColor,
                                    spinnerSize: "3x",
                                    overlayIDName: "overlay",
                                    spinnerIDName: "spinner",
                                    offsetY: 0,
                                    offsetX: 0,
                                    lockScroll: !1,
                                    containerID: null,
                                    spinnerZIndex: 99999,
                                    overlayZIndex: 99998
                                }, this.stylesheetBaseURL = "https://cdn.jsdelivr.net/npm/load-awesome@1.1.0/css/", this.spinner = null, this.spinnerStylesheetURL = null, this.numberOfEmptyDivForSpinner = {
                                    "ball-8bits": 16,
                                    "ball-atom": 4,
                                    "ball-beat": 3,
                                    "ball-circus": 5,
                                    "ball-climbing-dot": 1,
                                    "ball-clip-rotate": 1,
                                    "ball-clip-rotate-multiple": 2,
                                    "ball-clip-rotate-pulse": 2,
                                    "ball-elastic-dots": 5,
                                    "ball-fall": 3,
                                    "ball-fussion": 4,
                                    "ball-grid-beat": 9,
                                    "ball-grid-pulse": 9,
                                    "ball-newton-cradle": 4,
                                    "ball-pulse": 3,
                                    "ball-pulse-rise": 5,
                                    "ball-pulse-sync": 3,
                                    "ball-rotate": 1,
                                    "ball-running-dots": 5,
                                    "ball-scale": 1,
                                    "ball-scale-multiple": 3,
                                    "ball-scale-pulse": 2,
                                    "ball-scale-ripple": 1,
                                    "ball-scale-ripple-multiple": 3,
                                    "ball-spin": 8,
                                    "ball-spin-clockwise": 8,
                                    "ball-spin-clockwise-fade": 8,
                                    "ball-spin-clockwise-fade-rotating": 8,
                                    "ball-spin-fade": 8,
                                    "ball-spin-fade-rotating": 8,
                                    "ball-spin-rotate": 2,
                                    "ball-square-clockwise-spin": 8,
                                    "ball-square-spin": 8,
                                    "ball-triangle-path": 3,
                                    "ball-zig-zag": 2,
                                    "ball-zig-zag-deflect": 2,
                                    cog: 1,
                                    "cube-transition": 2,
                                    fire: 3,
                                    "line-scale": 5,
                                    "line-scale-party": 5,
                                    "line-scale-pulse-out": 5,
                                    "line-scale-pulse-out-rapid": 5,
                                    "line-spin-clockwise-fade": 8,
                                    "line-spin-clockwise-fade-rotating": 8,
                                    "line-spin-fade": 8,
                                    "line-spin-fade-rotating": 8,
                                    pacman: 6,
                                    "square-jelly-box": 2,
                                    "square-loader": 1,
                                    "square-spin": 1,
                                    timer: 1,
                                    "triangle-skew-spin": 1
                                }
                            }
                            var t, n, a;
                            return t = e, (n = [{
                                key: "show",
                                value: function(e) {
                                    this.setOptions(e), this.addSpinnerStylesheet(), this.generateSpinnerElement(), this.options.lockScroll && (document.body.style.overflow = "hidden", document.documentElement.style.overflow = "hidden"), this.generateAndAddOverlayElement()
                                }
                            }, {
                                key: "hide",
                                value: function() {
                                    this.options.lockScroll && (document.body.style.overflow = "", document.documentElement.style.overflow = "");
                                    var e = document.getElementById("loading-overlay-stylesheet");
                                    e && (e.disabled = !0, e.parentNode.removeChild(e), document.getElementById(this.options.overlayIDName).remove(), document.getElementById(this.options.spinnerIDName).remove())
                                }
                            }, {
                                key: "setOptions",
                                value: function(e) {
                                    if (void 0 !== e)
                                        for (var t in e) this.options[t] = e[t]
                                }
                            }, {
                                key: "generateAndAddOverlayElement",
                                value: function() {
                                    var e = "50%";
                                    0 !== this.options.offsetX && (e = "calc(50% + " + this.options.offsetX + ")");
                                    var t = "50%";
                                    if (0 !== this.options.offsetY && (t = "calc(50% + " + this.options.offsetY + ")"), this.options.containerID && document.body.contains(document.getElementById(this.options.containerID))) {
                                        var o = '<div id="'.concat(this.options.overlayIDName, '" style="display: block !important; position: absolute; top: 0; left: 0; overflow: auto; opacity: ').concat(this.options.overlayOpacity, "; background: ").concat(this.options.overlayBackgroundColor, '; z-index: 50; width: 100%; height: 100%;"></div><div id="').concat(this.options.spinnerIDName, '" style="display: block !important; position: absolute; top: ').concat(t, "; left: ").concat(e, '; -webkit-transform: translate(-50%); -ms-transform: translate(-50%); transform: translate(-50%); z-index: 9999;">').concat(this.spinner, "</div>"),
                                            n = document.getElementById(this.options.containerID);
                                        return n.style.position = "relative", void n.insertAdjacentHTML("beforeend", o)
                                    }
                                    var a = '<div id="'.concat(this.options.overlayIDName, '" style="display: block !important; position: fixed; top: 0; left: 0; overflow: auto; opacity: ').concat(this.options.overlayOpacity, "; background: ").concat(this.options.overlayBackgroundColor, "; z-index: ").concat(this.options.overlayZIndex, '; width: 100%; height: 100%;"></div><div id="').concat(this.options.spinnerIDName, '" style="display: block !important; position: fixed; top: ').concat(t, "; left: ").concat(e, "; -webkit-transform: translate(-50%); -ms-transform: translate(-50%); transform: translate(-50%); z-index: ").concat(this.options.spinnerZIndex, ';">').concat(this.spinner, "</div>");
                                    document.body.insertAdjacentHTML("beforeend", a)
                                }
                            }, {
                                key: "generateSpinnerElement",
                                value: function() {
                                    var e = this,
                                        t = Object.keys(this.numberOfEmptyDivForSpinner).find((function(t) {
                                            return t === e.options.spinnerIcon
                                        })),
                                        o = this.generateEmptyDivElement(this.numberOfEmptyDivForSpinner[t]);
                                    this.spinner = '<div style="color: '.concat(this.options.spinnerColor, '" class="la-').concat(this.options.spinnerIcon, " la-").concat(this.options.spinnerSize, '">').concat(o, "</div>")
                                }
                            }, {
                                key: "addSpinnerStylesheet",
                                value: function() {
                                    this.setSpinnerStylesheetURL();
                                    var e = document.createElement("link");
                                    e.setAttribute("id", "loading-overlay-stylesheet"), e.setAttribute("rel", "stylesheet"), e.setAttribute("type", "text/css"), e.setAttribute("href", this.spinnerStylesheetURL), document.getElementsByTagName("head")[0].appendChild(e)
                                }
                            }, {
                                key: "setSpinnerStylesheetURL",
                                value: function() {
                                    this.spinnerStylesheetURL = this.stylesheetBaseURL + this.options.spinnerIcon + ".min.css"
                                }
                            }, {
                                key: "generateEmptyDivElement",
                                value: function(e) {
                                    for (var t = "", o = 1; o <= e; o++) t += "<div></div>";
                                    return t
                                }
                            }]) && o(t.prototype, n), a && o(t, a), e
                        }();
                        window.JsLoadingOverlay = new n, e.exports = JsLoadingOverlay
                    },
                    0: function(e, t, o) {
                        e.exports = o("./src/js-loading-overlay.js")
                    }
                })
            },
            219: () => {
                function e(e) {
                    return function(e) {
                        if (Array.isArray(e)) return t(e)
                    }(e) || function(e) {
                        if ("undefined" != typeof Symbol && null != e[Symbol.iterator] || null != e["@@iterator"]) return Array.from(e)
                    }(e) || function(e, o) {
                        if (!e) return;
                        if ("string" == typeof e) return t(e, o);
                        var n = Object.prototype.toString.call(e).slice(8, -1);
                        "Object" === n && e.constructor && (n = e.constructor.name);
                        if ("Map" === n || "Set" === n) return Array.from(e);
                        if ("Arguments" === n || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return t(e, o)
                    }(e) || function() {
                        throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")
                    }()
                }

                function t(e, t) {
                    (null == t || t > e.length) && (t = e.length);
                    for (var o = 0, n = new Array(t); o < t; o++) n[o] = e[o];
                    return n
                }! function(t) {
                    "use strict";
                    document.querySelectorAll("[data-year]").forEach((function(e) {
                        e.textContent = (new Date).getFullYear()
                    })), t("[data-aos]").length > 0 && AOS.init({
                        once: !0,
                        disable: "mobile"
                    });
                    var o = t("#otp-code");
                    if (o.length && o.on("input", (function() {
                            this.value = this.value.replace(/\D/g, "")
                        })), "#_=_" === window.location.hash)
                        if (history.replaceState) {
                            var n = window.location.href.split("#")[0];
                            history.replaceState(null, null, n)
                        } else window.location.hash = "";
                    var a = document.querySelectorAll("[data-dropdown]");
                    null != a && a.forEach((function(e) {
                        function t() {
                            e.getBoundingClientRect().top + e.querySelector(".drop-down-menu").offsetHeight > window.innerHeight - 60 ? (e.querySelector(".drop-down-menu").style.top = "auto", e.querySelector(".drop-down-menu").style.bottom = "40px") : (e.querySelector(".drop-down-menu").style.top = "40px", e.querySelector(".drop-down-menu").style.bottom = "auto")
                        }
                        window.addEventListener("click", (function(o) {
                            e.contains(o.target) ? (e.classList.toggle("active"), setTimeout((function() {
                                e.classList.toggle("animated")
                            }), 0)) : (e.classList.remove("active"), e.classList.remove("animated")), t()
                        })), window.addEventListener("resize", t), window.addEventListener("scroll", t)
                    }));
                    var i = document.querySelectorAll("[data-link]");
                    i && i.forEach((function(e) {
                        e.onclick = function(t) {
                            t.preventDefault();
                            var o = document.querySelector(e.getAttribute("data-link")).offsetTop - 65;
                            console.log(o), window.scrollTo("0", o), r.classList.remove("show"), document.body.classList.remove("overflow-hidden")
                        }
                    }));
                    var r = document.querySelector(".nav-bar-menu"),
                        l = document.querySelector(".nav-bar-menu-btn");
                    if (r) {
                        var s = r.querySelector(".nav-bar-menu-close"),
                            c = r.querySelector(".overlay"),
                            d = document.querySelector(".nav-bar-menu [data-upload-btn]");
                        l.onclick = function() {
                            r.classList.add("show"), document.body.classList.add("overflow-hidden")
                        }, s.onclick = c.onclick = function() {
                            r.classList.remove("show"), document.body.classList.remove("overflow-hidden")
                        }, d && d.addEventListener("click", (function() {
                            r.classList.remove("show")
                        }))
                    }
                    t(".confirm-action").on("click", (function(e) {
                        var o = this;
                        e.preventDefault(), Swal.fire({
                            title: getConfig.alertActionTitle,
                            text: getConfig.alertActionText,
                            icon: "question",
                            showCancelButton: !0,
                            allowOutsideClick: !1,
                            focusConfirm: !1,
                            confirmButtonText: getConfig.alertActionConfirmButton,
                            confirmButtonColor: getConfig.primaryColor,
                            cancelButtonText: getConfig.alertActionCancelButton
                        }).then((function(e) {
                            e.isConfirmed && (location.href = t(o).attr("href"))
                        }))
                    })), t(".confirm-action-form").on("click", (function(e) {
                        var o = this;
                        e.preventDefault(), Swal.fire({
                            title: getConfig.alertActionTitle,
                            text: getConfig.alertActionText,
                            icon: "question",
                            showCancelButton: !0,
                            allowOutsideClick: !1,
                            focusConfirm: !1,
                            confirmButtonText: getConfig.alertActionConfirmButton,
                            confirmButtonColor: getConfig.primaryColor,
                            cancelButtonText: getConfig.alertActionCancelButton
                        }).then((function(e) {
                            e.isConfirmed && t(o).parents("form")[0].submit()
                        }))
                    }));
                    var u = document.querySelectorAll(".input-password");
                    u && u.forEach((function(e) {
                        var t = e.querySelector("button"),
                            o = e.querySelector("input");
                        t.onclick = function(e) {
                            e.preventDefault(), "password" === o.type ? (o.type = "text", t.innerHTML = '<i class="fas fa-eye-slash"></i>') : (o.type = "password", t.innerHTML = '<i class="fas fa-eye"></i>')
                        }
                    }));
                    var f = document.querySelectorAll("[data-refresh]");
                    f && f.forEach((function(e) {
                        e.onclick = function() {
                            location.reload()
                        }
                    }));
                    var p = document.querySelectorAll(".btn-copy");
                    p && p.forEach((function(e) {
                        new ClipboardJS(e).on("success", (function() {
                            toastr.success(getConfig.copiedToClipboardSuccess)
                        }))
                    }));
                    var m = document.querySelector(".fileviewer");
                    if (document.querySelector(".fileviewer-sidebar")) {
                        var h = document.querySelector(".fileviewer-sidebar-open"),
                            v = document.querySelector(".fileviewer-sidebar-close"),
                            y = document.querySelector(".fileviewer-sidebar .overlay");
                        h.onclick = function() {
                            m.classList.add("toggle")
                        }, v.onclick = y.onclick = function() {
                            m.classList.remove("toggle")
                        }, window.addEventListener("resize", (function() {
                            m.classList.remove("toggle")
                        }))
                    }
                    var b = document.querySelectorAll(".filemanager-file"),
                        g = document.querySelector(".filemanager-actions"),
                        k = document.querySelector(".filemanager-select-all"),
                        w = [];
                    b && b.forEach((function(t) {
                        var o = t.querySelector(".form-check-input"),
                            n = t.querySelectorAll(".filemanager-link"),
                            a = t.querySelector(".drop-down");

                        function i() {
                            var t = document.querySelectorAll(".filemanager-file.selected");
                            t.length > 0 ? g.classList.add("show") : g.classList.remove("show"), t.length === b.length ? (k.checked = !0, k.nextElementSibling.textContent = k.parentNode.getAttribute("data-unselect")) : (k.checked = !1, k.nextElementSibling.textContent = k.parentNode.getAttribute("data-select")), b.forEach((function(t) {
                                if (!0 === t.querySelector(".form-check-input").checked) {
                                    w.push(t.querySelector(".form-check-input").id);
                                    var o = e(new Set(w));
                                    filesSelectedInput.value = o.sort()
                                } else {
                                    w = w.filter((function(e) {
                                        return e !== t.querySelector(".form-check-input").id
                                    }));
                                    var n = e(new Set(w));
                                    filesSelectedInput.value = n
                                }
                            }))
                        }
                        o.onchange = function() {
                            !0 === o.checked ? (t.classList.add("selected"), o.checked) : (t.classList.remove("selected"), o.checked), i()
                        }, t.onclick = function() {
                            !0 === o.checked ? (o.checked = !1, t.classList.remove("selected"), o.checked) : (o.checked = !0, t.classList.add("selected"), o.checked), i()
                        }, a.onclick = function() {
                            !0 === o.checked ? (o.checked = !1, t.classList.remove("selected"), o.checked) : (o.checked = !0, t.classList.add("selected"), o.checked)
                        }, o.onclick = function(e) {
                            e.stopPropagation()
                        }, n && n.forEach((function(e) {
                            e.onclick = function(e) {
                                e.stopPropagation()
                            }
                        })), k.onchange = function() {
                            !0 === k.checked ? b.forEach((function(e) {
                                e.querySelector(".form-check-input").checked = !0, e.classList.add("selected"), o.checked
                            })) : b.forEach((function(e) {
                                e.querySelector(".form-check-input").checked = !1, g.classList.remove("show"), e.classList.remove("selected"), o.checked
                            })), i()
                        }
                    }));
                    var C = t("#change_avatar"),
                        S = t("#avatar_preview");
                    C.on("change", (function() {
                        (function(e) {
                            if (e.files && e.files[0]) {
                                var t = new FileReader;
                                
                                t.onload = function(e) {
                                    S.attr("src", e.target.result)
                                }, t.readAsDataURL(e.files[0])
                            }
                        })(this)
                    })), t(".delete-file").on("click", (function(e) {
                        e.preventDefault();
                        var o = t(this).data("id");
                        Swal.fire({
                            title: getConfig.alertActionTitle,
                            text: getConfig.alertActionText,
                            icon: "question",
                            showCancelButton: !0,
                            allowOutsideClick: !1,
                            focusConfirm: !1,
                            confirmButtonText: getConfig.alertActionConfirmButton,
                            confirmButtonColor: getConfig.primaryColor,
                            cancelButtonText: getConfig.alertActionCancelButton
                        }).then((function(e) {
                            e.isConfirmed && document.getElementById("deleteFile" + o).submit()
                        }))
                    }));
                    var x = t(".fileManager-share-file"),
                        E = t("#shareModal"),
                        L = t(".share-modal .share"),
                        O = t(".share-modal #copy-share-link"),
                        A = t(".share-modal .filename"),
                        z = t("#htmlCode"),
                        q = t("#bbCode"),
                        reddit = t(".share-modal #reddit");
                    x.length && x.on("click", (function(e) {
                        e.preventDefault();
                        var o = t(this).data("share"),
                            n = "https://www.facebook.com/sharer/sharer.php?u=" + o.share_link,
                            a = "https://twitter.com/intent/tweet?text=" + o.share_link,
                            i = "https://wa.me/?text=" + o.share_link,
                            r = "https://www.linkedin.com/shareArticle?mini=true&url=" + o.share_link,
                            l = "http://pinterest.com/pin/create/button/?url=" + o.share_link;
                            function getFileExtension(filename) {
                                var ext = filename.substring(filename.lastIndexOf('.') + 1);
                                var allowedExtensions = ['mp4', 'webm', 'mov', 'MOV'];
                                if(allowedExtensions.includes(ext)){
                                    return true;
                                }
                                return false;
                              }
                             var redditor = o.direct_link;
                            if(getFileExtension(o.filename)){
                                var url2 = o.direct_link;
                                var filename = url2.substring(url2.lastIndexOf('/') + 1);
                                redditor = "http://local/stashpicz/httpdocs/images/thumbnails/" + "thumbnail-" + filename + ".gif";

                            }
                        A.html("<strong>" + o.filename + "</strong>"), L.html('<a href="' + n + '" target="_blank" class="social-btn social-facebook"><i class="fab fa-facebook-f"></i></a> <a href="' + a + '" target="_blank" class="social-btn social-twitter"><i class="fab fa-twitter"></i></a> <a href="' + i + '" target="_blank" class="social-btn social-whatsapp"><i class="fab fa-whatsapp"></i></a> <a href="' + r + '" target="_blank" class="social-btn social-linkedin"><i class="fab fa-linkedin"></i></a> <a href="' + l + '" target="_blank" class="social-btn social-pinterest"><i class="fab fa-pinterest"></i></a>'), O.attr("value", o.share_link), reddit.attr("value", redditor), z.html('<a target="_blank" href="' + o.share_link + '"><img src="' + o.direct_link + '" alt="' + o.filename + '"/></a>'), q.html("[url=" + o.share_link + "][img]" + o.direct_link + "[/img][/url]"), E.modal("show")
                    }))
                }(jQuery)
            },
            759: () => {},
            100: () => {},
            529: () => {},
            605: () => {}
        },
        o = {};

    function n(e) {
        var a = o[e];
        if (void 0 !== a) return a.exports;
        var i = o[e] = {
            exports: {}
        };
        return t[e](i, i.exports, n), i.exports
    }
    n.m = t, e = [], n.O = (t, o, a, i) => {
        if (!o) {
            var r = 1 / 0;
            for (d = 0; d < e.length; d++) {
                for (var [o, a, i] = e[d], l = !0, s = 0; s < o.length; s++)(!1 & i || r >= i) && Object.keys(n.O).every((e => n.O[e](o[s]))) ? o.splice(s--, 1) : (l = !1, i < r && (r = i));
                if (l) {
                    e.splice(d--, 1);
                    var c = a();
                    void 0 !== c && (t = c)
                }
            }
            return t
        }
        i = i || 0;
        for (var d = e.length; d > 0 && e[d - 1][2] > i; d--) e[d] = e[d - 1];
        e[d] = [o, a, i]
    }, n.o = (e, t) => Object.prototype.hasOwnProperty.call(e, t), (() => {
        var e = {
            507: 0,
            138: 0,
            554: 0,
            778: 0,
            188: 0
        };
        n.O.j = t => 0 === e[t];
        var t = (t, o) => {
                var a, i, [r, l, s] = o,
                    c = 0;
                if (r.some((t => 0 !== e[t]))) {
                    for (a in l) n.o(l, a) && (n.m[a] = l[a]);
                    if (s) var d = s(n)
                }
                for (t && t(o); c < r.length; c++) i = r[c], n.o(e, i) && e[i] && e[i][0](), e[i] = 0;
                return n.O(d)
            },
            o = self.webpackChunk = self.webpackChunk || [];
        o.forEach(t.bind(null, 0)), o.push = t.bind(null, o.push.bind(o))
    })(), n.O(void 0, [138, 554, 778, 188], (() => n(124))), n.O(void 0, [138, 554, 778, 188], (() => n(759))), n.O(void 0, [138, 554, 778, 188], (() => n(100))), n.O(void 0, [138, 554, 778, 188], (() => n(529)));
    var a = n.O(void 0, [138, 554, 778, 188], (() => n(605)));
    a = n.O(a)
})();