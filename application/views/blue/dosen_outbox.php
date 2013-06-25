					<div class="block">
						<h5>Daftar Pesan Keluar</h5>
						<div class="block">
						<?php if($outbox_list): ?>		
							<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
								<thead>
									<tr>
										<th>No.</th>
										<th>Tanggal Pesan</th>
										<th>Subjek</th>
										<th>Tujuan</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
							<?php $no = 1; ?>
							<?php foreach($outbox_list as $outbox): ?>
							<?php $message_recipient = $this->Sipuma_model->message_recipient($outbox->message_id); ?>	
									<tr class="odd">
										<td>
											<?php echo $no++; ?>
										</td>
										<td>
											<a href="<?php echo base_url().'dosen/message_detail/'.$outbox->message_id; ?>"><?php echo tgl_indo($outbox->message_date); ?></a>
										</td>
										<td>
											<?php echo $outbox->subject; ?>	
										</td>
										<td>
									<?php if($message_recipient): ?>
										<?php $category = "";
										  $comma = ", "; ?>
										<?php foreach ($message_recipient as $recipient): ?>
											<?php 
											$category .= $recipient->full_name.' ('.$recipient->user_id.')';
											$category .= $comma;
											?>
										<?php endforeach; ?>
											<?php $category = substr($category,0,-2); ?>
											<?php echo $category; ?>
									<?php else: ?>
											-
									<?php endif; ?>
										</td>
										<td>
											<a href="#" onClick="confirmation('<?php echo base_url().'dosen/message_delete/'.$outbox->message_id; ?>')">[Hapus]</a>
										</td>
									</tr>				
							<?php endforeach; ?>
								</tbody>
							</table>
						<?php else: ?>
							<p>Tidak ada pesan masuk</p>
						<?php endif; ?>		
							<p><a href="<?php echo base_url().'dosen/message'; ?>">[Kirim Pesan]</a></p>
						</div>
					</div>