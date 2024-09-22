<?php
if (!isset($events) || empty($events)) {
    die('No discussion boards available.');
}
?>

<div class="container-fluid p-4 main-content" id="mainContent">
    <?php
    $totalBoards = count($events);
    for ($i = 0; $i < $totalBoards; $i++): 
        if ($i % 3 === 0): // Start a new row for every 3 boards
    ?>
        <div class="row mb-4">
    <?php 
        endif; 
    ?>
            <div class="col-md-3 mb-4">
                <div class="card view_dashboard info-card" onclick="location.href='?page=posts&board=<?= $events[$i]['board_id']; ?>';">
                    <div class="card-header"><?= htmlspecialchars($events[$i]['board_name']); ?></div>
                    <div class="card-body">
                        <?= htmlspecialchars($events[$i]['description']); ?>
                    </div>
                </div>
            </div>
    <?php 
        if (($i + 1) % 3 === 0 || $i === $totalBoards - 1): // Close the row after every 3 boards or if it's the last board
    ?>
        </div>
    <?php 
        endif; 
    endfor; 
    ?>
</div>
