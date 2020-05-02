$(document).ready(function(){
    $("#btnUpvote").click(function() {

    // postid ? 
    let commentId = this.dataset.commentid;
    let postId = $("#postID").val();
    let userId = $("#userID").val();
    console.log(commentId);
    console.log(postId);
    console.log(userId);
    // post naar database (AJAX)
    let formData = new FormData();
    formData.append('userId', userId);
    formData.append('commentId', commentId);

    fetch('ajax/savelike.php', {
    method: 'POST',
    body: formData
    })

    .then(response => response.json())
    .then(result => {
    console.log('Success:', result);
    })
    .catch(error => {
    console.error('Error:', error);
    });
});
});