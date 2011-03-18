<div id="[?php echo $pager_id ?]" class="pager">
[?php if ($pager->haveToPaginate()): ?]
  [?php echo link_to($nav['first'], $url.'1') ?]
  [?php echo link_to($nav['prev'], $url.$pager->getPreviousPage()) ?]
 
  [?php foreach ($pager->getLinks() as $page): ?]
     [?php echo link_to_unless($page == $pager->getPage(), $page, $url.$page, array("class"=>"page")) ?]
    [?php echo ($page != $pager->getCurrentMaxLink()) ? '&nbsp;' : '' ?]
  [?php endforeach; ?]
 
  [?php echo link_to($nav['next'], $url.$pager->getNextPage()) ?]
  [?php echo link_to($nav['last'], $url.$pager->getLastPage()) ?]
[?php endif; ?]
</div>
