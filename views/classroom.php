<?php
if (!defined('APP_RUNNING') && ($_SESSION['role'] != "teacher" || $_SESSION['role'] != "university")) {
    die('Access denied'); // Stop execution if accessed directly
}
?>

<div class="container-fluid p-4 main-content" id="mainContent">
    <h1>Classroom</h1>

    <?php if ($_SESSION['role'] == "teacher" || $_SESSION['role'] == "university"): ?>
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
                                <p><strong>Subject:</strong></p>
                                <p><?php echo nl2br(htmlspecialchars($classroom['subject'])); ?></p>
                            </div>
                            <div class="event-details">
                                <p><strong>Description:</strong></p>
                                <p><?php echo nl2br(htmlspecialchars($classroom['description'])); ?></p>
                            </div>
                            <div class="event-details">
                                <p><strong>Token:</strong></p>
                                <button class="btn btn-sm btn-outline-secondary" onclick="copyToken('<?php echo $classroom['key']; ?>')">Copy Join Key</button>
                            </div>
                            <!-- Add content modal trigger -->
                            <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#contentModal<?php echo $classroom['classroom_id']; ?>">Add Content</button>

                            <!-- Delete classroom button -->
                            <button type="button" class="btn btn-danger mt-3" onclick="deleteClassroom('<?php echo $classroom['classroom_id']; ?>')">Delete Classroom</button>
                        </div>
                    </div>

                    <!-- Modal for adding content to the classroom -->
                    <div class="modal fade" id="contentModal<?php echo $classroom['classroom_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="contentModalLabel<?php echo $classroom['classroom_id']; ?>" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="contentModalLabel<?php echo $classroom['classroom_id']; ?>">Add Content to Classroom</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="addContentForm<?php echo $classroom['classroom_id']; ?>" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label for="content_type" class="form-label">Content Type</label>
                                            <select class="form-select" id="content_type<?php echo $classroom['classroom_id']; ?>" onchange="showContentInput('<?php echo $classroom['classroom_id']; ?>')">
                                                <option value="" disabled selected>Select content type</option>
                                                <option value="pdf">PDF</option>
                                                <option value="video_url">Video URL</option>
                                                <option value="video_file">Video File</option>
                                            </select>
                                        </div>

                                        <!-- PDF Upload -->
                                        <div class="mb-3 content-input" id="pdfInput<?php echo $classroom['classroom_id']; ?>" style="display: none;">
                                            <label for="pdf_file" class="form-label">Upload PDF</label>
                                            <input type="file" class="form-control" id="pdf_file<?php echo $classroom['classroom_id']; ?>" accept="application/pdf">
                                        </div>

                                        <!-- Video URL Input -->
                                        <div class="mb-3 content-input" id="videoUrlInput<?php echo $classroom['classroom_id']; ?>" style="display: none;">
                                            <label for="video_url" class="form-label">Video URL</label>
                                            <input type="text" class="form-control" id="video_url<?php echo $classroom['classroom_id']; ?>">
                                        </div>

                                        <!-- Video File Upload -->
                                        <div class="mb-3 content-input" id="videoFileInput<?php echo $classroom['classroom_id']; ?>" style="display: none;">
                                            <label for="video_file" class="form-label">Upload Video File</label>
                                            <input type="file" class="form-control" id="video_file<?php echo $classroom['classroom_id']; ?>" accept="video/*">
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="submitContent('<?php echo $classroom['classroom_id']; ?>')">Add Content</button>
                                </div>
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
                        <label for="classroom_name" class="form-label">Classroom Name</label>
                        <input type="text" class="form-control" id="classroom_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Classroom Description</label>
                        <textarea class="form-control" id="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Classroom Subject</label>
                        <input type="text" class="form-control" id="subject" required>
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

<script>
    document.getElementById('submitClassroom').addEventListener('click', function() {
        const classroom_name = document.getElementById('classroom_name').value;
        const description = document.getElementById('description').value;
        const subject = document.getElementById('subject').value;

        const feedbackElement = document.getElementById('classroomFeedback');

        if (!classroom_name || !description || !subject) {
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
                console.log(response); 
                if (response.message === "Classroom added successfully.") {
                    showFeedback('Classroom added successfully!', 'success');
                    setTimeout(() => {
                        location.reload(); // Refresh the page after 1 second to show the new classroom
                    }, 1000);
                } else {
                    showFeedback( response.message, 'success');
                    setTimeout(() => {
                        location.reload(); // Refresh the page after 1 second to show the new classroom
                    }, 1000);
                }
            }
        };

        xhr.send(`classroom_name=${encodeURIComponent(classroom_name)}&description=${encodeURIComponent(description)}&subject=${encodeURIComponent(subject)}`);
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

<script>
    function showContentInput(classroomId) {
        const type = document.getElementById('content_type' + classroomId).value;
        const pdfInput = document.getElementById('pdfInput' + classroomId);
        const videoUrlInput = document.getElementById('videoUrlInput' + classroomId);
        const videoFileInput = document.getElementById('videoFileInput' + classroomId);

        pdfInput.style.display = 'none';
        videoUrlInput.style.display = 'none';
        videoFileInput.style.display = 'none';

        if (type === 'pdf') {
            pdfInput.style.display = 'block';
        } else if (type === 'video_url') {
            videoUrlInput.style.display = 'block';
        } else if (type === 'video_file') {
            videoFileInput.style.display = 'block';
        }
    }

    function submitContent(classroomId) {
        // Handle content submission logic (AJAX, form submission, etc.)
        console.log('Submit content for classroom:', classroomId);
    }

    function deleteClassroom(classroomId) {
        if (confirm('Are you sure you want to delete this classroom?')) {
            // Send AJAX request to delete the classroom
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './handlers/classroom_handler.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
            if (this.status === 200) {
                const response = JSON.parse(this.responseText);
                console.log(response); 
                if (response.message === "Virtual classroom deleted successfully.") {
                    setTimeout(() => {
                        location.reload(); // Refresh the page after 1 second to show the new classroom
                    }, 1000);
                } else {
                    
                }
            }
        };
            xhr.send('delete_classroom_id=' + classroomId);
        }
    }


</script>
