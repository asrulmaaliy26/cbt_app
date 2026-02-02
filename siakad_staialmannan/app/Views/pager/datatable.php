<!--<nav class="dataTable-pagination">
	<ul class="dataTable-pagination-list">
		<li class="active">
			<a href="#" data-page="1">1</a>
		</li>
		<li class="">
			<a href="#" data-page="2">2</a>
		</li>
		<li class="">
			<a href="#" data-page="3">3</a>
		</li>
		<li class="">
			<a href="#" data-page="4">4</a>
		</li>
		<li class="">
			<a href="#" data-page="5">5</a>
		</li>
		<li class="">
			<a href="#" data-page="6">6</a>
		</li>
		<li class="pager">
			<a href="#" data-page="2">›</a>
		</li>
		<?php
			foreach ($pager->links() as $link) {
				$activeClass = $link['active']?'active':"";
		?>
		<li class="<?=$activeClass;?>">
			<a href="<?=$link['uri'];?>"><?=$link['title'];?></a>
		</li>
		<?php
			}
		?>
	</ul>
</nav>-->
<?php 
	$pager->setSurroundCount(5)
	/** setSurroundCount fungsinya untuk menampilkan jumlah halaman
	 * kalau isinya 2 maka akan menampilkan 12
	 * kalau isinya 0 maka tidak akan menampilkan apa-apa  
	*/
?>

<div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
	<ul class="pagination">
		<?php if($pager->hasPrevious()){?>
		<li class="paginate_button page-item previous" >
			<a href="<?php echo $pager->getPrevious()?>" class="page-link">Previous</a>
		</li>
		<?php } ?>
		
		
		<?php
			foreach ($pager->links() as $link) {
				$activeClass = $link['active']?'active':"";
		?>
		<li class="paginate_button page-item <?=$activeClass;?>">
			<a href="<?=$link['uri'];?>" class="page-link"><?=$link['title'];?></a>
		</li>
		<?php
			}
		?>
		
		<?php if($pager->hasNext()){?>
		<li class="paginate_button page-item next" >
			<a href="<?php echo $pager->getNext()?>" class="page-link">Next</a>
		</li>
		<?php } ?>
	</ul>
</div>