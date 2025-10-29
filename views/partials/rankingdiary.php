<div class="ranking">
    <div class="title-ranking" style="display: block;">
        <h4>🏆 Ranking <span>Diário</span></h4>
        <p style="margin-top: -5px;"><?php echo htmlspecialchars($campaign['ranking_diary_phrase']); ?></p>
    </div>

    <div class="container-ranking">
        <?php if (isset($topBuyersToday[0])) { 
            $primeiroComprador = $topBuyersToday[0];
            $nameArray = explode(' ', $primeiroComprador['name']);
            $primeiroNome = $nameArray[0];
        ?>
        <div>
            <span>🥇</span>
            <h3><?php echo substr(htmlspecialchars($primeiroNome), 0, 12); ?></h3>
            <p><?php echo number_format($primeiroComprador['total_numbers'], 0, ',', '.'); ?>
            Títulos</p>
        </div>
        <?php } ?>

        <?php if (isset($topBuyersToday[1])) { 
            $segundoComprador = $topBuyersToday[1];
            $nameArray = explode(' ', $segundoComprador['name']);
            $segundoNome = $nameArray[0];
        ?>
        <div>
            <span>🥈</span>
            <h3><?php echo substr(htmlspecialchars($segundoNome), 0, 12); ?></h3>
            <p><?php echo number_format($segundoComprador['total_numbers'], 0, ',', '.'); ?>
            Títulos</p>
        </div>
        <?php } ?>

        <?php if (isset($topBuyersToday[2])) { 
            $terceiroComprador = $topBuyersToday[2];
            $nameArray = explode(' ', $terceiroComprador['name']);
            $terceiroNome = $nameArray[0];
        ?>
        <div>
            <span>🥉</span>
            <h3><?php echo substr(htmlspecialchars($terceiroNome), 0, 12); ?></h3>
            <p><?php echo number_format($terceiroComprador['total_numbers'], 0, ',', '.'); ?>
            Títulos</p>
        </div>
        <?php } ?>
    </div>

</div>  