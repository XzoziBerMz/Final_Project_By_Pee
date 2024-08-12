function changeImage(imageUrl) {
    document.getElementById('mainImage').src = imageUrl;
}

function showReplyForm(commentId) {
    var replyForm = document.getElementById('reply-form-' + commentId);
    if (replyForm.style.display === "none") {
        replyForm.style.display = "block";
    } else {
        replyForm.style.display = "none";
    }
}
function showReplyCommentForm(commentId) {
    console.log("🚀 ~ showReplyCommentForm ~ commentId:", commentId)
    var replyForm = document.getElementById('reply-form-comment-' + commentId);
    if (replyForm.style.display === "none") {
        replyForm.style.display = "block";
    } else {
        replyForm.style.display = "none";
    }
}

function showImageModal(imageUrl) {
    modalImage.src = document.getElementById('mainImage').src;
    var imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
    imageModal.show();
}


function showEditForm(commentId) {
    var editForm = document.getElementById('edit-comment-' + commentId);
    if (editForm) {
        if (editForm.style.display === "" || editForm.style.display === "none") {
            editForm.style.display = "block";
        } else {
            editForm.style.display = "none";
        }
    } else {
        console.error('Edit form element not found for commentId:', commentId);
    }
}

function showReplyForm(commentId) {
    var replyForm = document.getElementById('reply-form-' + commentId);
    if (replyForm) {
        if (replyForm.style.display === "" || replyForm.style.display === "none") {
            replyForm.style.display = "block";
        } else {
            replyForm.style.display = "none";
        }
    } else {
        console.error('Reply form element not found for commentId:', commentId);
    }
}

function toggleEditForm(commentId) {
    const form = document.querySelector(`#edit-form-${commentId}`);
    const formText = document.querySelector(`#text-edit-${commentId}`);

    if (form && formText) {
        if (form.style.display === 'none') {
            form.style.display = 'flex';
            formText.style.display = 'none';
        } else {
            form.style.display = 'none';
            formText.style.display = 'block';
        }
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const section = document.querySelector('#comment-section');
    const button = document.querySelector('#show-more-btn');

    if (section && button) {
        function checkContentHeight() {
            section.style.height = 'auto'; 
            const contentHeight = section.scrollHeight; 
            section.style.height = '350px'; 

            if (contentHeight > 350) {
                button.style.display = 'block'; 
            } else {
                button.style.display = 'none';
            }
        }

        checkContentHeight();
    } else {
        console.error('Elements not found.');
    }
});

function toggleShowMore() {
    const section = document.querySelector('#comment-section');
    const button = document.querySelector('#show-more-btn');

    if (section && button) { 
        if (section.style.height === 'max-content') {
            section.style.height = '350px';
            button.textContent = 'แสดงเพิ่มเติม';
        } else {
            section.style.height = 'max-content';
            button.textContent = 'แสดงน้อยลง';
        }
    } else {
        console.error('Elements not found.');
    }
}

function viewProductMore(value) {
    console.log("🚀 ~ viewProductMore ~ value:", value)
    window.location.href = `allcategory.php?act=showbytype&type_id=${value}`
    
}

function viewProfileBy(id) {
    console.log("🚀 ~ viewProfileBy ~ id:", id)
    window.location.href = `./profile_by.php?profile_id=${id}`
}

function ratingsCheck(checkbox, user_id, user_post_id, post_id) {
    const isChecked = checkbox.checked;

    const data = {
        user_id: user_id,        // User ID ของผู้ใช้
        ratings: isChecked,        // ค่า point ที่เป็น true หรือ false ขึ้นอยู่กับ checkbox
        post_id: post_id,        // Post ID ที่เกี่ยวข้อง
        user_post_id: user_post_id // User ID ของเจ้าของโพสต์
    };

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "points_update.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText); // ดูผลลัพธ์จากเซิร์ฟเวอร์
        } else if (xhr.readyState === 4) {
            console.error("เกิดข้อผิดพลาดในการส่งข้อมูล");
        }
    };
    xhr.send(JSON.stringify(data));
}