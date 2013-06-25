					<div class="block">	
						<h5>Ganti Password</h5>
						<p>Lengkapi form berikut untuk melakukan perubahan password.</p>
					</div>
					<div class="block" id="forms">
						<form name="password" id="password" action="" method="post" onSubmit="return pass_check(password)">
							<fieldset>
								<p>
									<label>Password lama: (*)</label>
									<?php echo form_error('password_old','<br /><label><font color="red"><b>','</b></font></label>'); ?>
									<input type="password" name="password_old" id="password_old" maxlength="50" />
								</p>
								<p>
									<label>Password baru: (*)</label>
									<?php echo form_error('password_new','<br /><label><font color="red"><b>','</b></font></label>'); ?>
									<input type="password" name="password_new" id="password_new" maxlength="50" />
								</p>
								<p>
									<label>Password baru(ulangi): (*)</label>
									<?php echo form_error('password_new_confirm','<br /><label><font color="red"><b>','</b></font></label>'); ?>
									<input type="password" name="password_new_confirm" id="password_new_confirm" maxlength="50" />
								</p>
								<p>
									<label>Keterangan(*): Wajib diisi</label>
								</p>
								<input type="submit" value="Ganti Password" />
								<input type="reset" value="Batal" />
							</fieldset>
						</form>
					</div>