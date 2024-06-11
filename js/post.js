function changeImage(imageUrl) {
    document.getElementById('mainImage').src = imageUrl;
}

function showReplyForm(commentId) {
    console.log("🚀 ~ showReplyForm ~ commentId:", commentId)
    var replyForm = document.getElementById('reply-form-' + commentId);
    if (replyForm.style.display === "none") {
        replyForm.style.display = "block";
    } else {
        replyForm.style.display = "none";
    }
}