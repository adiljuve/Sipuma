					<div class="block">
						<h5>Daftar User</h5>
						<div class="block">
						<?php if($user_list): ?>	
							<?php $no = 1; ?>
							<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
								<thead>
									<tr>
										<th>No.</th>
										<th>Nama Lengkap</th>
										<th>Tipe User</th>
										<th>ID</th>
										<th>Status User</th>
										<th>Jumlah Karya Ilmiah</th>
										<th>Aksi</th>
										<th>Aktivasi</th>
									</tr>
								</thead>
								<tbody>
							<?php foreach($user_list as $user): ?>	
									<tr class="odd">
										<td><?php echo $no++; ?></td>
										<td><a href="<?php echo base_url().'admin/user_detail/'.$user->user_id; ?>"><?php echo $user->full_name; ?></a></td>
										<td><a href="<?php echo base_url().'admin/user_type/'.$user->user_type; ?>"><?php echo ucfirst($user->user_type); ?></a></td>
										<td><?php echo $user->user_id; ?></td>
										<td>
										<?php if($user->user_status == '1'): ?>
										Aktif
										<?php elseif($user->user_status == '0'): ?>
										Tidak Aktif
										<?php endif; ?>
										</td>
										<?php $user_paper_count = $this->Sipuma_model->user_paper_count($user->user_id); ?>
										<td>
										<?php echo $user_paper_count; ?>
										</td>
										<td>
										<a href="<?php echo base_url().'admin/user_edit/'.$user->user_id; ?>">[Edit]</a> | <a href="#" onClick="confirmation('<?php echo base_url().'admin/user_delete/'.$user->user_id; ?>')">[Hapus]</a>
										</td>
										<td>
										<?php if($user->user_status == '1'): ?>
										<a href="#" onClick="confirmation('<?php echo base_url().'admin/deactivate/'.$user->user_id; ?>')">[Nonaktifkan]</a>
										<?php elseif($user->user_status == '0'): ?>
										<a href="#" onClick="confirmation('<?php echo base_url().'admin/activate/'.$user->user_id; ?>')">[Aktifkan]</a>
										<?php endif; ?>
										</td>
									</tr>					
							<?php endforeach; ?>
								</tbody>
							</table>
						<?php else: ?>
							<p>Tidak ada user</p>
						<?php endif; ?>							
						</div>
					</div>
					<div class="block" id="forms"> 
						<form name="registration" id="registration" action="" method="post" onSubmit="return registration_check(registration)">
							<fieldset>
								<legend>Tambah User</legend>
								<p>
									<label>Tipe Akun: (*)</label>
									<?php echo form_error('user_type','<br /><font color="red"><b>','</b></font>'); ?>
									<select name="user_type" id="user_type" onChange="changeText()">
										<option value="">--Pilih--</option>
										<option value="D">Dosen</option>
										<option value="M">Mahasiswa</option>
									</select>
								</p>
								<p>
									<label id="ID">[ID]: (*)</label>
									<?php echo form_error('user_id','<br /><font color="red"><b>','</b></font>'); ?>
									<input type="text" name="user_id" id="user_id" maxlength="25" onBlur="white_space(user_id)" />
								</p>
								<p>
									<label>Nama Lengkap: (*)</label>
									<?php echo form_error('full_name','<br /><font color="red"><b>','</b></font>'); ?>
									<input type="text" name="full_name" id="full_name" maxlength="50" onBlur="white_space(full_name)" />
								</p>
								<p>
									<label>Jenis Kelamin: (*)</label>
									<?php echo form_error('gender','<br /><font color="red"><b>','</b></font>'); ?>
									<select name="gender" id="gender">
										<option value="">--Pilih--</option>
										<option value="L">Laki-laki</option>
										<option value="P">Perempuan</option>
									</select>
								</p>
								<p>
									<label>Email: (*)</label>
									<?php echo form_error('email','<br /><font color="red"><b>','</b></font>'); ?>
									<input type="text" name="email" id="email" maxlength="50" onBlur="white_space(email)" />
								</p>
								<p>
									<label>Nomor Telepon: </label>
									<input type="text" name="phone_number" id="phone_number" maxlength="50" onBlur="white_space(phone_number)" />
								</p>
								<p>
									<label>Website: </label>
									<?php echo form_error('website','<br /><font color="red"><b>','</b></font>'); ?>
									<input type="text" name="website" id="website" maxlength="50" onBlur="white_space(website)" />
								</p>
								<p>
									<label>Password: (*)</label>
									<input type="text" name="password" id="password" maxlength="50" onBlur="white_space(password)" />
								</p>
								<p>
									<label>Status Akun:</label>
									<select name="user_status" id="user_status">
										<option value="1">Aktif</option>
										<option value="0">Tidak Aktif</option>
									</select>
								</p>
								<p>
									<label>Keterangan(*): Wajib diisi</label>
								</p>
								<input type="submit" value="Tambah User" />
								<input type="reset" value="Batal" />
							</fieldset>
						</form>
					</div>