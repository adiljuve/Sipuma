			<div class="block">
				<?php $paper_review = $this->Sipuma_model->paper_review($paper_requested->paper_id); ?>
				<?php if($paper_review): ?>	
				<h5>Review</h5>
				<div class="first article">
					<?php foreach($paper_review as $review): ?>							
						<p class="meta"><b><i><?php echo $review->full_name; ?>, <?php echo $review->review_date; ?></i></b>  <?php if($review->user_id == $this->session->userdata('user_id')): ?><a href="#" onClick="confirmation('<?php echo base_url().'mahasiswa/review_delete/'.$review->review_id; ?>')">[Hapus]</a><?php endif; ?></p>
						<p><?php echo $review->review_message; ?></p>
						<?php if($review->review_status == '0'): ?>
						<p><b>Hasil Review: Direvisi</b></p>
						<?php elseif($review->review_status == '1'): ?>
						<p><b>Hasil Review: Ditolak</b></p>
						<?php elseif($review->review_status == '2'): ?>
						<p><b>Hasil Review: Diterima</b></p>
						<?php endif; ?>
						<hr />
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
				<div class="block" id="forms">
				<?php if($paper_requested): ?>
					<form name="paper" id="paper" action="" method="post" enctype="multipart/form-data">
						<fieldset>
							<input name="paper_id"  id="paper_id" type="hidden" value="<?php echo $this->uri->segment(3); ?>">
							<p>
								<label>Judul: (*)</label>
								<?php echo form_error('title','<br /><label><font color="red"><b>','</b></font></label>'); ?>
								<input type="text" name="title" id="title" value="<?php echo $paper_requested->title; ?>" />
							</p>
							<p class="both">
								<label>Jurnal:</label><br/>
								<?php if($journal_paper): ?>
										<input type="text" name="journal_id" id="journal_id" value="<?php echo $journal_paper->journal_name; ?>" disabled />
										<input type="hidden" name="path" id="path" value="<?php echo $journal_paper->path; ?>" />
								<?php endif; ?>
							</p>
							<p>
								<label>Penulis Terdaftar</label>
								<input type="text" name="author" id="author" />
								<script type="text/javascript">
								$(document).ready(function() {
									$("#author").tokenInput("<?php echo base_url().'mahasiswa/author_edit'; ?>", {
									prePopulate: <?php echo $partner_paper; ?>,
									theme: "facebook",
									preventDuplicates: true,                
									hintText: "Tambah Penulis Yang Terdaftar",
									noResultsText: "Tidak Ditemukan",
									searchingText: "Mencari...",
									//tokenLimit: 3,
									resultsFormatter: function(item){ return "<li>" + item.name + " (" + item.id +")</li>" },
									tokenFormatter: function(item) { return "<li><p>" + item.name + "</p></li>" }
									});
								});
								</script>
								<label>Penulis Tidak Terdaftar</label>
								<input type="text" name="free_author" id="free_author" />
								<script type="text/javascript">
								$(document).ready(function() {
									$("#free_author").tokenInput("<?php echo base_url().'mahasiswa/free_author'; ?>", {
									prePopulate: <?php echo $free_partner_paper; ?>,
									theme: "facebook",
									preventDuplicates: true,                
									hintText: "Tambah Penulis Yang Tidak Terdaftar",
									noResultsText: "Tidak Ditemukan",
									searchingText: "Mencari...",
									//tokenLimit: 3,
									resultsFormatter: function(item){ return "<li>" + item.name + " (" + item.token +")</li>" },
									tokenFormatter: function(item) { return "<li><p>" + item.name + "</p></li>" }
									});
								});
								</script>
							</p>
							<p>
								<label>Abstraksi: (*)</label><br/>
								<?php echo form_error('abstraction','<label><font color="red"><b>','</b></font></label><br />'); ?>
								<textarea cols="43" rows="10" name="abstraction" id="abstraction"><?php echo $paper_requested->abstraction; ?></textarea>
							</p>
							<p>
								<label>Ubah File Lampiran(.pdf): (*)</label>
								<?php echo form_error('file','<br /><label><font color="red"><b>','</b></font></label>'); ?>
								<input type="file" name="file" id="file" />
								<?php if($paper_requested->file_name != ''): ?>
									<img src="<?php echo base_url().'style/img/pdf_document.png'; ?>" /> <a href="<?php echo base_url().'mahasiswa/file/'.$paper_requested->paper_id; ?>" onclick="$(this).modal({width:900, height:500}).open(); return false;"><?php echo $paper_requested->file_name; ?></a>
								<?php endif; ?>
									<input type="hidden" name="file_exist" id="file_exist" value="<?php echo $paper_requested->file_name; ?>" />
							</p>
							<h5>File Lama:</h5>
							<?php $file_revision = $this->Sipuma_model->file_revision($paper_requested->paper_id); ?>
							<ul class="file">
							<?php if($file_revision != ''): ?>
								<?php foreach($file_revision as $file): ?>
								<li><a href="<?php echo base_url().'file/revision/'.$file->file_id; ?>" onclick="$(this).modal({width:900, height:500}).open(); return false;"><?php echo $file->file_name; ?></a></li>
								<?php endforeach; ?>
							<?php else: ?>
								<li>-</li>
							<?php endif; ?>	
							</ul>
							<p>
								<label>Keterangan(*): Wajib diisi</label>
							</p>
							<input type="submit" value="Revisi" />
							<input type="reset" value="Batal" />
							<a href="javascript:history.go(-1)">[Kembali]</a>
						</fieldset>
					</form>
				</div>
				<?php else: ?>
					<?php redirect(base_url().'mahasiswa/paper_list'); ?>
				<?php endif; ?>
			</div>
			