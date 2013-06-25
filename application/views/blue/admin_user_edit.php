					<div class="block" id="forms">
					<?php if($user_detail): ?>
						<form name="registration" id="registration" action="" method="post">
							<fieldset>
								<legend>Edit User</legend>
								<p>
									<label>Tipe Akun: (*)</label>
									<select name="user_type" id="user_type">
										<option value="D" <?php if($user_detail->user_type == 'D'): ?>selected<?php else: ?><?php endif; ?>>Dosen</option>
										<option value="M" <?php if($user_detail->user_type == 'M'): ?>selected<?php else: ?><?php endif; ?>>Mahasiswa</option>
									</select>
								</p>
								<p>
									<label>[ID]: (*)</label>
									<input type="text" name="user_id" id="user_id" maxlength="25" value="<?php echo $user_detail->user_id; ?>" onBlur="white_space(user_id)" disabled />
								</p>
								<p>
									<label>Nama Lengkap: (*)</label>
									<?php echo form_error('full_name','<font color="red"><b>','</b></font>'); ?>
									<input type="text" name="full_name" id="full_name" maxlength="50" value="<?php echo $user_detail->full_name; ?>"  onBlur="white_space(nama_lengkap)" />
								</p> 
								<p>
									<label>Jenis Kelamin: (*)</label>
									<select name="gender" id="gender">
										<option value="L" <?php if($user_detail->gender == 'L'): ?>selected<?php else: ?><?php endif; ?>>Laki-laki</option>
										<option value="P" <?php if($user_detail->gender == 'P'): ?>selected<?php else: ?><?php endif; ?>>Perempuan</option>
									</select>
								</p>
								<p>
									<label>Email: (*)</label>
									<?php echo form_error('email','<font color="red"><b>','</b></font>'); ?>
									<input type="text" name="email" id="email" maxlength="50" value="<?php echo $user_detail->email; ?>" onBlur="white_space(email)" />
								</p>
								<p>
									<label>Nomor Telepon: </label>
									<?php echo form_error('phone_number','<font color="red"><b>','</b></font>'); ?>
									<input type="text" name="phone_number" id="phone_number" maxlength="20" value="<?php echo $user_detail->phone_number; ?>" onBlur="white_space(phone_number)" />
								</p>
								<p>
									<label>Website: </label>
									<?php echo form_error('website','<font color="red"><b>','</b></font>'); ?>
									<input type="text" name="website" id="website" maxlength="50" value="<?php echo $user_detail->website; ?>" onBlur="white_space(website)" />
								</p>
								<p>
									<label>Keterangan Tambahan: </label><br/>
									<textarea name="info" id="info" cols="50" rows="10"><?php echo $user_detail->info; ?></textarea>
								</p>
								<p>
									<label>Status Akun<label>
									<select name="user_status" id="user_status">
										<option value="1" <?php if($user_detail->user_status == '1'): ?>selected<?php else: ?><?php endif; ?>>Aktif</option>
										<option value="0" <?php if($user_detail->user_status == '0'): ?>selected<?php else: ?><?php endif; ?>>Tidak Aktif</option>
									</select>
								</p>
								<p>
									<a href="#" onClick="confirmation('<?php echo base_url().'admin/password_reset/'.$user_detail->user_id.'/'.$user_detail->user_id; ?>')">[Reset Password = <?php echo strrev($user_detail->user_id); ?>] </a>
								<p>
								<p>
									<label>Keterangan(*): Wajib diisi</label>
								</p>
								<input type="submit" value="Edit User" />
								<input type="reset" value="Batal" />
								<a href="javascript:history.back(1);">[Kembali]</a>
							</fieldset>
						</form>
					<?php else: ?>
						<p>Data user tidak ditemukan.</p>
					<?php endif; ?>
					</div>