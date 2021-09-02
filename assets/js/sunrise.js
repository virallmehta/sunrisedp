(function ($) {
  Drupal.behaviors.sunrise = {
    attach: function (context, settings) {
    	

		if($('.typeList').length > 0) {
			myFunction(myArray);

			/* Selecting a particular catagory of service.*/
			var i = 0,t;
			$(".typeList li a").click(function() {
				var e = $(this).attr("href");
				$('.typeList li').removeClass("active");
				$(this).parent().addClass("active");
				var i = e.replace("#", "");
				$(".styleList li.mainList").fadeOut(), $(".styleList li." + i).fadeIn(450);
			});


        //AJAX Form
        // Get the form.
        var form = $('#booknow');

        // Get the messages div.
        var formMessages = $('#form-messages');
        //alert($(form).prop('action'));
        //alert($(location).attr('href'));
        var root = location.protocol + '//' + location.host;
        //alert("root : " + root);


        // Set up an event listener for the contact form.
        $('#booknow .btn').click(function(e) {
          // Stop the browser from submitting the form.
          e.preventDefault();

          // Serialize the form data.
          var formData = $(form).serialize();
          //alert($(form).attr('action'));
          // Submit the form using AJAX.

          $.ajax({
            type: 'POST',
            url: root + '/process.php', //$(form).prop('action'), //'http://missbeautiful.co.in/process.php', //$(form).attr('action'),
            data: formData
          })
          .done(function(response) {
            // Make sure that the formMessages div has the 'success' class.
            $(formMessages).removeClass('error error-message');
            $(formMessages).addClass('success-message');

            // Set the message text.
            $(formMessages).text(response);

            // Clear the form.
            $('#txtfname').val('');
            $('#txtlname').val('');
            $('#txtemail').val('');
            $('#txtmobile').val('');
            $('#txtaddress1').val('');
            $('#txtaddress2').val('');
            $('#txtpin').val('');
            $('#txtdate').val('');
            $('#txttime').val('');
            $('.viewservice').text('');
            $('#styleList1').text('');
            myFunction(myArray);

          })
          .fail(function(data) {
            // Make sure that the formMessages div has the 'error' class.
            $(formMessages).removeClass('success');
            $(formMessages).addClass('error');

            // Set the message text.
            if (data.responseText !== '') {
              $(formMessages).text(data.responseText);
            } else {
              $(formMessages).text('Oops! An error occured and your message could not be sent.');
            }
          });

        });


		}


		/* Step 1 : Load all the services , Hide all accept th active class service */
		function myFunction(e) {
		    var i,t = "";
		    for (i = 0; i < e.length; i++){
				if(e[i].Category == "Packages"){
					t += '<li id="service'+i+'" class="mainList service'+i+' ' + e[i].Category + ' ' + e[i].Category + '-' + e[i].Service + '" style="    display: list-item;"><h2 id="' + e[i].Category + '|' + e[i].Service + '">' + e[i].Service + '</h2><p>' + e[i].Discription + '</p><ul class="servicePrice"><li>' + e[i].NonMember + '</li></ul></li>';		
				}
				else{
					t += '<li id="service'+i+'" class="mainList service'+i+' ' + e[i].Category + ' ' + e[i].Category + '-' + e[i].Service + '" style="    display: none;"><h2 id="' + e[i].Category + '|' + e[i].Service + '">' + e[i].Service + '</h2><ul class="servicePrice"><li>' + e[i].NonMember + '</li></ul></li>';
				}
			}
			$(".styleList").append(t);
		}

		/* 
			Check weather the service is already selected ,if not select Service and drop it into the main area,
		*/
		$(document).on("click", ".styleList li.mainList", function(){	
			if ($(this).hasClass("checked") ) {
				$("#error").html("Service already Selected.");
			}
			else{
				$("#error").html("");
				var e = $(this).html();
				$(this).addClass('checked');
				var t = $("h2", this).attr("id");
				var serviceId = $(this).attr("id");
				var l = '<input type="checkbox" value="' + t + '" name="chk[]" class="type" checked>';
				var i = '<li class="selectedList" id="Selected'+serviceId+'">' + e + '<a class="close">X</a>'+l+'</li>';
				$(".viewservice").append(i);
				console.log('append');
				$('#count span').html($('.viewservice li.selectedList').length);
			}
		});

		$(document).on("click", ".close", function() {
		    $(this).parent().remove();
		    var t = $(this).parent().attr("id");
			var newString = t.substr(8);
			console.log(newString);
			$('#count span').html($('.viewservice li.selectedList').length);
			$('#'+newString+'').removeClass("checked");	
			
		});

	}
  }
}(jQuery));
