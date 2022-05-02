<div class="link">
  <h2 class="center"><a href="<?= $link->link ?>"><?= $link->title ?></a></h2>
  <?php foreach ($link->item as $entry) : ?>
    <div class="items">
      <h3> <a href="<?= $entry->link ?>"> <?= $entry->title; ?></a></h3>
    </div>
  <?php endforeach; ?>
</div>