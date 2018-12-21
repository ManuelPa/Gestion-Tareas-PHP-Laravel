function cambiarTam(id_tab, tam){
	//Obtenemos el elemento al que vamos a cambiar los parámetros. 
	//El [0] es para obtener el objeto HTML desde el objeto que devuelve jQuery.
	var tab = $('#tab'+id_tab)[0];
	if (tam == 1) {
		$(tab).height(400);
		$(tab).removeClass();
		$(tab).addClass( "tab" );
		$(tab).addClass( "col-md-4");
	}
	if (tam == 2) {
		$(tab).height(400);
		$(tab).removeClass();
		$(tab).addClass( "tab" );
		$(tab).addClass( "col-md-6");
	}
	if (tam == 3) {
		$(tab).height(600);
		$(tab).removeClass();
		$(tab).addClass( "tab" );
		$(tab).addClass( "col-md-12");
	}
	$.ajax({
			data: { size: tam , id_ventana : id_tab},
			url:   'setHW',
			type:  'GET'
	});
}

//Reconocimiento de voz.
var recognition;
var recognizing = false;
var id_tab_new = '';
if (!('webkitSpeechRecognition' in window)) {
	console.log('Reconocimiento de voz no es compatible con el navegador.');
} else {
	recognition = new webkitSpeechRecognition();
	recognition.lang = "es-VE";
	recognition.continuous = true;
	recognition.interimResults = true;

	recognition.onstart = function() {
		recognizing = true;
		console.log("empezando a escuchar");
	}

	recognition.onresult = function(event) {

		for (var i = event.resultIndex; i < event.results.length; i++) {
			if(event.results[i].isFinal)
				document.getElementById("tasktextnew"+id_tab_new).value += event.results[i][0].transcript;
		}
	}

	recognition.onerror = function(event) {
	}
	recognition.onend = function() {
		recognizing = false;
		document.getElementById("procesar" + id_tab_new).innerHTML = "<img height='20' width='20' src='http://localhost/ProyectoLaravel/public/css/audio.png'>";
		console.log("terminó de escuchar, llegó a su fin");
	}

}

function procesar(id_tab) {
	if (!('webkitSpeechRecognition' in window)) {
		console.log('Reconocimiento de voz no es compatible con el navegador.');
	}else{
		if (recognizing == false) {
			recognition.start();
			recognizing = true;
			id_tab_new = id_tab;
			document.getElementById("procesar" + id_tab).innerHTML = "<img height='20' width='20' src='http://localhost/ProyectoLaravel/public/css/mute.png'>";
		} else {
			recognition.stop();
			recognizing = false;
			document.getElementById("procesar" + id_tab).innerHTML = "<img height='20' width='20' src='http://localhost/ProyectoLaravel/public/css/audio.png'>";
		}
	}
}

function setCheck(id_task){
	$.ajax({
		data: { id: id_task},
		url:   'setCheck',
		type:  'GET'
	});
}

function setTexto(id_task){
	var texto = $('#tasktext'+id_task).val();
	$.ajax({
		data: { text: texto, id: id_task},
		url:   'setText',
		type:  'GET'
	});
}

function setTextotab(id_tab){
	var texto = $('#tabtext'+id_tab).val();

	$.ajax({
		data: { text: texto, id: id_tab},
		url:   'setTextTab',
		type:  'GET'
	});
}

function eliminartask(id_task, num){
	if (num == 1) {
		var task = document.getElementById("taskcompletada"+id_task);
	}else{
		var task = document.getElementById("tasksincompletar"+id_task);
	}
	task.remove();

	$.ajax({
		headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    	},
		data: { id: id_task},
		url:   'deletetask',
		type:  'POST'
	});
}

function cambiacolor(color, id_tab){
	$.ajax({
		data: { color: color, id_tab: id_tab},
		url:   'setColor',
		type:  'GET'
	});

	var tab = document.getElementById('tab'+id_tab);
	tab.removeAttribute('style');
	tab.setAttribute('style', 'background-color: '+ color +'; height: 662px');
}

function setUncheckCompletado(id_task, id_tab, texto){
	setCheck(id_task);

	var task_unckeck = document.getElementById("taskcompletada" + id_task);
	task_unckeck.remove();

	var listapadre = document.getElementById('milista'+id_tab);

	var li = document.createElement('li');
	li.setAttribute('class', 'col-md-12 ui-sortable-handle');
	li.setAttribute('id', 'tasksincompletar'+id_task);

	var checkbox = document.createElement('input');
	checkbox.setAttribute('type', 'checkbox');
	checkbox.setAttribute('name', 'taskcheck' + id_task);
	checkbox.setAttribute('id', 'taskcheck' + id_task);
	checkbox.setAttribute("onclick", "setCheckCompletado('"+ id_task +"', '"+ id_tab +"', '"+ texto +"')");
	li.appendChild(checkbox);

	var text = document.createElement('input');
	text.setAttribute('type', 'text');
	text.setAttribute('class', 'inputask');
	text.setAttribute('onkeyup', 'setTexto('+ id_task +')');
	text.setAttribute('name', 'tasktext' + id_task);
	text.setAttribute('id', 'tasktext' + id_task);
	text.setAttribute('value', texto);
	li.appendChild(text);

	var button = document.createElement("button");
	button.setAttribute('class', 'btn btn-link');
	button.setAttribute('onclick', 'eliminartask("'+ id_task +'", "0")');
	li.appendChild(button);

	var img = document.createElement('img');
	img.setAttribute('width', '20');
	img.setAttribute('src', document.URL + '/css/eliminar.png');
	button.appendChild(img);

	listapadre.insertBefore(li, listapadre.firstChild);
}

function setCheckCompletado(id_task, id_tab, texto){
	setCheck(id_task);

	var litask = document.getElementById("tasksincompletar" + id_task);
	litask.remove();

	var ol = document.getElementById('listacompletada' + id_tab);
                                            
	var li = document.createElement("li");
	li.setAttribute("id", "taskcompletada" + id_task);
	li.setAttribute("style", "list-style:none; text-align: left;");

	var text = document.createElement("p");
	text.setAttribute('style', 'margin-bottom: 3%');

	var input = document.createElement("input");
	input.setAttribute("type", "checkbox");
	input.setAttribute("name", "taskcheck" + id_task);
	input.setAttribute("id", "taskcheck" + id_task);
	input.setAttribute("checked", "checked");
	input.setAttribute("onclick", "setUncheckCompletado('"+ id_task +"', '"+ id_tab +"', '"+ texto +"')");
	
	text.appendChild(input);   

	var del = document.createElement("del");
	var textnode = document.createTextNode(texto);
	
	del.appendChild(textnode);
	text.appendChild(del);

	var button = document.createElement("button");
	button.setAttribute('style', 'float: right');
	button.setAttribute('class', 'btn btn-link');
	button.setAttribute('onclick', 'eliminartask("'+ id_task +'", "0")');

	var img = document.createElement('img');
	img.setAttribute('width', '20');
	img.setAttribute('src', document.URL + '/css/eliminar.png');
	
	button.appendChild(img);
	text.appendChild(button);
	li.appendChild(text);  
	ol.appendChild(li);

}

function buscar(texto, ventanas){
	var vents = ventanas.split(",");

	var input, filter, ul, li, a, i, txtValue;
		input = document.getElementById("search");
		filter = input.value.toUpperCase();
		ul = document.getElementById("listageneral");

	vents.forEach(function(element) {
		li = ul.getElementsByTagName("li");
		    for (i = 0; i < li.length; i++) {
		        a = li[i].getElementsByTagName("a")[0];
		        txtValue = a.textContent || a.innerText;
		        if (txtValue.toUpperCase().indexOf(filter) > -1) {
		            li[i].style.display = "";
		        } else {
		            li[i].style.display = "none";
		        }
		    }
	});
}