function showComments(eventId) {
    $.ajax({
        url: `/events/${eventId}/comments`,
        method: 'GET',
        success: function(data) {
            console.log('Event Data:', data.event); // Debugging: Log the event data
            let commentsHtml = '<div class="flex bg-black p-2 rounded-lg ">';

            // Display the event image on the left side
            commentsHtml += `<div class="">`;
            commentsHtml += `<img src="${data.event.image}" alt="${data.event.title}" class="w-4/5 h-full mb-4 object-cover">`;
            commentsHtml += `</div>`;

            // Create a container for the creator's info and comments
            commentsHtml += '<div class="flex flex-col w-full overflow-auto mr-6">';

            // Display the name of the event creator if it exists
            if (data.event.user) {
                commentsHtml += `<div class="flex items-center mb-2">`;
                commentsHtml += `<div class="avatar avatar-sm bg-red-200 rounded-full h-10 w-10 flex items-center justify-center text-white font-bold" style="background-color: #${data.event.user.name.substring(0, 6)};">
                                <span class="avatar-initial">${data.event.user.name.charAt(0).toUpperCase()}</span>
                            </div>`;
                commentsHtml += `<div class="ml-4">`;
                commentsHtml += `<p class="text-lg text-white font-semibold">${data.event.user.name}</p>`;
                commentsHtml += `<p class="text-sm text-white text-gray-500">${data.event.major}</p>`;
                commentsHtml += `</div>`;
                commentsHtml += `</div>`; // End of creator info div
                commentsHtml += `<hr class="my-4">`; // Add a horizontal line
            } else {
                console.log('User data not found in event data'); // Debugging: Log if user data is missing
            }

            // Create a container for comments with a white background
            commentsHtml += '<div class="bg-black p-1 rounded-lg w-full ">';

            data.comments.forEach(comment => {
                commentsHtml += '<div class="flex items-start mb-4 gap-2 right-20">';

                // Display avatar
                commentsHtml += `<div class="avatar avatar-sm me-3 bg-blue-700 rounded-full h-10 w-10 flex items-center justify-center text-white font-bold" style="background-color: #${comment.user.name.substring(0, 6)}; ">
                            <span class="avatar-initial">${comment.user.name.charAt(0).toUpperCase()}</span>
                        </div>`;

                // Display comment content
                commentsHtml += `<div class="flex right-20 gap-2">`;
                commentsHtml += `<p class="text-white"><strong>${comment.user.name}:</strong></p>`;
                commentsHtml += `</br>`;
                commentsHtml += `<p class="text-white"> ${comment.content}</p>`;

                // Add delete button for authorized users (creator or admin)
                if (data.currentUser) {
                    // Show delete icon for the comment creator or admin users
                    if (data.currentUser.id === comment.user.id || data.currentUser.role === 'admin') {
                        commentsHtml += `<button class="delete-comment-btn text-sm text-red-500" data-comment-id="${comment.id}" onclick="deleteComment(${eventId}, ${comment.id})">                                        <i class="fa-regular fa-trash-can"></i></button>`;
                    }
                }
                commentsHtml += `</div>`;

                commentsHtml += '</div>'; // End of comment container div
            });

            commentsHtml += '</div>'; // End of comments container div
            commentsHtml += '</div>'; // End of flex container div

            commentsHtml += '</div>'; // End of main flex container

            Swal.fire({
                title: 'Comments',
                html: commentsHtml,
                width: '800px',
                padding: '3em',
                background: 'none',
                backdrop: `
                    rgba(0,0,123,0.4)
                    url("/images/nyan-cat.gif")
                    left top
                    no-repeat
                `
            });
        },
        error: function(xhr, status, error) {
            Swal.fire('Error', 'Unable to fetch comments.', 'error');
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    window.deleteComment = function(eventId, commentId) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        $.ajax({
            url: `/comments/${commentId}`,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire('Success', 'Comment deleted successfully.', 'success');
                    // Refresh comments after successful deletion
                    showComments(eventId); // Make sure to pass the correct eventId
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                Swal.fire('Error', 'Unable to delete comment.', 'error');
            }
        });
    }
});
