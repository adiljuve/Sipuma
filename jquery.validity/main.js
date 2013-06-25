            $(function() { 
                $("#registration").validity(function() {
                    $("#user_type")
                        .require("Harus dipilih");
						
					$("#user_id")
                        .require("Harus diisi")
						.maxLength(25, "Maksimal 25 karakter");
						
					$("#full_name")
						.require("Harus diisi")
						.alphabet("abcdefghijklmnopqrstuvwxyz .,ABCDEFGHIJKLMNOPQRSTUVWXYZ","Hanya terdiri dari Huruf Alfabet")
						.maxLength(50, "Maksimal 50 huruf");
						
					$("#gender")
                        .require("Harus dipilih");
						
					$("#email")
                        .require("Harus diisi")
						.match("email","Alamat Email Harus Valid")
						.maxLength(50, "Maksimal 50 karakter");

					$("#phone_number")
						.match("number","Hanya terdiri dari Angka")
						.maxLength(20, "Maksimal 20 karakter");
						
					$("#website")
                    	.match("url","Alamat Website Harus Valid, diawali 'http://', 'https://', atau 'ftp://'")
						.maxLength(50, "Maksimal 50 karakter");
						
					$("#password")
						.require("Harus diisi")
						.maxLength(50, "Maksimal 50 karakter");
						
					$("#password_confirmation")
						.require("Harus diisi")
						.maxLength(50, "Maksimal 50 karakter");

					$("#verification")
						.require("Harus diisi");
                });
				
				$("#paper").validity(function() {
                    $("#title")
                        .require("Harus diisi")
						.maxLength(100, "Maksimal 100 karakter");
						
					$("#journal_id")
                        .require("Harus dipilih");	

					$("#abstraction")
                        .require("Harus diisi");						
                });

                $("#discussion").validity(function() {
                    $("#comment")
                        .require("Harus diisi")
						.maxLength(255, "Maksimal 255 karakter");						
                });
					
                $("#profile").validity(function() {						
					$("#gender")
                        .require("Harus dipilih");
					
					$("#email")
                        .require("Harus diisi")
						.match("email","Alamat Email Harus Valid")
						.maxLength(50, "Maksimal 50 karakter");
						
					$("#phone_number")
                    	.match("number","Hanya terdiri dari Angka")
						.maxLength(50, "Maksimal 50 karakter");
						
					$("#website")
                    	.match("url","Alamat Website Harus Valid, diawali 'http://', 'https://', atau 'ftp://'")
						.maxLength(50, "Maksimal 50 karakter");
                });

                $("#password").validity(function() {						
					$("#password_old")
						.require("Harus diisi");
						
					$("#password_new")
						.require("Harus diisi");
						
					$("#password_new_confirm")
						.require("Harus diisi");
                });

                $("#message").validity(function() {						
					/*$("#recipient")
						.require("Harus diisi");*/
						
					$("#subject")
						.require("Harus diisi")
						.maxLength(25, "Maksimal 25 karakter");
						
					$("#message_text")
						.require("Harus diisi")
						.maxLength(255, "Maksimal 255 karakter");
                });

                $("#subject").validity(function() {						
					$("#subject_name")
						.require("Harus diisi")
						.maxLength(50, "Maksimal 50 karakter");
                });

                $("#journal").validity(function() {						
					$("#journal_name")
						.require("Harus diisi")
						.maxLength(100, "Maksimal 100 karakter");
						
					//$("#subject_id")
					//	.require("Harus dipilih");
						
					$("#path")
						.require("Harus diisi")
						.alphabet("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-.0123456789","Hanya terdiri dari Huruf dan Angka Tanpa Menggunakan Spasi")
						.maxLength(25, "Maksimal 25 karakter");
                });

                $("#site_info").validity(function() {	
					$("#judul")
						.maxLength(100, "Maksimal 100 karakter");
					
					$("#owner")
						.maxLength(100, "Maksimal 100 karakter");
					
					$("#phone_number")
						.match("number","Hanya terdiri dari Angka")
						.maxLength(50, "Maksimal 50 karakter");
						
					$("#fax")
						.alphabet("number","Hanya terdiri dari Angka")
						.maxLength(50, "Maksimal 50 karakter");
						
					$("#email")
						.match("email","Alamat Email Harus Valid")
						.maxLength(50, "Maksimal 50 karakter");
						
					$("address")
						.maxLength(100, "Maksimal 100 karakter");
                });
            });