
function showAllPost(){  
    $.ajax({
        url:"./adminView/viewAllPost.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
        }
    });
}
function showCategory(){  
    $.ajax({
        url:"./adminView/viewCategories.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
        }
    });
}

function showSubCategory(type_id) {
    $.ajax({
        url: "./adminView/viewSubCategory.php",
        method: "post",
        data: { type_id: type_id },
        success: function(data) {
            $('.allContent-section').html(data);
        }
    });
}


function showCustomers(){
    $.ajax({
        url:"./adminView/viewCustomers.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
        }
    });
}
function showAllComments(){
    $.ajax({
        url:"./adminView/viewComments.php",
        method:"post",
        data:{record:1},
        success:function(data){
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
function postDelete(id){
    $.ajax({
        url:"./controller/deletePostController.php",
        method:"post",
        data:{record:id},
        success:function(data){
            $('form').trigger('reset');
            showAllPost();
        }
    });
}

function userDelete(id){
    $.ajax({
        url:"./controller/deleteUserController.php",
        method:"post",
        data:{record:id},
        success:function(data){
            $('form').trigger('reset');
            showCustomers();
        }
    });
}



//delete category data
function categoryDelete(id){
    $.ajax({
        url:"./controller/catDeleteController.php",
        method:"post",
        data:{record:id},
        success:function(data){
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
        success: function(data) {
            alert('ลบข้อมูลหมวดหมู่ย่อยเรียบร้อยแล้ว');
            $('form').trigger('reset');
            showSubCategory(type_id);
        }
    });
}

//delete comments data
function commentsDelete(id){
    $.ajax({
        url:"./controller/deleteCommentsController.php",
        method:"post",
        data:{record:id},
        success:function(data){
            alert('ลบข้อมูลการตอบกลับเรียบร้อยแล้ว');
            $('form').trigger('reset');
            showAllComments();
        }
    });
}


    // ฟังก์ชั่น adduser ที่ใช้ AJAX สำหรับเพิ่มผู้ใช้
    // function adduser(event) {
    //     event.preventDefault(); // ป้องกันการส่งฟอร์มตามปกติ
    //     let formData = new FormData(event.target);
      
    //     $.ajax({
    //       url: "./controller/adduserController.php",
    //       method: "post",
    //       data: formData,
    //       processData: false,
    //       contentType: false,
    //       success: function(data) {
    //         alert('เพิ่มข้อมูลผู้ใช้เรียบร้อยแล้ว');
    //         $('#addUserForm').trigger('reset'); // รีเซ็ตฟอร์ม
    //         showCustomers();
    //         $('#myModal').modal('hide'); // ปิด modal
    //       }
    //     });
    //   }

// detail post
// function detailpost(postId) {  
//     $.ajax({
//         url: "../post.php",
//         method: "post",
//         data: { record: postId }, // ส่งค่า postId ไปที่ post.php
//         success: function(data) {
//             $('.allContent-section').html(data);
//         }
//     });
// }
