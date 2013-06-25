				<div class="box">
					<h2>
						<a href="#" id="toggle-search">Cari Publikasi</a>
					</h2>
					<div class="block" id="search">
						<form id="search" name="search" method="post" action="<?php echo base_url(); ?>home/search" class="search" onSubmit="return paper_search_check(search)">
							<p>
								<input type="text" id="keyword" name="keyword" onBlur="white_space(keyword)" onKeyPress="return disableEnterKey(event)" />
								<select name="option" id="option">
									<option value="title">Judul</option>
									<option value="author">Penulis</option>
								</select>
								<input class="search button" type="submit" value="Cari" />
							</p>
						</form>
					</div>
				</div>
				<div class="box">
					<h2>
						<a href="#" id="toggle-login-forms">Login Form</a>
					</h2>
					<div class="block" id="login-forms">
						<form id="login" name="login" method="post" action="<?php echo base_url(); ?>home/login" onSubmit="return login_check(login)">
							<fieldset class="login">
								<legend>Login</legend>
								<p class="notice">Login form.</p>
								<p>
									<label>Username: </label>
									<input type="text" id="user_id" name="user_id" onBlur="white_space(user_id)" onKeyPress="return disableEnterKey(event)" />
								</p>
								<p>
									<label>Password: </label>
									<input type="password" id="password" name="password" />
								</p>
								<input class="login button" type="submit" value="Login" />
							</fieldset>
						</form>
						<fieldset>
							<legend>Registrasi</legend>
							<p>Belum punya akun? lakukan <a href="<?php echo base_url(); ?>home/registration">registrasi</a>.</p>
						</fieldset>
					</div>
				</div>