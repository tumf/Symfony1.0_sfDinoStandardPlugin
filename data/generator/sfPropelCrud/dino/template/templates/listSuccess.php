<h1><?php echo $this->getModuleName() ?></h1>


<div class="list">
<table class="listing">
<thead>
<tr>
 <th colspan="<?php echo 1+count($this->getTableMap()->getColumns()) ?>">
<div  class="utility">
[?php echo link_to (
image_tag("/sf/sf_admin/images/add.png"), '<?php echo $this->getModuleName() ?>/create')
?]
</div>
 </th>
</tr>

<tr>
<?php foreach ($this->getTableMap()->getColumns() as $column): ?>
  <th><?php echo sfInflector::humanize(sfInflector::underscore($column->getPhpName())) ?></th>
<?php endforeach; ?>
<th>&nbsp;</th>
</tr>
</thead>

<tfoot>
<tr>
 <th colspan="<?php echo 1+count($this->getTableMap()->getColumns()) ?>">
[?php
include_partial("<?php echo $this->getModuleName() ?>/pager",
array(
	"pager"=>$pager,
	"pager_id" => "<?php echo $this->getSingularName() ?>_pager",
	"url" => "<?php echo $this->getModuleName() ?>/list?page=",
	"nav" => array(
                       "first" => image_tag("/sf/sf_admin/images/first.png",array("alt" => "&laquo;","title" => "first")),
                       "prev" => image_tag("/sf/sf_admin/images/previous.png",array("alt" => "&lt;","title" => "previous")),
                       "next" => image_tag("/sf/sf_admin/images/next.png",array("alt" => "&gt;","title" => "next")),
                       "last" => image_tag("/sf/sf_admin/images/last.png",array("alt" => "&raquo;","title" => "last")))))
?]
 </th>
</tr>
</tfoot>



<tbody>
[?php $i = 0 ?]
[?php foreach($pager->getResults() as $<?php echo $this->getSingularName() ?>) : ?]
<tr class="[?php echo ($i++ % 2)?'even':'odd' ?]">

<?php foreach ($this->getTableMap()->getColumns() as $column): ?>
     <td class="data">[?php echo link_to($<?php echo $this->getSingularName() ?>->get<?php echo $column->getPhpName() ?>()?$<?php echo $this->getSingularName() ?>->get<?php echo $column->getPhpName() ?>():"&nbsp;", '<?php echo $this->getModuleName() ?>/show?<?php echo $this->getPrimaryKeyUrlParams() ?>) ?]</td>
<?php endforeach; ?>

 <td class="actions">
[?php echo link_to(image_tag('/sf/sf_admin/images/edit.png',array("class"=>"action")),'<?php echo $this->getModuleName() ?>/edit?<?php echo $this->getPrimaryKeyUrlParams() ?>) ?][?php echo link_to(image_tag('/sf/sf_admin/images/delete.png',array("class"=>"action")),'<?php echo $this->getModuleName() ?>/delete?<?php echo $this->getPrimaryKeyUrlParams() ?>) ?]
 </td>
</tr>
[?php endforeach; ?]
</tbody>
</table>
</div>
