<?php 
	$pager->setSurroundCount(5)
	/** setSurroundCount fungsinya untuk menampilkan jumlah halaman
	 * kalau isinya 2 maka akan menampilkan 12
	 * kalau isinya 0 maka tidak akan menampilkan apa-apa  
	*/
?>

<div class="col-md-12">
	<nav>
		<ul class="pagination">
			<?php if($pager->hasPrevious()){?>
		  	<li> 
		  		<a href="<?php echo $pager->getPrevious()?>" aria-label="Previous"> 
		  			<span aria-hidden="true">«</span> 
		  		</a> 
			</li>
			<?php } ?>
		
		
			<?php
				foreach ($pager->links() as $link) {
					$activeClass = $link['active']?'active':"";
			?>
			<li class="<?=$activeClass;?>"><a href="<?=$link['uri'];?>"><?=$link['title'];?></a></li>
			<?php
				}
			?>
			
			<?php if($pager->hasNext()){?>
			<li> <a href="<?php echo $pager->getNext()?>" aria-label="Next"> <span aria-hidden="true">»</span> </a> </li>
			<?php } ?>
		</ul>
	</nav>
</div>