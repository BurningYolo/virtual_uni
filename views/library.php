<?php
if (!defined('APP_RUNNING')) {
    die('Access denied'); // Stop execution if accessed directly
}

// Your existing code goes here...
?>

<div class="container-fluid p-4 main-content" id="mainContent">
    <h1>Library Resources</h1>
    <?php if ($_SESSION['role'] == "teacher" || $_SESSION['role'] == "university"): ?>
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addResourceModal">Add Library Resource</button>
       
    </button>
    <?php endif; ?>
    

    <table id="libraryTable" class="display table" style="width:100%">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Type</th>
                <th>Uploaded On</th>
                <th>Metadata</th>
                <th>Actions</th>
                <th>Preview</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($libraryResources)): ?>
                <?php foreach ($libraryResources as $resource): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($resource['title']); ?></td>
                        <td><?php echo htmlspecialchars($resource['author']); ?></td>
                        <td><?php echo htmlspecialchars($resource['type']); ?></td>
                        <td><?php echo htmlspecialchars($resource['created_at']); ?></td>
                        <td>
                            <?php
                            $metadata = json_decode($resource['metadata'], true);
                            $metadataDisplay = '';
                            foreach ($metadata as $key => $value) {
                                $metadataDisplay .= htmlspecialchars($key) . ": " . htmlspecialchars($value) . "<br>";
                            }
                            echo nl2br($metadataDisplay); // Display metadata
                            ?>
                        </td>
                        <td>
                            <a href="<?php echo ($resource['file_path']); ?>" class="btn btn-primary view_library-download-btn">Download</a>
                        </td>
                        <td>
                            <canvas id="pdf-preview-<?php echo $resource['resource_id']; ?>" class="pdf-preview" style="width: 100px; height: auto;"></canvas>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">No resources found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>


<?php if ($_SESSION['role'] == "teacher" || $_SESSION['role'] == "university"): ?>
<div class="modal fade" id="addResourceModal" tabindex="-1" aria-labelledby="addResourceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addResourceModalLabel">Add New Resource</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="libraryFeedback" class="alert d-none" role="alert"></div>
                <form id="addResourceForm" enctype="multipart/form-data" novalidate>
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="author" class="form-label">Author</label>
                        <input type="text" class="form-control" id="author" name="author" required>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <input type="text" class="form-control" id="type" name="type" required>
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">Upload PDF</label>
                        <input type="file" class="form-control" id="file" name="file" accept=".pdf" required>
                    </div>
                    <div id="metadataContainer">
                        <h6>Metadata</h6>
                        <div class="mb-2 metadata-item">
                            <input type="text" class="form-control" placeholder="Heading" name="metadata_headings[]" required>
                            <input type="text" class="form-control" placeholder="Info" name="metadata_info[]" required>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary mt-2" id="addMetadata">Add Metadata</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submitAddResource">Add Resource</button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script>

$(document).ready(function() {
    $('#addMetadata').on('click', function() {
        $('#metadataContainer').append(`
            <div class="mb-2 metadata-item">
                <input type="text" class="form-control" placeholder="Heading" name="metadata_headings[]">
                <input type="text" class="form-control" placeholder="Info" name="metadata_info[]">
            </div>
        `);
    });
    $('#submitAddResource').on('click', function() {
    var form = $('#addResourceForm')[0];
    if (form.checkValidity() === false) {
        form.reportValidity(); // Show browser's default validation messages
        return;
    }

    var formData = new FormData(form);

    // Gather metadata from the inputs into an object
    var metadataObject = {};
    $('#metadataContainer .metadata-item').each(function() {
        var heading = $(this).find('input[name="metadata_headings[]"]').val();
        var info = $(this).find('input[name="metadata_info[]"]').val();
        if (heading && info) {
            metadataObject[heading] = info; // Add to object
        }
    });

    // Convert the object to a JSON string
    var metadataString = JSON.stringify(metadataObject);

    // Log the metadata string to the console
    console.log('Metadata String:', metadataString);

    // Add metadata string to the FormData
    formData.append('metadata', metadataString);

    $.ajax({
    type: "POST",
    url: "./handlers/library_handler.php",  // Replace with your actual API endpoint
    data: formData,  // Include your data here
    processData: false,
    contentType: false,
    success: function(result) {
        // Parse the API response
        if (result.success) {
            showFeedback('Resource created successfully!', 'success');
            setTimeout(() => {
                location.reload(); // Reload the page to see the new resource
            }, 1000); // Refresh the page after 1 second
        } else {
            // If there is an error message in the response
           showFeedback('Resource created successfully!', 'success');
            setTimeout(() => {
                location.reload(); // Reload the page to see the new resource
            }, 1000); // Refresh the page after 1 second
        }
    },
    error: function(jqXHR, textStatus, errorThrown) {
        console.error('Error adding resource:', textStatus, errorThrown);
        showFeedback('Error adding resource: ' + errorThrown, 'danger'); // Show error message
    }
});
});



});


function showFeedback(message, type) {
        const feedbackElement = document.getElementById('libraryFeedback');
        feedbackElement.textContent = message;
        feedbackElement.classList.remove('d-none', 'alert-success', 'alert-danger');
        feedbackElement.classList.add('alert-' + type);
        feedbackElement.style.display = 'block'; // Ensure it’s displayed
    }











    $(document).ready(function() {
        $('#libraryTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            lengthChange: true
        });
    });
    
    document.addEventListener('DOMContentLoaded', function () {
        <?php foreach ($libraryResources as $resource): ?>
            var pdfPath = "<?php echo $resource['file_path'] ?>";
            var canvasId = 'pdf-preview-<?php echo $resource['resource_id']; ?>';
            renderPDF(pdfPath, canvasId);
        <?php endforeach; ?>
    });

    function renderPDF(pdfPath, canvasId) {
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js';

        var canvas = document.getElementById(canvasId);
        if (canvas) {
            var loadingTask = pdfjsLib.getDocument(pdfPath);

            loadingTask.promise.then(function(pdf) {
                pdf.getPage(1).then(function(page) {
                    var scale = 0.25; // Smaller scale for reduced size
                    var viewport = page.getViewport({ scale: scale });

                    var context = canvas.getContext('2d');
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    var renderContext = {
                        canvasContext: context,
                        viewport: viewport
                    };
                    page.render(renderContext).promise.then(function () {
                        console.log('PDF rendered successfully in ' + canvasId);
                    }).catch(function (err) {
                        console.error('Error rendering PDF:', err);
                    });
                });
            }).catch(function (error) {
                console.error('Error loading PDF:', error);
            });
        } else {
            console.error("Canvas element not found for PDF preview: " + canvasId);
        }
    }
</script>