
function openNav() {
  document.getElementById("mySidebar").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";  
  document.getElementById("main-content").style.marginLeft = "250px";
  document.getElementById("main").style.display="none";
}

function closeNav() {
  document.getElementById("mySidebar").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";  
  document.getElementById("main").style.display="block";  
}


document.getElementById('photo_file').addEventListener('change', function (event) {
  const preview = document.getElementById('preview-images');
  preview.innerHTML = ''; // Clear the preview area
  const files = event.target.files;

  if (files) {
    Array.from(files).forEach(file => {
      const reader = new FileReader();
      reader.onload = function (e) {
        const img = document.createElement('img');
        img.src = e.target.result;
        img.style.width = '100px';
        img.style.margin = '10px';
        preview.appendChild(img);
      }
      reader.readAsDataURL(file);
    });
  }
});
