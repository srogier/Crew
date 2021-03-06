<?php



/**
 * Skeleton subclass for performing query and update operations on the 'branch' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.5.6 on:
 *
 * Mon Oct 24 09:36:19 2011
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.lib.model
 */
class BranchPeer extends BaseBranchPeer {

  const A_TRAITER = 0;
  const OK        = 1;
  const KO        = 2;

  /**
   * @static
   * @param int $statusId
   * @return string
   */
  public static function getLabelStatus($statusId)
  {
    switch ($statusId)
    {
      case BranchPeer::A_TRAITER:
        return 'to do';
      case BranchPeer::OK:
        return 'ok';
      case BranchPeer::KO:
        return 'ko';
    }

    return '';
  }

  public static function getBasecampLabelStatus($statusId)
  {
    switch ($statusId)
    {
      case BranchPeer::A_TRAITER:
        return ':zzz:';
      case BranchPeer::OK:
        return ':thumbsup:';
      case BranchPeer::KO:
        return ':thumbsdown:';
    }

    return '';
  }

  /**
   * @static
   * @param GitCommand $gitCommand
   * @param Repository $repository
   * @param Branch $branch
   * @param bool $deleteOnly
   * @return void
   */
  public static function synchronize(GitCommand $gitCommand, Repository $repository, Branch $branch, $deleteOnly = false)
  {
    $branchGit = $gitCommand->getNoMergedBranchInfos($repository->getGitDir(), $branch->getBaseBranchName(), $branch->getName());

    $branchModel = BranchQuery::create()
      ->filterByRepositoryId($repository->getId())
      ->filterByName($branch->getName())
      ->findOne()
    ;

    if($branchModel)
    {
      if(is_null($branchGit))
      {
        $branchModel->delete();
      }
      elseif(!$branchModel->getIsBlacklisted() && !$deleteOnly)
      {
        $lastSynchronizationCommit = $branchModel->getLastCommit();
        $branchModel->setCommitReference($branchGit['commit_reference']);
        $branchModel->setLastCommit($branchGit['last_commit']);
        $branchModel->setLastCommitDesc($branchGit['last_commit_desc']);
        $branchModel->save();

        return FilePeer::synchronize($gitCommand, $branchModel, $lastSynchronizationCommit);
      }
    }

    return 0;
  }
} // BranchPeer
