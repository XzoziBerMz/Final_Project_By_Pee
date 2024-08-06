let uploadedFiles = [];
let removedImages = [];

function readURL(input) {
  if (input.files && input.files[0]) {
    for (let i = 0; i < input.files.length; i++) {
      uploadedFiles.push(input.files[i]); // Add the file to the global array
      const reader = new FileReader();
      reader.onload = (function (file, index) {
        return function (e) {
          const imagePreview = `
            <div class="image-container row">
              <img class="file-upload-image" src="${e.target.result}" alt="your image" width="200" height="200"/>
              <div>
                <button type="button" class="remove-single-image" onclick="removeSingleUpload(this, ${index})">Remove</button>
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
  updateDeletedImagesField();
}

function removeSingleUpload(button, index) {
  const imgElement = $(button).closest('.image-container').find('img');

  if (imgElement.length > 0 && imgElement.attr('src')) {
    const removedImage = imgElement.attr('src').split('/').pop();
    removedImages.push(removedImage);
    uploadedFiles.splice(index, 1);
    $(button).closest('.image-container').remove();

    if ($('.image-preview').children().length === 0) {
      $('.file-upload-content').hide();
      $('.drag-text').show();
      $('.file-upload-input').val(null);
    }
    updateFileInput();
    updateDeletedImagesField();
  } else {
    console.error('Image element not found or missing src attribute');
  }
}

function updateFileInput() {
  let dataTransfer = new DataTransfer();
  uploadedFiles.forEach(file => {
    dataTransfer.items.add(file);
  });
  $('.file-upload-input')[0].files = dataTransfer.files;
}

function updateDeletedImagesField() {
  document.getElementById('deleted_images').value = JSON.stringify(removedImages);
}