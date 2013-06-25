					<div class="block" id="forms">
					<?php if($user_detail): ?>
						<form name="profile" id="profile" method="post" action="">
							<fieldset>
								<p><font color="red"><b>Perubahan Profil Berhasil</b></font></p>
								<legend>Profil Admin</legend>
								<p>
									<label>ID: </label>
									<?php echo form_error('user_id','<br /><label><font color="red"><b>','</b></font></label>'); ?>
									<input type="text" name="user_id" id="user_id" maxlength="25" value="<?php echo $user_detail->user_id; ?>" />
								</p>
								<p>
									<label>Nama Lengkap: </label>
									<?php echo form_error('full_name','<br /><label><font color="red"><b>','</b></font></label>'); ?>
									<input type="text" name="full_name" id="full_name" maxlength="50" value="<?php echo $user_detail->full_name; ?>" onBlur="white_space(full_name)" />
								</p>
								<p>
									<label>Jenis Kelamin: </label>
									<select name="gender" id="gender">
										<option value="L" <?php if($user_detail->gender == 'L'): ?>selected<?php else: ?><?php endif; ?>>Laki-laki</option>
										<option value="P" <?php if($user_detail->gender == 'P'): ?>selected<?php else: ?><?php endif; ?>>Perempuan</option>
									</select>
								</p>
								<p>
									<label>Email: </label>
									<?php echo form_error('email','<br /><label><font color="red"><b>','</b></font></label>'); ?>
									<input type="text" name="email" id="email" maxlength="50" value="<?php echo $user_detail->email; ?>" onBlur="white_space(email)" />
								</p>
								<p>
									<label>Nomor Telepon: </label>
									<?php echo form_error('phone_number','<br /><label><font color="red"><b>','</b></font></label>'); ?>
									<input type="text" name="phone_number" id="phone_number" maxlength="20" value="<?php echo $user_detail->phone_number; ?>" onBlur="white_space(phone_number)" />
								</p>
								<p>
									<label>Website: </label>
									<?php echo form_error('website','<br /><label><font color="red"><b>','</b></font></label>'); ?>
									<input type="text" name="website" id="website" maxlength="50" value="<?php echo $user_detail->website; ?>" onBlur="white_space(website)" />
								</p>
								<p>
									<label>Tanggal Terdaftar: </label>
									<?php echo $user_detail->date_registered; ?>
								</p>
								<p>
									<label>Info: </label><br/>
									<textarea name="info" id="info" cols="50" rows="10"><?php echo $user_detail->info; ?></textarea>
								</p>
								<input type="submit" value="Edit Profil" />
								<input type="reset" value="Batal" />
							</fieldset>
						</form>
					<?php endif; ?>
					</div>