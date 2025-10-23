<div class="draw-titles-single">
    <div class="title-award">
        <h4>🔥 Títulos premiados</h4>
        <p>Achou ganhou!</p>
    </div>

    <div class="draw-titles-content">
        <?php 
        $drawTitles = explode(', ', htmlspecialchars($campaign['draw_titles']));
        $awardTitles = explode(', ', htmlspecialchars($campaign['award_titles']));
        ?>
        <?php foreach ($drawTitles as $index => $value): ?>
            <?php $buyer = $buyersOfDrawTitles[$value] ?? null; ?>
            <div class="title-content" style="background-color: <?php echo $buyer ? '#fff' : htmlspecialchars($settings['color_website']); ?>; box-shadow: <?php echo $buyer ? '-1px 10px 17px -11px rgba(0, 0, 0, 0.6)' : 'none'; ?>;">

                <?php if ($buyer): ?>
                    <span class="number-title" style="background-color: #6c747e; color: #fff;">
                        <?php echo htmlspecialchars($value); ?>
                    </span>
                <?php else: ?>
                    <span class="number-title">
                        <?php echo htmlspecialchars($value); ?>
                    </span>
                <?php endif; ?>

                <?php if ($buyer): ?>
                    <span class="award-title" style="color: #000;">
                        <?php echo isset($awardTitles[$index]) ? substr(htmlspecialchars($awardTitles[$index]), 0, 22) : ' '; ?>
                    </span>
                <?php else: ?>
                    <span class="award-title">
                        <?php echo isset($awardTitles[$index]) ? substr(htmlspecialchars($awardTitles[$index]), 0, 22) : ' '; ?>
                    </span>
                <?php endif; ?>

                <?php if ($buyer): ?>
                    <?php $buyerArray = explode(' ', (string)$buyer); ?>
                    <span class="buyer" style="color: #000;">
                        <span style="color: #ff9100;"><i class="bi bi-trophy-fill" style="padding-right: 2px; "></i></span>
                        <?php echo htmlspecialchars($buyerArray[0]); ?>
                    </span>
                <?php else: ?>
                    <span class="buyer">
                        <span style="color: #1ebc1e;">● </span>
                        Disponível
                    </span>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
