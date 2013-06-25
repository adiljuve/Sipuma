					<div class="block" id="forms">
					<?php if($subject_detail): ?>
						<form name="subject" id="subject" action="" method="post" onSubmit="return subject_check(subject)">
							<fieldset>
								<legend>Edit Subjek</legend>
								<p>
									<label>Nama Subjek: (*)</label>
									<?php echo form_error('subject_name','<br /><label><font color="red"><b>','</b></font></label>'); ?>
									<input type="text" name="subject_name" id="subject_name" maxlength="50" value="<?php echo $subject_detail->subject_name; ?>"  onBlur="white_space(subject_name)" onKeyPress="return disableEnterKey(event)" />
								</p>
								<p>
									<label>Keterangan(*): Wajib diisi</label>
								</p>
								<input type="submit" value="Edit Subjek" />
								<input type="reset" value="Batal" />
								<a href="javascript:history.back(1);">[Kembali]</a>
							</fieldset>
						</form>
					<?php else: ?>
						<p>Data subjek tidak ditemukan.</p>
					<?php endif; ?>
					</div>