<div class="container-fluid p-4 main-content" id="mainContent">
    <h1>Library Resources</h1>

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

<script>
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
