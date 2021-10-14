
<ul class="list">
  <?php foreach ($menu as $key => $value): ?>
      <li class="item">
        <a class="link <?=isCurrentUrl($value['path']) ? 'active' : ''?>" 
           href="<?=$value['path']?>">
           <?=$value['title']?>
         </a>
      </li>
  <?php endforeach; ?>
</ul>
