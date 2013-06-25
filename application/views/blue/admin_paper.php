					<div class="block">
						<h5>Daftar Karya Ilmiah</h5>
						<div class="block">
						<?php if($paper_list): ?>	
							<?php $no = 1; ?>
							<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
								<thead>
									<tr>
										<th>No.</th>
										<th>Judul</th>
										<th>Jurnal</th>
										<th>Tanggal Pengajuan</th>
										<th>Status</th>
										<th>Revisi</th>
									</tr>
								</thead>
								<tbody>
							<?php foreach($paper_list as $paper): ?>	
									<tr class="odd">
										<td><?php echo $no++; ?></td>
										<td><?php if($paper->paper_status == '2'): ?><a href="<?php echo base_url().'admin/paper_detail/'.$paper->paper_id; ?>"><?php echo $paper->title; ?></a><?php else: ?><?php echo $paper->title; ?><?php endif; ?></td>
										<?php $journal_paper = $this->Sipuma_model->journal_paper($paper->paper_id); ?>
										<?php if($journal_paper): ?>
										<td><a href="<?php echo base_url().'admin/journal_detail/'.$journal_paper->path; ?>"><?php echo $journal_paper->journal_name; ?></a></td>
										<?php else: ?>
										<td>Tidak Ada</td>
										<?php endif; ?>
										<td><?php echo tgl_indo($paper->date_created); ?></td>
										<?php if($paper->paper_status == '0'): ?>
										<td><a href="<?php echo base_url().'admin/review_detail/'.$paper->paper_id; ?>">Review</a></td>
										<?php elseif($paper->paper_status =='1'): ?>
										<td><a href="<?php echo base_url().'admin/review_detail/'.$paper->paper_id; ?>">Ditolak</a></td>
										<?php elseif($paper->paper_status =='2'): ?>
										<td><a href="<?php echo base_url().'admin/review_detail/'.$paper->paper_id; ?>">Publikasi</a></td>
										<?php endif; ?>
										<td><?php echo $paper->revision_count; ?></td>			
							<?php endforeach; ?>
								</tbody>
							</table>
						<?php else: ?>
							<p>Tidak ada karya ilmiah</p>
						<?php endif; ?>							
						</div>
					</div>
