<div class="ranking">
    <div class="title-ranking">
        <h4>🏆 Ranking</h4>
        <p><?php echo htmlspecialchars($campaign['ranking_phrase']); ?></p>
    </div>

    <div class="container-ranking">
        <?php if (isset($topBuyers[0])) { 
            $primeiroComprador = $topBuyers[0];
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

        <?php if (isset($topBuyers[1])) { 
            $segundoComprador = $topBuyers[1];
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

        <?php if (isset($topBuyers[2])) { 
            $terceiroComprador = $topBuyers[2];
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