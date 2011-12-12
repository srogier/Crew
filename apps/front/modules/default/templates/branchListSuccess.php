<div class="list">
  <div class="list_head">
    <span class="title">Branch list</span>
    <div class="right">
      <button class="icon loop"><?php echo link_to('Synchronize', 'default/branchesSynchronize', array('title' => 'Synchronize branches', 'query_string' => 'repository='.$repository->getId(), 'class' => 'branch-sync')) ?></button>
    </div>
  </div>
  <div class="list_body" id="project_list">
    <table>
      <?php foreach ($branches as $branch): ?>
      <tr class="<?php echo $branch['reviewRequest'] === 1 ? 'review_request':'' ?>">
        <td class="branch_name">
          <h3><?php echo link_to($branch['name'], 'default/fileList', array('query_string' => 'branch='.$branch['id'])) ?></h3><br />
          <span title="<?php echo $branch['lastCommitDesc'] ?>" class="commit_desc tooltip"><?php echo stringUtils::shorten(stringUtils::trimTicketInfos($branch['lastCommitDesc']), 105) ?></span>
        </td>
        <td class="file_infos">
          <?php echo $branch['total'].' files' ?>
          <?php if($branch['added']): ?><span class="added tooltip" title="<?php echo $branch['added'].' added file(s)'; ?>"><?php echo $branch['added'].'+'; ?></span><?php endif; ?>
          <?php if($branch['modified']): ?><span class="modified tooltip" title="<?php echo $branch['modified'].' modified file(s)'; ?>"><?php echo $branch['modified'].'*'; ?></span><?php endif; ?>
          <?php if($branch['deleted']): ?><span class="deleted tooltip" title="<?php echo $branch['deleted'].' deleted file(s)'; ?>"><?php echo $branch['deleted'].'-'; ?></span><?php endif; ?>
        </td>
        <td class="status">
          <ul class="dropdown-action">
            <li class="dropdown">
              <?php if (BranchPeer::OK === $branch['status']): ?>
                <?php echo link_to('*', 'default/changeStatus', array('query_string' => sprintf('type=branch&id=%s&status=%s', $branch['id'], BranchPeer::OK), 'class' => 'dropdown-toggle ricon validate tooltip', 'title' => 'Validated')); ?>
                <ul class="dropdown-menu">
                  <lI><?php echo link_to('%', 'default/changeStatus', array('query_string' => sprintf('type=branch&id=%s&status=%s', $branch['id'], BranchPeer::KO), 'class' => 'ricon item-status-action tooltip', 'title' => 'Invalidated')); ?></lI>
                  <lI><?php echo link_to('!', 'default/changeStatus', array('query_string' => sprintf('type=branch&id=%s&status=%s', $branch['id'], BranchPeer::A_TRAITER), 'class' => 'ricon item-status-action tooltip', 'title' => 'To do')); ?></lI>
              <?php elseif (BranchPeer::KO === $branch['status']): ?>
                <?php echo link_to('%', 'default/changeStatus', array('query_string' => sprintf('type=branch&id=%s&status=%s', $branch['id'], BranchPeer::KO), 'class' => 'dropdown-toggle ricon invalidate tooltip', 'title' => 'Invalidated')); ?>
                <ul class="dropdown-menu">
                    <lI><?php echo link_to('*', 'default/changeStatus', array('query_string' => sprintf('type=branch&id=%s&status=%s', $branch['id'], BranchPeer::OK), 'class' => 'ricon item-status-action tooltip', 'title' => 'Validated')); ?></lI>
                    <lI><?php echo link_to('!', 'default/changeStatus', array('query_string' => sprintf('type=branch&id=%s&status=%s', $branch['id'], BranchPeer::A_TRAITER), 'class' => 'ricon item-status-action tooltip', 'title' => 'To do')); ?></lI>
              <?php else: ?>
                <?php echo link_to('!', 'default/changeStatus', array('query_string' => sprintf('type=branch&id=%s&status=%s', $branch['id'], BranchPeer::A_TRAITER), 'class' => 'dropdown-toggle ricon todo tooltip', 'title' => 'To do')); ?>
                <ul class="dropdown-menu">
                  <lI><?php echo link_to('*', 'default/changeStatus', array('query_string' => sprintf('type=branch&id=%s&status=%s', $branch['id'], BranchPeer::OK), 'class' => 'ricon item-status-action tooltip', 'title' => 'Validated')); ?></lI>
                  <lI><?php echo link_to('%', 'default/changeStatus', array('query_string' => sprintf('type=branch&id=%s&status=%s', $branch['id'], BranchPeer::KO), 'class' => 'ricon item-status-action tooltip', 'title' => 'Invalidated')); ?></lI>
              <?php endif; ?>
              </ul>
            </li>
          </ul>
        </td>
      </tr>
      <?php endforeach; ?>
    </table>
  </div>
</div>
<?php include_partial('default/statusAction', array('statusActions' => $statusActions)) ?>
<?php include_partial('default/commentBoard', array('commentBoards' => $commentBoards)) ?>
