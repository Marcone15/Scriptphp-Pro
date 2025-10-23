<?php
$minTitleDaily = explode(', ', $campaign['min_title_daily']);
$maxTitleDaily = explode(', ', $campaign['max_title_daily']);

$todayDate = date('Y-m-d');

function checkIfToday($date) {
    return date('Y-m-d', strtotime($date)) === date('Y-m-d');
}
?>

<div class="bigger-smaller">
    <div class="bigger-smaller-title">
        <h4><i class="bi bi-arrow-down-up"></i> Maior e menor título <span>Diário</span></h4>
    </div>
    <div class="bigger-smaller-container">
        <div style="background-color: <?php echo htmlspecialchars($settings['color_website']); ?>;">
            <p>Menor título</p>
            <span>
                <?php 
                if (isset($minTitleDaily[0]) && isset($minTitleDaily[2])) {
                    if (checkIfToday($minTitleDaily[2])) {
                        echo htmlspecialchars($minTitleDaily[0]);
                    } else {
                        echo '&nbsp;';
                    }
                } else {
                    echo '&nbsp;';
                }
                ?>
            </span>
            <h3>
                <?php 
                if (isset($minTitleDaily[1]) && isset($minTitleDaily[2])) {
                    if (checkIfToday($minTitleDaily[2])) {
                        echo substr(htmlspecialchars($minTitleDaily[1]), 0, 15);
                    } else {
                        echo '&nbsp;';
                    }
                } else {
                    echo '&nbsp;';
                }
                ?>
            </h3>
            <p>
                <?php 
                if (isset($minTitleDaily[2]) && checkIfToday($minTitleDaily[2])) {
                    echo date('d/m/y \à\s H:i', strtotime($minTitleDaily[2])); 
                } else {
                    echo '&nbsp;';
                }
                ?>
            </p>
        </div>
        <div style="background-color: <?php echo htmlspecialchars($settings['color_website']); ?>;">
            <p>Maior título</p>
            <span>
                <?php 
                if (isset($maxTitleDaily[0]) && isset($maxTitleDaily[2])) {
                    if (checkIfToday($maxTitleDaily[2])) {
                        echo htmlspecialchars($maxTitleDaily[0]);
                    } else {
                        echo '&nbsp;';
                    }
                } else {
                    echo '&nbsp;';
                }
                ?>
            </span>
            <h3>
                <?php 
                if (isset($maxTitleDaily[1]) && isset($maxTitleDaily[2])) {
                    if (checkIfToday($maxTitleDaily[2])) {
                        echo htmlspecialchars($maxTitleDaily[1]);
                    } else {
                        echo '&nbsp;';
                    }
                } else {
                    echo '&nbsp;';
                }
                ?>
            </h3>
            <p>
                <?php 
                if (isset($maxTitleDaily[2]) && checkIfToday($maxTitleDaily[2])) {
                    echo date('d/m/y \à\s H:i', strtotime($maxTitleDaily[2])); 
                } else {
                    echo '&nbsp;';
                }
                ?>
            </p>
        </div>
    </div>                                               
</div>
