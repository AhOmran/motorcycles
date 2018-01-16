require('./bootstrap');

var $body = $('body');

$('#formLogin').validate();
$('#formRegister').validate({
    rules: {
        password_confirmation: {
            equalTo: "#password"
        }
    }
});

$body.on('click', '.btn-select', function () {
    $(this).parents('.file-input').find('input[type=file]').click();
});

$body.on('change', '.file-input input[type=file]', function () {
    var $filename = $(this).parents('.file-input').find('.filename');

    return this.files[0] ? $filename.val(this.files[0].name) : $filename.val('');
});

$body.on('click', '.file-input .btn-delete', function () {
    $(this).parents('.file-input').remove();
});

$('.images .btn-add').on('click', function () {
    $('.images .inputs').append(
        Handlebars.compile($('#fileInputTemplate').html())
    );
});

$('.images .existing .btn-delete').on('click', function (e) {
    var $this = $(this);

    $('.images .existing').append(
        '<input type="hidden" name="deleted_image_ids[]" value="' + $this.data('id') + '">'
    );

    $this.closest('.thumb').remove();

    e.stopPropagation();
});

$body.on('click', '[data-method]', function (e) {
    e.preventDefault();

    var token = $('meta[name=csrf-token]').attr('content');

    var $form = $('<form></form>');
    $form.attr('action', $(this).data('url'));
    $form.attr('method', 'POST');
    $form.append(
        '<input type="hidden" name="_token" value="' + token + '">' +
        '<input type="hidden" name="_method" value="' + $(this).data('method') + '">'
    );

    $body.append($form);
    $form.submit();
});