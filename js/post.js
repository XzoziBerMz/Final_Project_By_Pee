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