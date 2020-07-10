$(function () {
    submitForm();
});

function submitForm() {
    $('.form').submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let url = form.attr('action');
        let data = form.serializeArray();

        data.push({ name: 'page', 'value': document.location.href });

        disableControls(form);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function (response) {
                enableControls(form);
                form.find("input[type=text], input[type=tel], input[type=email], textarea").val("");
            },
        })
    });
}

function disableControls(elem){
    let controls = elem.find('input, textarea, button, select, input[type="checkbox"]');
    controls.prop('disabled', true);
    elem.css('opacity', 0.5);
}

function enableControls(elem){
    let controls = elem.find('input, textarea, button, select, input[type="checkbox"]');
    elem.css('opacity', 1);
    controls.prop('disabled', false);
}
