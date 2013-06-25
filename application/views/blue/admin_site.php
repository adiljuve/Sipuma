					<div class="block" id="forms">
					<?php if($site_info): ?>
						<form name="site_info" id="site_info" method="post" action="">
							<fieldset>
								<legend>Site Info</legend>
								<p>
									<label>Judul: </label>
									<?php echo form_error('title','<br /><label><font color="red"><b>','</b></font></label>'); ?>
									<input type="text" name="title" id="title" maxlength="100" value="<?php echo $site_info->title; ?>" />
								</p>
								<p>
									<label>Nama Instansi: </label>
									<?php echo form_error('owner','<br /><label><font color="red"><b>','</b></font></label>'); ?>
									<input type="text" name="owner" id="owner" maxlength="100" value="<?php echo $site_info->owner; ?>" />
								</p>
								<p>
									<label>No. Telepon: </label>
									<?php echo form_error('phone_number','<br /><label><font color="red"><b>','</b></font></label>'); ?>
									<input type="text" name="phone_number" id="phone_number" maxlength="20" value="<?php echo $site_info->phone_number; ?>" />
								</p>
								<p>
									<label>Fax: </label>
									<?php echo form_error('fax','<br /><label><font color="red"><b>','</b></font></label>'); ?>
									<input type="text" name="fax" id="fax" maxlength="50" value="<?php echo $site_info->fax; ?>" />
								</p>
								<p>
									<label>Email: </label>
									<?php echo form_error('email','<br /><label><font color="red"><b>','</b></font></label>'); ?>
									<input type="text" name="email" id="email" maxlength="50" value="<?php echo $site_info->email; ?>" />
								</p>
								<p>
									<label>Alamat: </label>
									<?php echo form_error('address','<br /><label><font color="red"><b>','</b></font></label>'); ?>
									<input type="text" name="address" id="address" maxlength="100" value="<?php echo $site_info->address; ?>" />
								</p>
								<p>
									<label>Info: </label><br/>
									<textarea name="info" id="info" cols="50" rows="10"><?php echo $site_info->info; ?></textarea>
								</p>
								<input type="submit" value="Edit Info" />
								<input type="reset" value="Batal" />
							</fieldset>
						</form>
					<?php endif; ?>
					</div>