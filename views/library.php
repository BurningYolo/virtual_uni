<!-- library.php -->
<div class="container-fluid p-4 main-content" id="mainContent">
    <h1>Library Resources</h1>
     <!-- Search Form -->
     <form method="GET" action="" class="view_library-search-form mb-4" onsubmit="return false;">
        <div class="input-group">
            <input type="text" id="searchInput" class="form-control view_library-search-input" placeholder="Search for a resource...">
        </div>
    </form>
    <div class="row">
        <?php if (!empty($libraryResources)): ?>
            <?php foreach ($libraryResources as $resource): ?>
                <div class="col-md-12 mb-4">
                    <div class="card view_library">
                        <div class="card-header text-white">
                            <h5 class="mb-0"><?php echo htmlspecialchars($resource['title']); ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <!-- Placeholder for the first page of PDF -->
                                    <canvas id="pdf-preview-<?php echo $resource['resource_id']; ?>" class="pdf-preview" ></canvas>
                                </div>
                                <div class="col-md-8">
                                    <p><strong>Author:</strong> <?php echo htmlspecialchars($resource['author']); ?></p>
                                    <p><strong>Type:</strong> <?php echo htmlspecialchars($resource['type']); ?></p>
                                    <strong>Additional Info:</strong>
                                    <table class="table table-bordered">
                                        <tbody>
                                            <?php
                                            $metadata = json_decode($resource['metadata'], true);
                                            foreach ($metadata as $key => $value) {
                                                echo "<tr><td><strong>" . htmlspecialchars($key) . ":</strong></td><td>" . htmlspecialchars($value) . "</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <p><strong>Uploaded On:</strong> <?php echo htmlspecialchars($resource['created_at']); ?></p>
                                    
                                    <!-- Download Button -->
                                    <a href="<?php echo ($resource['file_path']); ?>" class="btn btn-primary view_library-download-btn" >
                                        Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No resources found.</p>
        <?php endif; ?>
    </div>
</div>

<!-- PDF.js library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Loop through each resource and render the PDF preview for each canvas
    <?php foreach ($libraryResources as $resource): ?>
        var pdfPath = "<?php echo $resource['file_path'] ?>"; // Correct file path to your PDF
        var canvasId = 'pdf-preview-<?php echo $resource['resource_id']; ?>';
        
        renderPDF(pdfPath, canvasId);

    <?php endforeach; ?>
});

// Function to render PDF to canvas
function renderPDF(pdfPath, canvasId) {
    // Ensure PDF.js worker is set correctly
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js';

    var canvas = document.getElementById(canvasId);
    if (canvas) {
        var loadingTask = pdfjsLib.getDocument(pdfPath);

        loadingTask.promise.then(function(pdf) {
            // Fetch the first page
            pdf.getPage(1).then(function(page) {
                var scale = 0.75; // Adjusted scale for smaller rendering
                var viewport = page.getViewport({ scale: scale });

                var context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                // Set canvas size based on PDF page dimensions
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
