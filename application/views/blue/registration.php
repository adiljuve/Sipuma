					<div class="block">	
						<h4>Registrasi</h4>
						<p>Lengkapi form berikut untuk melakukan registrasi.</p>
					</div>
					<div class="block" id="forms"> 						
						<form name="registration" id="registration" action="" method="post" onSubmit="return registration_check(registration)">
							<fieldset>
								<legend>Form Registrasi</legend>
								<p>
									<label>Tipe Akun: (*)</label><br />
									<select class="smallselect" name="user_type" id="user_type" onChange="changeText()">
										<option value="">--Pilih--</option>
										<option value="D">Dosen</option>
										<option value="M">Mahasiswa</option>
									</select>
									<?php echo form_error('user_type','<font color="red"><b>','</b></font>'); ?>
								</p>
								<p>
									<label id="ID">[ID]: (*)</label><br />
									<input class="small" type="text" name="user_id" id="user_id" maxlength="25" onBlur="white_space(user_id)" />
									<?php echo form_error('user_id','<font color="red"><b>','</b></font>'); ?>
								</p>
								<p>									
									<label>Nama Lengkap: (*)</label><br />
									<input class="small" type="text" name="full_name" id="full_name" maxlength="50" onBlur="white_space(full_name)" />
									<?php echo form_error('full_name','<font color="red"><b>','</b></font>'); ?>
								</p>
								<p>
									<label>Jenis Kelamin: (*)</label><br />
									<select class="smallselect" name="gender" id="gender">
										<option value="">--Pilih--</option>
										<option value="L">Laki-laki</option>
										<option value="P">Perempuan</option>
									</select>
									<?php echo form_error('gender','<font color="red"><b>','</b></font>'); ?>
								</p>
								<p>
									<label>Email: (*)</label><br />
									<input class="small" type="text" name="email" id="email" maxlength="50" onBlur="white_space(email)" />
									<?php echo form_error('email','<font color="red"><b>','</b></font>'); ?>
								</p>
								<p>
									<label>Nomor Telepon: </label><br />
									<input class="small" type="text" name="phone_number" id="phone_number" maxlength="20" onBlur="white_space(phone_number)" />
								</p>
								<p>
									<label>Website: </label><br />
									<input class="small" type="text" name="website" id="website" maxlength="50" onBlur="white_space(website)" />
									<?php echo form_error('website','<font color="red"><b>','</b></font>'); ?>
								</p>
								<p>
									<label>Password: (*)</label><br />
									<input class="small" type="password" name="password" id="password" maxlength="50" />
									<?php echo form_error('password','<font color="red"><b>','</b></font>'); ?>
								</p>
								<p>
									<label>Konfirmasi Password: (*)</label><br />
									<input class="small" type="password" name="password_confirmation" id="password_confirmation" maxlength="50" />
									<?php echo form_error('password_confirmation','<font color="red"><b>','</b></font>'); ?>
								</p>
								<p>
									<label>Kode Verifikasi (*)</label><br/>
									<label><img src="<?php echo base_url();?>home/captchaImg" /></label><br />
									<input class="small" type="text" name="verification" id="verification" />
									<?php echo form_error('verification','<font color="red"><b>','</b></font>'); ?>
								</p>
								<p>
									<label>Keterangan(*): Wajib diisi</label>
								</p>
								<input type="submit" value="Registrasi" />
								<input type="reset" value="Batal" />
							</fieldset>
						</form>
					</div>