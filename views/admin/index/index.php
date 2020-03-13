<?php

    echo head(array('title' => 'Tag Info'));
?>
<div id="primary">
    <h2><?php echo 'Step 1: Select Tag to add info'; ?></h2>
    <ul>
        <?php foreach($tags as $tag): ?>
            <li>
            <a href="<?php echo url("tag-info/index/edit/tag_id/{$tag['id']}"); ?>"><?php echo $tag->name;?></li>
</a>
        <?php endforeach; ?>

    </ul>
</div>

<?php
    echo foot();
?>
