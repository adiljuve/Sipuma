					<div class="block" id="forms">
					<?php if($journal_detail): ?>
						<form name="journal" id="journal" action="" method="post" onSubmit="return journal_check(journal)">
							<fieldset>
								<legend>Edit Jurnal</legend>
								<p>
									<label>Nama Jurnal: (*)</label>
									<?php echo form_error('journal_name','<br /><label><font color="red"><b>','</b></font></label>'); ?>
									<input type="text" name="journal_name" id="journal_name" maxlength="100" value="<?php echo $journal_detail->journal_name; ?>" onBlur="white_space(journal_name)" />
									<input type="hidden" name="journal_id" id="journal_id" value="<?php echo $journal_detail->journal_id; ?>" />
								</p>
								<p>
									<label>Subjek: (*)</label>
									<?php echo form_error('subject_id','<br /><label><font color="red"><b>','</b></font></label>'); ?>
								<?php if($subject_list): ?>
									<br />
									<select multiple class="chzn-select" name="subject_id[]" id="subject_id">
									<?php foreach($subject_list as $subject): ?>
										<?php $selected = $this->Sipuma_model->subject_journal_check($subject->subject_id, $journal_detail->journal_id); ?>
										<option value="<?php echo $subject->subject_id; ?>"<?php if ($selected == 1):?> selected<?php else:?><?php endif;?>><?php echo $subject->subject_name; ?></option>
									<?php endforeach; ?>
									</select>
								<?php else: ?>
									<p>Tidak ada subjek. <a href="<?php echo base_url().'admin/subject'; ?>">Tambahkan Subjek</a></p>
								<?php endif; ?>
								</p>								
								<p>
									<label>Path: (*)</label>
									<input type="text" name="path" id="path" maxlength="25" value="<?php echo $journal_detail->path; ?>" disabled />
								</p>
								<p>
									<label>Info: (*)</label><br/>
									<textarea cols="40" rows="10" name="info" id="info" ><?php echo $journal_detail->info; ?></textarea>
								</p>
								<p>
									<label>Keterangan(*): Wajib diisi</label>
								</p>
								<input type="submit" value="Edit Jurnal" />
								<input type="reset" value="Batal" />
								<a href="javascript:history.back(1);">[Kembali]</a>
							</fieldset>
						</form>
					<?php else: ?>
						<p>Data jurnal tidak ditemukan.</p>
					<?php endif; ?>
					</div>