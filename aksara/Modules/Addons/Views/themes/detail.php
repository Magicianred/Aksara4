<?php
	$carousel										= null;
	
	if($detail->screenshot)
	{
		foreach($detail->screenshot as $key => $val)
		{
			if(file_exists(ROOTPATH . 'themes' . $detail->folder . '/' . $val->src))
			{
				$screenshot							= base_url('../themes/' . $detail->folder . '/' . $val->src);
			}
			else
			{
				$screenshot							= get_image(null, 'placeholder_thumb.png');
			}
			
			$carousel								.= '
				<div class="carousel-item rounded' . (!$key ? ' active' : null) . '">
					<img src="' . $screenshot . '" class="d-block rounded w-100" alt="' . $val->alt . '">
				</div>
			';
		}
	}
?>
<div class="container-fluid pt-3 pb-3">
	<div class="row">
		<div class="col-md-6">
			<div class="relative" style="overflow: hidden">
				<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
					<div class="carousel-inner">
						<?php echo $carousel; ?>
					</div>
					<?php if(sizeof($detail->screenshot) > 1) { ?>
						<a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
							<span class="carousel-control-prev-icon" aria-hidden="true"></span>
							<span class="sr-only">
								<?php echo phrase('previous'); ?>
							</span>
						</a>
						<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
							<span class="carousel-control-next-icon" aria-hidden="true"></span>
							<span class="sr-only">
								<?php echo phrase('next'); ?>
							</span>
						</a>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<h5 class="font-weight-light">
				<?php echo $detail->name; ?>
				<?php echo ($detail->type == 'backend' ? '<span class="badge badge-warning float-right">' . phrase('back_end') . '</span>' : '<span class="badge badge-success float-right">' . phrase('front_end') . '</span>'); ?>
			</h5>
			<hr />
			<div class="row">
				<div class="col-4">
					<label class="text-muted d-block">
						<?php echo phrase('author'); ?>
					</label>
				</div>
				<div class="col-8">
					<p>
						<?php echo (isset($detail->website) ? '<a href="' . $detail->website . '" target="_blank"><b>' . $detail->author . '</b></a>' : '<b>' . $detail->author . '</b>'); ?>
					</p>
				</div>
			</div>
			<div class="row">
				<div class="col-4">
					<label class="text-muted d-block">
						<?php echo phrase('version'); ?>
					</label>
				</div>
				<div class="col-8">
					<p>
						<?php echo $detail->version; ?>
					</p>
				</div>
			</div>
			<p class="mb-0">
				<?php echo nl2br($detail->description); ?>
			</p>
		</div>
	</div>
	<hr class="row" />
	<div class="row">
		<div class="col-md-3">
			<a href="<?php echo current_page('../../install'); ?>" class="btn btn-primary btn-block btn-sm">
				<?php echo phrase('customize'); ?>
			</a>
		</div>
		<div class="col-md-3">
		</div>
		<div class="col-md-3">
			<a href="<?php echo base_url(('backend' == $detail->type ? 'dashboard' : null), array('aksara_mode' => 'preview-theme', 'aksara_theme' => $detail->folder, 'integrity_check' => $detail->integrity)); ?>" class="btn btn-outline-primary btn-block btn-sm" target="_blank">
				<?php echo phrase('preview'); ?>
			</a>
		</div>
		<div class="col-md-3">
			<a href="<?php echo current_page('../delete', array('item' => $detail->folder)); ?>" class="btn btn-outline-danger btn-block btn-sm --modal">
				<?php echo phrase('delete'); ?>
			</a>
		</div>
	</div>
</div>
