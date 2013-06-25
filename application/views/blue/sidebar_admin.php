				<div class="box">
					<h2><a href="#" id="toggle-list-items">Data Statistik</a></h2>
					<div class="block" id="list-items">
						<p>Total Jurnal: <a href="<?php echo base_url().'admin/journal'; ?>"><?php echo $journal_stats; ?></a></p>
						<p>Total User: <a href="<?php echo base_url().'admin/user'; ?>"><?php echo $user_stats; ?></a></p>
						<p>Total Publikasi: <a href="<?php echo base_url().'admin'; ?>"><?php echo $paper_stats; ?></a></p>
						<p>Total Review: <?php echo $review_stats; ?></p>
						<p>User Publikasi Terbanyak: <?php if($user_max_paper):?><a href="<?php echo base_url().'admin/user_detail/'.$user_max_paper->id_user; ?>"><?php echo $user_max_paper->nama_lengkap; ?> (<?php echo $user_max_paper->jumlah_paper; ?>)</a><?php else: ?>-<?php endif; ?></p>
						<p>Jurnal Publikasi Terbanyak: <?php if($journal_max_paper):?><a href="<?php echo base_url().'admin/journal_detail/'.$journal_max_paper->direktori; ?>"><?php echo $journal_max_paper->nama_jurnal; ?> (<?php echo $journal_max_paper->jumlah_publikasi; ?>)</a><?php else: ?>-<?php endif; ?></p>
					</div>
				</div>
				<?php $inbox_count = $this->Sipuma_model->inbox_count($this->session->userdata('user_id')); ?>
				<?php $user_inactive_count = $this->Sipuma_model->user_inactive_count(); ?>
				<?php if(($inbox_count != 0) || ($user_inactive_count != 0)): ?>
				<div class="box">
					<h2>
						<a href="#" id="toggle-paragraphs">Notifikasi</a>
					</h2>
					<div class="block" id="paragraphs">
						<?php if($inbox_count != 0): ?>
						<p><img src="<?php echo base_url().'style/img/message.png'; ?>" /> Ada <a href="<?php echo base_url().'admin/inbox_unread'; ?>"><?php echo $inbox_count; ?> pesan masuk</a> yang belum dibaca</p>
						<?php endif; ?>
						<?php if($user_inactive_count != 0): ?>
						<p><img src="<?php echo base_url().'style/img/user_red.png'; ?>" /> Ada <a href="<?php echo base_url().'admin/user_inactive'; ?>"><?php echo $user_inactive_count; ?> user</a> dengan status belum/tidak aktif</p>
						<?php endif; ?>
						
					</div>
				</div>
				<?php endif; ?>