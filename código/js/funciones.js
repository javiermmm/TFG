				function creaTabla(){
					$('.container').append('<img id="gif" src="./images/dancer_024.gif" WIDTH="100" HEIGHT="100">');
					timerID = setTimeout(tabla, 1000);
				}

				function tabla(){
					clearTimeout(timerID);
					$.getJSON(url_submission, function(data){
					//$.getJSON("http://acr.programame.com/ws/problem/100/paths", function(data){
						$('#gif').remove();
						var cell = document.getElementById("cont");
						if ( cell.hasChildNodes() )
						{
								while ( cell.childNodes.length >= 1 )
								{
									cell.removeChild( cell.firstChild );
								}
						}
					  
						$.each(data.submission, function(j,x){
							if (j%2 == 0)
								$('#cont').append('<tr class="cuerpo filaPar" id=' + j + ' >  </tr>');
							else
								$('#cont').append('<tr class="cuerpo filaImpar" id=' + j + ' >  </tr>');

							if ( (allCode) || ( myCode && (user  == data.submission[j].user ["nick"]))) {
								$('#'+j+'').append('<td><a href="codigo_enviado.php?cod=' + data.submission[j].num + '&title=' +data.submission[j].problem ["title"] +  '&num=' +data.submission[j].problem ["num"] + '&lang=' +data.submission[j].language +  '">' + data.submission[j].num + '</a></td>');
							}
							else
								$('#'+j+'').append('<td>' +  data.submission[j].num + '</td>');
								
							$('#'+j+'').append('<td><a href="usuario.php?id=' +data.submission[j].user ["id"] + ' ">'+ data.submission[j].user ["nick"] + '</a></td>');
							$('#'+j+'').append('<td><a href="enunciado.php?num=' + data.submission[j].problem ["num"]  + ' ">'+ data.submission[j].problem ["title"] + '</a></td>');
							switch (data.submission[j].result ){
										case "AC":  $('#'+j+'').append('<td class="aceptado">' + data.submission[j].result + '</td>');
													break;
										case "WA":  $('#'+j+'').append('<td class="error">' + data.submission[j].result + '</td>');
													break;
										case "IQ":  $('#'+j+'').append('<td class="encolado">' + data.submission[j].result + '</td>');
													break;
										case "CE":  $('#'+j+'').append('<td class="compilationError">' + data.submission[j].result + '</td>');
													break;
										case "IR":  $('#'+j+'').append('<td class="internalError">' + data.submission[j].result + '</td>');
													break;
										case "TL":  $('#'+j+'').append('<td class="timeLimit">' + data.submission[j].result + '</td>');
													break;
										case "TL":  $('#'+j+'').append('<td class="memoryLimit">' + data.submission[j].result + '</td>');
													break;
										case "RF":  $('#'+j+'').append('<td class="restrictedFunction">' + data.submission[j].result + '</td>');
													break;
										default:	$('#'+j+'').append('<td class="otroEstado">' + data.submission[j].result + '</td>');
													break;
							}
							if (data.submission[j].language == "CPP")
										$('#'+j+'').append('<td>' + "C++" + '</td>');
							else
										$('#'+j+'').append('<td>' + data.submission[j].language + '</td>');
							 if ((data.submission[j].executionTime == undefined))
										$('#'+j+'').append('<td>' + ' --- ' + '</td>');
							else
										$('#'+j+'').append('<td>' + data.submission[j].executionTime + '</td>');
							 if ((data.submission[j].memoryUsed == undefined))
										$('#'+j+'').append('<td>' + ' --- ' + '</td>');
							else
										$('#'+j+'').append('<td>' + data.submission[j].memoryUsed + '</td>');
							if ((data.submission[j].ranking == undefined))
										$('#'+j+'').append('<td>' + ' --- ' + '</td>');
							else
										$('#'+j+'').append('<td>' + data.submission[j].ranking + '</td>');
							var partesfechaIzq = data.submission[j].submissionDate.split('T');
							var partesfechaDer = partesfechaIzq[1].split('+');
							$('#'+j+'').append('<td>' +  partesfechaIzq[0] + ' a las ' + partesfechaDer[0] +'</td>');
						 });
						 timerID = setTimeout(tabla, 3000);
					});
				};
				
				function refrescaTabla(){
					$('.container').append('<img id="gif" src="./images/dancer_024.gif" WIDTH="100" HEIGHT="100">');
					intervalo = setInterval(tablaVol, 600000);
				}

				function tablaVol(){
					$.getJSON(url_volumenes, function(data){
						$('#gif').remove();
						var cell = document.getElementById("cont");
						if ( cell.hasChildNodes() )
						{
								while ( cell.childNodes.length >= 1 )
								{
									cell.removeChild( cell.firstChild );
								}
						}
					  
						$.each(data.volume, function(j,x){
							if (j%2 == 0)
								$('#cont').append('<tr class="cuerpo filaPar" id=' + j + ' >  </tr>');
							else
								$('#cont').append('<tr class="cuerpo filaImpar" id=' + j + ' >  </tr>');
								
							$('#'+j+'').append('<td class="volumeRow"><a href="problemas.php?vol=' + data.volume[j] + ' ">' + data.volume[j] + '</a></td>');
						});
						
						$.getJSON(url_volumenes + "stats", function(data2){	
							$.each(data2.volumeStats, function(j,x){
								//Solo nos quedamos con los numeros de envio de usuarios y de resultados AC
								var totalSubs = data2.volumeStats[j].totalSubs;
								var ac = data2.volumeStats[j].ac;
								var porcentaje1 = ac*100/totalSubs;
								if (ac == 0){
									porcentaje1=0;
									porcentaje2=0;
								}
							
								$('#'+j+'').append('<td><div class="meter-wrap" style="width: auto;"><div class="meter-value" style="background-color: #0a0; width: '+ porcentaje1 +'%;"><div class="meter-text">' + ac + '/' + totalSubs + '</div></div></div></td>');
							});
						});
					});
				};
				
				function refrescaAcertados(){
						$('#container').append('<img id="gif" src="./images/dancer_024.gif" WIDTH="100" HEIGHT="100">');
						intervalo = setInterval(tablaAcer, intervalo);
					}

					function tablaAcer(){
						$.getJSON(url_user+ idUsuario + "/problems/ac", function(data){
							$('#gif').remove();
							var cell = document.getElementById("cont2");
							if ( cell.hasChildNodes() )
							{
									while ( cell.childNodes.length >= 1 )
									{
										cell.removeChild( cell.firstChild );
									}
							}

							$.getJSON(url_user+ idUsuario + "/problems/all", function(data2){
								$('#title_ac').empty();
								$('#title_ac').append('<h2 id="title_ac">Problemas Aceptados (' + data.problem.length + '/' + data2.problem.length + ') </h2>');
							});
							
							if  (data.problem instanceof Array){														
								$.each(data.problem, function(j,x){
		
									if (j%2 == 0)
										$('#cont2').append('<tr class="cuerpo filaPar" id=' + j + ' >  </tr>');
									else
										$('#cont2').append('<tr class="cuerpo filaImpar" id=' + j + ' >  </tr>');
										
									$.each(data, function(i,item){
										$('#'+j+'').append('<td class="volumeRow"><a href="enunciado.php?num=' + data.problem[j] +' ">' + data.problem[j] + '</a></td>');
										$.getJSON("http://acr.programame.com/ws/problem/"+ data.problem[j], function(data2){			
											$('#'+j+'').append('<td><a href="enunciado.php?num=' + data2.num +' ">' + data2.title + '</a></td>');
										});	
										
										//$('#'+j+'').append('<td class="volumeRow"><a href="enunciado.php?num=' + data2.titulo[j] +' ">' + data.problem[j] + '</a></td>');
									});
								 });
							} 
							else{
								$('#cont2').append('<tr class="cuerpo filaPar" id=' + '0' + ' >  </tr>');
								$.each(data, function(i,item){
									$('#'+'0'+'').append('<td class="volumeRow"><a href="enunciado.php?num=' + data.problem +' ">' + data.problem + '</a></td>');
									$.getJSON("http://acr.programame.com/ws/problem/"+ data.problem, function(data2){			
											$('#'+0+'').append('<td><a href="enunciado.php?num=' + data2.num +' ">' + data2.title + '</a></td>');
										});
									//$('#'+j+'').append('<td class="volumeRow"><a href="enunciado.php?num=' + data2.titulo[j] +' ">' + data.problem[j] + '</a></td>');
								});
							}							 
						});
					};

				function tablaEnviosUsuario(timerID2){
					clearTimeout(timerID2);
					$.getJSON(url_user + id + "/submissions", function(data){
						$('#gif').remove();
						var cell = document.getElementById("cont");
						if ( cell.hasChildNodes() )
						{
								while ( cell.childNodes.length >= 1 )
								{
									cell.removeChild( cell.firstChild );
								}
						}
					  
						if ($.isEmptyObject(data)) {
							$('#cont').append('<tr class="cuerpo filaPar" id="0" ><td colspan="9">NO TIENES ENVÍOS </td></tr>');
						} else {
							if  (data.submission instanceof Array){
					  
								$.each(data.submission, function(j,x){
									if (j%2 == 0)
										$('#cont').append('<tr class="cuerpo filaPar" id=' + j + ' >  </tr>');
									else
										$('#cont').append('<tr class="cuerpo filaImpar" id=' + j + ' >  </tr>');

									if ( (allCode) || ( myCode && (user  != NULL))) {
										$('#'+j+'').append('<td><a href="codigo_enviado.php?cod=' + data.submission[j].num + '">' + data.submission[j].num + '</a></td>');
										//$('#'+j+'').append('<td>' +  data.submission[j].num + '</td>');
									}
									else
										$('#'+j+'').append('<td>' +  data.submission[j].num + '</td>');
										
									$('#'+j+'').append('<td><a href="enunciado.php?num=' + data.submission[j].problem.num  /*+ '&title=' + data.submission[j].problem ["title"] */+ ' ">'+ data.submission[j].problem.num + '</a></td>');
									$('#'+j+'').append('<td><a href="enunciado.php?num=' + data.submission[j].problem.num  /*+ '&title=' + data.submission[j].problem ["title"] */+ ' ">'+ data.submission[j].problem.title + '</a></td>');
									
									switch (data.submission[j].result ){
												case "AC":  $('#'+j+'').append('<td class="aceptado">' + data.submission[j].result + '</td>');
															break;
												case "WA":  $('#'+j+'').append('<td class="error">' + data.submission[j].result + '</td>');
															break;
												case "IQ":  $('#'+j+'').append('<td class="encolado">' + data.submission[j].result + '</td>');
															break;
												case "CE":  $('#'+j+'').append('<td class="compilationError">' + data.submission[j].result + '</td>');
															break;
												case "IR":  $('#'+j+'').append('<td class="internalError">' + data.submission[j].result + '</td>');
															break;
												case "TL":  $('#'+j+'').append('<td class="timeLimit">' + data.submission[j].result + '</td>');
															break;
												case "TL":  $('#'+j+'').append('<td class="memoryLimit">' + data.submission[j].result + '</td>');
															break;
												case "RF":  $('#'+j+'').append('<td class="restrictedFunction">' + data.submission[j].result + '</td>');
															break;
												default:	$('#'+j+'').append('<td class="otroEstado">' + data.submission[j].result + '</td>');
															break;
									}
									
									if (data.submission[j].language == "CPP")
												$('#'+j+'').append('<td>' + "C++" + '</td>');
									else
												$('#'+j+'').append('<td>' + data.submission[j].language + '</td>');
									
									if ((data.submission[j].executionTime == undefined))
												$('#'+j+'').append('<td>' + ' --- ' + '</td>');
									else
												$('#'+j+'').append('<td>' + data.submission[j].executionTime + '</td>');
									 if ((data.submission[j].memoryUsed == undefined))
												$('#'+j+'').append('<td>' + ' --- ' + '</td>');
									else
												$('#'+j+'').append('<td>' + data.submission[j].memoryUsed + '</td>');
									if ((data.submission[j].ranking == undefined))
												$('#'+j+'').append('<td>' + ' --- ' + '</td>');
									else
												$('#'+j+'').append('<td>' + data.submission[j].ranking + '</td>'); 
									
									
									var partesfechaIzq = data.submission[j].submissionDate.split('T');
									var partesfechaDer = partesfechaIzq[1].split('+');
									$('#'+j+'').append('<td>' +  partesfechaIzq[0] + ' a las ' + partesfechaDer[0] +'</td>');
								 });
							}
						else {
							$('#cont').append('<tr class="cuerpo filaPar" id="0" >  </tr>');

							if ( (allCode) || ( myCode && (user  != NULL))) {
								$('#0').append('<td><a href="codigo_enviado.php?cod=' + data.submission.num + '">' + data.submission.num + '</a></td>');
								//$('#'+j+'').append('<td>' +  data.submission.num + '</td>');
							}
							else
								$('#0').append('<td>' +  data.submission.num + '</td>');
								
							$('#0').append('<td><a href="enunciado.php?num=' + data.submission.problem.num  /*+ '&title=' + data.submission.problem ["title"] */+ ' ">'+ data.submission.problem.num + '</a></td>');
							$('#0').append('<td><a href="enunciado.php?num=' + data.submission.problem.num  /*+ '&title=' + data.submission.problem ["title"] */+ ' ">'+ data.submission.problem.title + '</a></td>');
							
							switch (data.submission.result ){
										case "AC":  $('#0').append('<td class="aceptado">' + data.submission.result + '</td>');
													break;
										case "WA":  $('#0').append('<td class="error">' + data.submission.result + '</td>');
													break;
										case "IQ":  $('#0').append('<td class="encolado">' + data.submission.result + '</td>');
													break;
										case "CE":  $('#0').append('<td class="compilationError">' + data.submission.result + '</td>');
													break;
										case "IR":  $('#0').append('<td class="internalError">' + data.submission.result + '</td>');
													break;
										case "TL":  $('#0').append('<td class="timeLimit">' + data.submission.result + '</td>');
													break;
										case "TL":  $('#0').append('<td class="memoryLimit">' + data.submission.result + '</td>');
													break;
										case "RF":  $('#0').append('<td class="restrictedFunction">' + data.submission.result + '</td>');
													break;
										default:	$('#0').append('<td class="otroEstado">' + data.submission.result + '</td>');
													break;
							}
							
							if (data.submission.language == "CPP")
										$('#0').append('<td>' + "C++" + '</td>');
							else
										$('#0').append('<td>' + data.submission.language + '</td>');
							
							if ((data.submission.executionTime == undefined))
										$('#0').append('<td>' + ' --- ' + '</td>');
							else
										$('#0').append('<td>' + data.submission.executionTime + '</td>');
							 if ((data.submission.memoryUsed == undefined))
										$('#0').append('<td>' + ' --- ' + '</td>');
							else
										$('#0').append('<td>' + data.submission.memoryUsed + '</td>');
							if ((data.submission.ranking == undefined))
										$('#0').append('<td>' + ' --- ' + '</td>');
							else
										$('#0').append('<td>' + data.submission.ranking + '</td>'); 
							
							
							var partesfechaIzq = data.submission.submissionDate.split('T');
							var partesfechaDer = partesfechaIzq[1].split('+');
							$('#0').append('<td>' +  partesfechaIzq[0] + ' a las ' + partesfechaDer[0] +'</td>');
						}
					}
						timerID2 = setTimeout(tablaEnviosUsuario, 3000);
					});
				};
				

				function ponerAnho(){
			var anho = document.getElementById("anhoNac");//tomamos el elemento anhoNac.
			fechaActual = new Date();//fecha actual
			anhoActual = fechaActual.getYear();//año de la fecha actual
			anhoActual+=1900;//debido a que nos arroja los años transcurridos entre 1900 (en este caso 109) le debemos sumar 1900 para que nos de 2009)
			var anhosTotal = anho.options.length-1;//tomamos los años que hay en el select y los borramos en el for
			for(var i=anhosTotal;i>=0;i--){
				anho.options[i]=null;
			}
			var i=0;//creamos esta variable para las posiciones en el select
			for(var a=anhoActual-5;a>=anhoActual-80;a--){
				op = document.createElement("OPTION");//pasamos a crear el option
				op.value = a;
				op.text = a;
				anho.options[i] = op;//en la posicion i creamos ese option
				i++;//aumentamos i
			}
		}

		function ponerMes(){
			var mes = document.getElementById("mesNac");//tomamos el elemento
			var nombreMes;//creamos la variable que va a contener los nombres de los meses
			for(var m=0;m<=11;m++){//aca escojemos el mes segun el ciclo
				if(m==0){
					nombreMes="Enero";
				}
				if(m==1){
					nombreMes="Febrero";
				}
				if(m==2){
					nombreMes="Marzo";
				}
				if(m==3){
					nombreMes="Abril";
				}
				if(m==4){
					nombreMes="Mayo";
				}
				if(m==5){
					nombreMes="Junio";
				}
				if(m==6){
					nombreMes="Julio";
				}
				if(m==7){
					nombreMes="Agosto";
				}
				if(m==8){
					nombreMes="Septiembre";
				}
				if(m==9){
					nombreMes="Octubre";
				}
				if(m==10){
					nombreMes="Noviembre";
				}
				if(m==11){
					nombreMes="Diciembre";
				}
				op = document.createElement("OPTION");//creamos la opcion
				var valorMes="";
				var aux=0;
				if(m+1>0 && m+1<10){//dado que el día trabaja con el mes en dos digitos entonces le agregamos un cero (0) al inicio si es menor que 10
					aux=m+1;
					valorMes="0"+aux;
				}
				else{//si no pues no XD
					valorMes=m+1;
				}
				op.value = valorMes;
				op.text = nombreMes;
				mes.options[m] = op;
		 
			}
		}

		function ponerDias(){
			var anho = document.getElementById("anhoNac");//tomamos el elemento año
			var mes = document.getElementById("mesNac");//el mes
			var dias = document.getElementById("diaNac");//y el dia
			var diasTotal = dias.options.length-1;//tomamos cuantos elementos hay en el select
			for(var i=diasTotal;i>=0;i--){//y los borramos
				dias.options[i]=null;
			}
			var diasMes = 0;//esta variable creo que ya no la uso XD
			//si es enero, marzo, mayo, etc, le asigno 31 dias, recuerden lo de que empieza en 0 y termina en 30 para hacer 31 dias, aqui tambien 
			//sumo 1 a la variable
			if(mes.value=="01" || mes.value=="03" || mes.value=="05" || mes.value=="07" || mes.value=="08" || mes.value=="10" || mes.value=="12"){
				//dias.options.length=30;
				for(var o=0;o<=30;o++){
					op = document.createElement("OPTION");
					op.value = o+1;
					op.text = o+1;
					dias.options[o] = op;
					//document.body.appendChild(dias);
				}
			}
			//si el mes es de 30 dias entonces solo le pongo 30 dias
			if(mes.value=="04" || mes.value=="06" || mes.value=="09" || mes.value=="11"){
				//dias.options.length=30;
				for(var o=0;o<=29;o++){
					op = document.createElement("OPTION");
					op.value = o+1;
					op.text = o+1;
					dias.options[o] = op;
					//document.body.appendChild(dias);
				}
			}
			//pero si el mes es el desgraciado de febrero, (desgraciado por que tiene mas poquitos :S)
			if(mes.value=="02"){
				//si es bisiesto
				if((anho.value % 4 == 0) && ((anho.value % 100 != 0) || (anho.value % 400 == 0))){
					for(var o=0;o<=28;o++){
						op = document.createElement("OPTION");
						op.value = o+1;
						op.text = o+1;
						dias.options[o] = op;
						//document.body.appendChild(dias);
					}
				}
				else{//o si no lo es
					for(var o=0;o<=27;o++){
						op = document.createElement("OPTION");
						op.value = o+1;
						op.text = o+1;
						dias.options[o] = op;
						//document.body.appendChild(dias);
					}
				}
			}
		}
		
	

		function validaAux() {
		
			an= document.form_registro.anhoNac.value;
			mo= document.form_registro.mesNac.value;
			da= document.form_registro.diaNac.value;
			fecha= an + "-" + mo + "-" + da + "T00:00:00+02:00";

			
			for(i=0;i<document.form_registro.mailNotification.length;i++){
				if(document.form_registro.mailNotification[i].checked) {
					marcado=i;
				}
			}
			var valNotification = document.form_registro.mailNotification[marcado].value;
			
			var valor = document.form_registro.email.value;
			var cell = document.getElementById("celdaMail");
			var recuadro = document.getElementById("email");
			respuesta = null;
			$.ajax({
				async:false,   
				cache:false,  
				type:'POST',
				url: "/ws/user/add/dry-run",
				data:  '{"name":"' +  document.form_registro.name.value + '",' + 
						 '"nick":"' + document.form_registro.nick.value + '",' +
						 '"gender":"' + document.form_registro.gender.value + '",' +
						 '"email":"' + document.form_registro.email.value + '",' +
						 '"institutionId":"' + document.form_registro.institucion.value + '",' +
						 '"countryCode":"' + document.form_registro.country.value + '",' +
						 '"role":"' + "STUDENT" + '",' +
						 '"password":"' + document.form_registro.password.value + '",' +
						 '"mailNotification":"'+ document.form_registro.mailNotification[marcado].value + '",' +
						 '"birthday":"' + fecha + '"}',
				contentType:'application/json; charset=utf-8',
				dataType:'json',
				success:function(response){
					respuesta = response;
					if (response.correct == "true") {
						document.getElementById("send").disabled = false; 
					}
				}
			});
			return respuesta;
		}
		
			function validarMail(){
				
				var valor = document.form_registro.email.value;
				var cell = document.getElementById("celdaMail");
				var recuadro = document.getElementById("email");

				var response = validaAux();
				if (response.email == "Valor ya utilizado"){
					recuadro.className="rojo2";
					recuadro.removeClass=("vanadium-valid");
					if (cell.childNodes.length > 2)
					cell.removeChild( cell.lastChild );
					$('#celdaMail').append('<span class="rojo">' + response.email + '</span>');
				}
				else if (cell.childNodes.length > 2){
					recuadro.className="verde";
					cell.removeChild( cell.lastChild );
				}
			}
			
			function validarNick(){
				var valor = document.form_registro.nick.value;
				var cell = document.getElementById("celdaNick");
				var recuadro = document.getElementById('nick');
				document.getElementById('nick').className += ' vanadium-invalid';
				
				var response = validaAux();
				if (response.nick == "Valor ya utilizado"){
					recuadro.className="rojo2";
					if (cell.childNodes.length > 2)
						cell.removeChild( cell.lastChild );
						$('#celdaNick').append('<span class="rojo">' + response.nick + '</span>');}
				else if (response.nick == "Campo oblitagorio"){
					recuadro.className="rojo2";
					if (cell.childNodes.length > 2)
						cell.removeChild( cell.lastChild );
					$('#celdaNick').append('<span class="rojo">' + response.nick + '</span>');}
				else if (response.nick == "Campo demasiado corto"){
					recuadro.className="rojo2";
					if (cell.childNodes.length > 2)
						cell.removeChild( cell.lastChild );
					$('#celdaNick').append('<span class="rojo">' + response.nick + '</span>');}
					else if (cell.childNodes.length > 2){
						recuadro.className="verde";
						cell.removeChild( cell.lastChild );
					}
			}
			
			function validarName(){
				var valor = document.form_registro.name.value;
				var cell = document.getElementById("celdaName");
				var recuadro = document.getElementById('name');
				
				var response = validaAux();
				if (response.name == "Campo oblitagorio"){
					recuadro.className="rojo2";
					if (cell.childNodes.length > 2)
						cell.removeChild( cell.lastChild );
					$('#celdaName').append('<span class="rojo">' + response.name + '</span>');}
				else if (response.name == "Campo demasiado corto"){
					recuadro.className="rojo2";
					if (cell.childNodes.length > 2)
						cell.removeChild( cell.lastChild );
					$('#celdaName').append('<span class="rojo">' + response.name + '</span>');}
				else if (cell.childNodes.length > 2){
						recuadro.className="verde";
						cell.removeChild( cell.lastChild );
					}
			}
			
			function validarPass(){
				var valor = document.form_registro.name.value;
				var cell = document.getElementById("celdaPass");
				var recuadro = document.getElementById('password');
				
				var response = validaAux();
				if (response.password == "La contraseña no cumple los mínimos de seguridad"){
					recuadro.className="rojo2";
					if (cell.childNodes.length > 2)
						cell.removeChild( cell.lastChild );
					$('#celdaPass').append('<span class="rojo">' + response.password + '</span>');}
				else if (cell.childNodes.length > 2){
						recuadro.className="verde";
						cell.removeChild( cell.lastChild );
					}
			}
			
			function enviar() {
				//creamos el array para pasar a json
				$json= {
					"name": document.form_registro.name.value,
					"nick": document.form_registro.nick.value,
					"gender": document.form_registro.gender.value,
					"email" : document.form_registro.email.value,
					"institutionId": document.form_registro.institucion.value,
					"countryCode": document.form_registro.country.value,
					"role": "STUDENT",
					"password": document.form_registro.password.value,
					"mailNotification": document.form_registro.mailNotification.value,
					"birthday": document.form_registro.birthday.value,
				}
			
				$.ajax({
					async:false,   
					cache:false,  
					type:'POST',
					url: "/ws/user/add",
					data: $json,
					contentType:'application/json; charset=utf-8',
					dataType:'json',
					success:function(response){
						coordenadaCentral = response.d ? response.d : response;
						if (response.nick == "Valor ya utilizado")
							$('#celdaNick').append('<span class="rojo">' + response.email + '</span>');
					},
					error:function(jqXHR, textStatus, errorThrown){
						alert(textStatus);
					}
				});
			}	
			
			function cargaPaises() {
				
				$.getJSON(url_country, function(data){		
						var cell = document.getElementById("country");
						if ( cell.hasChildNodes() )
						{
								while ( cell.childNodes.length >= 1 )
								{
									cell.removeChild( cell.firstChild );
								}
						}
					  
						$.each(data.country, function(j,x){
						if(data.country[j].nombre == 'España')
							$('#country').append('<option selected value="'+ data.country[j].code +'">' + data.country[j].nombre + ' </option>');
						else
						$('#country').append('<option value="'+ data.country[j].code +'">' + data.country[j].nombre + ' </option>');
						})
											
					})

			}
				
			function cargaInstituciones(valor) {
				$.getJSON(url_institution +valor, function(data){
													
					var cell = document.getElementById("institucion");
					if ( cell.hasChildNodes() )
					{
							while ( cell.childNodes.length >= 1 )
							{
								cell.removeChild( cell.firstChild );
							}
					}
				  
					$.each(data.institution, function(j,x){
						$('#institucion').append('<option value="'+ data.institution[j].id +'">' + data.institution[j].name + ' </option>');
					})
											
				});
			}
			
			function captcha () {
				$.getScript("http://www.google.com/recaptcha/api/js/recaptcha_ajax.js",function(){
						//creamos y mostramos el recaptcha
						Recaptcha.create("6LfA0dgSAAAAAO2jITWZahXJsogP3_qfHH2BpWwh",
									 "recaptcha", {
								 theme: "red",
								 callback: Recaptcha.focus_response_field
									 });
				});
			}
			
			function refrescaTablaProb(){
					$('.container').append('<img id="gif" src="./images/dancer_024.gif" WIDTH="100" HEIGHT="100">');
					intervalo = setInterval(tablaProb, 5000);
				}

				function tablaProb(){
					$.getJSON(url_volumenes + numVolumen, function(data){
						$('#gif').remove();
						var cell = document.getElementById("cont");
						if ( cell.hasChildNodes() )
						{
								while ( cell.childNodes.length >= 1 )
								{
									cell.removeChild( cell.firstChild );
								}
						}
					  
						$.each(data.problem, function(j,x){
							if (j%2 == 0)
								$('#cont').append('<tr class="cuerpo filaPar" id=' + j + ' >  </tr>');
							else
								$('#cont').append('<tr class="cuerpo filaImpar" id=' + j + ' >  </tr>');
								
								//Solo nos quedamos con los numeros de envio de usuarios y de resultados AC
								var totalSubs = data.problem[j].totalSubs;
								var totalUsers = data.problem[j].totalUsers;
								var ac = data.problem[j].ac;
								var dacu = data.problem[j].dacu;
								var porcentaje1 = ac*100/totalSubs;
								var porcentaje2 = dacu*100/totalUsers;
								if (ac == 0){
									porcentaje1=0;
									porcentaje2=0;}
								if (porcentaje2 > 100)
									porcentaje2=100;
								
								$('#'+j+'').append('<td class="enunciado" ><a href="enunciado.php?num=' + data.problem[j].num /*+'&title='+ data.problem[j].title */+ '">'+ data.problem[j].num + '</a></td>');
								$('#'+j+'').append('<td class="enunciado"><a href="enunciado.php?num=' + data.problem[j].num /*+ '&title='+ data.problem[j].title */+ '">'+ data.problem[j].title + '</a></td>');
								
								$('#'+j+'').append('<td><div class="meter-wrap"><div class="meter-value" style="background-color: #0a0; width: '+ porcentaje1 +'%;"><div class="meter-text">' + ac + '/' + totalSubs + '</div></div></div></td>');
								$('#'+j+'').append('<td><div class="meter-wrap"><div class="meter-value" style="background-color: #0a0; width: '+ porcentaje2 +'%;"><div class="meter-text">' + dacu + '/' + totalUsers + '</div></div></div></td></td>');
						 });
					});
				};
				
				function refrescaTablaAC(){
						$('#container').append('<img id="gif" src="./images/dancer_024.gif" WIDTH="100" HEIGHT="100">');
						intervalo = setInterval(tablaAC, 5000);
					}

					function show_best() {
						$.getJSON(url_user + usuario + '/submissions/problem/' + numProblema + '/best', function(data, j, item){
						  
							if (data != null) {
							
								$('#mejor_problema').append('<h2>&Eacute;ste es tu mejor env&iacute;o de este problema</h2>');
								$('#mejor_problema').append('<table id="mejor">');
								$('#mejor').append('<thead id="thead_best">');
								$('#thead_best').append('<tr id="cuerpo">');
								$('#cuerpo').append('<th> Submission </th>');
								$('#cuerpo').append('<th> Lang </th>');
								$('#cuerpo').append('<th> Execution </th>');
								$('#cuerpo').append('<th> Memory </th>');
								$('#cuerpo').append('<th> Ranking </th>');
								$('#cuerpo').append('<th> Date </th>');
								$('#thead_best').append('</tr>');
								$('#mejor').append('</thead>');
								$('#mejor').append('<tbody id="cont_best"></tbody>');
								
								
							
								$('#cont_best').append('<tr class="cuerpo filaPar" id="best">  </tr>');
							
								$('#best').append('<td>' + data.num + '</td>');

								if (data.language == "CPP")
									$('#best').append('<td>' + "C++" + '</td>');
								else
									$('#best').append('<td>' + data.language + '</td>');

								$('#best').append('<td>' + data.executionTime + '</td>');
								$('#best').append('<td>' + data.memoryUsed + '</td>');
								$('#best').append('<td>' + data.ranking + '</td>');
								$('#best').append('<td>' + data.submissionDate + '</td>');
							}
							else {
								$('#mejor_problema').empty();	
							}
						});
					}
					
					function tablaAC(){

						$.getJSON(url_problem + numProblema + '/ranking', function(data, j, item){
							$('#gif').remove();		
							
							/*
							$('#title_envios').empty();
							$('#title_envios').append('<h2 id="title_envios">Últimos envíos de este problema (' + data.submission.length + ') </h2>');
							*/
							if (data.submission == undefined){
								$('#accepted').empty();
								$('#accepted').append('<table id="tabla"><tbody id="cont"><td>¡Sé el primero en resolver este problema!</td></tbody></table>');
							}else {
								$('#accepted').empty();
								$('#accepted').append('<table id="tabla"><thead><tr><th> Pos </th><th> Envío</th><th> Usuario </th><th> Lenguaje </th><th> Ejecución/th><th> Memoria </th><th> Fecha </th></tr></thead><tbody id="cont"></tbody></table>');
								
								var cell = document.getElementById("cont");
								if ( cell.hasChildNodes() )
								{
										while ( cell.childNodes.length >= 1 )
										{
											cell.removeChild( cell.firstChild );
										}
								}
								
								if (data.submission.length > 1) {
									$.each(data.submission, function(j,x){
										if (j%2 == 0)
											$('#cont').append('<tr class="cuerpo filaPar" id=' + j + ' >  </tr>');
										else
											$('#cont').append('<tr class="cuerpo filaImpar" id=' + j + ' >  </tr>');
										$('#'+j+'').append('<td>' + (j+1) + '</td>');
										$.each(data.submission[j], function(i,item){
											
											if (item == data.submission[j].user)
					
												$('#'+j+'').append('<td><a href="usuario.php?id=' + item ["id"] + ' ">'+ item["nick"] + '</a></td>');
											else if (item == data.submission[j].language) {
												if (item == "CPP")
													$('#'+j+'').append('<td>' + "C++" + '</td>');
												else
													$('#'+j+'').append('<td>' + item + '</td>');
											}
											else if (item == data.submission[j].ranking) {
													}
											else if (item == data.submission[j].result) {
													} else
													$('#'+j+'').append('<td>' + item + '</td>');
										});
									});
								}else {
									$('#cont').append('<tr class="cuerpo filaPar" id="' + 0 + '" >  </tr>');
									$('#'+0+'').append('<td>' + 1 + '</td>');
									$.each(data.submission, function(i, item){
										if (item == data.submission.user)
											$('#'+0+'').append('<td><a href="usuario.php?id=' + item ["id"] + ' ">'+ item["nick"] + '</a></td>');
										else if (item == data.submission.language) {
											if (item == "CPP")
												$('#'+0+'').append('<td>' + "C++" + '</td>');
											else
												$('#'+0+'').append('<td>' + item + '</td>');
										}
										else if (item == data.submission.ranking) {
												}
										else if (item == data.submission.result) {
												} else
												$('#'+0+'').append('<td>' + item + '</td>');
									});
								}
							}
						});
					};
					
					function alerta(){
						document.getElementById("aviso").style.display="inline";
					}
					
					function contar(input) {
								//Comprobamos que no pase de 5000 caracteres y si pasa, que borre los sobrantes
								if (input.value.length >= 500) {
								input.value = input.value.substring(0,500);
								}
								//almacenamos el resto
								var resto = 500 - input.value.length;
								 
								//imprimimos los caracteres restantes en el span
								var final=document.getElementById('letras');
								final.innerHTML=resto+"/500 caracteres";
					}
					
					