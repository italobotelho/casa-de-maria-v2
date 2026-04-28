$(function(){
	$('#clinica').submit(function(){
		var er = new RegExp(/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]{2,}\.[A-Za-z0-9]{2,}(\.[A-Za-z0-9])?/);
		var email_aten = $('#email_aten_clin').val();
        var email_resp = $('#email_resp_clin').val();

		if( email_aten == '' || !er.test(email_aten) ) { alert('Preencha o campo email corretamente'); return false; }
        if( email_resp == '' || !er.test(email_resp) ) { alert('Preencha o campo email corretamente'); return false; }

		// Se passou por essas validações exibe um alert
		alert( 'formulário enviado com sucesso!' );
	});
});