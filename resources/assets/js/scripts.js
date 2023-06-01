var body = $('body');


$(function(){

    body.on('click', '#show-todo-add-form', function(){
        $('#task-create-form').slideDown();
    });


    body.on('submit', '#task-create-form', function(evt){
        evt.preventDefault();
        let form = $(this);
        let btn=form.find('button[type=submit]');
        btn.prop('disabled',true);

        $.ajax({
            url: $(this).attr("action"),
            type: $(this).attr("method"),
            dataType: "JSON",
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function (respData, status)
            {
                btn.prop('disabled',false);
                if (respData.status==='success') {
                    $('#tasks-header').after(respData.html);
                    $('#task-create-form').slideUp();
                    form[0].reset();
                } else {
                    $.each(respData.errors, function (key, val) {
                        $('#task-create-errors').append('<li>'+val+'</li>');
                    });
                }
            },
            error: function (xhr, desc, err)
            {
                console.log('Ошибка отправки формы')
            }
        });

    });


    body.on('submit', '.task-edit-form', function(evt){
        evt.preventDefault();
        let form = $(this);
        let btn = form.find('button[type=submit]');
        let id = form.prop('id').split('-')[3];
        btn.prop('disabled',true);

        $.ajax({
            url: $(this).attr("action"),
            type: $(this).attr("method"),
            dataType: "JSON",
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function (respData, status)
            {
                btn.prop('disabled',false);
                if (respData.status==='success') {
                    $('#task-'+id+' + hr').remove();
                    form.after(respData.html).remove();
                } else {
                    $.each(respData.errors, function (key, val) {
                        $('#task-edit-errors').append('<li>'+val+'</li>');
                    });
                }
            },
            error: function (xhr, desc, err)
            {
                console.log('Ошибка отправки формы')
            }
        });

    });

    body.on('click', '.img-del-label', function(){
        let id = $(this).prop('for').split('-')[2];
        $(this).addClass('d-none');
        let image = $('#noimage').clone().prop('id', 'preview-edit-'+id).removeClass('d-none');
        $('#image-wrapper-'+id).html(image);
        $('#image-edit-'+id).val('');
    });

    body.on('input', '#tag-filter', function(){
        let form = $('#tag-filter-form');
        let action = form.prop('action');
        let formData = form.serialize();
        $.get(action, formData, function(respData) {
            $('#tasks-list').html(respData);
        });
    });

});

window.remove_task = function(id) {
    let form = $('#task-del-'+id);
    let action = form.prop('action');
    let formData = form.serialize();
    $.post(action, formData, function(respData) {
        $('#task-'+id+' + hr').remove();
        $('#task-'+id).remove();
    });
}

window.get_task_edit_form = function(id,action) {
    $.get(action, null, function(respData) {
        $('#task-'+id).addClass('d-none').before(respData);
    });
}

window.task_edit_cancel = function(id) {
    $('#task-edit-form-'+id).remove();
    $('#task-'+id).removeClass('d-none');
}

window.onFileSelected = function(event,id) {
    let selectedFile = event.target.files[0];
    let reader = new FileReader();

    let imgtag = document.getElementById('preview-edit-'+id);
    imgtag.title = selectedFile.name;

    reader.onload = function(event) {
        imgtag.src = event.target.result;

        let image = new Image();
        image.src = event.target.result;
        image.onload = function() {
            let img_width = this.width;
            let img_height = this.height;
            let div_width = $(imgtag).parent().width();
            let div_height = $(imgtag).parent().height();
            if (img_width>img_height) {
                $(imgtag).css({'width': 'auto', 'height': div_height});
                let newMargin = -($(imgtag).width()-div_width)/2+'px';
                $(imgtag).css({'margin-left': newMargin});
            } else {
                $(imgtag).css({'width': div_width, 'height': 'auto'});
                let newMargin = -($(imgtag).height()-div_height)/2+'px';
                $(imgtag).css({'margin-top': newMargin});
            }
        };
        $('#image-del-'+id).prop('checked',false);
        $('label[for=image-del-'+id+']').removeClass('d-none');

    };

    reader.readAsDataURL(selectedFile);

}
