				<ul class="nav main">
					<li>
						<a href="<?php echo base_url().'dosen'; ?>"><img src="<?php echo base_url().'style/img/home.png'; ?>" /> Home</a>
					</li>
					<li>
						<a href="<?php echo base_url().'dosen/journal'; ?>"><img src="<?php echo base_url().'style/img/journal.png'; ?>" /> Jurnal</a>
					</li>
					<li>
						<a href="#"><img src="<?php echo base_url().'style/img/review.png'; ?>" /> Review</a>
						<ul>
							<li>
								<a href="<?php echo base_url().'dosen/paper_list'; ?>">Daftar Karya Ilmiah</a>
							</li>
							<li>
								<a href="<?php echo base_url().'dosen/review'; ?>">Sejarah Review</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="#"><img src="<?php echo base_url().'style/img/user_red.png'; ?>" /> Profil</a>
						<ul>
							<li>
								<a href="<?php echo base_url().'dosen/profile'; ?>">Edit Profil</a>
							</li>
							<li>
								<a href="<?php echo base_url().'dosen/password'; ?>">Ganti Password</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="#"><img src="<?php echo base_url().'style/img/message.png'; ?>" /> Pesan</a>
						<ul>
							<li>
								<a href="<?php echo base_url().'dosen/message'; ?>">Kirim Pesan</a>
							</li>
							<li>
								<a href="<?php echo base_url().'dosen/inbox'; ?>">Pesan Masuk</a>
							</li>
							<li>
								<a href="<?php echo base_url().'dosen/outbox'; ?>">Pesan Keluar</a>
							</li>
						</ul>
					</li>
					<li class="secondary">
						<a href="<?php echo base_url().'logout'; ?>"><img src="<?php echo base_url().'style/img/logout.png'; ?>" /> Logout</a>
					</li>
				</ul>