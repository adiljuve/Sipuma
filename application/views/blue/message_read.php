				<div class="block">
					<h5>Detail Pesan</h5>
					<div class="block">
						<ul>
					<?php if($message_detail): ?>
						<?php $message_recipient = $this->Sipuma_model->message_recipient($message_detail->message_id); ?>
							<li>
								<b>Tanggal Pesan:</b> <?php echo tgl_indo($message_detail->message_date); ?>
							</li>
							<li>
								<b>Pengirim:</b> <?php echo $message_detail->full_name; ?>
							</li>
							<li>
								<b>Tujuan:</b> 
								<?php if($message_recipient): ?>
									<?php $category = "";
										  $comma = ", "; ?>
										<?php foreach ($message_recipient as $recipient): ?>
											<?php 
											$category .= $recipient->full_name;
											$category .= $comma;
										?>
										<?php endforeach; ?>
										<?php $category = substr($category,0,-2); ?>
										<?php echo $category; ?>
								<?php else: ?>
										-
								<?php endif; ?>
							</li>
							<li>
								<b>Subjek:</b><br/>
								<?php echo $message_detail->subject; ?>
							</li>
							<li>
								<b>Isi Pesan:</b><br/>
								<?php echo nl2br($message_detail->message); ?>
							</li>
					<?php else: ?>
							<li>
								Detail Pesan Tidak Ditemukan
							</li>
					<?php endif; ?>
						</ul>
						<p><a href="<?php echo base_url().$this->uri->segment(1).'/inbox'; ?>">[Kembali]</a> <a href="<?php echo base_url().$this->uri->segment(1).'/message_reply'.'/'.$message_detail->message_id.'/'.$message_detail->user_id; ?>">[Balas Pesan]</a></p>
					</div>
				</div>