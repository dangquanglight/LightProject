var RecaptchaOptions = {
    theme: 'clean'
};

var GEH = new function () {
    var self = this;
    this.baseUrl = false;

    this.selectList = function (list, value, text, attrs) {
        var selectList = $("<select></select>");
        if (attrs)
            selectList.attr(attrs);
        for (var i = 0; i < list.length; i++) {
            var item = list[i];
            var opt = "<option value='{value}'>{text}</option>";
            opt = opt.replace("{value}", item[value])
                .replace("{text}", item[text]);
            selectList.append(opt);
        }
        return selectList;
    }

    this.init = function () {
        $(".watermark").each(function () {
            initWatermark($(this));
        });

        $(".qtip-link").each(function () {
            initQtip($(this));
        });

        $(".qtip-link-hover").each(function () {
            self.initHoverQtip($(this));
        });

        $(".textarea-counter").each(function () {
            initTextareaCounter($(this));
        });

        $(".autofocus:last").focus();

        $("body").delegate(".authorize", "click",function (e) {
            if (!self.userId) {
                self.openLoginDialog();
                e.stopPropagation();
                e.preventDefault();
                return false;
            }
        }).delegate(".alternate-checkbox", "change", function (e) {
            var $this = $(this);
            var $target = $($this.attr("data-ref"));
            if ($this.is(":checked")) {
                $target.removeClass("ignore").show();
            } else {
                $target.addClass("ignore").hide();
            }
        });

        StarRating.init();
    };

    /* BEGIN COMMON METHODS */

    this.openNewTab = function (url) {
        window.open(url, '_blank');
        window.focus();
    };
    this.block = function ($wrapper) {
        if (typeof $wrapper === "string") {
            $wrapper = $($wrapper);
        }
        var opts = {
            overlayCSS: {
                opacity: 0
            },
            message: '<img src="' + self.baseUrl + '/media/img/loading.gif" alt="Loading..." title="Loading..." />'
        };
        if ($wrapper) {
            var tagName = $wrapper.prop("tagName");
            switch (tagName) {
                case "TD":
                    $wrapper.blockCell(opts);
                    break;
                case "TR":
                    $wrapper.blockRow(opts);
                    break;
                default:
                    $wrapper.block(opts);
                    break;
            }
        } else {
            $.blockUI(opts);
        }
    };
    this.unblock = function ($wrapper) {
        if (typeof $wrapper === "string") {
            $wrapper = $($wrapper);
        }
        if ($wrapper) {
            var tagName = $wrapper.prop("tagName");
            switch (tagName) {
                case "TD":
                    $wrapper.unblockCell();
                    break;
                case "TR":
                    $wrapper.unblockRow();
                    break;
                default:
                    $wrapper.unblock();
                    break;
            }
        } else {
            $.unblockUI();
        }
    };
    this.alert = function (msg, callback, button) {
        jQuery.fancybox({
            padding: 0,
            margin: 0,
            autoSize: false,
            autoHeight: true,
            autoWidth: true,
            modal: true,
            content: "<div class='dialog'>" +
                "<div class=\"block\">" +
                "<h2 class='title'><span>Message</span></h2>" +
                "<div style=\"min-height: 60px;width:320px;padding-left:10px;padding-right:10px;margin-bottom:10px;line-height:18px;text-align:left;\">" + msg + "</div>" +
                "<div style=\"text-align:right;\">" +
                (button ? button : "") +
                "<a href='javascript:void(0);' class='button' onclick='$.fancybox.close();'>Close</a>" +
                "</div>" +
                "</div></div>",
            afterClose: function () {
                if (callback) {
                    callback.call();
                }
            }
        });
    };
    this.confirm = function (msg, callback, closeCallback) {
        var ret;
        jQuery.fancybox({
            padding: 0,
            margin: 0,
            autoSize: false,
            autoHeight: true,
            autoWidth: true,
            modal: true,
            content: "<div class='dialog'>" +
                "<div class=\"block\">" +
                "<h2 class='title'><span>Confirm</span></h2>" +
                "<div style=\"min-height: 60px;width:320px;padding-top:15px;padding-left:10px;padding-right:10px;margin-bottom:10px;line-height:18px;text-align:justify;\">" + msg + "</div>" +
                "<div style=\"text-align:right;\">" +
                "<a href='javascript:void(0);' class='button' id='fancyConfirm_ok' style='margin-right: 5px;'>Yes</a>" +
                "<a href='javascript:void(0);' class='button' id='fancyConfirm_cancel'>No</a>" +
                "</div>" +
                "</div></div>",
            afterShow: function () {
                jQuery("#fancyConfirm_cancel").click(function () {
                    ret = false;
                    jQuery.fancybox.close();
                    closeCallback.call(this, ret);
                });
                jQuery("#fancyConfirm_ok").click(function () {
                    ret = true;
                    jQuery.fancybox.close();
                    callback.call(this, ret);
                });
            },
            onClosed: function () {
                if (closeCallback) closeCallback.call(this, ret);
            }
        });
    };
    this.editListing = function (id) {
        $.fancybox.open({
            href: this.baseUrl + "list-book/edit/" + id,
            type: "iframe",
            width: 600,
            height: 330,
            autoSize: false
        });
    };
    this.listOnSaleList = function (params, callback) {
        params += "&sob=0";
        GEH.block();
        $.ajax({
            url: self.baseUrl + "listing/ajax/list_book",
            type: "POST",
            data: params,
            success: function (response) {
                GEH.unblock();
                if (response.errors && response.errors.length === 0) {
                    if (callback) {
                        callback(response);
                    }
                }
            },
            error: function () {
                GEH.block();
            }
        });
    };
    this.listOnWishList = function (params, callback) {
        params += "&sob=1";
        GEH.block();
        $.ajax({
            url: self.baseUrl + "listing/ajax/list_book",
            type: "POST",
            data: params,
            success: function (response) {
                GEH.unblock();
                if (response.errors && response.errors.length === 0) {
                    if (callback) {
                        callback(response);
                    }
                }
            },
            error: function () {
                GEH.block();
            }
        });
    };
    this.deleteListing = function (id) {
        this.confirm("Do you want to remove this book from your listing ?", function () {
            GEH.block();
            $.ajax({
                url: self.baseUrl + "listing/ajax/delete_listing",
                type: "POST",
                data: {
                    id: id
                },
                success: function (response) {
                    GEH.unblock();
                    if (response.errors && response.errors.length > 0) {
                        GEH.alert(response.errors[0].message);
                        return;
                    }
                    location.reload();
                }
            });
        });
    };
    this.viewMessage = function (id) {
        $.fancybox.open({
            href: this.baseUrl + "message/index/view/" + id,
            type: "ajax",
            width: 615,
            afterShow: function () {
                var objDiv = $(".messages").get(0);
                objDiv.scrollTop = objDiv.scrollHeight;
            }
        });
    };
    this.openMakeDealDialog = function (id) {
        $.fancybox.open({
            href: this.baseUrl + "listing/deal/make_deal/" + id,
            type: "iframe",
            width: 615,
            height: 340,
            autoSize: false
        });
    };
    this.openMakeDealSuccessDialog = function (id) {
        $.fancybox.open({
            href: this.baseUrl + "listing/deal/make_deal_success/" + id,
            type: "ajax",
            afterClose: function () {
                location.reload();
            }
        });
    };
    this.makeDeal = function () {
        var data = $("#makeDealForm").serialize();
        GEH.block();
        $.ajax({
            url: GEH.baseUrl + "listing/ajax/make_deal",
            dataType: "json",
            type: "POST",
            data: data,
            success: function (response) {
                GEH.unblock();
                if (response.errors && response.errors.length > 0) {
                    GEH.alert(response.errors[0].message);
                    return;
                }
                parent.GEH.openMakeDealSuccessDialog(response.id);
            }
        });
    };
    this.openLoginDialog = function () {
        $.fancybox.open({
            href: this.baseUrl + "login_dialog", //+ encodeURIComponent(document.URL),
            type: "iframe",
            width: 610,
            height: 300,
            autoSize: false
        });
    };
    this.openListingShareDialog = function (url) {
        $.fancybox.open({
                href: this.baseUrl + "listing/share_dialog?u=" + url,
                type: "iframe",
                width: 495,
                height: 160,
                autoSize: false,
                afterClose: function () {
                    parent.location = url;
                }
            }
        )
        ;
    };
    this.openRegisterSocialDialog = function (data) {
        if (!data) data = {
            firstname: "Nguyen",
            lastname: "Dung",
            email: "nguyenbadung@gmail.com"
        };
        //console.log(data);
        $.fancybox.open({
            href: this.baseUrl + "register/index/register_social_dialog?" + $.param(data),
            type: "iframe",
            width: 420,
            maxHeight: 280,
            autoResize: false
        });
    };
    this.openRegisterDialog = function () {
        $.fancybox.open({
            href: this.baseUrl + "register/index/register",
            type: "iframe",
            width: 700,
            maxHeight: 550,
            autoResize: false
        });
    };
    this.openRegisterDialog2 = function (userId) {
        userId = userId || 131;
        $.fancybox.open({
            href: this.baseUrl + "register/index/register_dialog2/" + userId,
            type: "iframe",
            width: 520,
            height: 300,
            autoSize: false
        });
    };
    this.openRegisterDialog3 = function (verified) {
        verified = verified ? 1 : 0;
        $.fancybox.open({
            href: this.baseUrl + "register/index/register_dialog3/" + verified,
            type: "ajax",
            width: 450,
            height: 300,
            autoSize: false,
            afterClose: function () {
                location.reload();
            }
        });
    };
    this.openEditProfileDialog = function () {
        $.fancybox.open({
            href: this.baseUrl + "profile/user/edit_profile",
            type: "iframe",
            width: 450,
            height: 350,
            autoSize: false
        });
    };
    this.openChangePasswordDialog = function () {
        $.fancybox.open({
            href: this.baseUrl + "profile/user/change_password",
            type: "iframe",
            width: 450,
            height: 210,
            autoSize: false
        });
    };
    this.openForgotPasswordDialog = function () {
        $.fancybox.open({
            href: this.baseUrl + "login/index/forgot_password",
            type: "iframe",
            width: 410,
            height: 150,
            autoSize: false
        });
    };
    this.defaultQTipOptions = {
        id: "",
        prerender: true,
        overwrite: false,
        content: {
            text: "",
            title: {
                button: true
            }
        },
        position: {
            my: 'top left', // ...at the center of the viewport
            at: 'bottom left',
            target: false
        },
        show: {
            event: 'click', // Show it on click...
            solo: true, // ...and hide all other tooltips...
            modal: false
        },
        hide: {
            event: 'unfocus'
        },
        style: {
            tip: {
                corner: false
            },
            classes: "GEH-qtip",
            width: 356,
            height: 390
        },
        onShow: function () {

        }
    };
    this.reportBook = function () {
        var data = $("#bookReportForm").serialize();
        GEH.block();
        $.ajax({
            url: GEH.baseUrl + "ajax/report_book",
            dataType: "json",
            type: "POST",
            data: data,
            success: function (response) {
                GEH.unblock();
                if (response.errors && response.errors.length > 0) {
                    GEH.alert(response.errors[0].message);
                    return;
                }
                GEH.alert(response.success_message);
            }
        });
    };

    /* END COMMON METHODS */
};

var SearchResult = new function () {
    var self = this;
    this.baseUrl = false;
    this.init = function () {

        $.ajax({
            url: this.baseUrl,
            data: {},
            success: function (response) {
                response = $.parseJSON(response);
                console.log(response);
                appendItems(response);
                initInfiniteScroll();
            }
        });
    };

    function buildItem(item) {
        var html = '<div>';
        html += '<div class="frame"><img width="161" height="161" src="'
            + item.book_image + '" /></div>';
        html += '</div>';
        return $(html);
    }

    function appendItems(items) {
        for (var i = 0; i < items.length; i++) {
            $("#books").append(buildItem(items[i]));
        }
    }

    var UserManager = new function () {
        this.messageId = 0;
        this.init = function () {
            $("body").delegate(".view-deal", "click", function () {
                var id = parseInt($(this).attr("data-id"), 10);
                $.fancybox.open({
                    href: GEH.baseUrl + "deal/details/" + id,
                    type: "ajax",
                    autoSize: false,
                    width: 615,
                    height: 300
                });
            });
        };
        this.reply = function (id) {
            $.ajax({
                url: GEH.baseUrl + "message/ajax/reply",
                type: "POST",
                data: {
                    id: id,
                    subject: $("#postReply").val()
                }, success: function (response) {
                    if (response.errors && response.errors.length > 0) {
                        GEH.alert(response.errors[0].message, function () {
                            GEH.viewMessage(id);
                        });
                    }
                    else {
                        GEH.alert("Your message has been sent successfully!", function () {
                            GEH.viewMessage(id);
                        });
                    }
                }
            });
        };
        this.delete_message = function (id) {
            GEH.confirm("Do you want to delete the whole conversation of this message?", function () {
                $.ajax({
                    url: GEH.baseUrl + "message/ajax/delete_message",
                    type: "POST",
                    data: {
                        id: id
                    }, success: function (response) {
                        location.reload();
                    }
                });
            });
        }
        this.reply_conversation = function (id) {
            $.ajax({
                url: GEH.baseUrl + "message/ajax/reply",
                type: "POST",
                data: {
                    id: id,
                    subject: $("#postReply").val()
                }, success: function (response) {
                    if (response.errors && response.errors.length > 0) {
                        GEH.alert(response.errors[0].message, function () {
                            // GEH.viewMessage(id);
                            location.reload();
                        });
                    }
                    else {
                        GEH.alert("Your message has been sent successfully!", function () {
                            //GEH.viewMessage(id);
                            location.reload();
                        });
                    }
                }
            });
        };
    };

    var BookDetails = new function () {
        var self = this;
        this.bookId = false;
        this.sobId = false;
        this.init = function () {
            $("#bookReportForm").validate({
                errorElement: "div",
                submitHandler: function () {
                    GEH.reportBook();
                },
                rules: {
                    content: "required",
                    book_report_issue: {
                        greaterThan: 0
                    }
                },
                messages: {
                    book_report_issue: "Please choose issue"
                }
            });
            $("#saleListForm").validate({
                errorPlacement: function (error, element) {
                    if (!error.text()) return;
                    if (element.is(":checkbox") && element.attr("name") === "agree") {
                        //$('<span class="error"></span>').text(error.text()).insertAfter(element.next());
                        error.insertAfter(element.next());
                        return;
                    }
                    element.qtip(GEH.createQTipOptions({
                        content: error,
                        show: {
                            event: "focus",
                            modal: false,
                            solo: false
                        },
                        position: {
                            my: "bottom center",
                            at: "top center",
                            adjust: {
                                y: -5
                            }
                        }
                    }));
                },
                success: function (error, element) {
                    $(element).qtip("destroy");
                },
                submitHandler: function (form) {
                    var data = $(form).serialize() + "&book_id=" + self.bookId;
                    $(".qtip-link").qtip("hide");
                    GEH.listOnSaleList(data, function (response) {
                        GEH.openListingShareDialog(response.url)
                        /*
                         GEH.alert(response.message, function () {
                         location.reload();
                         });
                         */
                    });
                },
                rules: {
                    condition: {
                        greaterThan: 0
                    },
                    price: {
                        required: true,
                        number: true,
                        min: 1,
                        max: 999
                    }
                },
                messages: {
                    condition: false,
                    price: "Please enter a whole number"
                }
            });
            $("#wishListForm").validate({
                errorPlacement: function (error, element) {
                    if (!error.text()) return;
                    if (element.is(":checkbox") && element.attr("name") === "agree") {
                        //$('<span class="error"></span>').text(error.text()).insertAfter(element.next());
                        error.insertAfter(element.next());
                        return;
                    }
                    element.qtip(GEH.createQTipOptions({
                        content: error,
                        show: {
                            event: "focus",
                            modal: false,
                            solo: false
                        },
                        position: {
                            my: "bottom center",
                            at: "top center",
                            adjust: {
                                y: -5
                            }
                        }
                    }));
                },
                invalidHandler: function () {
                    $("#errorWrap1").show();
                },
                submitHandler: function (form) {
                    var data = $(form).serialize() + "&book_id=" + self.bookId;
                    $(".qtip-link").qtip("hide");
                    GEH.listOnWishList(data, function (response) {
                        GEH.openListingShareDialog(response.url)
                        /*
                         GEH.alert(response.message, function () {
                         location.reload();
                         });
                         */
                    });
                },
                rules: {
                    price: {
                        required: true,
                        number: true,
                        min: 1,
                        max: 999
                    }
                },
                messages: {
                    price: "Please enter a whole number"
                }
            });
            if (this.sobId) {
                var $tr = $("#sob_" + this.sobId);
                if ($tr) {
                    var tabIndex = parseInt($tr.attr("data-sob"), 10);
                    var interval = setInterval(function () {
                        var $btab = $(".btablive");
                        if (!$btab) return;
                        $btab.get(0).btab.taGEHhow(tabIndex);
                        $tr.addClass("highlight");
                        setTimeout(function () {
                            $tr.removeClass("highlight");
                        }, 5000);
                        clearInterval(interval);
                    }, 1000);
                }
            }
        };
    };

    var StarRating = new function () {
        this.init = function () {
            $("body").delegate(".star", "mouseover",function () {
                var $this = $(this);
                var value = parseInt($this.attr("data-value"), 10);
                $this.parent().find(".star").each(function () {
                    $t = $(this);
                    $t.removeClass("selected");
                    if (value >= parseInt($t.attr("data-value"), 10)) {
                        $t.addClass("selected");
                    }
                });
            }).delegate(".star", "mouseout",function () {
                var $this = $(this);
                var value = parseInt($this.parent().find("input[type=hidden]").val(), 10) || 0;
                $this.parent().find(".star").each(function () {
                    $t = $(this);
                    $t.removeClass("selected");
                    if (value >= parseInt($t.attr("data-value"), 10)) {
                        $t.addClass("selected");
                    }
                });
            }).delegate(".star", "click", function () {
                var $this = $(this);
                $this.parent().find("input[type=hidden]").val($this.attr("data-value"));
            });
        };
        this.reset = function ($wrap) {
            $wrap.find(".star").removeClass("selected");
            $wrap.find("input[type=hidden]").val(0);
        };
    };

    var Listing = new function () {
        var self = this;
        this.selectedBook = false;
        this.selectedMajor = false;

        this.init = function () {
            initBookTitleBox("#searchTitle");
            //set current form visible
            $form = $("#bookForm");
            if ($form.find("input[name=book_id]").val() > 0) {
                $("#bookFormBox").hide();
                $('#listingFormWrap').fadeIn(200);
            }
            $("#bookForm").validate({
                submitHandler: function (form) {
                    var $form = $(form);
                    var listOwnBook =
                        self.selectedBook.title != $form.find("input[name=title]").val() ||
                            self.selectedBook.author != $form.find("input[name=author]").val() ||
                            self.selectedBook.isbn10 != $form.find("input[name=isbn10]").val() ||
                            self.selectedBook.isbn13 != $form.find("input[name=isbn13]").val() ||
                            self.selectedBook.pubYear != $form.find("input[name=publish]").val();
                    var data = $("#bookForm").serialize() + "&" + $form.serialize();
                    var imageFileName = $("#imgBook").attr("data-file");
                    if (imageFileName) {
                        data += "&book_image=" + imageFileName;
                    }

                    if (!listOwnBook) {
                        $('#listingFormWrap').fadeIn(200);
                    } else {
//                    $('#selectCourseFormWrap').fadeIn(200);
                        //do nothing
                    }
                    $("#bookFormBox").hide();

                    GEH.block();
                    $.ajax({
                        url: GEH.baseUrl + "listing/ajax/insert_book",
                        type: "POST",
                        data: data,
                        success: function (response) {
                            GEH.unblock();
                            if (response.errors && response.errors.length > 0) {
                                //GEH.alert(response.errors[0].message);
                                GEH.confirm("Your book is duplicated. Do you want to use this book?<br />" +
                                    "Click Yes to use this book, No to back!", function () {
                                    self.selectedBook = {
                                        id: response.book_id
                                    };
                                    $('#listingFormWrap').fadeIn(200);
                                    $form.hide();
                                    //GEH.openListingShareDialog();
                                }, function () {
                                    location.reload();
                                });
                                return;
                            }
                            //GEH.unblock();
                            self.selectedBook = {
                                id: response.book_id
                            };
                            $('#listingFormWrap').fadeIn(200);
                            $form.hide();
                        },
                        error: function (result) {
                            console.log(result);
                        }
                    });
                },
                rules: {
                    college: {
                        greaterThan: 0
                    },
                    title: "required",
                    isbn10: {
                        requiredOne: "#isbn13",
                        isbn10: true
                    },
                    isbn13: {
                        requiredOne: "#isbn10",
                        isbn13: true
                    },
                    publish: {
                        number: true
                    },
                    course_number: {
                        number: true,
                        required: true
                    }
                },
                messages: {
                    college: "Please choose college",
                    title: false,
                    isbn10: "Please enter 10 numbers and/or letters",
                    isbn13: "Please enter 13 numbers and/or letters",
                    course_number: "Please input number."
                }
            });

            $("#selectCourseForm").validate({
                errorElement: "div",
                submitHandler: function () {
                    var $form = $(this.currentForm);
                    var data = $("#bookForm").serialize() + "&" + $form.serialize();
                    var imageFileName = $("#imgBook").attr("data-file");
                    if (imageFileName) {
                        data += "&book_image=" + imageFileName;
                    }
                    GEH.block();
                    $.ajax({
                        url: GEH.baseUrl + "listing/ajax/insert_book",
                        type: "POST",
                        data: data,
                        success: function (response) {
                            GEH.unblock();
                            if (response.errors && response.errors.length > 0) {
                                //GEH.alert(response.errors[0].message);
                                GEH.confirm("Your book is duplicated. Do you want to use this book?<br />" +
                                    "Click Yes to use this book, No to back!", function () {
                                    self.selectedBook = {
                                        id: response.book_id
                                    };
                                    $('#listingFormWrap').fadeIn(200);
                                    $form.hide();
                                    //GEH.openListingShareDialog();
                                }, function () {
                                    location.reload();
                                });
                                return;
                            }
                            //GEH.unblock();
                            self.selectedBook = {
                                id: response.book_id
                            };
                            $('#listingFormWrap').fadeIn(200);
                            $form.hide();
                        },
                        error: function (result) {
                            console.log(result);
                        }
                    });
                },
                rules: {
                    course_number: {
                        number: true,
                        required: true
                    }
                },
                messages: {
                    course_number: "Please input number."
                }

            });

            $("#listingForm").validate({
                submitHandler: function () {
                    var $form = $(this.currentForm);
                    $("#book_id").val(self.selectedBook.id);
                    var data = $form.serialize();
                    GEH.block();
                    $.ajax({
                        url: GEH.baseUrl + "listing/ajax/list_book",
                        type: "POST",
                        data: data,
                        success: function (response) {
                            GEH.unblock();
                            if (response.errors && response.errors.length > 0) {
                                GEH.alert(response.errors[0].message);
                                return;
                            }
                            GEH.openListingShareDialog(response.url);
                        },
                        error: function (result) {
                            console.log(result);
                        }
                    });
                },
                /*
                 submitHandler: function (form) {
                 $("#book_id").val(self.selectedBook.id);
                 form.submit();
                 },
                 */
                rules: {
                    condition: {
                        greaterThan: 0
                    },
                    price: {
                        required: true,
                        number: true,
                        min: 1,
                        max: 999
                    },
                    agree: "required"
                },
                messages: {
                    condition: false,
                    price: "Please enter a whole number",
                    agree: "Please agree with our Terms of Use and Privacy Policies"
                }
            });

            $("#ddlColleges").change(function () {
                var collegeId = parseInt($(this).val(), 10);
                if (!collegeId) return;
                GEH.block();
                $.ajax({
                    url: GEH.baseUrl + "ajax/majors/" + collegeId,
                    data: {},
                    success: function (response) {
                        GEH.unblock();
                        $('#majors').empty();
                        $.each(response, function (key, value) {
                            $('#majors')
                                .append($("<option></option>")
                                    .attr("value", value.id)
                                    .text(value.name));
                        });
                        if (!Listing.selectedMajor) {
                            $('#majors').change();
                        } else {
                            $('#majors').val(Listing.selectedMajor);
                        }
                    }
                });
            }).change();

            $("#majors").change(function () {
                var majorId = parseInt($(this).val(), 10);
                if (!majorId) return;
                GEH.block();
                $.ajax({
                    url: GEH.baseUrl + "ajax/courses/" + majorId,
                    data: {},
                    success: function (response) {
                        GEH.unblock();
                        //$('#courses').empty();
                        //$.each(response, function(key, value) {
                        //     $('#courses')
                        //         .append($("<option></option>")
                        //         .attr("value", value.id)
                        //         .text(value.name));
                        //});
                        $("#course").autocomplete({
                            source: response
                        });
                    }
                });
            });

            var uploader = new qq.FineUploaderBasic({
                button: $("#upload").get(0),
                multiple: false,
                maxConnections: 3,
                disableCancelForFormUploads: false,
                autoUpload: true,
                request: {
                    endpoint: GEH.baseUrl + 'upload/upload_book_image',
                    params: {
                        tmp_file: $("#imgBook").attr("src")
                    }
                },
                validation: {
                    allowedExtensions: ["jpeg", "jpg", "gif", "png"],
                    sizeLimit: 0,
                    minSizeLimit: 0,
                    stopOnFirstInvalidFile: true
                },
                callbacks: {
                    onSubmit: function (id, name) {
                        GEH.block();
                    },
                    onComplete: function (id, name, response) {
                        if (response.errors && response.errors.length > 0) {
                            GEH.alert(response.errors[0].message);
                            GEH.unblock();
                            return;
                        }
                        var img = new Image();
                        img.onload = function () {
                            GEH.unblock();
                            $("#imgBook").attr({
                                "src": this.src,
                                "data-file": this.filename
                            });
                        };
                        img.filename = response.file_name;
                        img.src = response.url;
                    },
                    onCancel: function (id, name) {
                    },
                    onUpload: function (id, name) {
                    },
                    onUploadChunk: function (id, name, chunkData) {
                    },
                    onResume: function (id, fileName, chunkData) {
                    },
                    onProgress: function (id, name, loaded, total) {
                    },
                    onError: function (id, name, reason) {
                    },
                    onAutoRetry: function (id, name, attemptNumber) {
                    },
                    onManualRetry: function (id, name) {
                    },
                    onValidateBatch: function (fileOrBlobData) {
                    },
                    onValidate: function (fileOrBlobData) {
                    },
                    onSubmitDelete: function (id) {
                    },
                    onDelete: function (id) {
                    },
                    onDeleteComplete: function (id, xhr, isError) {
                    }
                }
            });
        };


        function initBookTitleBox(selector) {
            //initWatermark($(selector));
            $(selector).autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: GEH.baseUrl + "search/ajax/search_without_isbn",
                        dataType: "json",
                        data: {
                            s: request.term,
                            cid: parseInt($("#ddlColleges").val(), 10)
//                        crid: parseInt($("#course").val(), 10)
                        },
                        success: function (data) {
                            response($.map(data.data, function (item) {
                                return {
                                    label: item.title,
                                    value: item.title,
                                    id: item.id,
                                    url: item.url
                                };
                            }));
                        }
                    });
                },
                minLength: 3,
                select: function (event, ui) {
                    var bookId = parseInt(ui.item.id, 10);
                    $.ajax({
                        url: GEH.baseUrl + "ajax/book_info/" + bookId,
                        data: {},
                        success: function (response) {
                            self.selectedBook = response;
                            $form = $("#bookForm");
                            $form.find("input[name=hdBookId]").val(response.id);
                            $form.find("input[name=author]").val(response.author);
                            $form.find("input[name=isbn10]").val(response.isbn10);
                            $form.find("input[name=isbn13]").val(response.isbn13);
                            $form.find("input[name=publish]").val(response.pubYear);
                            $("#imgBook").attr("src", response.imageUrl);
                        }
                    });
                },
                open: function () {
                    $(this).removeClass("ui-corner-all").addClass(
                        "ui-corner-top");
                },
                close: function () {
                    $(this).removeClass("ui-corner-top").addClass(
                        "ui-corner-all");
                }
            });
        };
    };

    var FreeStuff = new function () {
        var self = this;
        this.init = function () {
            $("#freeStuffForm").validate({
                submitHandler: function (form) {
                    var $form = $(form);
                    var data = $form.serialize();
                    GEH.block();
                    $.ajax({
                        url: GEH.baseUrl + "free_stuff/ajax/insert_free_stuff",
                        type: "POST",
                        data: data,
                        success: function (response) {
                            GEH.unblock();
                            GEH.alert("Awesome! Your bumper sticker will arrive in 2-6 days!", function () {
                                location.reload();
                            });
                        },
                        error: function (result) {
                            console.log(result);
                        }
                    });
                },
                rules: {
                    name: "required",
                    address1: "required",
                    email: {
                        required: true,
                        email: true
                    },
                    city: "required",
                    state_list: {
                        greaterThan: 0
                    },
                    quantity_list: {
                        greaterThan: 0,
                        min: 1,
                        max: 5
                    },
                    zip_code: {
                        required: true,
                        number: true,
                        minlength: 5,
                        maxlength: 5,
                        number: true
                    }
                },
                messages: {
                    state_list: "Please choose your state.",
                    zip_code: "Please enter your 5-digit ZIP code"
                }
            });
        }
    }

    var CollegeRequests = new function () {
        this.requestCollege = function () {
            var url = GEH.baseUrl + "ajax/college_list_request";
            var data = $("#requestForm").serialize();
            $.ajax({
                url: url,
                type: "POST",
                data: data,
                success: function (response) {
                    if (response.errors && response.errors.length > 0) {
                        GEH.alert(response.errors[0].message);
                        return;
                    }
                    if (response.message) {
                        GEH.alert(response.message, function () {
                            location.reload();
                        });
                    }
                }
            });
        };
    };

    var UserHelpers = new function () {
        this.login = function () {
            var url = GEH.baseUrl + "login/ajax/login";
            var data = $("#signin").serialize();
            GEH.block();
            $.ajax({
                url: url,
                type: "POST",
                data: data,
                success: function (response) {
                    if (response.errors && response.errors.length > 0) {
                        var html = response.errors[0].message;
                        html += "<br />";
                        html += 'If you don\'t have an account yet, you can <a href="javascript:void(0)" class="blue" onclick="parent.GEH.openRegisterDialog()"><strong>create one</strong></a>. <br />';
                        html += 'If you forgot your password, you can request a new one by clicking <a href="javascript:void(0)" class="blue" onclick="parent.GEH.openForgotPasswordDialog()"><strong>Forgot password</strong></a>.';
                        GEH.alert(html);
                        GEH.unblock();
                        return;
                    }
                    if (response.returnUrl) {
                        parent.document.location = response.returnUrl;
                        return;
                    }
                    parent.location.reload();
                }
            });
            return false;
        };
        this.registerSocial = function () {
            var url = GEH.baseUrl + "register/ajax/register_social";
            var data = $("#registerSocialForm").serialize();
            GEH.block();
            $.ajax({
                url: url,
                type: "POST",
                data: data,
                success: function (response) {
                    if (response.errors && response.errors.length > 0) {
                        GEH.unblock();
                        if (response.errors[0].code == 20) {
                            GEH.alert(response.errors[0].message, function () {
                                parent.location.reload();
                                return;
                            });
                        } else if (response.errors[0].code > 0) {
                            GEH.alert(response.errors[0].message);
                            return;
                        }
                        return;
                    }
                    //parent.GEH.openRegisterDialog2(response.user_id);
                    parent.GEH.openRegisterDialog3(response.verified);
                }
            });
        };
        this.register = function () {
            var url = GEH.baseUrl + "register/ajax/register_verify";
            var data = $("#signupForm").serialize();
            GEH.block();
            $.ajax({
                url: url,
                type: "POST",
                data: data,
                success: function (response) {
                    if (response.errors && response.errors.length > 0) {
                        GEH.unblock();
                        if (response.errors[0].code == 20) {
                            GEH.alert(response.errors[0].message, function () {
                                parent.location.reload();
                                return;
                            });
                        } else if (response.errors[0].code > 0) {
                            GEH.alert(response.errors[0].message);
                            return;
                        }
                        //Recaptcha.reload();

                        return;
                    }
                    //parent.GEH.openRegisterDialog2(response.user_id);
                    parent.GEH.openRegisterDialog3(response.verified);
                }
            });
        };
        this.resendConfirmEmail = function () {
            var url = GEH.baseUrl + "register/ajax/resend_confirm_email";
            GEH.block();
            $.ajax({
                url: url,
                type: "POST",
                data: {},
                success: function (response) {
                    GEH.unblock();
                    if (response.errors && response.errors.length > 0) {
                        GEH.alert(response.errors[0].message);
                        return;
                    }
                    GEH.alert("We just sent you a verification email to your student email address. Please click the link on the email to confirm your college.");
                }
            });
        };
        this.verify = function () {
            var url = GEH.baseUrl + "register/ajax/verify";
            var data = $("#registerForm2").serialize();
            GEH.block();
            $.ajax({
                url: url,
                type: "POST",
                data: data,
                success: function (response) {
                    if (response.errors && response.errors.length > 0) {
                        GEH.alert(response.errors[0].message);
                        GEH.unblock();
                        return;
                    }
                    parent.GEH.openRegisterDialog3(response.verified);
                }
            });
        };
        this.skipVerify = function () {
            if (!$("#ddlCollege").valid() || !$("#agree").valid()) return;
            var collegeId = parseInt($("#ddlCollege").val(), 10);
            $.ajax({
                url: GEH.baseUrl + "register/ajax/skip_verify",
                type: "POST",
                data: {
                    college_id: collegeId,
                    user_id: parseInt($("#hfUserId").val(), 10)
                },
                success: function () {
                    parent.GEH.openRegisterDialog3();
                }
            });
        };
        this.edit = function () {
            var url = GEH.baseUrl + "profile/ajax/edit_profile";
            var data = $("#editProfileForm").serialize();
            GEH.block();
            $.ajax({
                url: url,
                type: "POST",
                data: data,
                success: function (response) {
                    GEH.unblock();
                    if (response.errors && response.errors.length > 0) {
                        GEH.alert(response.errors[0].message);
                        return;
                    }
                    if (response.changeStudentEmail) {
                        parent.GEH.openRegisterDialog3(response.verified);
                        return;
                    }
                    GEH.alert(response.message, function () {
                        parent.location.reload();
                    });
                }
            });
        };
        this.changePassword = function () {
            var url = GEH.baseUrl + "profile/ajax/change_password";
            var data = $("#changePasswordForm").serialize();
            GEH.block();
            $.ajax({
                url: url,
                type: "POST",
                data: data,
                success: function (response) {
                    GEH.unblock();
                    if (response.errors && response.errors.length > 0) {
                        GEH.alert(response.errors[0].message);
                        return;
                    }
                    GEH.alert("Your password was changed successfully!", function () {
                        parent.location.reload();
                    });
                }
            });
        };
        this.forgotPassword = function () {
            var url = GEH.baseUrl + "login/ajax/forgot_password";
            var data = $("#forgotPasswordForm").serialize();
            GEH.block();
            $.ajax({
                url: url,
                type: "POST",
                data: data,
                success: function (response) {
                    if (response.errors && response.errors.length > 0) {
                        var html = response.errors[0].message;
                        html += "<br />";
                        html += 'If you don\'t have an account yet, you can <a href="javascript:void(0)" class="blue" onclick="parent.GEH.openRegisterDialog()"><strong>create one</strong></a>.';
                        parent.GEH.alert(html, false, '<a style="margin-right: 5px;" href="javascript:void(0)" class="button" onclick="GEH.openForgotPasswordDialog();">Re-enter email</a>');
                        GEH.unblock();
                        return;
                    }
                    parent.GEH.alert("We just sent an email to <strong>" + response.email + "</strong> with a link that helps reset your password. Please check your email and click on the link to start.");
                    parent.location.reload();
                }
            });
        };
        this.resetPassword = function () {
            var url = GEH.baseUrl + "login/ajax/reset_password";
            var data = $("#resetPasswordForm").serialize();
            GEH.block();
            $.ajax({
                url: url,
                type: "POST",
                data: data,
                success: function (response) {
                    if (response.errors && response.errors.length > 0) {
                        GEH.alert(response.errors[0].message);
                        GEH.unblock();
                        return;
                    }
                    GEH.unblock();
                    GEH.alert("Your password was reset!", function () {
                        document.location = GEH.baseUrl;
                    });
                }
            });
        };
    };

    $.validator.addMethod("greaterThan", function (value, element, param) {
        value = parseInt(value, 10);
        return value > param;
    }, "Please input greater than {0}");

    $.validator.addMethod("requiredOne", function (value, element, param) {
        value = value.trim();
        param = $(param).val().trim();
        return !((!value || value.length === 0) && (!param || param.length === 0));
    }, "Please input one of them!");

    $.validator.addMethod("phoneUS", function (phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, "");
        return this.optional(element) || phone_number.length > 9 &&
            phone_number.match(/^\(?(\d{3})\)?[- ]?(\d{3})[- ]?(\d{4})$/);
    }, "Please enter your phone number as xxx-xxx-xxxx");


//override these in your code to change the default behavior and style
    /*$.blockUI.defaults = {
     // message displayed when blocking (use null for no message)
     message: '<h1>Please wait...</h1>',

     title: null,        // title string; only used when theme == true
     draggable: true,    // only used when theme == true (requires jquery-ui.js to be loaded)

     theme: false, // set to true to use with jQuery UI themes

     // styles for the message when blocking; if you wish to disable
     // these and use an external stylesheet then do this in your code:
     // $.blockUI.defaults.css = {};
     css: {
     padding: 0,
     margin: 0,
     width: '30%',
     top: '40%',
     left: '35%',
     textAlign: 'center',
     color: '#000'
     //border:         '3px solid #aaa',
     //backgroundColor:'#fff',
     //cursor:         'wait'
     },

     // minimal style set used when themes are used
     themedCSS: {
     width: '30%',
     top: '40%',
     left: '35%'
     },

     // styles for the overlay
     overlayCSS: {
     backgroundColor: '#000',
     opacity: 0.6
     //cursor:          'wait'
     },

     // style to replace wait cursor before unblocking to correct issue
     // of lingering wait cursor
     cursorReset: 'default',

     // styles applied when using $.growlUI
     growlCSS: {
     width: '350px',
     top: '10px',
     left: '',
     right: '10px',
     border: 'none',
     padding: '5px',
     opacity: 0.6,
     cursor: null,
     color: '#fff',
     backgroundColor: '#000',
     '-webkit-border-radius': '10px',
     '-moz-border-radius': '10px'
     },

     // IE issues: 'about:blank' fails on HTTPS and javascript:false is s-l-o-w
     // (hat tip to Jorge H. N. de Vasconcelos)
     iframeSrc: /^https/i.test(window.location.href || '') ? 'javascript:false' : 'about:blank',

     // force usage of iframe in non-IE browsers (handy for blocking applets)
     forceIframe: false,

     // z-index for the blocking overlay
     baseZ: 1000,

     // set these to true to have the message automatically centered
     centerX: true, // <-- only effects element blocking (page block controlled via css above)
     centerY: true,

     // allow body element to be stetched in ie6; this makes blocking look better
     // on "short" pages.  disable if you wish to prevent changes to the body height
     allowBodyStretch: true,

     // enable if you want key and mouse events to be disabled for content that is blocked
     bindEvents: true,

     // be default blockUI will supress tab navigation from leaving blocking content
     // (if bindEvents is true)
     constrainTabKey: true,

     // fadeIn time in millis; set to 0 to disable fadeIn on block
     fadeIn: 200,

     // fadeOut time in millis; set to 0 to disable fadeOut on unblock
     fadeOut: 400,

     // time in millis to wait before auto-unblocking; set to 0 to disable auto-unblock
     timeout: 0,

     // disable if you don't want to show the overlay
     showOverlay: true,

     // if true, focus will be placed in the first available input field when
     // page blocking
     focusInput: true,

     // suppresses the use of overlay styles on FF/Linux (due to performance issues with opacity)
     // no longer needed in 2012
     // applyPlatformOpacityRules: true,

     // callback method invoked when fadeIn has completed and blocking message is visible
     onBlock: null,

     // callback method invoked when unblocking has completed; the callback is
     // passed the element that has been unblocked (which is the window object for page
     // blocks) and the options that were passed to the unblock call:
     //   onUnblock(element, options)
     onUnblock: null,

     // don't ask; if you really must know: http://groups.google.com/group/jquery-en/browse_thread/thread/36640a8730503595/2f6a79a77a78e493#2f6a79a77a78e493
     quirksmodeOffsetHack: 4,

     // class name of the message block
     blockMsgClass: 'blockMsg',

     // if it is already blocked, then ignore it (don't unblock and reblock)
     ignoreIfBlocked: false
     };*/


    /* BEGIN UTILITIES METHODS */

    String.prototype.capitalize = function () {
        return this.charAt(0).toUpperCase() + this.slice(1);
    };
    if (typeof String.prototype.trim !== 'function') {
        String.prototype.trim = function () {
            return this.replace(/^\s+|\s+$/g, '');
        };
    }
    if (!Array.prototype.indexOf) {
        Array.prototype.indexOf = function (searchElement /*, fromIndex */) {
            "use strict";
            if (this == null) {
                throw new TypeError();
            }
            var t = Object(this);
            var len = t.length >>> 0;
            if (len === 0) {
                return -1;
            }
            var n = 0;
            if (arguments.length > 1) {
                n = Number(arguments[1]);
                if (n != n) { // shortcut for verifying if it's NaN
                    n = 0;
                } else if (n != 0 && n != Infinity && n != -Infinity) {
                    n = (n > 0 || -1) * Math.floor(Math.aGEH(n));
                }
            }
            if (n >= len) {
                return -1;
            }
            var k = n >= 0 ? n : Math.max(len - Math.aGEH(n), 0);
            for (; k < len; k++) {
                if (k in t && t[k] === searchElement) {
                    return k;
                }
            }
            return -1;
        };
    }
}

/* END UTILITIES METHODS */