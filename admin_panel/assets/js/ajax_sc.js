
function showAllPost() {
  $.ajax({
    url: "./adminView/viewAllPost.php",
    method: "post",
    data: { record: 1 },
    success: function (data) {
      $('.allContent-section').html(data);
    }
  });
}
function showAllPostDetail(id) {
  $.ajax({
    url: "./adminView/detailPost.php",
    method: "post",
    data: { record: 1, posts_id: id },
    success: function (data) {
      $('.allContent-section').html(data);
    }
  });
}
function showCategory() {
  $.ajax({
    url: "./adminView/viewCategories.php",
    method: "post",
    data: { record: 1 },
    success: function (data) {
      $('.allContent-section').html(data);
    }
  });
}

function showSubCategory(type_id) {
  $.ajax({
    url: "./adminView/viewSubCategory.php",
    method: "post",
    data: { type_id: type_id },
    success: function (data) {
      $('.allContent-section').html(data);
    }
  });
}


function showCustomers() {
  $.ajax({
    url: "./adminView/viewCustomers.php",
    method: "post",
    data: { record: 1 },
    success: function (data) {
      $('.allContent-section').html(data);
    }
  });
}

function showlocation() {
  $.ajax({
    url: "./adminView/viewpositions.php",
    method: "post",
    data: { record: 1 },
    success: function (data) {
      $('.allContent-section').html(data);
    }
  });
}

function showAllComments() {
  $.ajax({
    url: "./adminView/viewComments.php",
    method: "post",
    data: { record: 1 },
    success: function (data) {
      $('.allContent-section').html(data);
    }
  });
}



// category update

//update post after submit
// function updatePost() {
//     var formData = new FormData();
//     formData.append('posts_id', document.getElementById('posts_id').value);
//     formData.append('p_name', document.getElementById('p_name').value);
//     formData.append('p_desc', document.getElementById('p_desc').value);
//     formData.append('phone_number', document.getElementById('phone_number').value);

//     var priceType = document.getElementById('p_price').value;
//     formData.append('p_price', priceType);

//     if (priceType === 'ราคาคงที่') {
//         formData.append('fixedPrice', document.getElementById('fixedPrice').value);
//     } else if (priceType === 'ต่อรองได้') {
//         formData.append('negotiablePrice', document.getElementById('negotiablePrice').value);
//     } else if (priceType === 'ฟรี') {
//         formData.append('freePrice', document.getElementById('freePrice').value);
//     }

//     formData.append('category', document.getElementById('category').value);
//     formData.append('Subcategory', document.getElementById('Subcategory').value);

//     var newImage = document.getElementById('newImage').files[0];
//     if (newImage) {
//         formData.append('newImage', newImage);
//     } else {
//         formData.append('existingImage', document.getElementById('existingImage').value);
//     }

//     $.ajax({
//         url: './controller/updatePostController.php',
//         method: 'post',
//         data: formData,
//         processData: false,
//         contentType: false,
//         success: function(data) {
//             alert('Post Update Success.');
//             $('form').trigger('reset');
//             showAllPost();
//         },
//     });

//     return false; // Prevent default form submission
// }


//delete post data
function postDelete(id) {
  $.ajax({
    url: "./controller/deletePostController.php",
    method: "post",
    data: { record: id },
    success: function (data) {
      $('form').trigger('reset');
      showAllPost();
    }
  });
}

function userDelete(id) {
  $.ajax({
    url: "./controller/deleteUserController.php",
    method: "post",
    data: { record: id },
    success: function (data) {
      $('form').trigger('reset');
      showCustomers();
    }
  });
}

function locationDelete(id) {
  $.ajax({
    url: "./controller/deletePositonsController.php",
    method: "post",
    data: { record: id },
    success: function (data) {
      $('form').trigger('reset');
      showlocation();
    }
  });
}



//delete category data
function categoryDelete(id) {
  $.ajax({
    url: "./controller/catDeleteController.php",
    method: "post",
    data: { record: id },
    success: function (data) {
      alert('ลบข้อมูลหมวดหมู่เรียบร้อยแล้ว');
      $('form').trigger('reset');
      showCategory();
    }
  });
}

//delete Subcategory data
function SubcategoryDelete(id, type_id) {
  $.ajax({
    url: "./controller/SubcatDeleteController.php",
    method: "post",
    data: { record: id },
    success: function (data) {
      alert('ลบข้อมูลหมวดหมู่ย่อยเรียบร้อยแล้ว');
      $('form').trigger('reset');
      showSubCategory(type_id);
    }
  });
}

//delete comments data
function commentsDelete(id) {
  $.ajax({
    url: "./controller/deleteCommentsController.php",
    method: "post",
    data: { record: id },
    success: function (data) {
      alert('ลบข้อมูลการตอบกลับเรียบร้อยแล้ว');
      $('form').trigger('reset');
      showAllComments();
    }
  });
}

// update role users
function updateUserRole(userId, newRole) {
  $.ajax({
    url: './controller/updateUserRole.php',
    method: 'POST',
    data: {
      user_id: userId,
      new_role: newRole
    },
    success: function (response) {
      Swal.fire({
        title: 'Role ของผู้ใช้ถูกอัพเดตเรียบร้อย',
        icon: 'success',
        timer: 1500,
        showConfirmButton: false,
      });
    },
    error: function () {
      Swal.fire({
        title: 'ไม่สามารถอัพเดต role ของผู้ใช้ได้',
        icon: 'error',
        timer: 1500,
        showConfirmButton: false,
      });
    }
  });
}

// ฟังก์ชั่น adduser ที่ใช้ AJAX สำหรับเพิ่มผู้ใช้
function adduser(event) {
  event.preventDefault(); // ป้องกันการส่งฟอร์มตามปกติ

  let formData = new FormData(event.target);
  let submitButton = $(event.target).find('button[type="submit"]');
  submitButton.prop('disabled', true); // ปิดปุ่มส่งฟอร์มชั่วคราว

  $.ajax({
    url: "./controller/adduserController.php",
    method: "post",
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {
      alert(data); // แสดงข้อความที่ได้จากเซิร์ฟเวอร์
      $('#addUserForm').trigger('reset'); // รีเซ็ตฟอร์ม
      showCustomers();
      $('#myModal').modal('hide'); // ปิด modal
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error('Error: ' + textStatus, errorThrown); // แสดงข้อผิดพลาดใน console
    },
    complete: function () {
      submitButton.prop('disabled', false); // เปิดปุ่มส่งฟอร์มอีกครั้ง
    }
  });
}

// ฟังก์ชั่น addpositions ที่ใช้ AJAX สำหรับเพิ่มจุดนัดพบ
function addlocation(event) {
  event.preventDefault(); // ป้องกันการส่งฟอร์มตามปกติ

  let formData = new FormData(event.target);
  let submitButton = $(event.target).find('button[type="submit"]');
  submitButton.prop('disabled', true); // ปิดปุ่มส่งฟอร์มชั่วคราว

  $.ajax({
    url: "./controller/addpositionsController.php",
    method: "post",
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {
      alert(data); // แสดงข้อความที่ได้จากเซิร์ฟเวอร์
      $('#addlocationForm').trigger('reset'); // รีเซ็ตฟอร์ม
      showlocation();
      $('#myModal').modal('hide'); // ปิด modal
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error('Error: ' + textStatus, errorThrown); // แสดงข้อผิดพลาดใน console
    },
    complete: function () {
      submitButton.prop('disabled', false); // เปิดปุ่มส่งฟอร์มอีกครั้ง
    }
  });
}

// ฟังก์ชั่น updatepositions ที่ใช้ AJAX สำหรับเพิ่มผู้ใช้
function updatelocation(event) {
  event.preventDefault(); // ป้องกันการส่งฟอร์มตามปกติ

  let formData = new FormData(event.target);
  let submitButton = $(event.target).find('button[type="submit"]');
  submitButton.prop('disabled', true); // ปิดปุ่มส่งฟอร์มชั่วคราว

  $.ajax({
    url: "./controller/updatePositonsController.php",
    method: "post",
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {
      alert(data); // แสดงข้อความที่ได้จากเซิร์ฟเวอร์
      $('#updatelocationForm').trigger('reset'); // รีเซ็ตฟอร์ม
      showlocation();
      $('#editlocationModal').modal('hide'); // ปิด modal
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error('Error: ' + textStatus, errorThrown); // แสดงข้อผิดพลาดใน console
    },
    complete: function () {
      submitButton.prop('disabled', false); // เปิดปุ่มส่งฟอร์มอีกครั้ง
    }
  });
}

// ฟังก์ชั่น addcategory ที่ใช้ AJAX สำหรับเพิ่มผู้ใช้
function addCat(event) {
  event.preventDefault(); // ป้องกันการส่งฟอร์มตามปกติ

  let formData = new FormData(event.target);
  let submitButton = $(event.target).find('button[type="submit"]');
  submitButton.prop('disabled', true); // ปิดปุ่มส่งฟอร์มชั่วคราว

  $.ajax({
    url: "./controller/addCatController.php",
    method: "post",
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {
      alert(data); // แสดงข้อความที่ได้จากเซิร์ฟเวอร์
      $('#addCatForm').trigger('reset'); // รีเซ็ตฟอร์ม
      showCategory();
      $('#myModal').modal('hide'); // ปิด modal
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error('Error: ' + textStatus, errorThrown); // แสดงข้อผิดพลาดใน console
    },
    complete: function () {
      submitButton.prop('disabled', false); // เปิดปุ่มส่งฟอร์มอีกครั้ง
    }
  });
}

// ฟังก์ชั่น updatecategory ที่ใช้ AJAX สำหรับเพิ่มผู้ใช้
function updateCat(event) {
  event.preventDefault(); // ป้องกันการส่งฟอร์มตามปกติ

  let formData = new FormData(event.target);
  let submitButton = $(event.target).find('button[type="submit"]');
  submitButton.prop('disabled', true); // ปิดปุ่มส่งฟอร์มชั่วคราว

  $.ajax({
    url: "./controller/updateCatController.php",
    method: "post",
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {
      alert(data); // แสดงข้อความที่ได้จากเซิร์ฟเวอร์
      $('#updateCatForm').trigger('reset'); // รีเซ็ตฟอร์ม
      showCategory();
      $('#editcategoryModal').modal('hide'); // ปิด modal
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error('Error: ' + textStatus, errorThrown); // แสดงข้อผิดพลาดใน console
    },
    complete: function () {
      submitButton.prop('disabled', false); // เปิดปุ่มส่งฟอร์มอีกครั้ง
    }
  });
}


// ฟังก์ชั่น AddSubcategory ที่ใช้ AJAX สำหรับเพิ่มผู้ใช้
function addSubCat(type_id, event) {
  event.preventDefault(); // ป้องกันการส่งฟอร์มตามปกติ

  let formData = new FormData(event.target);
  let submitButton = $(event.target).find('button[type="submit"]');
  submitButton.prop('disabled', true); // ปิดปุ่มส่งฟอร์มชั่วคราว

  $.ajax({
    url: "./controller/addSubCatController.php",
    method: "post",
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {
      alert(data); // แสดงข้อความที่ได้จากเซิร์ฟเวอร์
      $('#addSubCatForm').trigger('reset'); // รีเซ็ตฟอร์ม
      showSubCategory(type_id);
      $('#myModalSub').modal('hide'); // ปิด modal
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error('Error: ' + textStatus, errorThrown); // แสดงข้อผิดพลาดใน console
    },
    complete: function () {
      submitButton.prop('disabled', false); // เปิดปุ่มส่งฟอร์มอีกครั้ง
    }
  });
}

// ฟังก์ชั่น updateSubcategory ที่ใช้ AJAX สำหรับเพิ่มผู้ใช้
function updateSubCat(type_id, event) {
  event.preventDefault(); // ป้องกันการส่งฟอร์มตามปกติ

  let formData = new FormData(event.target);
  let submitButton = $(event.target).find('button[type="submit"]');
  submitButton.prop('disabled', true); // ปิดปุ่มส่งฟอร์มชั่วคราว

  $.ajax({
    url: "./controller/updateSubCatController.php",
    method: "post",
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {
      alert(data); // แสดงข้อความที่ได้จากเซิร์ฟเวอร์
      $('#updateSubCatForm').trigger('reset'); // รีเซ็ตฟอร์ม
      showSubCategory(type_id);
      $('#editsubcategoryModal').modal('hide'); // ปิด modal
    },

    error: function (jqXHR, textStatus, errorThrown) {
      console.error('Error: ' + textStatus, errorThrown); // แสดงข้อผิดพลาดใน console
    },
    complete: function () {
      submitButton.prop('disabled', false); // เปิดปุ่มส่งฟอร์มอีกครั้ง
    }
  });
}
