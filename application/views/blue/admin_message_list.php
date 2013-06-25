					<div class="block">
						<h5>Daftar Pesan User</h5>
						<div class="block">
						<?php if($message_list): ?>		
							<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
								<thead>
									<tr>
										<th>No.</th>
										<th>Pengirim</th>
										<th>Tujuan</th>
										<th>Subjek</th>
										<th>Tanggal</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
							<?php $no = 1; ?>
							<?php foreach($message_list as $message): ?>
							<?php $message_recipient = $this->Sipuma_model->message_recipient($message->message_id); ?>
									<tr class="odd">
										<td>
											<?php echo $no++; ?>
										</td>
										<td>
											<a href="<?php echo base_url().'admin/message_detail/'.$message->message_id; ?>"><?php echo $message->full_name.' ('.$message->user_id.')'; ?></a>
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
											<?php echo substr($category,0,20).'...'; ?>
									<?php else: ?>
											-
									<?php endif; ?>
										</td>
										<td>
											<?php echo $message->subject; ?>
										</td>										
										<td>
											<?php echo tgl_indo($message->message_date); ?>
										</td>
										<td>
											<a href="#" onClick="confirmation('<?php echo base_url().'admin/message_delete/'.$message->message_id; ?>')">[Hapus]</a>
										</td>
									</tr>
								
							<?php endforeach; ?>
								</tbody>
							</table>
						<?php else: ?>
							<p>Tidak ada data pesan</p>
						<?php endif; ?>	
							<p><a href="<?php echo base_url().'admin/message'; ?>">[Kirim Pesan]</a></p>
						</div>
					</div>