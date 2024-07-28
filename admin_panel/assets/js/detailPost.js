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

function toggleShowMore() {
    const section = document.querySelector('#comment-section');
    const button = document.querySelector('#show-more-btn');

    if (section && button) { 
        if (section.style.height === 'max-content') {
            section.style.height = '350px';
            button.textContent = 'Show More';
        } else {
            section.style.height = 'max-content';
            button.textContent = 'Show Less';
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
    window.location.href = `../../profile_by.php?profile_id=${id}`
}
