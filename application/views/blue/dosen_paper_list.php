					<div class="block">
						<h5>Daftar Karya Ilmiah Yang Perlu Direview</h5>
						<div class="block">	
						<?php $no = 1; ?>						
						<?php if($paper_review): ?>		
							<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
								<thead>
									<tr>
										<th>No.</th>
										<th>Judul</th>
										<th>Jurnal</th>
										<th>Tgl. Pengajuan</th>
										<th>Jumlah Revisi</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
							<?php foreach($paper_review as $paper): ?>
							<?php $paper_published_author = $this->Sipuma_model->paper_published_author($paper->paper_id); ?>
								
									<tr class="odd">
										<td>
										<?php echo $no++; ?>
										</td>
										<td>
										<?php echo $paper->title; ?>
										</td>
										<td>
									<?php $journal_paper = $this->Sipuma_model->journal_paper($paper->paper_id);?>
										<?php if($journal_paper): ?>
										<a href="<?php echo base_url().'dosen/journal_detail/'.$journal_paper->path; ?>"><?php echo $journal_paper->journal_name; ?>
									<?php else: ?>
										-
									<?php endif; ?>
										</td>
										<td>
										<?php echo tgl_indo($paper->date_created); ?>
										</td>
										<td>
										<?php echo $paper->revision_count; ?>
										</td>
										<td>
										<?php if($this->uri->segment(2) == 'paper_revision_list'): ?>
										<a href="<?php echo base_url().'dosen/review_paper_revision/'.$paper->paper_id; ?>">[Review]</a>
										<?php else: ?>
										<a href="<?php echo base_url().'dosen/review_paper/'.$paper->paper_id; ?>">[Review]</a>
										<?php endif; ?>
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