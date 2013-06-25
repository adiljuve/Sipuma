					<div class="block">
						<h4>Edit Profil</h4>
						<div class="block">
						<?php if($profile_detail): ?>
							<form name="profile" id="profile" action="" method="post">
								<fieldset>
									<p class="notice">Berikut detail profil Anda</p>
									<p>
										<label>NIM:</label>
										<?php echo $profile_detail->user_id; ?>
									</p>
									<p>
										<label>Nama Lengkap:</label>
										<?php echo $profile_detail->full_name; ?>
									</p>
									<p>
										<label>Tanggal Terdaftar:</label>
										<?php echo tgl_indo($profile_detail->date_registered); ?>
									</p>
									<p>
										<?php if($profile_detail->gender == 'L'): ?>
										<label>Jenis Kelamin:</label> Laki-laki
										<?php elseif($profile_detail->user_type == 'P'): ?>
										<label>Jenis Kelamin:</label> Perempuan
										<?php endif; ?>
									</p>
									<p>
										<label>Email: (*)</label>
										<?php echo form_error('email','<br /><label><font color="red"><b>','</b></font></label>'); ?>
										<input type="text" name="email" id="email" maxlength="50" value="<?php echo $profile_detail->email; ?>" onBlur="white_space(email)" />
									</p>
									<p>
										<label>Nomor Telepon: </label>
										<?php echo form_error('phone_number','<br /><label><font color="red"><b>','</b></font></label>'); ?>
										<input type="text" name="phone_number" id="phone_number" maxlength="20" value="<?php echo $profile_detail->phone_number; ?>" onBlur="white_space(phone_number)" />
									</p>
									<p>
										<label>Website:</label>
										<?php echo form_error('website','<br /><label><font color="red"><b>','</b></font></label>'); ?>
										<input type="text" name="website" id="website" maxlength="50" value="<?php echo $profile_detail->website; ?>" onBlur="white_space(website)" />
									</p>

									<p>
										<label>Info:</label><br/>
										<textarea name="info" id="info" cols="50" rows="10"><?php echo $profile_detail->info; ?></textarea>
									</p>
									<p>
										<label>Keterangan(*): Wajib diisi</label>
									</p>
									<input type="submit" value="Edit" />
									<input type="reset" value="Batal" />
								</fieldset>
							</form>						
						<?php else: ?>
								<p>
									Tidak ada karya ilmiah yang dipublikasi
								</p>
						<?php endif; ?>
						</div>
					</div>