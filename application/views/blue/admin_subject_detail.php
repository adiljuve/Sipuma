				<div class="block">
					<?php if($subject_detail): ?>
					<h4><?php echo $subject_detail->subject_name; ?></h4>
					<div class="block">
					<?php if($journal_list): ?>
						<?php $no = 1; ?>
						<h5>Daftar Jurnal</h5>
						<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
							<thead>
								<tr>
									<th>No.</th>
									<th>Nama Jurnal</th>
									<th>Nama Subjek</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
						<?php foreach ($journal_list as $journal): ?>
							<tr>
								<td>
									<?php echo $no++; ?>
								</td>
								<td>
									<a href="<?php echo base_url(); ?>admin/journal_detail/<?php echo $journal->path; ?>"><?php echo $journal->journal_name;?></a>
								</td>
								<td>
									<?php echo $subject_detail->subject_name; ?>
								</td>
								<td>
									<a href="<?php echo base_url().'admin/journal_edit/'.$journal->path; ?>">[Edit]</a> | <a href="#" onClick="confirmation('<?php echo base_url().'admin/journal_delete/'.$journal->journal_id; ?>')">[Hapus]</a>
								</td>
							</tr>
						<?php endforeach;?>
							</tbody>
						</table>
					<?php else: ?>							
						<p>Tidak Ada Jurnal</p>
					<?php endif; ?>	
					</div>
					<?php else: ?>
						<?php redirect('home'); ?>
					<?php endif;?>
				</div>