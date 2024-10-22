<?php
if (!defined('APP_RUNNING') && $_SESSION['role'] != "teacher") {
    die('Access denied'); // Stop execution if accessed directly
}
?>

<div class="container-fluid p-4 main-content" id="mainContent">
    <h1>Classroom</h1>

    <?php if ($_SESSION['role'] == "teacher"): ?>
    <button type="button" class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#classroomModal" id="addClassroomBtn">
        Create New ClassRoom
    </button>
    <?php endif; ?>
    <div class="row">
        <?php if (!empty($classrooms)): ?>
            <?php foreach ($classrooms as $classroom): ?>
                <div class="col-md-12 mb-4">
                    <div class="card view_events">
                        <div class="card-header text-white">
                            <h5 class="mb-0"><?php echo htmlspecialchars($classroom['classroom_name']); ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="event-details">
                                <p><strong>Description:</strong></p>
                                <p><?php echo nl2br(htmlspecialchars($classroom['subject'])); ?></p>
                            </div>
                            <div class="event-details">
                                <p><?php echo nl2br(htmlspecialchars($classroom['description'])); ?></p>
                            </div>
                            <div class="event-details">
    <p><strong>Token:</strong></p>
    <button class="btn btn-sm btn-outline-secondary" onclick="copyToken('<?php echo $classroom['key']; ?>')">Copy Join Key</button>
</div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No classrooms found.</p>
        <?php endif; ?>
    </div>
</div>

<?php if ($_SESSION['role'] == "teacher"): ?>
<!-- Modal for creating a classroom -->
<div class="modal fade" id="classroomModal" tabindex="-1" role="dialog" aria-labelledby="classroomModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="classroomModalLabel">Add a New Classroom</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Feedback message -->
                <div id="classroomFeedback" class="alert d-none" role="alert"></div>

                <form id="createClassroomForm">
                    <div class="mb-3">
                        <label for="className" class="form-label">Classroom Name</label>
                        <input type="text" class="form-control" id="className" required>
                    </div>
                    <div class="mb-3">
                        <label for="classroomDescription" class="form-label">Classroom Description</label>
                        <textarea class="form-control" id="classroomDescription" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="classroomLocation" class="form-label">Classroom Location</label>
                        <input type="text" class="form-control" id="classroomLocation" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submitClassroom">Add Classroom</button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
    document.getElementById('submitClassroom').addEventListener('click', function() {
        const className = document.getElementById('className').value;
        const classroomDescription = document.getElementById('classroomDescription').value;
        const classroomLocation = document.getElementById('classroomLocation').value;

        const feedbackElement = document.getElementById('classroomFeedback');

        if (!className || !classroomDescription || !classroomLocation) {
            showFeedback('All fields are required.', 'danger');
            return;
        }

        // Send AJAX request to the PHP handler
        const xhr = new XMLHttpRequest();
        xhr.open('POST', './handlers/classroom_handler.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (this.status === 200) {
                const response = JSON.parse(this.responseText);
                if (response.message === "Classroom added successfully.") {
                    showFeedback('Classroom added successfully!', 'success');
                    setTimeout(() => {
                        location.reload(); // Refresh the page after 1 second to show the new classroom
                    }, 1000);
                } else {
                    showFeedback('Error: ' + response.message, 'danger');
                }
            }
        };

        xhr.send(`class_name=${encodeURIComponent(className)}&description=${encodeURIComponent(classroomDescription)}&location=${encodeURIComponent(classroomLocation)}`);
    });

    // Function to show feedback in the modal
    function showFeedback(message, type) {
        const feedbackElement = document.getElementById('classroomFeedback');
        feedbackElement.textContent = message;
        feedbackElement.classList.remove('d-none', 'alert-success', 'alert-danger');
        feedbackElement.classList.add('alert-' + type);
    }

    // Copy token function


    // Copy token function
function copyToken(token) {
    // Create a temporary input element to hold the token value
    const tempInput = document.createElement('input');
    tempInput.value = token;
    document.body.appendChild(tempInput);
    
    // Select the input field's text and copy it to the clipboard
    tempInput.select();
    tempInput.setSelectionRange(0, 99999); // For mobile devices
    
    try {
        document.execCommand('copy');
        alert('Token copied to clipboard.');
    } catch (err) {
        alert('Failed to copy token.');
    }
    
    // Remove the temporary input field
    document.body.removeChild(tempInput);
}

</script>
