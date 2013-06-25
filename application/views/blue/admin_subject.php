					<div class="block">
						<h5>Daftar Subjek</h5>
						<div class="block">
						<?php if($subject_list): ?>	
							<?php $no = 1; ?>
							<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
								<thead>
									<tr>
										<th>No.</th>
										<th>Nama Subjek</th>
										<th>Jumlah Jurnal</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
							<?php foreach($subject_list as $subject): ?>	
									<tr class="odd">
										<td><?php echo $no++; ?></td>
										<td><?php echo $subject->subject_name; ?></td>
										<?php $journal_count = $this->Sipuma_model->journal_count($subject->subject_id); ?>
										<td><a href="<?php echo base_url().'admin/subject_detail/'.$subject->subject_id; ?>"><?php echo $journal_count; ?></a></td>
										<td><a href="<?php echo base_url().'admin/subject_edit/'.$subject->subject_id; ?>">[Edit]</a> | <a href="#" onClick="confirmation('<?php echo base_url().'admin/subject_delete/'.$subject->subject_id; ?>')">[Hapus]</a></td>
									</tr>					
							<?php endforeach; ?>
								</tbody>
							</table>
						<?php else: ?>
							<p>Tidak ada subjek</p>
						<?php endif; ?>							
						</div>
					</div>
					<div class="block" id="forms">
						<form name="subject" id="subject" action="" method="post">
							<fieldset>
								<legend>Tambah Subjek</legend>
								<p>
									<label>Nama Subjek: (*)</label>
									<?php echo form_error('subject_name','<br /><label><font color="red"><b>','</b></font></label>'); ?>
									<input type="text" name="subject_name" id="subject_name" maxlength="50" onBlur="white_space(subject_name)" onKeyPress="return disableEnterKey(event)" />
								</p>
								<p>
									<label>Keterangan(*): Wajib diisi</label>
								</p>
								<input type="submit" value="Tambah Subjek" />
								<input type="reset" value="Batal" />
							</fieldset>
						</form>
					</div>