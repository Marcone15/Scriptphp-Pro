<div class="socials-icons">
    <span>
        <?php if (!empty($settings['instagram'])): ?>
            <a href="https://<?php echo htmlspecialchars($settings['instagram']); ?>" target="_blank">
                <button class="insta-dr">
                    <i class="bi bi-instagram"></i>
                </button>
            </a>
        <?php endif; ?>
        
        <?php if (!empty($settings['telegram'])): ?>
            <a href="https://<?php echo htmlspecialchars($settings['telegram']); ?>" target="_blank">
                <button class="telegram-dr">
                    <i class="bi bi-telegram"></i>
                </button>
            </a>
        <?php endif; ?>
        
        <?php if (!empty($settings['tiktok'])): ?>
            <a href="https://<?php echo htmlspecialchars($settings['tiktok']); ?>" target="_blank">
                <button class="tiktok-dr">
                    <i class="bi bi-tiktok"></i>
                </button>
            </a>
        <?php endif; ?>
        
        <?php if (!empty($settings['support_wpp'])): ?>
            <a href="https://wa.me/55<?php echo htmlspecialchars($settings['support_wpp']); ?>" target="_blank">
                <button class="support-dr">
                    <i class="bi bi-whatsapp"></i>
                </button>
            </a>
        <?php endif; ?>
    </span>
    
    <?php if (!empty($settings['group_wpp'])): ?>
        <a href="https://<?php echo htmlspecialchars($settings['group_wpp']); ?>" target="_blank">
            <button class="group-dr">
                <i class="bi bi-whatsapp" style="font-style: normal;"> Grupo</i>
            </button>
        </a>
    <?php endif; ?>
</div>
