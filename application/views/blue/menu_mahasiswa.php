				<ul class="nav main">
					<li>
						<a href="<?php echo base_url().'mahasiswa'; ?>"><img src="<?php echo base_url().'style/img/home.png'; ?>" /> Home</a>
					</li>
					<li>
						<a href="<?php echo base_url().'mahasiswa/journal'; ?>"><img src="<?php echo base_url().'style/img/journal.png'; ?>" /> Jurnal</a>
					</li>
					<li>
						<a href="#"><img src="<?php echo base_url().'style/img/paper.png'; ?>" /> Karya Ilmiah</a>
						<ul>
							<li>
								<a href="<?php echo base_url().'mahasiswa/paper_list'; ?>">Daftar Karya Ilmiah</a>
							</li>
							<li>
								<a href="<?php echo base_url().'mahasiswa/paper_add'; ?>">Tambah Karya Ilmiah</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="#"><img src="<?php echo base_url().'style/img/user_red.png'; ?>" /> Profil</a>
						<ul>
							<li>
								<a href="<?php echo base_url().'mahasiswa/profile'; ?>">Edit Profil</a>
							</li>
							<li>
								<a href="<?php echo base_url().'mahasiswa/password'; ?>">Ganti Password</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="#"><img src="<?php echo base_url().'style/img/message.png'; ?>" /> Pesan</a>
						<ul>
							<li>
								<a href="<?php echo base_url().'mahasiswa/message'; ?>">Kirim Pesan</a>
							</li>
							<li>
								<a href="<?php echo base_url().'mahasiswa/inbox'; ?>">Pesan Masuk</a>
							</li>
							<li>
								<a href="<?php echo base_url().'mahasiswa/outbox'; ?>">Pesan Keluar</a>
							</li>
						</ul>
					</li>
					<li class="secondary">
						<a href="<?php echo base_url().'logout'; ?>"><img src="<?php echo base_url().'style/img/logout.png'; ?>" /> Logout</a>
					</li>
				</ul>