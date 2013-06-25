				<ul class="nav main">
					<li>
						<a href="<?php echo base_url().'admin'; ?>"><img src="<?php echo base_url().'style/img/home.png'; ?>" />Home</a>
					</li>
					<li>
						<a href="<?php echo base_url().'admin/subject'; ?>"><img src="<?php echo base_url().'style/img/subject.png'; ?>" /> Subjek</a>
					</li>
					<li>
						<a href="<?php echo base_url().'admin/journal'; ?>"><img src="<?php echo base_url().'style/img/journal.png'; ?>" /> Jurnal</a>
					</li>
					<li>
						<a href="<?php echo base_url().'admin/paper'; ?>"><img src="<?php echo base_url().'style/img/paper.png'; ?>" /> Karya Ilmiah</a>
					</li>
					<li>
						<a href="<?php echo base_url().'admin/user'; ?>"><img src="<?php echo base_url().'style/img/user_red.png'; ?>" /> User</a>
						<ul>
							<li>
								<a href="<?php echo base_url().'admin/user_type/D'; ?>">Daftar Dosen</a>
							</li>
							<li>
								<a href="<?php echo base_url().'admin/user_type/M'; ?>">Daftar Mahasiswa</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="#"><img src="<?php echo base_url().'style/img/admin.png'; ?>" />Administrator</a>
						<ul>
							<li>
								<a href="<?php echo base_url().'admin/site_info'; ?>">Manajemen Info</a>
							</li>
							<li>
								<a href="<?php echo base_url().'admin/profile'; ?>">Profil Admin</a>
							</li>
							<li>
								<a href="<?php echo base_url().'admin/password'; ?>">Ganti Password</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="#"><img src="<?php echo base_url().'style/img/message.png'; ?>" /> Pesan</a>
						<ul>
							<li>
								<a href="<?php echo base_url().'admin/message_list'; ?>">Daftar Pesan</a>
							</li>
							<li>
								<a href="<?php echo base_url().'admin/message'; ?>">Kirim Pesan</a>
							</li>
							<li>
								<a href="<?php echo base_url().'admin/inbox'; ?>">Pesan Masuk</a>
							</li>
							<li>
								<a href="<?php echo base_url().'admin/outbox'; ?>">Pesan Keluar</a>
							</li>
						</ul>
					</li>
					<li class="secondary">
						<a href="<?php echo base_url().'logout'; ?>"><img src="<?php echo base_url().'style/img/logout.png'; ?>" />Logout</a>
					</li>
				</ul>