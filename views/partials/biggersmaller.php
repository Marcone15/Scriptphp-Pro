<?php
$minTitleGeneral = explode(', ', $campaign['min_title_general']);
$maxTitleGeneral = explode(', ', $campaign['max_title_general']);

?>
<div class="bigger-smaller">
    <div class="bigger-smaller-title">
        <h4><i class="bi bi-arrow-down-up"></i> Maior e menor título</h4>
    </div>
    <div class="bigger-smaller-container">
        <div style="background-color: <?php echo htmlspecialchars($settings['color_website']); ?>;">
            <p>Menor título</p>
            <span>
                <?php echo isset($minTitleGeneral[0]) ? htmlspecialchars($minTitleGeneral[0]) : ''; ?>
            </span>
            <h3>
                <?php echo isset($minTitleGeneral[1]) ? substr(htmlspecialchars($minTitleGeneral[1]), 0, 15) : ''; ?>
            </h3>
            <p>
                <?php 
                if (isset($minTitleGeneral[2])) {
                    $date = new DateTime($minTitleGeneral[2]);
                    echo $date->format('d/m/y \à\s H:i'); 
                } else {
                    echo '';
                }
                ?>
            </p>
        </div>
        <div style="background-color: <?php echo htmlspecialchars($settings['color_website']); ?>;">
            <p>Maior título</p>
            <span>
            <?php echo isset($maxTitleGeneral[0]) ? htmlspecialchars($maxTitleGeneral[0]) : ''; ?>
            </span>
            <h3>
             <?php echo isset($maxTitleGeneral[1]) ? substr(htmlspecialchars($maxTitleGeneral[1]), 0, 15) : ''; ?>
            </h3>
            <p>
                <?php 
                if (isset($maxTitleGeneral[2])) {
                    $date = new DateTime($maxTitleGeneral[2]);
                    echo $date->format('d/m/y \à\s H:i'); 
                } else {
                    echo '';
                }
                ?>
            </p>
        </div>
    </div>                                               
</div>
