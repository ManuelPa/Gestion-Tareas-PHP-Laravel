<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use App\Tab;
use App\Task;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        //Obtenemos el id del usuario
        $user_id = Auth::user()->id;
        //Obtenemos el registro del usuario con ese id, con el metodo find al cual hay que pasarle el id.
        $user = User::find($user_id);
        if ($user->admin == 'true') {
            //Obtenemos todas las ventanas para el administrador.
            $tabs = Tab::orderBy('order')->get();
        }else{
            //Obtenemos el registro de la ventana asociada al usuario.
            $tabs = Tab::where('id_user', $user->id)->orderBy('order')->get();
        }
        //Obtenemos los registros de las tareas.
        $tasks = Task::orderBy('order')->get();

        return view('home', compact('user', 'tabs', 'tasks'));
    }

    public function nuevotask(Request $request)
    {
        //Obtenemos el id del tab desde la vista con el objeto request.
        $id_tab = $request->id_tab;
        //Generamos el name del texto a añadir.
        $texto_name = 'tasktextnew'.$id_tab;
        $new_texto = $request->$texto_name;
        //Insertamos la nueva tarea en la base de datos.
        //Generamos un objeto del elemento a insertar
        $task = new Task();
        $task->id_tab = $id_tab;
        $task->text = $new_texto;
        $task->check = 'false';
        $task->order = '0';
        $task->save();
        
        return redirect()->route('mainpage');
    }

    public function nuevotab(Request $request)
    {
        //Obtenemos el nombre y el color del tab desde la vista con el objeto request.
        $text = $request->newtab;
        $color = $request->newcolor;
        //Insertamos la nueva ventana en la base de datos.
        //Generamos un objeto del elemento a insertar
        $tab = new Tab();
        $tab->id_user = Auth::user()->id;
        $tab->name = $text;
        $tab->color = $color;
        $tab->order = '0';
        $tab->grid_wide = 12;
        $tab->grid_height = 432;
        $tab->save();
        
        return redirect()->route('mainpage');
    }

    public function eliminartask()
    {
        //Obtenemos el id del task desde la vista con el objeto request.
        $id_task = $_POST['id'];
        //Eliminamos el task en la base de datos.
        //Generamos un objeto del elemento a eliminar
        $task = Task::find($id_task);
        $task->delete();
        
    }

    public function eliminartab(Request $request)
    {
        //Obtenemos el id del tab desde la vista con el objeto request.
        $id_tab = $request->id_tab;
        //Eliminamos el task en la base de datos.
        //Generamos un objeto del elemento a eliminar
        $tab = Tab::find($id_tab);
        $tab->delete();
        
        return redirect()->route('mainpage');
    }

    public function setAltoAncho(){

        $size = $_GET['size'];
        $id_tab =  $_GET['id_ventana'];
        if ($size == 1) {
            $tab = Tab::find($id_tab);
            $tab->grid_wide = 4;
            $tab->grid_height = 432;
            $tab->save();
        }
        if ($size == 2) {
            $tab = Tab::find($id_tab);
            $tab->grid_wide = 6;
            $tab->grid_height = 432;
            $tab->save();
        }
        if ($size == 3) {
            $tab = Tab::find($id_tab);
            $tab->grid_wide = 12;
            $tab->grid_height = 632;
            $tab->save();
        }
    }

    public function setcheck(){
        $id_task = $_GET['id'];

        $task = Task::find($id_task);
        if ($task->check == 'true') {
           $task->check = 'false';
        }else{
            $task->check = 'true';
        }
        $task->save();
    }

    public function settexto(){
        $texto = $_GET['text'];
        $id_task = $_GET['id'];

        $task = Task::find($id_task);
        $task->text = $texto;
        $task->save();
    }

    public function settextotab(){
        $texto = $_GET['text'];
        $id_tab = $_GET['id'];

        $tab = Tab::find($id_tab);
        $tab->name = $texto;
        $tab->save();
    }

    public function setOrder() {
        $ids_lista= $_GET['id_lista'];

        $id_ol = $_GET['id_tab'];
        $id_tab = preg_split('/milista/', $id_ol);

        $id_li = $_GET['id_task'];
        $id_task = preg_split('/tasksincompletar/', $id_li);

        $task = Task::find($id_task[1]);
        $task->id_tab = $id_tab[1];
        $task->save();

        $i = 1;
        foreach ($ids_lista as $key) {
            $id = preg_split('/tasksincompletar/', $key);
            $task = Task::find($id[1]);
            $task->order = $i;
            $task->save();
            $i++;
        }
    }

    public function setOrderTab() {
        $ids_lista= $_GET['id_lista'];

        $i = 1;
        foreach ($ids_lista as $key) {
            $id = preg_split('/tab/', $key);
            $task = Tab::find($id[1]);
            $task->order = $i;
            $task->save();
            $i++;
        }
    }

    public function setColor() {
        $id_tab = $_GET['id_tab'];
        $color = $_GET['color'];

        $tab = Tab::find($id_tab);
        $tab->color = $color;
        $tab->save();
    }
}
