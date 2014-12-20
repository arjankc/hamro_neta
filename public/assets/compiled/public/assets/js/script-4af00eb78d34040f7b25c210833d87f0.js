$(document).ready(function() {
    $('.chosen-select').chosen();
    format_date();
    ajax_submit();
    // Event listeners for ajax paginations
    var target = $(".ajax").find("a");

    if (target.length > 0) {
        target.livequery("click", function(e) {
            e.preventDefault();
            var target_url = $(this).attr("href");
            NProgress.start();

            $(".ajax-replace").load(target_url, function () {
                ajax_done_cb();
                $('meta[property="og:url"]').attr('content', target_url);
                window.history.pushState({ path: this.path }, '', target_url);
                if (window.top.location.search) {
                    if (window.top.location.search.match(/party=(\d)+/img)) {
                        party_id = window.top.location.search.match(/party=(\d)+/img)[0].replace('party=','');
                        $("#party-id").val(party_id);
                    }
                }
            });
        });

        $(window).bind('popstate', function() {
            NProgress.start();
            $('.ajax-replace').load(window.location.href, function() {
                ajax_done_cb();
            });
        });
    }
});
function unescapeHtml(unsafe) {
    return unsafe
         .replace("&amp;", '&')
         .replace("&lt;", '<')
         .replace("&gt;", '>')
         .replace("&quot;", '"')
         .replace("&#039;", '\'');
 }
function format_date() {
    $('.date-time').each(function() {
        $(this).html(moment($(this).html(), "YYYYMMDD").fromNow());
    });
}
function ajax_done_cb () {
    $('.alert').remove();   // Remove any alerts
    format_date();
    $("#testimonial_tab").css('visibility', 'visible');
    $( "#testimonial_tab" ).tabs({active: 2});
    if ($("#page-title")) {
        page_title = unescapeHtml($("#page-title").html()) + ' :: Hamro Neta';
        window.top.document.title = page_title;
        $('meta[property="og:title"]').attr('content', page_title);
    }
    $("html, body").animate({ scrollTop: 0 }, "fast");
    ReinitializeAddThis();
    NProgress.done();
}
// Ajax for form submits (GET, POST)
function ajax_submit () {
    $('form').livequery(function() {
        $(this).submit(function() {
            if ($(this).attr('class') != 'no-ajax') {
                var url = $(this).attr('action');
                var serialized = $(this).serialize();
                var method = $(this).attr('method');

                NProgress.start();
                $.ajax({
                    type: method,
                    url: url,
                    data: serialized, // serializes the form's elements.
                    success: function(data) {
                        ajax_submit_cb(data);
                        if (method != 'POST') {
                            window.history.pushState({ path: this.path }, '', url + '?' + serialized);
                        }
                    }
                });
                return false;
            }
        });
    });
}

function ajax_submit_cb(data) {
    $('.alert').remove();   // Remove any alerts
    if (data.match(/<div class='alert/img)) {
        // For only notifications
        $("#search_input_div").after(data);
        if (data.contains("<div class='alert alert-success'>You have successfully voted for")) {
            $('span.vote_this').html(parseInt($('span.vote_this').html()) + 1);
        }
        $("html, body").animate({ scrollTop: $(".alert").offset().top }, "fast");
    } else {
        $(".ajax-replace").html(data);
        $("html, body").animate({ scrollTop: 0 }, "fast");
    }
    format_date();
    if ($("#page-title")) {
        page_title = unescapeHtml($("#page-title").html()) + ' :: Hamro Neta';
        window.top.document.title = page_title;
        $('meta[property="og:title"]').attr('content', page_title);
    }
    NProgress.done();
}
function ReinitializeAddThis() {
    if (window.addthis){
        window.addthis.ost = 0;
        window.addthis.ready();
    }
}
