					<div class="block">	
						<h5>Form Kirim Pesan</h5>
					</div>
					<div class="block" id="forms">
						<form name="message" id="message" action="" method="post" onSubmit="return message_check(message)">
							<fieldset>
								<p>
									<label>Tujuan: (*) pilih minimal 1 tujuan pesan</label>
									<?php $select_user = $this->Sipuma_model->select_user($this->uri->segment(4)); ?>
									<?php if($select_user): ?>
									<input type="text" name="recipient_name" id="recipient_name" value="<?php echo $select_user->full_name; ?>" disabled />
									<input type="hidden" name="recipient_reply" id="recipient_reply" value="<?php echo $select_user->user_id; ?>" />
									<?php endif; ?>
								</p>
								<p>
									<label>Subjek: (*)</label>
									<?php echo form_error('subject','<br /><label><font color="red"><b>','</b></font></label>'); ?>
									<input type="text" name="subject" id="subject" maxlength="50" onBlur="white_space(subject)" />
								</p>
								<p>
									<label>Isi Pesan: (*)</label><br/>
									<?php echo form_error('message_text','<label><font color="red"><b>','</b></font></label><br />'); ?>
									<textarea cols="50" rows="10" maxlength="255" name="message_text" id="message_text" OnFocus="Count();" OnClick="Count();" onKeydown="Count();" OnChange="Count();" onKeyup="Count();"></textarea>
								</p>
								<p>
									<input name="counter" type="text" class="text-small" value="255" disabled/>
								</p>
								<p>
									<label>Keterangan(*): Wajib diisi</label>
								</p>
								<input type="submit" value="Kirim Pesan" onClick="white_space(message_text);" />
								<input type="reset" value="Batal" />
							</fieldset>
						</form>
					</div>