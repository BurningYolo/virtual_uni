<?php
if (!defined('APP_RUNNING')) {
    die('Access denied'); // Stop execution if accessed directly
}

// Your existing code goes here...
?>


<div class="container-fluid p-4 main-content" id="mainContent">
    <h1>Events</h1>
    

    

    <?php if ($_SESSION['role'] == "teacher" || $_SESSION['role'] == "university"): ?>
    <button type="button" class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#eventModal">
        Create New Event
    </button>
    <?php endif; ?>
    <div class="row">
        <?php if (!empty($events)): ?>
            <?php foreach ($events as $event): ?>
                <div class="col-md-12 mb-4">
                    <div class="card view_events">
                        <div class="card-header text-white">
                            <h5 class="mb-0"><?php echo htmlspecialchars($event['event_name']); ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="event-details">
                                <p><strong>Description:</strong></p>
                                <p><?php echo nl2br(htmlspecialchars($event['description'])); ?></p>
                            </div>
                            <div class="event-details">
                                <p><strong>Start Time:</strong> <span class="event-start-time"><?php echo htmlspecialchars($event['start_time']); ?></span></p>
                                <p><strong>End Time:</strong> <span><?php echo htmlspecialchars($event['end_time']); ?></span></p>
                                <p><strong>Location:</strong> <span><?php echo htmlspecialchars($event['location']); ?></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No events found.</p>
        <?php endif; ?>
    </div>
</div>

<?php if ($_SESSION['role'] == "teacher" || $_SESSION['role'] == "university"): ?>
<!-- Modal for creating an event -->
<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Create a New Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Feedback message -->
                <div id="eventFeedback" class="alert d-none" role="alert"></div>

                <form id="createEventForm">
                    <div class="mb-3">
                        <label for="eventName" class="form-label">Event Name</label>
                        <input type="text" class="form-control" id="eventName" required>
                    </div>
                    <div class="mb-3">
                        <label for="eventDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="eventDescription" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="startTime" class="form-label">Start Time</label>
                        <input type="datetime-local" class="form-control" id="startTime" required>
                    </div>
                    <div class="mb-3">
                        <label for="endTime" class="form-label">End Time</label>
                        <input type="datetime-local" class="form-control" id="endTime" required>
                    </div>
                    <div class="mb-3">
                        <label for="eventLocation" class="form-label">Location</label>
                        <input type="text" class="form-control" id="eventLocation" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submitEvent">Create Event</button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<script>
    document.getElementById('submitEvent').addEventListener('click', function() {
        const eventName = document.getElementById('eventName').value;
        const eventDescription = document.getElementById('eventDescription').value;
        const startTime = document.getElementById('startTime').value;
        const endTime = document.getElementById('endTime').value;
        const eventLocation = document.getElementById('eventLocation').value;

        const feedbackElement = document.getElementById('eventFeedback');

        if (!eventName || !eventDescription || !startTime || !endTime || !eventLocation) {
            showFeedback('All fields are required.', 'danger');
            return;
        }

        // Send AJAX request to the PHP handler
        const xhr = new XMLHttpRequest();
        xhr.open('POST', './handlers/events_handler.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (this.status === 200) {
                const response = JSON.parse(this.responseText);
                if (response.message === "Event created successfully.") {
                    showFeedback('Event created successfully!', 'success');
                    setTimeout(() => {
                        location.reload(); // Refresh the page after 1 second to show the new event
                    }, 1000);
                } else {
                    showFeedback('Error: ' + response.message, 'danger');
                }
            }
        };

        xhr.send(`event_name=${encodeURIComponent(eventName)}&description=${encodeURIComponent(eventDescription)}&start_time=${encodeURIComponent(startTime)}&end_time=${encodeURIComponent(endTime)}&location=${encodeURIComponent(eventLocation)}`);
    });

    // Function to show feedback in the modal
    function showFeedback(message, type) {
        const feedbackElement = document.getElementById('eventFeedback');
        feedbackElement.textContent = message;
        feedbackElement.classList.remove('d-none', 'alert-success', 'alert-danger');
        feedbackElement.classList.add('alert-' + type);
    }
</script>
