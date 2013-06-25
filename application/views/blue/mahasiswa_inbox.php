					<div class="block">
						<h5>Daftar Pesan Masuk</h5>
						<div class="block">
						<?php if($inbox_list): ?>		
							<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
								<thead>
									<tr>
										<th>No.</th>
										<th>Pengirim</th>
										<th>Subjek</th>
										<th>Status</th>
										<th>Tanggal Pesan</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
							<?php $no = 1; ?>
							<?php foreach($inbox_list as $inbox): ?>								
									<tr class="odd">
										<td>
											<?php echo $no++; ?>
										</td>
										<td>
											<a href="<?php echo base_url().'mahasiswa/message_read/'.$inbox->message_status.'/'.$inbox->message_id; ?>"><?php echo $inbox->full_name; ?></a>
										</td>
										<td>
											<?php echo $inbox->subject; ?>
										</td>
										<td>
											<?php if($inbox->message_status == '1'): ?>
											sudah dibaca
											<?php else: ?>
											<b>belum dibaca</b>
											<?php endif; ?>
										</td>
										<td>
											<?php echo tgl_indo($inbox->message_date); ?>
										</td>
										<td>
											<a href="#" onClick="confirmation('<?php echo base_url().'mahasiswa/message_inbox_delete/'.$inbox->message_id; ?>')">[Hapus]</a>
										</td>
									</tr>
							<?php endforeach; ?>
								</tbody>
							</table>
						<?php else: ?>
							<p>Tidak ada pesan masuk</p>
						<?php endif; ?>			
							<p><a href="<?php echo base_url().'mahasiswa/message'; ?>">[Kirim Pesan]</a></p>
						</div>
					</div>