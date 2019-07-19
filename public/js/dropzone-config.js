$('#addImagem').on('click', function () {
    $("#imagem-modal").modal();
});

Dropzone.options.myDropzone = {
    maxFilesize: 16,
    acceptedFiles: "image/*",
    previewTemplate: document.querySelector('#preview').innerHTML,
    addRemoveLinks: true,
    dictRemoveFile: "Remover Imagem",
    dictFileTooBig: 'Image is larger than 16MB',
    uploadMultiple: false,
    timeout: 10000,
    autoProcessQueue: false,

    init: function () {

        this.on("thumbnail", function (file) {
            $('#crop-modal').modal();
            var image_holder = $('#image-holder');
            image_holder.empty();
            $('<img />', {
                'src': file.dataURL,
                'id': 'image',
                'style': 'max-width: 750px',
            }).appendTo(image_holder);
            $("#image").cropper({
                minContainerWidth: 750,
                minContainerHeight: 400,
                zoomable: false
            });
            image_holder.show();
            $('.dz-progress').hide();
        });

        this.on("removedfile", function (file) {

            imageId = file.previewTemplate['childNodes']['3']['id'];

            $.ajax({
                url: '/images-delete',
                data: {id: imageId},
                method: 'POST',
                dataType: 'json',
                success: function (data) {
                    alert('Imagem removida com sucesso!');
                }
            });
        });
    },

    error: function (file, message) {
        console.log(message);
        $(file.previewElement).addClass("dz-error").find('.dz-error-message').text(message.Message);
    },
};