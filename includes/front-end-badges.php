<?php
    echo ( isset( $before_widget ) ) ? $before_widget : '';
    echo ( isset( $before_title) ) ? $before_title : '';
    echo ( isset( $title) ) ? $title : '';
    echo ( isset( $after_title ) ) ? $after_title : '';
?>

<ul class="platzi-badges-list">
    <?php for ( $i = 0; $i < $number; $i++ ) : ?>
        <?php
            $badge = isset( $badges[$i] ) ? $badges[$i] : null;
        ?>
        <?php if ( $badge ) : ?>
            <li class="platzi-badges-list__item">
                <img src="<?php echo $badge->url; ?>" alt="<?php echo $badge->name; ?>" width="100">
                <?php if ( $show_titles ) : ?>
                    <span><?php echo $badge->name; ?></span>
                <?php endif; ?>
            </li>
        <?php endif; ?>
    <?php endfor; ?>
</ul>

<?php echo ( isset( $after_widget ) ) ? $after_widget : ''; ?>
