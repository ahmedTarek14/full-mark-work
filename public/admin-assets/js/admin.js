//submit form using ajax
$(document).on("submit", ".ajax-form", function () {
    var form = $(this);
    var url = form.attr("action");
    var formData = new FormData(form[0]);
    form.find(":submit")
        .attr("disabled", true)
        .html('<i class="fas fa-yin-yang fa-spin"></i>');

    $.ajax({
        xhr: function () {
            var xhr = new window.XMLHttpRequest();

            xhr.upload.addEventListener(
                "progress",
                function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        $(".progress-bar").width(percentComplete + "%");
                        $(".progress-bar").html(percentComplete + "%");
                    }
                },
                false
            );

            return xhr;
        },
        url: url,
        method: "POST",
        dataType: "json",
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
            notification("success", response, "fas fa-check");
            setTimeout(function () {
                window.location.reload();
            }, 2000);
        },
        error: function (jqXHR) {
            var response = $.parseJSON(jqXHR.responseText);
            notification("danger", response, "fas fa-times");
            form.find(":submit").attr("disabled", false).html("Save");
        },
    });
    $.ajaxSetup({
        headers: {
            "X-CSRF-Token": $('input[name="_token"]').val(),
        },
    });
    return false;
});
// In your Javascript (external .js resource or <script> tag)
$(document).ready(function () {
    $(".select2").select2();
});

//open edit form in model
$(document).on("click", ".btn-modal-view", function () {
    var $this = $(this);
    var url = $this.data("url");
    var originalHtml = $this.html();

    $.ajax({
        url: url,
        method: "GET",
        success: function (data) {
            $this.prop("disabled", false).html(originalHtml);
            $("#common-modal").modal("show");
            $("#edit-area").html(data);
        },
    });
});

//load more button
$(document).on("click", "#load-more-button", function () {
    var button = $(this);
    var url = button.data("url");
    var last_page = parseInt($(this).attr("data-last"));
    var counter = parseInt($(this).attr("data-count")) + 1;

    $.ajax({
        url: url,
        method: "GET",
        data: {
            page: counter,
            _token: $('input[name="_token"]').val(),
        },
        success: function (response) {
            button.attr("data-count", counter);
            if (counter + 1 > last_page) {
                button.css("display", "none");
            }
            $("#load-area").append(response);
        },
    });
    return false;
});

//add delete url to form
$(document).on("click", ".delete-btn", function () {
    var url = $(this).data("url");

    $("#delete-form").attr("action", url);
    $("#delete").modal("show");
});

//add restore url to form
$(document).on("click", ".restore-btn", function () {
    var url = $(this).data("url");

    $("#restore-form").attr("action", url);
    $("#restore").modal("show");
});

//bootstrap notify
function notification(type, message, icon) {
    var content = {};

    content.message = message;
    content.icon = icon;

    var notify = $.notify(content, {
        type: type,
        allow_dismiss: false,
        newest_on_top: true,
        mouse_over: true,
        spacing: 10,
        timer: 2000,
        placement: {
            from: "bottom",
            align: "right", // isRTL() ? 'left' :
        },
        offset: {
            x: 10,
            y: 10,
        },
        delay: 1000,
        z_index: 99999999,
        animate: {
            enter: "animated fadeInUp",
            exit: "animated fadeOutDown",
        },
    });
}
