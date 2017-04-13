<?php if(@$pages>1): ?>
    <nav class="pagination__container">

        <div class="pagination">
            <?php
            $current = (isset($_GET['p']))? $_GET['p']: 1;

            for($i =0; $i<$pages; $i++): ?>

            <?php if($i==0 && $current>1){ ?>  <a href="<?php echo URL.\Lib\HelperService::getRidOfRepeatedItemsInUrl('p').'p=1' ?>"> << </a> <?php } ?>
            <?php if($i == 0 && $pages>1 && $current>1) {  ?> <a href="<?= URL.\Lib\HelperService::getRidOfRepeatedItemsInUrl('p').'p='.($current-1) ?>"> < </a>  ... <?php } ?>
            <?php

            if($i> ($current-6) && $i<($current+4)): ?>

            <?php if($i+1 == $current): ?>
            <a href="<?php echo URL.\Lib\HelperService::getRidOfRepeatedItemsInUrl('p').'p='.($i+1); ?>" class="pagination__current-item-link" ><span class="pagination__current-item"><?php echo $i+1 ?></span>
                <?php else:  ?>
                    <a href="<?php echo URL.\Lib\HelperService::getRidOfRepeatedItemsInUrl('p').'p='.($i+1); ?>" ><?php echo ($i+1); ?></a>
                <?php  endif;

                endif; ?>
                <?php if($current<$pages): ?>
                    <?php if($i == $pages-1 && $pages>1 && $current<$pages) {  ?>...  <a href="<?php echo URL.\Lib\HelperService::getRidOfRepeatedItemsInUrl('p').'p='.($current+1) ?>"> > </a> <?php } ?>
                    <?php if($i==$pages-1){ ?>  <a href="<?php echo URL.\Lib\HelperService::getRidOfRepeatedItemsInUrl('p').'p='.$pages ?>"> >> </a> <?php } ?>
                <?php endif; ?>


                <?php endfor; ?>
        </div>
    </nav>
<?php endif; ?>