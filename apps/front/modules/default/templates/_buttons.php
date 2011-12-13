<ul class="right actions">
  <li class="status">
    <button class="icon success like <?php echo $file->getStatus() === BranchPeer::OK ? 'enabled' : ''?>"><?php echo link_to('Validate file', 'default/fileToggleValidate', array('title' => 'Validate file', 'query_string' => 'file='.$file->getId(), 'class' => 'toggle')) ?></button>
    <button class="icon danger dislike <?php echo $file->getStatus() === BranchPeer::KO ? 'enabled' : ''?>"><?php echo link_to('Invalidate file', 'default/fileToggleUnvalidate', array('title' => 'Invalidate file', 'query_string' => 'file='.$file->getId(), 'class' => 'toggle')) ?></button>
    <button><?php echo link_to('View file', 'default/fileContent', array('title' => 'View entire file', 'query_string' => 'file='.$file->getId())) ?></button>
  </li>
</ul>