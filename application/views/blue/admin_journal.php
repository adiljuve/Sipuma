					<div class="block">
						<h5>Daftar Jurnal</h5>
						<div class="block">
						<?php if($journal_list_all): ?>	
							<?php $no = 1; ?>
							<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
								<thead>
									<tr>
										<th>No.</th>
										<th>Nama Jurnal</th>
										<th>Path</th>
										<th>Jumlah Member</th>
										<th>Jumlah Publikasi</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
							<?php foreach($journal_list_all as $journal): ?>	
									<tr class="odd">
										<td><?php echo $no++; ?></td>
										<td><a href="<?php echo base_url().'admin/journal_detail/'.$journal->path; ?>"><?php echo $journal->journal_name; ?></a></td>
										<td><?php echo $journal->path; ?></td>
										<?php $journal_member_count = $this->Sipuma_model->journal_member_count($journal->journal_id);?>
										<td><a href="<?php echo base_url().'admin/journal_member/'.$journal->path; ?>"><?php echo $journal_member_count; ?></a></td>
										<?php $paper_published_count = $this->Sipuma_model->paper_published_count($journal->journal_id);?>
										<td><?php echo $paper_published_count; ?></td>
										<td><a href="<?php echo base_url().'admin/journal_edit/'.$journal->path; ?>">[Edit]</a> | <a href="#" onClick="confirmation('<?php echo base_url().'admin/journal_delete/'.$journal->path.'/'.$journal->journal_id; ?>')">[Hapus]</a></td>
									</tr>					
							<?php endforeach; ?>
								</tbody>
							</table>
						<?php else: ?>
							<p>Tidak ada jurnal</p>
						<?php endif; ?>							
						</div>
					<div class="block" id="forms">
						<form name="journal" id="journal" action="" method="post" onSubmit="return journal_check(journal)">
							<fieldset>
								<legend>Tambah Jurnal</legend>
								<p>
									<label>Nama Jurnal: (*)</label>
									<?php echo form_error('journal_name','<br /><label><font color="red"><b>','</b></font></label>'); ?>
									<input type="text" name="journal_name" id="journal_name" maxlength="100" onBlur="white_space(journal_name)" />
								</p>
								<p>
									<label>Subjek: (*)</label>
									<?php echo form_error('subject_id','<br /><label><font color="red"><b>','</b></font></label>'); ?>
								<?php if($subject_list): ?>
									<br />
									<select multiple class="chzn-select" name="subject_id[]" id="subject_id" data-placeholder="Pilih Subjek">
									<?php foreach($subject_list as $subject): ?>
										<option value="<?php echo $subject->subject_id; ?>"><?php echo $subject->subject_name; ?></option>
									<?php endforeach; ?>
									</select>
								<?php else: ?>
									<p>Tidak ada subjek. <a href="<?php echo base_url().'admin/subject'; ?>">Tambahkan Subjek</a></p>
								<?php endif; ?>
								</p>
								<p>
									<label>Path: (*) (isi berupa singkatan, atau akronim sebagai identifikasi alamat jurnal)</label>
									<?php echo form_error('path','<br /><label><font color="red"><b>','</b></font></label>'); ?>
									<input type="text" name="path" id="path" maxlength="25" onBlur="white_space(path)" />
								</p>
								<p>
									<label>Info:</label><br/>
									<textarea name="info" id="info" cols="50" rows="10" /></textarea>
								</p>
								<p>
									<label>Keterangan(*): Wajib diisi</label>
								</p>
								<input type="submit" value="Tambah Jurnal" />
								<input type="reset" value="Batal" />
							</fieldset>
						</form>
					</div>
					</div>
