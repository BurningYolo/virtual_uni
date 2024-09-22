<div class="container-fluid p-4 main-content" id="mainContent">
    <h1>Events</h1>
    
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
                                <p class="text-success"><strong>Time Remaining:</strong> <span class="time-remaining" data-start-time="<?php echo htmlspecialchars($event['start_time']); ?>">Calculating...</span></p>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const timeRemainingElements = document.querySelectorAll('.time-remaining');

        timeRemainingElements.forEach(function(element) {
            const startTime = new Date(element.getAttribute('data-start-time')).getTime();

            function updateTimer() {
                const now = new Date().getTime();
                const distance = startTime - now;

                if (distance < 0) {
                    element.textContent = "Event has Ended!";
                    clearInterval(interval); // Stop the timer
                    return;
                }

                // Time calculations
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                element.textContent = `${hours}h ${minutes}m ${seconds}s remaining`;
            }

            // Update the timer immediately and every second
            updateTimer();
            const interval = setInterval(updateTimer, 1000);
        });
    });
</script>
