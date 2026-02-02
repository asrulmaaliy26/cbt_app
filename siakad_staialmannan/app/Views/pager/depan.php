<?php 
	$pager->setSurroundCount(0)
	/** setSurroundCount fungsinya untuk menampilkan jumlah halaman
	 * kalau isinya 2 maka akan menampilkan 12
	 * kalau isinya 0 maka tidak akan menampilkan apa-apa  
	*/
?>
<div class="row">
	<div class="col-lg-6 d-flex justify-content-start mb-4">
		<?php if($pager->hasPrevious()){?>
		<a class="btn btn-primary text-uppercase" href="<?php echo $pager->getPrevious()?>">&lsaquo;Post Terbaru </a>
		<?php } ?>
	</div>
	<div class="col-lg-6 d-flex justify-content-end mb-4">
		<?php if($pager->hasNext()){?>
		<a class="btn btn-primary text-uppercase" href="<?php echo $pager->getNext()?>">Post Sebelumnya &rsaquo;</a>
		<?php } ?>
	</div>
</div>
