<!-- CSS y Script para el mapa -->
<link rel="stylesheet" type="text/css" href="misc/img/dc_refactor.css">
<link rel="stylesheet" type="text/css" href="assets/css/Mapa.css">
<script src="misc/lib/mscross-1.1.9.js" type="text/javascript"></script>

<style>
.page-inner {
	padding: 0;
	height: 100vh;
}
</style>

<div class="contenedor">
        <div class="mscross" style="width: <?php echo '<script>parent.clientWidth</script>' . 'px' ?> ; height: 600px" id="dc_main"></div>
        
		<img id="brujula" src="misc/img/Brujula Vector.png">

        <div id="Layer2" class="layer-panel">
    <div class="card shadow-lg p-3 bg-white rounded" style="width:220px;">

        <div class="layer-header" onclick="toggleLayers()">
		    <h5 class="mb-0">Capas</h5>
		    <span id="layerIcon" class="layer-icon">&#9660;</span>
		</div>


		    <div id="layerContent" class="layer-content">
		        <form name="select_layers" class="d-grid gap-2 mt-3">

		            <div class="form-check form-switch">
		                <input class="form-check-input" checked onclick="chgLayers()" type="checkbox" name="layer[0]" value="Cali" id="swCali">
		                <label class="form-check-label" for="swCali"><strong>Cali</strong></label>
		            </div>

		            <div class="form-check form-switch">
		                <input class="form-check-input" onclick="chgLayers()" type="checkbox" name="layer[2]" value="Comunas" id="swComunas">
		                <label class="form-check-label" for="swComunas"><strong>Comunas</strong></label>
		            </div>

				<div class="form-check form-switch">
		                <input class="form-check-input" onclick="chgLayers()" type="checkbox" name="layer[1]" value="Barrios" id="swBarrios">
		                <label class="form-check-label" for="swBarrios"><strong>Barrios</strong></label>
		            </div>

		            <div class="form-check form-switch">
		                <input class="form-check-input" onclick="chgLayers()" type="checkbox" name="layer[3]" value="Manzanas" id="swManzanas">
		                <label class="form-check-label" for="swManzanas"><strong>Manzanas</strong></label>
		            </div>

		            <div class="form-check form-switch">
		                <input class="form-check-input" onclick="chgLayers()" type="checkbox" name="layer[4]" value="Malla_Vial" id="swMalla">
		                <label class="form-check-label" for="swMalla"><strong>Malla vial</strong></label>
		            </div>

		            <div class="form-check form-switch">
		                <input class="form-check-input" checked onclick="chgLayers()" type="checkbox" name="layer[5]" value="Punto" id="swPunto">
		                <label class="form-check-label" for="swPunto"><strong>Zoocriaderos</strong></label>
		            </div>

		        </form>
		    </div>
		    </div>
		</div>

        <div id="Layer1">
            <div style="overflow: auto; width: 140px; height: 140px; -moz-user-select:none; position:relative; z-index:100;" id="dc_main2"></div>
        </div>
    </div>

    <div class="modal" id="infoPunto" tabindex="-1" data-bs-backdrop="false" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-slideout" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="btn-close position-absolute" style="left:18px; top:18px;" aria-label="Cerrar" id="btnBackModal"></button>

                    <h5 class="modal-title">
                        Información de zoocriadero — zoocriadero #3
                    </h5>
                </div>

                <div class="modal-body text-start">
                    <div class="field-group">
                        <div class="field-legend">Código #</div>
                        <div class="field-value" id="idZoo"></div>
                    </div>

                    <div class="field-group">
                        <div class="field-legend">Nombre del zoocriadero</div>
                        <div class="field-value" id="nombreZoo"></div>
                    </div>

                    <div class="field-group">
                        <div class="field-legend">Comunas</div>
                        <div class="field-value" id="comunasZoo"></div>
                    </div>

                    <div class="field-group">
                        <div class="field-legend">Barrio</div>
                        <div class="field-value" id="barrioZoo"></div>
                    </div>

                    <div class="field-group">
                        <div class="field-legend">Dirección</div>
                        <div class="field-value" id="direccionZoo"></div>
                    </div>

                    <div class="field-group">
                        <div class="field-legend">Coordenadas (Lat, Lon)</div>
                        <div class="field-value" id="coordenadasZoo"></div>
                    </div>

                    <div class="field-group">
                        <div class="field-legend">Correo del responsable</div>
                        <div class="field-value" id="correoZoo"></div>
                    </div>

                    <div class="field-group">
                        <div class="field-legend">Nombre del responsable</div>
                        <div class="field-value" id="responsableZoo"></div>
                    </div>

                    <div class="field-group">
                        <div class="field-legend">Teléfono del responsable</div>
                        <div class="field-value" id="telefonoZoo"></div>
                    </div>

                    <div class="field-group">
                        <div class="field-legend">Correo del responsable</div>
                        <div class="field-value" id="correoZoo"></div>
                    </div>

                    <div class="field-group">
                        <div class="field-legend">Estado</div>
                        <div class="field-value" id="estadoZoo"></div>
                    </div>
                </div>

                <div class="modal-footer d-flex justify-content-between">
                    <a href="#" id="btnListaZoos" class="btn-zoos" role="button">
                        Ver lista de<br>zoocriaderos
                    </a>

                    <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Cerrar">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        // --- funciones base del mapa (sin cambios funcionales significativos) ---
        function calcTamañoInit() {
            var mapDiv = document.getElementById('dc_main');
            if (!mapDiv) return;
            var parent = mapDiv.parentElement || document.body;
            mapDiv.style.width = parent.clientWidth + 'px';
            mapDiv.style.height = parent.clientHeight + 'px';
        }

        calcTamañoInit();

        //<![CDATA[
        div = document.getElementById("dc_main");
        myMap1 = new msMap(div, "standardLeft");
		var listLayers = "Cali Puntos ";

        myMap1.setCgi("/cgi-bin/Mapserv.exe");
        myMap1.setMapFile("/ms4w/Apache/htdocs/cali.map");
        myMap1.setFullExtent(1050867.55, 1075491.88, 858820.55);
        cargarCapas();

        myMap2 = new msMap(document.getElementById("dc_main2"));
        myMap2.setActionNone();
        myMap2.setFullExtent(1050867.55, 1075491.88, 858820.55);
        myMap2.setMapFile("/ms4w/Apache/htdocs/cali.map");
        myMap2.setLayers("Cali");
        myMap1.setReferenceMap(myMap2);
        myMap1.redraw();
        myMap2.redraw();

        var insertarZoo = new msTool('InsertarZoocriadero', insertZ, 'misc/img/regisicono.png.png', queryI);
        var ConsultarZoo = new msTool('ConsultarZoocriadero', consultarZ, 'misc/img/puntoazu.png', queryII);

        myMap1.getToolbar(0).addMapTool(insertarZoo);
        myMap1.getToolbar(0).addMapTool(ConsultarZoo);

        function chgLayers() {
            var objForm = document.forms[0];
            listLayers = "Cali Puntos ";

            for (let i = 0; i < document.forms[0].length; i++) {
                if (objForm.elements["layer[" + i + "]"].checked) {
                    listLayers = listLayers + objForm.elements["layer[" + i + "]"].value + " ";
                }
            }
            myMap1.setLayers(listLayers);
            myMap1.redraw();
        }

		function toggleLayers() {
		    const card = document.querySelector('#Layer2 .card');
		    const icon = document.getElementById('layerIcon');
		
		    card.classList.toggle('layer-collapsed');
		}


        function objetoAjax() {
            var xmlhttp = false;

            try {
                xmlhttp = new ActiveXObject("Msxml2.XMLHTTP")
            } catch (e) {
                try {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (E) {
                    xmlhttp = false;
                }
            }

            if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
                xmlhttp = new XMLHttpRequest();
            }

            return xmlhttp;
        }

        var seleccionado = false;

        function insertZ(e, map) {
            map.getTagMap().style.cursor = "crosshair";
            seleccionado = true;
        }
        function consultarZ(e, map) {
            map.getTagMap().style.cursor = "crosshair";
            seleccionado = true;
        }

        function queryI(event, map, y, x, xx, yy) {
            if (!seleccionado) return;

            let confirmar = confirm("¿Estás seguro de que quieres registrar un nuevo zoocriadero?");
        
            if (!confirmar) return;

            <?php 
                $urlBase = getUrl("Zoocriaderos", "Zoocriadero", "getCreate"); 
            ?>
        
            let url = "<?php echo $urlBase ?>" + "&longitud=" + xx.toFixed(6) + "&latitud=" + yy.toFixed(6);
        
            let consulta1 = objetoAjax();
            consulta1.open("GET", url, true);
        
            consulta1.onreadystatechange = function () {
                if (consulta1.readyState === 4 && consulta1.status === 200) {
                    window.location.href = url;
                }
            };
        
            consulta1.send(null);
        }

        function setModalFields(zoo) {
            let id = zoo.id_zoocriadero;
            document.getElementById("idZoo").textContent  = id;

            let nombreZ = zoo.nombre;
            document.getElementById("nombreZoo").textContent = nombreZ;
            
            let barrio = zoo.barrio;
            document.getElementById("barrioZoo").textContent = barrio;

            let comuna = zoo.comuna;
            document.getElementById("comunaZoo").textContent = comuna;

            let direccion = zoo.direccion;
            document.getElementById("direccionZoo").textContent = direccion;

            let responsable = zoo.nombre_responsable + " \n" + zoo.apellido_responsable;
            document.getElementById("responsableZoo").textContent = responsable;

            let correo = zoo.correo;
            document.getElementById("correoZoo").textContent = correo;

            let telefono = zoo.telefono;
            document.getElementById("telefonoZoo").textContent = telefono;

            let estado = zoo.nombre_estado;
            document.getElementById("estadoZoo").textContent = estado;

            let coordText = "";
            if (zoo.coordenadas) {
                coordText = zoo.coordenadas;
            }
            document.getElementById("coordenadasZoo").textContent = coordText;


            document.getElementById("coordenadasZoo").textContent = coordText;
        }

        function queryII(event, map, y, x, xx, yy) {
            if (!seleccionado) return;

            <?php 
                $urlBase = getUrl("Zoocriaderos", "Zoocriadero", "getZoocriadero"); 
            ?>
        
            let url = "<?php echo $urlBase ?>" + "&ajax=1&longitud=" + xx + "&latitud=" + yy;

            consulta2 = objetoAjax();
            consulta2.open("GET", url, true);

            consulta2.onreadystatechange = function () {
                if (consulta2.readyState == 4 && consulta2.status === 200) {
                    console.log(consulta2.responseText);
                    let zoo = JSON.parse(consulta2.responseText);
                    setModalFields(zoo);

                    var idForTitle = zoo.id_zoocriadero;
                    var titleEl = document.querySelector('#infoPunto .modal-title');
                    titleEl.textContent = "Información de zoocriadero" + (idForTitle ? " — zoocriadero #" + idForTitle : "");

                    let modalEl = document.getElementById("infoPunto");
                    let modal = new bootstrap.Modal(modalEl, {
                        backdrop: false,
                        keyboard: false,
                        focus: false
                    });

                    modal.show();
                }
            }
            consulta2.send(null);
        }

        document.addEventListener('DOMContentLoaded', function () {
            var back = document.getElementById('btnBackModal');
            back.addEventListener('click', function () {
                let modalEl = document.getElementById("infoPunto");
                let modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();
            });

            document.getElementById('btnListaZoos').addEventListener('click', function (e) {
                e.preventDefault();
                window.location.href = 'lista_zoocriaderos.php';
            });
        });

        myMap1.redraw();
        myMap2.redraw();
        //]]>

        // cargarCapas y resize
        function cargarCapas() {
            var originalRedraw = myMap1.redraw.bind(myMap1);
            var lastExtentHash = null;
            var lastLayers = '';

            myMap1.redraw = function () {
                originalRedraw();
                var e = myMap1.getExtent().split(',');
                var ext = { minx: parseFloat(e[0]), maxx: parseFloat(e[1]), miny: parseFloat(e[2]), maxy: parseFloat(e[3]) };
                var scale = ext.maxx - ext.minx;
                listLayers = "Cali Puntos ";
				const activos = ['swCali', 'swPunto'];

				document.querySelectorAll('#Layer2 input[type="checkbox"]').forEach(cb => {
					cb.checked = activos.includes(cb.id);
  				});

                if (scale < 30000) {
					listLayers += "Comunas ";
            		document.getElementById("swComunas").checked = true;
				} 

                if (scale < 10000) {
					listLayers += "Barrios ";
					document.getElementById("swBarrios").checked = true;
				} 

                if (scale < 6000) {
					listLayers += "Manzanas ";
					document.getElementById("swManzanas").checked = true;
				}

                if (scale < 3000) {
					listLayers += "Malla_Vial ";
					document.getElementById("swMalla").checked = true;
				}

                if (listLayers !== lastLayers) {
                    lastLayers = listLayers;
                    chgLayers();
                    originalRedraw();
                }
            };
        }

        window.addEventListener("resize", function () {
            var mapDiv = document.getElementById("dc_main");
            if (!mapDiv) return;
            myMap1.recalc_map_size();
            myMap1.redraw();
        });
    </script>
