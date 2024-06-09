function readURL(input) {
  console.log("🚀 ~ readURL ~ input:", input.files)
  if (input.files && input.files[0]) {
    var reader;
    for (var i = 0; i < input.files.length; i++) {
      reader = new FileReader();
      reader.onload = (function (file, i) {
        return function (e) {
          var imagePreview = `
                    <div class="image-container row">
                        <img class="file-upload-image" src="` + e.target.result + `" alt="your image" width="200" height="200"/>
                        <div>
                          <button type="button" class="remove-single-image" onclick="removeSingleUpload(this)">Remove</button>
                        </div>
                    </div>`;
          $('.image-preview').append(imagePreview);
        };
      })(input.files[i], i);
      reader.readAsDataURL(input.files[i]);
    }
    $('.file-upload-content').show();
    $('.remove-image').show();
    // $('.drag-text').hide();
  }
}

function removeUpload() {
  $('.image-preview').empty();
  $('.file-upload-content').hide();
  $('.remove-image').hide();
  $('.drag-text').show();
  $('.file-upload-input').val(null);
}

function removeSingleUpload(button) {
  $(button).closest('.image-container').remove();
  if ($('.image-preview').children().length == 0) {
    $('.file-upload-content').hide();
    $('.drag-text').show();
    $('.file-upload-input').val(null);
  }
}
