[?php

/**
 * <?php echo $this->getGeneratedModuleName() ?> actions.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage <?php echo $this->getGeneratedModuleName() ?>

 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 52 2007-01-07 07:40:33Z tumf $
 */
class <?php echo $this->getGeneratedModuleName() ?>Actions extends sfActions
{
  public function preExecute()
  {
    $this->getResponse()->addStylesheet('/sfDinoStandardPlugin/css/dino', 'last');
  }

  public function executeIndex ()
  {
    return $this->forward('<?php echo $this->getModuleName() ?>', 'list');
  }

  public function executeList ()
  {
      $pager = new sfPropelPager("<?php echo $this->getClassName() ?>",10);
      $crit = new Criteria;
      $pager->setCriteria($crit);
      $pager->setPage($this->getRequestParameter("page",1));
      $pager->setPeerMethod('doSelect');
      $pager->init();

      $this->pager = $pager;
  }

  public function executeShow ()
  {
    $this-><?php echo $this->getSingularName() ?> = <?php echo $this->getClassName() ?>Peer::retrieveByPk(<?php echo $this->getRetrieveByPkParamsForAction(49) ?>);
    $this->forward404Unless($this-><?php echo $this->getSingularName() ?>);
  }

  public function executeCreate ()
  {
    $this-><?php echo $this->getSingularName() ?> = new <?php echo $this->getClassName() ?>();

    $this->setTemplate('edit');
  }

  public function executeEdit ()
  {
    $this-><?php echo $this->getSingularName() ?> = <?php echo $this->getClassName() ?>Peer::retrieveByPk(<?php echo $this->getRetrieveByPkParamsForAction(49) ?>);
    $this->forward404Unless($this-><?php echo $this->getSingularName() ?>);
  }

  public function executeUpdate ()
  {
    if (<?php echo $this->getTestPksForGetOrCreate() ?>)
    {
      $<?php echo $this->getSingularName() ?> = new <?php echo $this->getClassName() ?>();
    }
    else
    {
      $<?php echo $this->getSingularName() ?> = <?php echo $this->getClassName() ?>Peer::retrieveByPk(<?php echo $this->getRetrieveByPkParamsForAction(45) ?>);
      $this->forward404Unless($<?php echo $this->getSingularName() ?>);
    }

<?php foreach ($this->getTableMap()->getColumns() as $name => $column): $type = $column->getCreoleType(); ?>
<?php if ($name == 'CREATED_AT' || $name == 'UPDATED_AT') continue ?>
<?php $name = sfInflector::underscore($column->getPhpName()) ?>
<?php if ($type == CreoleTypes::DATE || $type == CreoleTypes::TIMESTAMP): ?>
    if ($this->getRequestParameter('<?php echo $name ?>'))
    {
      list($d, $m, $y) = sfI18N::getDateForCulture($this->getRequestParameter('<?php echo $name ?>'), $this->getUser()->getCulture());
      $<?php echo $this->getSingularName() ?>->set<?php echo $column->getPhpName() ?>("$y-$m-$d");
    }
<?php elseif ($type == CreoleTypes::BOOLEAN): ?>
    $<?php echo $this->getSingularName() ?>->set<?php echo $column->getPhpName() ?>($this->getRequestParameter('<?php echo $name ?>', 0));
<?php else: ?>
    $<?php echo $this->getSingularName() ?>->set<?php echo $column->getPhpName() ?>($this->getRequestParameter('<?php echo $name ?>'));
<?php endif; ?>
<?php endforeach; ?>

    $<?php echo $this->getSingularName() ?>->save();

    return $this->redirect('<?php echo $this->getModuleName() ?>/show?<?php echo $this->getPrimaryKeyUrlParams() ?>);
<?php //' ?>
  }

  public function executeDelete ()
  {
    $<?php echo $this->getSingularName() ?> = <?php echo $this->getClassName() ?>Peer::retrieveByPk(<?php echo $this->getRetrieveByPkParamsForAction(43) ?>);

    $this->forward404Unless($<?php echo $this->getSingularName() ?>);

    $<?php echo $this->getSingularName() ?>->delete();

    return $this->redirect('<?php echo $this->getModuleName() ?>/list');
  }
}
