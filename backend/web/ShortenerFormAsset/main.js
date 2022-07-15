/**
 * Variables
 */
var formId = 'sf__form';

/**
 * Submit form with AJAX
 */
var form = $('#' + formId);
form.on('beforeSubmit', function() {
    var data = form.serialize();
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: data,
        success: function(data) {
            $('.shortener-form-result').val(data['url']);
        },
        error: function(jqXHR, message) {
            $('.shortener-form-result').html(`Произошла неизвестная ошибка,\
                пожалуйста, попробуйте еще раз.`);
        }
    });
    return false;
});

function sfCopyToClickboard(e) {
    var inputGroup = $(e.target).parents('.input-group');
    var input = inputGroup.find('input.shortener-form-result');
    console.log(input);
    sfCopyToClipboard(input.val())
        .then(() => sfSetFlash('Ваша ссылка успешно скопирована в буфер обмена!'))
        .catch(() => console.log('Error on copy to clickboard!'));
    e.preventDefault();
}

function sfCopyToClipboard(text) {
    if (navigator.clipboard && window.isSecureContext) {
        // only HTTPS
        return navigator.clipboard.writeText(text);
    } else {
        let textArea = document.createElement("textarea");
        textArea.value = text;
        textArea.style.position = "absolute";
        textArea.style.opacity = 0
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        return new Promise((res, rej) => {
            // but execCommand is deprecated
            document.execCommand('copy') ? res() : rej();
            textArea.remove();
        });
    }
}

function sfSetFlash(text) {
    var container = $('body main .container');
    container.prepend(`
    <div class="alert-success alert alert-dismissible" role="alert">
        ${text}
        <button type="button" class="close" data-dismiss="alert">
            <span aria-hidden="true">×</span>
        </button>
    </div>`);
    $(".alert").animate({opacity: 1.0}, 1000).fadeOut("slow");
}