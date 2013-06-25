					<div class="block">	
						<h5>Form Kirim Pesan</h5>
					</div>
					<div class="block" id="forms"> 
						<form name="message" id="message" action="" method="post" onSubmit="return message_check(message)">
							<fieldset>
								<p>
									<label>Tujuan: (*) pilih minimal 1 tujuan pesan</label>
									<?php echo form_error('recipient','<br /><label><font color="red"><b>','</b></font></label>'); ?>
									<input type="text" name="recipient" id="recipient" />
									<script type="text/javascript">
									$(document).ready(function() {
										$("#recipient").tokenInput("<?php echo base_url().'admin/contact'; ?>", {
										theme: "facebook",
										preventDuplicates: true,                
										hintText: "Pilih Tujuan",
										noResultsText: "Tidak Ditemukan",
										searchingText: "Mencari...",
										tokenLimit: 3,
										resultsFormatter: function(item){ return "<li>" + item.name + " (" + item.id +")</li>" },
										tokenFormatter: function(item) { return "<li><p>" + item.name + "</p></li>" }
										});
									});
									</script>
								</p>
								<p>
									<label>Subjek: (*)</label>
									<?php echo form_error('subject','<br /><label><font color="red"><b>','</b></font></label>'); ?>
									<input type="text" name="subject" id="subject" maxlength="25" onBlur="white_space(subject)" />
								</p>
								<p>
									<label>Pesan: (*)</label><br/>
									<?php echo form_error('message_text','<label><font color="red"><b>','</b></font></label><br />'); ?>
									<textarea cols="40" rows="10" maxlength="255" name="message_text" id="message_text" OnFocus="Count();" OnClick="Count();" onKeydown="Count();" OnChange="Count();" onKeyup="Count();"></textarea>
								</p>
								<p>
									<input name="counter" type="text" class="text-small" value="255" disabled/>
								</p>
								<p>
									<label>Keterangan(*): Wajib diisi</label>
								</p>
								<input type="submit" value="Kirim Pesan" onClick="white_space(message_text);" />
								<input type="reset" value="Batal" />
							</fieldset>
						</form>
					</div>