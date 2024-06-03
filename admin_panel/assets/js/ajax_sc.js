
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

function showSubCategory(){  
    $.ajax({
        url:"./adminView/viewSubCategory.php",
        method:"post",
        data:{record:1},
        success:function(data){
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

 //add product data
// function addItems(){
//     var p_name=$('#p_name').val();
//     var p_price=$('#p_price').val();
//     var p_desc=$('#p_desc').val();
//     var category=$('#category').val();
//     var subcategory=$('#subcategory').val();
//     var file=$('#file')[0].files[0];
//     var upload=$('#upload').val();

//     var fd = new FormData();
//     fd.append('p_name', p_name);
//     fd.append('p_price', p_price);
//     fd.append('p_desc', p_desc);
//     fd.append('category', category);
//     fd.append('subcategory', subcategory);
//     fd.append('file', file);
//     fd.append('upload', upload);
//     $.ajax({
//         url:"./controller/addPostController.php",
//         method:"post",
//         data:fd,
//         processData: false,
//         contentType: false,
//         success: function(data){
//             alert('เพิ่มประกาศใหม่เรียบร้อยแล้ว');
//             $('form').trigger('reset');
//             showProductItems();
//         }
//     });
// }

//edit product data
function PostEditForm(id){
    $.ajax({
        url:"./adminView/editPostForm.php",
        method:"post",
        data:{record:id},
        success:function(data){
            $('.allContent-section').html(data);
        }
    });
}

//update post after submit
function updatePost() {
    var formData = new FormData();
    formData.append('posts_id', document.getElementById('posts_id').value);
    formData.append('p_name', document.getElementById('p_name').value);
    formData.append('p_desc', document.getElementById('p_desc').value);

    var priceType = document.getElementById('p_price').value;
    formData.append('p_price', priceType);
    
    if (priceType === 'ราคาคงที่') {
        formData.append('fixedPrice', document.getElementById('fixedPrice').value);
    } else if (priceType === 'ต่อรองได้') {
        formData.append('negotiablePrice', document.getElementById('negotiablePrice').value);
    } else if (priceType === 'ฟรี') {
        formData.append('freePrice', document.getElementById('freePrice').value);
    }
    
    formData.append('category', document.getElementById('category').value);
    formData.append('Subcategory', document.getElementById('Subcategory').value);

    var newImage = document.getElementById('newImage').files[0];
    if (newImage) {
        formData.append('newImage', newImage);
    } else {
        formData.append('existingImage', document.getElementById('existingImage').value);
    }

    $.ajax({
        url: './controller/updatePostController.php',
        method: 'post',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
            alert('Post Update Success.');
            $('form').trigger('reset');
            showAllPost();
        },
    });

    return false; // Prevent default form submission
}


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

function eachDetailsForm(id){
    $.ajax({
        url:"./view/viewEachDetails.php",
        method:"post",
        data:{record:id},
        success:function(data){
            $('.allContent-section').html(data);
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
function SubcategoryDelete(id){
    $.ajax({
        url:"./controller/SubcatDeleteController.php",
        method:"post",
        data:{record:id},
        success:function(data){
            alert('ลบข้อมูลหมวดหมู่ย่อยเรียบร้อยแล้ว');
            $('form').trigger('reset');
            showSubCategory();
        }
    });
}

//delete variation data
function variationDelete(id){
    $.ajax({
        url:"./controller/deleteVariationController.php",
        method:"post",
        data:{record:id},
        success:function(data){
            alert('Successfully deleted');
            $('form').trigger('reset');
            showProductSizes();
        }
    });
}

//edit variation data
function variationEditForm(id){
    $.ajax({
        url:"./adminView/editVariationForm.php",
        method:"post",
        data:{record:id},
        success:function(data){
            $('.allContent-section').html(data);
        }
    });
}


//update variation after submit
function updateVariations(){
    var v_id = $('#v_id').val();
    var product = $('#product').val();
    var size = $('#size').val();
    var qty = $('#qty').val();
    var fd = new FormData();
    fd.append('v_id', v_id);
    fd.append('product', product);
    fd.append('size', size);
    fd.append('qty', qty);
   
    $.ajax({
      url:'./controller/updateVariationController.php',
      method:'post',
      data:fd,
      processData: false,
      contentType: false,
      success: function(data){
        alert('Update Success.');
        $('form').trigger('reset');
        showProductSizes();
      }
    });
}
function search(id){
    $.ajax({
        url:"./controller/searchController.php",
        method:"post",
        data:{record:id},
        success:function(data){
            $('.eachCategoryProducts').html(data);
        }
    });
}


function quantityPlus(id){ 
    $.ajax({
        url:"./controller/addQuantityController.php",
        method:"post",
        data:{record:id},
        success:function(data){
            $('form').trigger('reset');
            showMyCart();
        }
    });
}
function quantityMinus(id){
    $.ajax({
        url:"./controller/subQuantityController.php",
        method:"post",
        data:{record:id},
        success:function(data){
            $('form').trigger('reset');
            showMyCart();
        }
    });
}

function checkout(){
    $.ajax({
        url:"./view/viewCheckout.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
        }
    });
}


function removeFromWish(id){
    $.ajax({
        url:"./controller/removeFromWishlist.php",
        method:"post",
        data:{record:id},
        success:function(data){
            alert('Removed from wishlist');
        }
    });
}


function addToWish(id){
    $.ajax({
        url:"./controller/addToWishlist.php",
        method:"post",
        data:{record:id},
        success:function(data){
            alert('Added to wishlist');        
        }
    });
}

