<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	
	public function __construct (){
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->model('registro');
    }
    
    public function index()
	{
        $this->load->library('logueo');
        $this->load->helper('form');
        if (empty($this->session->logueado)){ $this->load->view('header'); $this->load->view('login');}
        else {
            $this->load->view('header2');
            $this->load->view('menu');
            $this->load->view('principal');
            $this->load->view('footer');
        }
	}
    
    public function nuevo_usuario() {
        $this->load->view('header');
        $this->load->view('nuevo_usuario');
    }
    
    public function insertar()
	{
		if(isset($_POST['nombre']) && isset($_POST['correo']) && isset($_POST['clave']) && isset($_POST['departamento']) && isset($_POST['nivel'])){
			$success = $this->registro->insertar($_POST['nombre'], $_POST['correo'], md5($_POST['clave']), $_POST['departamento'], $_POST['nivel']);
			if($this->registro){
				redirect('./Welcome/usuarios_listado');
			}
		}
	}
    
    public function nueva_sesion(){  
        if(isset($_GET['correo']) && isset($_GET['clave'])){
			
			$success = $this->registro->verificar($_GET['correo'],md5($_GET['clave']));
            if($success) {
                date_default_timezone_set('america/caracas');
                $this->session->nombre = $success->nombre;
                $this->session->nivel = $success->nivel;
                $this->session->departamento = $success->departamento;
                $this->session->hora = date("h:i:s a");
                $this->session->logueado = "1";
                $this->session->correo = $success->departamento;
                $this->session->id = $success->id_usuario;
                echo $this->session->logueado;
                redirect('http://localhost:5050/codeIgniter');
            }
		}
	}
    
    public function destruir_sesion(){
        $this->session->sess_destroy();
        redirect('http://localhost:5050/codeIgniter');
    }
    
    public function solicitud_nueva(){
        $clientes = $this->registro->clientes_ver('');
        
        $this->load->view('header2');
        $this->load->view('menu');
        $this->load->view('nueva_solicitud',$clientes);
        $this->load->view('footer');
    }
    
    public function solicitud_nueva_bd(){
        
        $config['upload_path']          = './archivos/adjuntos';
        $config['allowed_types']        = 'gif|jpg|png|txt|pdf';
        $config['max_size']             = 400;
        $config['max_width']            = 1024;
        $config['max_height']           = 768;

        $this->load->library('upload', $config);

        $this->upload->do_upload('archivo');
        
        $data = $this->upload->data(); 
        $filename = $data['file_name']; 
        
        $success = $this->registro->solicitud_add_bd($_POST['cliente'], $_POST['tcontratacion'], $_POST['departamento'], $_POST['rfq'], $_POST['fsolicitud'], $_POST['asunto'], $_POST['pclave'], $_POST['detalle'], $filename, $_POST['isolicitados']);
        
       redirect('./Welcome/solicitud_nueva');
	}
    
    public function solicitud_listado(){
        $this->load->view('header2');
        $this->load->view('menu');
        $this->load->view('solicitudes_listado');
        $this->load->view('footer');
    }
    
    public function solicitud_cambiar_estado(){
        //echo '<script>alert("aqui");</script>';
        $this->registro->solicitud_modificar_bd($_POST['estado'], $_POST['id_solicitud']);
        //echo '<script>alert("aqui")</script>';
    }
    
    public function solicitud_detalle(){
        $datos['id_solicitud'] = $_GET['id_solicitud'];
        $this->load->view('header2');
        $this->load->view('menu');
        $this->load->view('solicitud_detalle');
        $this->load->view('footer');
        
    }
    
    public function solicitud_asignar_analista(){
       $this->registro->solicitud_asignar_analista($_POST['id_solicitud'], $_POST['analista']); 
    }
    
    public function solicitud_modificar_bd($accion, $id_solicitud){
        $this->registro->solicitud_modificar_bd($accion, $id_solicitud);
    }
    
    public function solicitud_ver(){
        $detalle = $this->registro->solicitud_ver_detalle($_POST['solicitud_detalle']);
        $this->load->view('header2');
        $this->load->view('menu');
        $this->load->view('solicitud_ver_detalle', $detalle);
        $this->load->view('footer');
    }
    
    public function ordenes_listado(){
        $this->load->view('header2');
        $this->load->view('menu');
        $this->load->view('ordenes_listado');
        $this->load->view('footer');
    }
    
    public function clientes_listado(){
        $listado = $this->registro->clientes_ver('');
        $this->load->view('header2');
        $this->load->view('menu');
        $this->load->view('clientes_listado', $listado);
        $this->load->view('footer');
    }
    
    public function cliente_nuevo(){
        $this->load->view('header2');
        $this->load->view('menu');
        $this->load->view('cliente_nuevo');
        $this->load->view('footer');
    }
    
    public function cliente_nuevo_bd(){
       $success = $this->registro->cliente_add_bd($_POST['nombre'], $_POST['rif'], $_POST['pais'], $_POST['contacto'], $_POST['telefono'], $_POST['medio'], $_POST['direccion'], $_POST['observaciones']); 
    }
    
    public function departamentos_listado(){
        $departamentos = $this->registro->departamentos_ver('');
        $this->load->view('header2');
        $this->load->view('menu');
        $this->load->view('departamentos_listado',$departamentos);
        $this->load->view('footer');
    }
    
    public function departamento_nuevo(){
        $this->load->view('header2');
        $this->load->view('menu');
        $this->load->view('departamento_nuevo');
        $this->load->view('footer');
        
    }
    
    public function departamento_nuevo_bd(){
        $sucess = $this->registro->departamento_nuevo($_POST['nombre'], $_POST['tipo'], $_POST['limite']);
        redirect('./Welcome/departamentos_listado');
    }
    
    public function usuarios_listado(){
        $usuarios = $this->registro->usuarios_ver('');
        $this->load->view('header2');
        $this->load->view('menu');
        $this->load->view('usuarios_listado', $usuarios);
        $this->load->view('footer');
        
    }
    
    public function usuario_nuevo(){
        $departamentos = $this->registro->departamentos_ver('');
        $this->load->view('header2');
        $this->load->view('menu');
        $this->load->view('usuario_nuevo', $departamentos);
        $this->load->view('footer');
        
    }
    
    public function cotizacion_cargar(){
        $config['upload_path']          = './archivos/cotizaciones';
        $config['allowed_types']        = 'gif|jpg|png|txt|pdf';
        $config['max_size']             = 400;
        $config['max_width']            = 1024;
        $config['max_height']           = 768;

        $this->load->library('upload', $config);

        $this->upload->do_upload('archivo');
        
        $data = $this->upload->data(); 
        $filename = $data['file_name']; 
        
        $success = $this->registro->cotizacion_add_bd($_POST['id_solicitud'], $filename, $_POST['monto']);
        
        echo '<script> alert("Cotización cargada satisfactoriamente") </script>';
        
        $detalle = $this->registro->solicitud_ver_detalle($_POST['id_solicitud']);
        $this->load->view('header2');
        $this->load->view('menu');
        $this->load->view('solicitud_ver_detalle', $detalle);
        $this->load->view('footer');
    }
    
    public function cotizacion_cambiar_estado(){
        $success = $this->registro->cotizacion_cambiar_estado($_POST['id_solicitud'], $_POST['estado']);
        if ($_POST['estado'] == '1')
            $this->registro->solicitud_modificar_bd('COA', $_POST['id_solicitud']);
        else
            $this->registro->solicitud_modificar_bd('SEP', $_POST['id_solicitud']);
    }
    
    public function sendMailGmail()
     {
         //cargamos la libreria email de ci
         $this->load->library("email");

         //configuracion para gmail
         $configGmail = array(
         'protocol' => 'smtp',
         'smtp_host' => 'smtp.gmail.com',
         'smtp_port' => 587,
         'smtp_user' => 'samydavd@gmail.com',
         'smtp_pass' => 'SAMY2481839.3',
         'mailtype' => 'html',
         'charset' => 'utf-8',
         'newline' => "\r\n"
         );    

         //cargamos la configuración para enviar con gmail
         $this->email->initialize($configGmail);

         $this->email->from('samydavd@gmail.com');
         $this->email->to('samydavd@gmail.com');
         $this->email->subject('Oferta presentada para la solicitud');
         /*$body_msg =  '<html><body><br />'.
                        '<h2><font face="times new roman" color="#da0021"><span><font face="times new roman" color="#00769f"> SIGROF Sistema Empresarial</h2></font>'.
                        "<tr><td><strong>Nombre</strong> </td><td> Nombre empresarial </td></tr>".

                        "<tr><td><strong>Email:</strong> </td><td>sigrof@sersinca.com</td></tr>".

                        "<tr><td><strong>Telefono:</strong> </td><td> 0269-2481839 </td></tr>".

                        "<tr><td><strong>Comentario:</strong> </td><td>La presente cotización se oferta de acuerto al requerimiento #". $_POST['id_solicitud'] ." cuyo asunto se encuentra determinado para la obtención de".$_POST['asunto']."</td></tr>".

                        '<tr><td><img src="https://d500.epimg.net/cincodias/imagenes/2015/05/08/pyme/1431098283_691735_1431098420_noticia_normal.jpg"/></td></tr>'.

                        "<br />";*/
         $this->email->message('body');
         //$this->email->attach('archivos/cotizaciones/'.$_POST['archivo_cotizacion']);
         $this->email->send(FALSE);
         //con esto podemos ver el resultado
         //var_dump($this->email->print_debugger());
        $this->registro->solicitud_modificar_bd('COE', $_POST['id_solicitud']);
        $detalle = $this->registro->solicitud_ver_detalle($_POST['id_solicitud']);
        $this->load->view('header2');
        $this->load->view('menu');
        $this->load->view('solicitud_ver_detalle', $detalle);
        $this->load->view('footer');
        
        
        
        //echo '<script> alert("Correo enviado satisfactoriamente") </script>';
     }
    
    public function orden_nueva(){
        $this->load->view('header2');
        $this->load->view('menu');
        $this->load->view('orden_nueva_listado');
        $this->load->view('footer');
    }
    
    public function orden_ver(){
        $detalle = $this->registro->orden_ver_detalle($_POST['orden_detalle']);
        $this->load->view('header2');
        $this->load->view('menu');
        $this->load->view('orden_ver',$detalle);
        $this->load->view('footer');
    }
    
    public function orden_nueva_bd(){
        
        $config['upload_path']          = './archivos/ordenes';
        $config['allowed_types']        = 'gif|jpg|png|txt|pdf';
        $config['max_size']             = 400;
        $config['max_width']            = 1024;
        $config['max_height']           = 768;

        $this->load->library('upload', $config);

        $this->upload->do_upload('archivo_po');
        
        $data = $this->upload->data(); 
        $po = $data['file_name']; 
        
        
        $config['upload_path']          = './archivos/adjuntos';
        $config['allowed_types']        = 'gif|jpg|png|txt|pdf';
        $config['max_size']             = 400;
        $config['max_width']            = 1024;
        $config['max_height']           = 768;

        $this->load->library('upload', $config);

        $this->upload->do_upload('archivo_adjunto');
        
        $data = $this->upload->data(); 
        $adjunto = $data['file_name'];
        
        $success = $this->registro->orden_add_bd($_POST['id_solicitud'], $po, $_POST['detalle'], $_POST['link'], $adjunto, $_POST['tpago'], $_POST['monto'], $_POST['ia']);
        
        $this->registro->solicitud_modificar_bd('OCR', $_POST['id_solicitud']);
        
        echo '<script> alert("Orden creada satisfactoriamente") </script>';
        
       redirect('./Welcome/orden_nueva');
        
    }
    
    public function orden_cambiar_estado(){
      $this->registro->orden_modificar_bd($_POST['estado'], $_POST['id_solicitud']);  
    }
    
    public function orden_ver_detalle(){
        $detalle = $this->registro->orden_ver_detalle($_POST['orden_detalle']);
        $this->load->view('header2');
        $this->load->view('menu');
        $this->load->view('orden_ver', $detalle);
        $this->load->view('footer'); 
    }
    
    public function factura_cargar(){
        $config['upload_path']          = './archivos/facturas';
        $config['allowed_types']        = 'gif|jpg|png|txt|pdf';
        $config['max_size']             = 400;
        $config['max_width']            = 1024;
        $config['max_height']           = 768;

        $this->load->library('upload', $config);

        $this->upload->do_upload('archivo');
        
        $data = $this->upload->data(); 
        $filename = $data['file_name']; 
        
        $success = $this->registro->factura_add_bd($_POST['id_orden'], $filename, $_POST['id_solicitud'], $_POST['satisfacion']);
        
        echo '<script> alert("Factura cargada satisfactoriamente") </script>';
        
        $detalle = $this->registro->orden_ver_detalle($_POST['id_solicitud']);
        $this->load->view('header2');
        $this->load->view('menu');
        $this->load->view('orden_ver', $detalle);
        $this->load->view('footer'); 
    }
    
    public function reportes_indicadores(){
        $dep['departamentos'] = $this->registro->departamentos_ver('WHERE tipo="1" OR tipo="2"');
        $this->load->view('header2');
        $this->load->view('menu');
        $this->load->view('reportes_indicadores',$dep);
        $this->load->view('footer'); 
        
    }
    
    public function reporte_cargar(){
        $datos = array(
            'desde' => $_POST['desde'], 
            'hasta' => $_POST['hasta'], 
            'departamento' => $_POST['departamento']
        );
        
        if($_POST['tipo'] == '1')
            $this->load->view('reporte_capacidad_respuesta', $datos);
        else
            $this->load->view('indice_ventas', $datos);
    }
}
