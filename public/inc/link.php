<div>
    <h2><?= $link->title ?></h2>

    <?php foreach($link->item as $entry): ?>

        <div>
          <h3>  <a href="<?= $entry->link ?>"> <?= $entry->title; ?></a></h3>
        <?php if(isset($entry->description)): ?>

            <?php foreach($entry->description as $description): ?>

              <p><?= $description ?></p>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

       
        <?php endforeach; ?>
</div>