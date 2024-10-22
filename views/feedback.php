<?php
if (!defined('APP_RUNNING')) {
    die('Access denied'); // Stop execution if accessed directly
}

// Your existing code goes here...
?>


<div class="container-fluid p-4 main-content" id="mainContent">
    <h1 class="text-center mb-4 view_feedback-title">Feedback for Virtual Uni</h1>
    
    <form id="feedbackForm" class="view_feedback-form">
        <div class="view_feedback-question">
            <label for="question1">How would you rate the overall experience?</label>
            <div class="view_feedback-star-rating" data-question="1">
                <span class="view_feedback-star" data-value="1">&#9733;</span>
                <span class="view_feedback-star" data-value="2">&#9733;</span>
                <span class="view_feedback-star" data-value="3">&#9733;</span>
                <span class="view_feedback-star" data-value="4">&#9733;</span>
                <span class="view_feedback-star" data-value="5">&#9733;</span>
            </div>
        </div>
        
        <div class="view_feedback-question">
            <label for="question2">How would you rate the quality of the courses?</label>
            <div class="view_feedback-star-rating" data-question="2">
                <span class="view_feedback-star" data-value="1">&#9733;</span>
                <span class="view_feedback-star" data-value="2">&#9733;</span>
                <span class="view_feedback-star" data-value="3">&#9733;</span>
                <span class="view_feedback-star" data-value="4">&#9733;</span>
                <span class="view_feedback-star" data-value="5">&#9733;</span>
            </div>
        </div>

        <div class="view_feedback-question">
            <label for="question3">How would you rate the support from staff?</label>
            <div class="view_feedback-star-rating" data-question="3">
                <span class="view_feedback-star" data-value="1">&#9733;</span>
                <span class="view_feedback-star" data-value="2">&#9733;</span>
                <span class="view_feedback-star" data-value="3">&#9733;</span>
                <span class="view_feedback-star" data-value="4">&#9733;</span>
                <span class="view_feedback-star" data-value="5">&#9733;</span>
            </div>
        </div>

        <div class="view_feedback-question">
            <label for="question4">How would you rate the user interface of the platform?</label>
            <div class="view_feedback-star-rating" data-question="4">
                <span class="view_feedback-star" data-value="1">&#9733;</span>
                <span class="view_feedback-star" data-value="2">&#9733;</span>
                <span class="view_feedback-star" data-value="3">&#9733;</span>
                <span class="view_feedback-star" data-value="4">&#9733;</span>
                <span class="view_feedback-star" data-value="5">&#9733;</span>
            </div>
        </div>

        <div class="view_feedback-question">
            <label for="question5">How would you rate the accessibility of resources?</label>
            <div class="view_feedback-star-rating" data-question="5">
                <span class="view_feedback-star" data-value="1">&#9733;</span>
                <span class="view_feedback-star" data-value="2">&#9733;</span>
                <span class="view_feedback-star" data-value="3">&#9733;</span>
                <span class="view_feedback-star" data-value="4">&#9733;</span>
                <span class="view_feedback-star" data-value="5">&#9733;</span>
            </div>
        </div>

        <div class="view_feedback-question">
            <label for="comments">Additional Comments:</label>
            <textarea id="comments" class="form-control view_feedback-comments" rows="4" placeholder="Your comments here..."></textarea>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary view_feedback-submit">Submit Feedback</button>
        </div>
    </form>
</div>
<script>
document.getElementById('feedbackForm').addEventListener('submit', function(e) {
    e.preventDefault();

    // Initialize variables to hold the concatenated questions and ratings
    let questions = '';
    let ratings = '';

    // Collect the questions and star ratings
    document.querySelectorAll('.view_feedback-star-rating').forEach(function(starRating) {
        const questionLabel = starRating.previousElementSibling.textContent.trim(); // Get the question text
        const selectedStar = starRating.querySelector('.view_feedback-star.selected');
        const ratingValue = selectedStar ? selectedStar.getAttribute('data-value') : 0;  // Default to 0 if no star is selected
        
        // Append the question and rating to the strings
        questions += questionLabel + '; ';
        ratings += ratingValue + '; ';
    });

    // Collect comments
    const comments = document.getElementById('comments').value;

    // Debug: log questions and ratings before sending
    console.log('feedback_text: ' + questions);
    console.log('Ratings: ' + ratings);
    console.log('Comments: ' + comments);

    // Create FormData to send the request
    let formData = new FormData();
    formData.append('user_id', <?php echo $_SESSION['user_id']; ?>); // Add dynamic user_id
    formData.append('feedback_text', questions); // Append all questions as one string
    formData.append('ratings', ratings);     // Append all ratings as one string
    // Send the feedback data to the server via AJAX
    fetch('./handlers/feedback_handler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Feedback submitted successfully!');
        } else {
            alert(data.message || 'Error submitting feedback.');
        }
    })
    .catch(error => console.error('Error:', error));
});

// Handle star selection
document.querySelectorAll('.view_feedback-star').forEach(function(star) {
    star.addEventListener('click', function() {
        const stars = this.parentNode.querySelectorAll('.view_feedback-star');
        stars.forEach(star => star.classList.remove('selected')); // Remove 'selected' from all stars in this group
        this.classList.add('selected'); // Add 'selected' to the clicked star
    });
});
</script>