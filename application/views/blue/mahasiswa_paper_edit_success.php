				<div class="block">
					<?php if($paper_detail_edit): ?>	
					<h4><?php echo $paper_detail_edit->title; ?></h4>
					<div class="block">
						<ul>
							<li>
								<?php if($journal_paper): ?>
									<i><b>Jurnal:</b> <a href="<?php echo base_url().'mahasiswa/journal_detail/'.$journal_paper->path; ?>"><?php echo $journal_paper->journal_name; ?></a></i>
								<?php else: ?>
									<i><b>Jurnal:</b> -</i>
								<?php endif; ?>
							</li>
							<li>								
								<?php if($paper_detail_author): ?>
									<?php foreach($paper_detail_author as $author): ?>
									<?php $list[] = '<a href="'.base_url().'mahasiswa/user_detail/'.$author->user_id.'">'.$author->full_name.' ('.$author->user_id.')</a>'; ?>
									<?php endforeach; ?>	
								<?php endif; ?>
								<i><b>Penulis:</b> <?php echo implode(", ",$list); ?>
								<?php if($free_user_paper): ?>
									<?php foreach($free_user_paper as $free_user): ?>
									<?php echo ', '.$free_user->full_name; ?>	
									<?php endforeach; ?>
								<?php endif; ?>								
								</i>
							</li>
							<li>
								<i><b>Tanggal Pengajuan:</b> <?php echo tgl_indo($paper_detail_edit->date_created); ?></i>
							</li>							
							<li>
								<i><b>Jumlah Revisi:</b> <?php echo $paper_detail_edit->revision_count; ?></i>
							</li>
							<?php if($paper_detail_edit->revision_count > 0): ?>
							<li>
								<i><b>Revisi Terakhir:</b> <?php echo tgl_indo($paper_detail_edit->latest_revision); ?></i>
							</li>
							<?php endif; ?>
						</ul>
						<h5>Abstraksi:</h5>
						<?php if($paper_detail_edit->abstraction != ''): ?>
						<?php echo $paper_detail_edit->abstraction; ?>
						<?php else: ?>
						-
						<?php endif; ?>
						<h5>File Terkait:</h5>
						<ul class="file">
						<?php if($paper_detail_edit->file_name != ''): ?>
							<li><a href="<?php echo base_url().'mahasiswa/file/'.$paper_detail_edit->paper_id; ?>" onclick="$(this).modal({width:900, height:500}).open(); return false;"><?php echo $paper_detail_edit->file_name; ?></a></li>
						<?php else: ?>
							<li>-</li>
						<?php endif; ?>
						</ul>
					</div>
					<div class="block" id="forms">
						<form name="paper" id="paper" action="" method="post" enctype="multipart/form-data">
							<fieldset>
								<p><font color="red"><b>Perubahan Karya Ilmiah Berhasil</b></font></p>
								<input name="paper_id"  id="paper_id" type="hidden" value="<?php echo $this->uri->segment(3); ?>">
								<p>
									<label>Judul: (*)</label>
									<?php echo form_error('title','<br /><label><font color="red"><b>','</b></font></label>'); ?>
									<input type="text" name="title" id="title" maxlength="100" value="<?php echo $paper_detail_edit->title; ?>" onBlur="white_space(title)" />
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
										resultsFormatter: function(item){ return "<li>" + item.name + " (" + item.token +")</li>" },
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
									<textarea cols="50" rows="10" name="abstraction" id="abstraction"><?php echo $paper_detail_edit->abstraction; ?></textarea>
								</p>
								<p>
									<label>Ubah File Lampiran(.pdf):</label>
									<?php echo form_error('file','<br /><label><font color="red"><b>','</b></font></label>'); ?>
									<input type="file" name="file" id="file" />	
								<?php if($paper_detail_edit->file_name != ''): ?>
									<img src="<?php echo base_url().'style/img/pdf_document.png'; ?>" /> <a href="<?php echo base_url().'mahasiswa/file/'.$paper_detail_edit->paper_id; ?>" onclick="$(this).modal({width:900, height:500}).open(); return false;"><?php echo $paper_detail_edit->file_name; ?></a>
								<?php endif; ?>
									<input type="hidden" name="file_exist" id="file_exist" value="<?php echo $paper_detail_edit->file_name; ?>" />
								</p>
								<p>
									<label>Keterangan(*): Wajib diisi</label>
								</p>
								<input type="submit" value="Edit" />
								<input type="reset" value="Batal" />
								<a href="javascript:history.go(-1)">[Kembali]</a>
							</fieldset>
						</form>
					</div>
					<?php else: ?>
						<?php redirect(base_url()); ?>
					<?php endif; ?>
				</div>
