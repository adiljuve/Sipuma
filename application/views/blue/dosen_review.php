					<div class="block">
						<h5>Daftar Review</h5>
						<p>Berisi daftar karya ilmiah yang pernah direview</p>
						<div class="block">
						<?php $no = 1; ?>
						<?php if($review_list): ?>		
							<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
								<thead>
									<tr>
										<th>No.</th>
										<th>Judul</th>
										<th>Hasil Review</th>
										<th>Tanggal Review</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
							<?php foreach($review_list as $review): ?>
							<?php $paper_published_author = $this->Sipuma_model->paper_published_author($review->paper_id); ?>
							<?php $paper_detail_review_list = $this->Sipuma_model->paper_detail_review_list($review->paper_id); ?>
									<tr class="odd">
										<td>
											<?php echo $no++; ?>
										</td>
										<td>
											<a href="<?php echo base_url(); ?>dosen/review_detail/<?php echo $review->paper_id; ?>"><?php if($paper_detail_review_list): ?><?php echo $paper_detail_review_list->title; ?><?php else: ?>-<?php endif; ?></a>
										</td>
										<td>
											<?php if(($review->review_status == '0') || ($review->review_status == '3')): ?>
											Merevisi
											<?php elseif($review->review_status == '1'): ?>
											Menolak
											<?php elseif($review->review_status == '2'): ?>
											Menerima
											<?php endif; ?>
										</td>
										<td>
											<?php echo tgl_indo($review->review_date); ?>
										</td>
										<td>
											<a href="<?php echo base_url().'dosen/review_detail/'.$review->paper_id; ?>">[Detail]</a> |
											<a href="#" onClick="confirmation('<?php echo base_url().'dosen/review_delete/'.$review->review_id; ?>')">[Hapus]</a>
										</td>
									</tr>
								
							<?php endforeach; ?>
								</tbody>
							</table>
						<?php else: ?>
								<p>
									Tidak ada karya ilmiah
								</p>
						<?php endif; ?>							
						</div>
					</div>