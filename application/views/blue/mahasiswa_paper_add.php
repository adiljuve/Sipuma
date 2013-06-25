					<div class="block">	
						<h5>Tambah Karya Ilmiah</h5>
						<p>Lengkapi form berikut untuk menambahkan karya ilmiah.</p>
					</div>
					<div class="block" id="forms">
						<form name="paper" id="paper" action="" method="post" enctype="multipart/form-data" onSubmit="return paper_check(paper)">
							<fieldset>
								<p>
									<label>Penulis: (Tambahan)</label>
									<input type="text" name="author" id="author" />
									<script type="text/javascript">
									$(document).ready(function() {
										$("#author").tokenInput("<?php echo base_url().'mahasiswa/author'; ?>", {
										theme: "facebook",
										//tokenDelimiter: ",",
										preventDuplicates: true,                
										hintText: "Tambah Penulis",
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
									<label>Judul: (*)</label>
									<?php echo form_error('title','<br /><label><font color="red"><b>','</b></font></label>'); ?>
									<input type="text" name="title" id="title" maxlength="100" onBlur="white_space(title)" />
								</p>
								<p class="both">
									<label>Jurnal: (*)</label>
									<?php echo form_error('journal_id','<br/ ><label><font color="red"><b>','</b></font></label>'); ?>
									<select name="journal_id" id="journal_id">
									<option value="" selected="selected">-- Pilih Jurnal --</option>
									<?php if($journal_member): ?>
										<?php foreach($journal_member as $journal): ?>
											<option value="<?php echo $journal->journal_id; ?>"><?php echo $journal->journal_name; ?></option>
										<?php endforeach; ?>
									<?php endif; ?>
									</select>
								</p>
								<p name="path" id="path">
								</p>
								<p>
									<label>Abstraksi: (*)</label><br/ >
									<?php echo form_error('abstraction','<label><font color="red"><b>','</b></font></label><br />'); ?>
									<textarea cols="50" rows="10" name="abstraction" id="abstraction"></textarea>
								</p>
								<p>
									<label>File Lampiran (.pdf) maksimal 10MB: (*)</label>
									<?php echo form_error('file','<br /><label><font color="red"><b>','</b></font></label>'); ?>
									<input type="file" name="file" id="file" />
								</p>
								<p>
									<label>Keterangan(*): Wajib diisi</label>
								</p>
								<input type="submit" value="Kirim" />
								<input type="reset" value="Batal" />
							</fieldset>
						</form>
					</div>