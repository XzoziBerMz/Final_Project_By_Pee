let uploadedFiles = []; // Global array to store the uploaded files

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader;
    for (var i = 0; i < input.files.length; i++) {
      uploadedFiles.push(input.files[i]); // Add the file to the global array
      reader = new FileReader();
      reader.onload = (function (file, i) {
        return function (e) {
          var imagePreview = `
                        <div class="image-container row">
                            <img class="file-upload-image" src="` + e.target.result + `" alt="your image" width="200" height="200"/>
                            <div>
                              <button type="button" class="remove-single-image" onclick="removeSingleUpload(this, ` + i + `)">Remove</button>
                            </div>
                        </div>`;
          $('.image-preview').append(imagePreview);
        };
      })(input.files[i], i);
      reader.readAsDataURL(input.files[i]);
    }
    $('.file-upload-content').show();
    $('.remove-image').show();
  }
}

function removeUpload() {
  uploadedFiles = []; // Clear the global array
  $('.image-preview').empty();
  $('.file-upload-content').hide();
  $('.remove-image').hide();
  $('.drag-text').show();
  $('.file-upload-input').val(null);
}

function removeSingleUpload(button, index) {
  uploadedFiles.splice(index, 1); // Remove the file from the global array
  $(button).closest('.image-container').remove();
  if ($('.image-preview').children().length == 0) {
    $('.file-upload-content').hide();
    $('.drag-text').show();
    $('.file-upload-input').val(null);
  }
  updateFileInput(); // Update the file input
}

function updateFileInput() {
  let dataTransfer = new DataTransfer();
  uploadedFiles.forEach(file => {
    dataTransfer.items.add(file);
  });
  $('.file-upload-input')[0].files = dataTransfer.files;
}
