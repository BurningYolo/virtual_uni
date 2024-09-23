
const sidebar = document.getElementById('sidebar');
const mainContent = document.getElementById('mainContent');
//const header = document.querySelector('.header');
const toggleButton = document.getElementById('toggleSidebar');

toggleButton.addEventListener('click', () => {
    sidebar.classList.toggle('hidden');
    mainContent.classList.toggle('hidden');
    //header.classList.toggle('collapsed');
});



   document.querySelectorAll('.view_feedback-star-rating').forEach(function(rating) {
    rating.addEventListener('click', function(e) {
        const stars = rating.querySelectorAll('.view_feedback-star');
        const selectedValue = e.target.dataset.value;

        stars.forEach(function(star) {
            star.classList.remove('selected');
        });

        for (let i = 0; i < selectedValue; i++) {
            stars[i].classList.add('selected');
        }
    });
});

// Form submission (handle as needed)
document.addEventListener('DOMContentLoaded', function() {
    const feedbackForm = document.getElementById('feedbackForm');
    
    if (feedbackForm) {
        feedbackForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Collect feedback data
            const feedbackData = {};
            this.querySelectorAll('.view_feedback-star-rating').forEach(function(rating) {
                const questionIndex = rating.getAttribute('data-question');
                const selectedStar = rating.querySelector('.view_feedback-star.selected');
                feedbackData[`question_${questionIndex}`] = selectedStar ? selectedStar.dataset.value : null;
            });

            feedbackData['comments'] = document.getElementById('comments').value;

            // You can send feedbackData to your server here
            console.log(feedbackData); // For now, just logging the feedback data
        });
    } else {
        
    }
});