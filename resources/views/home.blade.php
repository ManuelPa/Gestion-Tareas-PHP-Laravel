@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="overflow: auto;">
                    <!-- Para conectar todos los tabs  '#visitadas, #aeafea' -->
                    <?php 
                    //Generaremos un string para luego añadir este al metodo de js que nos permite cominicar determinados listados.
                    $ventanas = "";
                    //Encontraremos el ultimo elemento del array para asi escribir correctamente el string.
                    $last = end($tabs);
                    $reallast = end($last);
                    $vent = "";
                    foreach ($tabs as $ventana){
                        if ($ventana == $reallast) {
                            $ventanas = $ventanas .'#milista'.$ventana->id;
                        }else{
                            $ventanas = $ventanas .'#milista'.$ventana->id.',';
                        }
                        $vent = $vent . 'tab'.$ventana->id.',';
                    }
                    ?>
                    @if($user->admin == "true")
                    <p class="col-md-8">Panel de administración de tareas.</p>
                    <p class="col-md-4"><a class="btn btn-block btn-primary" href="{{ route('register') }}">Registrar usuario</a></p>
                <input type="text" name="search" id="search" class="form-control" onkeyup="buscar(this, '{{$vent}}')" placeholder="Escribe la ventana a buscar...">
                    @else
                    Tabla de tareas de {{$user->email}}.
                    @endif
                </div>
                <div class="panel-body" style="padding-top: 0!important; padding-bottom: 0!important; background-color: #9eccff">
                    <div class="row">
                        @if($tabs->isEmpty() && $user->admin == "false")
                        <div class="tab" style="margin-top: 1%;">
                            <form action="{{url('newtab')}}" method="post" id="formnewtab">
                                <div class="col-md-9">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <input type="text" placeholder="Nombre del nuevo tab..." class="inputask2" name="newtab" id="newtab" required>
                                    <input type="color" name="newcolor" value="#007066" required>
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-block btn-link" onclick="document.getElementById('formnewtab').submit()"><img height="20" width="20" src="{{ asset('css/anadir.png') }}"></button>
                                </div>
                            </form>
                        </div>
                        @endif
                        <ol id="listageneral" style="padding-left: 0px;">
                            @foreach($tabs as $tab)
                            @if($user->admin == "false")
                            <li class="tab col-md-12" id="tab{{$tab->id}}" style="background-color: {{$tab->color}}; height: 662px">
                            @else
                            <li class="tab col-md-{{$tab->grid_wide}}" id="tab{{$tab->id}}" style="background-color: {{$tab->color}}; height: {{$tab->grid_height}}px;">
                            @endif
                                    <div class="col-md-6">
                                        <input type="text" class="nombretab" onkeyup="setTextotab('{{$tab->id}}')" name="tabtext{{$tab->id}}" id="tabtext{{$tab->id}}" value="{{$tab->name}}">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="collapse in navbar-collapse" id="app-navbar-collapse{{$tab->id}}">
                                            <ul class="nav navbar-nav navbar-right">
                                                <li class="dropdown">
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                                        <span class="caret" style="color: black!important;" ></span>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <div>
                                                                <button class="btn btn-block btn-link" id="procesar{{$tab->id}}" onclick="procesar('{{$tab->id}}')"><img height="20" width="20" src="{{ asset('css/audio.png') }}"></button>
                                                            </div>
                                                        </li>
                                                        @if($user->admin == "false")
                                                        <li>
                                                            <form action="{{url('deletetab')}}" method="post" id="formdeletetab{{$tab->id}}">
                                                                <input type="hidden" name="_token" value="{{csrf_token()}}"><!--MUY IMPORTANTE: Necesario para poder enviar datos por post(Metodo de seguridad)-->
                                                                <input type="hidden" name="id_tab" value="{{$tab->id}}"/>
                                                                <button class="btn btn-block btn-link"  onclick="document.getElementById('formdeletetab{{$tab->id}}').submit()"><img height="20" width="20" src="{{ asset('css/eliminar.png') }}"></button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <div class="col-md-4">
                                                                <a href="#" class="tooltip-test" title="Tooltip">
                                                                    <span class="dot" style="background-color: #ffffff" onclick="cambiacolor('#ffffff', '{{$tab->id}}')">
                                                                        
                                                                    </span>
                                                                </a>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <span class="dot" style="background-color: #f28b82" onclick="cambiacolor('#f28b82', '{{$tab->id}}')"></span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <span class="dot" style="background-color: #a7ffeb" onclick="cambiacolor('#a7ffeb', '{{$tab->id}}')"></span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <span class="dot" style="background-color: #ccff90" onclick="cambiacolor('#ccff90', '{{$tab->id}}')"></span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <span class="dot" style="background-color: #d7aefb" onclick="cambiacolor('#d7aefb', '{{$tab->id}}')"></span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <span class="dot" style="background-color: #fdcfe8" onclick="cambiacolor('#fdcfe8', '{{$tab->id}}')"></span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <span class="dot" style="background-color: #fbbc04" onclick="cambiacolor('#fbbc04', '{{$tab->id}}')"></span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <span class="dot" style="background-color: #cbf0f8" onclick="cambiacolor('#cbf0f8', '{{$tab->id}}')"></span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <span class="dot" style="background-color: #e6c9a8" onclick="cambiacolor('#e6c9a8', '{{$tab->id}}')"></span>
                                                            </div>
                                                        </li>
                                                        @else
                                                        <li>
                                                            <div class="col-md-4" style="padding: 0!important;">
                                                                <button class="btn btn-block btn-link" onclick="cambiarTam('{{$tab->id}}', 1)"><img height="20" width="20" src="{{ asset('css/tamaño1.png') }}"></button>
                                                            </div>
                                                            <div class="col-md-4" style="padding: 0!important;">
                                                                <button class="btn btn-block btn-link" onclick="cambiarTam('{{$tab->id}}', 2)"><img height="20" width="20" src="{{ asset('css/tamaño2.png') }}"></button>
                                                            </div>
                                                            <div class="col-md-4" style="padding: 0!important;">
                                                                <button class="btn btn-block btn-link" onclick="cambiarTam('{{$tab->id}}', 3)"><img height="20" width="20" src="{{ asset('css/tamaño3.png') }}"></button>
                                                            </div>
                                                        </li>
                                                        @endif
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <ol class="row" id="milista{{$tab->id}}" style="color:black;">
                                        @foreach($tasks as $t)
                                        @if($tab->id == $t->id_tab)
                                        @if($t->check == 'false')
                                        <li class="col-md-12" id="tasksincompletar{{$t->id}}">
                                            <input type="checkbox" name="taskcheck{{$t->id}}" id="taskcheck{{$t->id}}" onclick="setCheckCompletado('{{$t->id}}','{{$tab->id}}', '{{$t->text}}')"/>
                                            <input type="text" class="inputask" onkeyup="setTexto('{{$t->id}}')"  name="tasktext{{$t->id}}" id="tasktext{{$t->id}}" value="{{$t->text}}">
                                            <button class="btn btn-link" onclick="eliminartask('{{$t->id}}', '0')">
                                                <img width="20" src="{{asset('css/eliminar.png')}}">
                                            </button>
                                        </li>
                                        @endif
                                        @endif
                                        @endforeach
                                    </ol>
                                    <div class="col-md-12">
                                        <form action="{{url('newtask')}}" method="post" id="formnewtask{{$tab->id}}">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}"><!--MUY IMPORTANTE: Necesario para poder enviar datos por post(Metodo de seguridad)-->
                                            <input type="hidden" name="id_tab" value="{{$tab->id}}"/>
                                            <input type="text" placeholder="Añade una nueva tarea..." class="inputask2" name="tasktextnew{{$tab->id}}" id="tasktextnew{{$tab->id}}" required>
                                            <button class="btn btn-link"  onclick="document.getElementById('formnewtask{{$tab->id}}').submit()"><img height="20" width="20" src="{{ asset('css/anadir.png') }}"></button>
                                        </form>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 3%; margin-bottom: 3%;">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tareasterminadas{{$tab->id}}">Tareas Completadas</button>
                                        <div class="modal fade" style="margin-top: 7%;" id="tareasterminadas{{$tab->id}}" tabindex="-1" role="dialog" aria-labelledby="Tareas completadas" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content" >
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="Tareas completadas">Tareas Completadas</h5>
                                                <!--  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button> -->
                                        </div>
                                        <div class="modal-body">
                                            <ul id="listacompletada{{$tab->id}}">
                                                @foreach($tasks as $t)
                                                @if($tab->id == $t->id_tab)
                                                @if($t->check == 'true')
                                                <li id="taskcompletada{{$t->id}}" style="list-style:none; text-align: left;">
                                                    <p style="margin-bottom: 3%;">
                                                        <input type="checkbox" name="taskcheck{{$t->id}}" id="taskcheck{{$t->id}}" checked="checked" onclick="setUncheckCompletado('{{$t->id}}', '{{$tab->id}}', '{{$t->text}}')">
                                                        <del>{{$t->text}}</del>
                                                        <button style="float: right;" class="btn btn-link" onclick="eliminartask('{{$t->id}}', '1')">
                                                            <img width="20" src="{{asset('css/eliminar.png')}}">
                                                        </button>
                                                    </p>
                                                </li>
                                                @endif
                                                @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                        $(document).ready(function(){
                                //Aplicar la función sortable a la lista con id milista
                                $( "#milista{{$tab->id}}" ).sortable({
                                    connectWith : '{{$ventanas}}',
                                    scroll: false,
                                    forcePlaceholderSize: true,
                                    update: function( event, ui ) {
                                        var id_tab = ui.item.parent().attr('id');//id tab del tab donde se deposita la tarea
                                        var id_task = ui.item.attr('id');//id task. que ha sido movido a ese tab

                                        var lista = $('#milista{{$tab->id}} li');//nuevo orden de la lista
                                        var id_lista = [];
                                        lista.each(function() {
                                            id_lista.push($(this).attr('id'));
                                        });
                                        $.ajax({
                                            data: { id_lista: id_lista, id_tab: id_tab, id_task: id_task},
                                            url:   'setOrder',
                                            type:  'GET'
                                        });
                                    }
                                });
                            });
                            </script>
                        </li>
                        @endforeach
                    </ol>
                    @if($user->admin == "true")
                    <script>
                        $(document).ready(function(){
                        //Aplicar la función sortable a la lista con id listageneral
                        $( "#listageneral" ).sortable({
                            scroll: false,
                            forcePlaceholderSize: true,
                            update: function( event, ui ) {
                                var lista = $('#listageneral li');//nuevo orden de la lista
                                var id_lista = [];
                                lista.each(function() {
                                    if ($(this).attr('id') != null && $(this).attr('id').includes('tab')) {
                                        id_lista.push($(this).attr('id'));
                                    }
                                });
                                console.log(id_lista);
                                $.ajax({
                                    data: { id_lista: id_lista},
                                    url:   'setOrderTab',
                                    type:  'GET'
                                });
                            }
                        });
                    });
                    </script>
                    @endif
            </div>  
        </div>
    </div>
</div>
</div>
</div>
@endsection
