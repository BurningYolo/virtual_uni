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


