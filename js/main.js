//webshims.polyfill('forms forms-ext');
//webshims.polyfill('forms');

$(function() {

	function html_select_paises() {
		var html = '';
		var paises = ciudades.damePaises();
		for (codigo in paises) {
			html += '<option value="'+codigo+'">'+paises[codigo]+'</option>'+"\n";
		}
		return html;
	}

	function html_select_provincias() {
		var html = '<option value="NC">OTRA</option>'+"\n";
		var provincias = ciudades.dameProvincias();
		for (i=0; i<provincias.length; i++) {
			html += '<option value="'+(i+1)+'">'+provincias[i]+'</option>'+"\n";
		}
		return html;
	}

	function html_select_ciudades(idProvincia) {
		var html = '<option value="NC">NC</option>'
		  , pueblos = ciudades.dameCiudades(idProvincia);
		for (var i=0; i<pueblos.length; i++) {
			html += '<option value="'+pueblos[i].id+'">'+pueblos[i].nombre+'</option>'+"\n";
		}
		return html;
	}

	function html_select_barrios() {
		var html = '<option value="NC">NC</option>'
		  , barrios = ciudades.dameBarrios();
		for (var i=0; i<barrios.length; i++) {
			html += '<option value="'+(i+1)+'">'+barrios[i]+'</option>'+"\n";
		}
		return html;
	}

	$('#select_provincia').on('change', function () {
		var idProvincia = $(this).val()
		  , provincia = $(this).find(':selected').text();
		$('#select_ciudad').html(html_select_ciudades(idProvincia));	
		$('#provincia').val(provincia);
		if (idProvincia == "NC") { //Extranjero
			$('#grupo_pais').show();
			$('#grupo_ciudad').hide();
			$('#select_ciudad').val("NC").trigger('change');
		} else {
			$('#grupo_pais').hide();
			$('#grupo_ciudad').show();
			//$('#select_ciudad').val("5025").trigger('change');
		}
	});
	$('#select_pais').on('change', function () {
		$('#pais').val($(this).val());		
	});
	$('#select_ciudad').on('change', function () {
		var idCiudad = $(this).val()
		  , ciudad = $(this).find(':selected').text();
		$('#ciudad').val(ciudad);
		if (idCiudad == "5025") {
			$('#grupo_barrio').show();
		} else {
			$('#grupo_barrio').hide();
			$('#select_barrio').val("NC").trigger('change');
		}		
	});
	$('#select_barrio').on('change', function () {
		$('#barrio').val($(this).find(':selected').text());		
	});
	$('#checkbox_visible').on('change', function () {
		if ($(this).is(':checked')) {
			$('#visible').val("1");
		} else {
			$('#visible').val("0");
		}
	});
	$('#checkbox_boletin').on('change', function () {
		if ($(this).is(':checked')) {
			$('#boletin').val("1");
		} else {
			$('#boletin').val("0");
		}
	});

	$('#select_pais').html(html_select_paises());
	$('#select_provincia').html(html_select_provincias());
	$('#select_barrio').html(html_select_barrios());

	// Valores iniciales
	$('#select_pais').val("ES").trigger('change');
	$('#select_provincia').val("9").trigger('change');
	$('#select_ciudad').val("5025").trigger('change');

	$('#nuevo').on('submit', function(e) {
		var dni = $('#dni').val().toUpperCase()
		  , ciudad = $('#ciudad').val();
		//if (ciudad == "NC") ciudad = $('#pais').val();
		$('#dni').val(dni);
		//$('#ciudad').val(ciudad);
	});

	$('.ok').each(function (indice,el) {
		alertify.success($(el).html());
	});
	$('.error').each(function (indice,el) {
		alertify.error($(el).html());
	});
	$('.aviso').each(function (indice,el) {
		alertify.set({ labels: {
			ok     : "Últimos apoyos",
			cancel : "Volver"
		} });
		/*alertify.confirm($(el).html(), function (e) {
			if (e) {
				// user clicked "ok"
				window.location.href='index.php';
			} 
		});*/
		alertify.alert($(el).html(), function() { window.location.href='index.php'; });
	});

	$('.codigo_pais').each(function (indice,el) {
		$(el).text(ciudades.damePais($(el).text()));
	});
});
