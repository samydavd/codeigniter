<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registro extends CI_Model{
    public function __construct(){
      parent::__construct();
      $this->load->database();
      $this->load->library('session');
    }
 
    function verificar($nom,$pass)
    {
        $query = $this->db->query('SELECT * FROM usuarios WHERE correo = "'.$nom.'" AND clave = SUBSTRING("'.$pass.'",1,20)');
        
        if ($query->num_rows())
        {
            return $query->row();
        }
        //else
        //{
            //redirect('http://localhost/login/index.php/verificar');
        //}
    }

    public function eliminar($cedula){
      $query = $this->db->query('DELETE FROM datos WHERE cedula = "'.$cedula.'"');
      return $query;
    }

    public function modificar($cedula,$nombre)
    {
      $query = $this->db->query('UPDATE datos SET nombre=".$cedula." WHERE cedula = "'.$cedula.'"');
      return $query;
    }


    public function insertar($nombre, $correo,$clave,$departamento,$nivel){
      $data = array('nombre' => $nombre, 'correo' => $correo, 'clave' => $clave, 'departamento' => $departamento, 'nivel' => $nivel);
      if($this->db->insert("usuarios",$data)){
        return true;
      }else{
        return false;
      }
    }

    public function filtrar ($cedula,$nombre){
      $query = $this->db->query("SELECT * FROM datos WHERE cedula LIKE '%$cedula' and nombre LIKE '$nombre%'");
        return $query->result_array();
    }
    
    public function solicitud_add_bd($cliente, $tcontratacion, $departamento, $rfq, $fsolicitud, $asunto, $pclave, $detalle, $archivo, $isolicitados){
        
        $query = $this->db->query('INSERT INTO solicitudes (cliente, departamento, analista1, rfq, asunto, pclave, detalle, adjunto, isolicitados, estado, fsolicitud, tcontratacion) VALUES ("'.$cliente.'","'.$departamento.'","-1","'.$rfq.'","'.$asunto.'","'.$pclave.'","'.$detalle.'","'.$archivo.'","'.$isolicitados.'","SCR",NOW(),"'.$tcontratacion.'")');
    }
    
    public function solicitudes_ver_listado($dep,$nivel){
        if($nivel=="1" || $nivel == "2")
            $query = $this->db->query('SELECT * FROM solicitudes WHERE departamento="'.$dep.'" AND estado <> "OCR"');
        else {
            $query = $this->db->query('SELECT id_usuario FROM usuarios WHERE nombre="'.$this->session->nombre.'"');
            $usuario = $query->result();
            
            $query = $this->db->query('SELECT * FROM solicitudes WHERE departamento="'.$dep.'" AND analista1="'.$usuario[0]->id_usuario.'" estado <> "OCR"');
        }
        return $query->result_array();
        
    }
    
    public function solicitudes_ver_listado_completo(){
        $query = $this->db->query('SELECT * FROM solicitudes WHERE estado <> "OCR"');
        return $query->result_array();
        
    }
    
    public function solicitudes_ver_total($dep){
        $query = $this->db->query('SELECT * FROM solicitudes WHERE departamento="'.$dep.'"');
        return $query->num_rows();
        
    }
    
    public function solicitudes_notificaciones($codicion){
        $query = $this->db->query('SELECT * FROM solicitudes WHERE '.$codicion.'');
        return $query->result_array();
    }
    
    public function ordenes_notificaciones($codicion){
        $query = $this->db->query('SELECT solicitudes.*, ordenes.* FROM solicitudes INNER JOIN ordenes ON (solicitudes.id_solicitud = ordenes.solicitud) WHERE '.$codicion.'');
        return $query->result_array();
    }
    
    public function ordenes_nuevas_listado(){
        $query = $this->db->query('SELECT * FROM solicitudes WHERE estado="COE"');
        return $query->result_array();
        
    }
    
    public function insert_file($filename, $title)
    {
        $data = array(
            'archivo'      => $filename
            
        );
        $this->db->insert('solicitudes', $data);
        return $this->db->insert_id();
    }
 
    
    public function solicitud_modificar_bd($accion, $id_solicitud){
        $query = $this->db->query('UPDATE solicitudes SET estado="'.$accion.'" WHERE id_solicitud ="'.$id_solicitud.'"');
        //return $query;
        
    }
    
    public function solicitud_ver_detalle($id){
        $query = $this->db->query('SELECT *, DATEDIFF(now(),fsolicitud) AS dias FROM solicitudes WHERE id_solicitud="'.$id.'"');
        return $query->result_array();
    }
    
    public function solicitud_asignar_analista($id_solicitud,$analista){
        $query = $this->db->query('UPDATE solicitudes SET analista1="'.$analista.'", estado="SAA" WHERE id_solicitud ="'.$id_solicitud.'"');
    }
    
    public function solicitud_ver_periodo($desde, $hasta, $estado){
        $query = $this->db->query('SELECT * FROM solicitudes WHERE ('.$estado.' fsolicitud >="'.$desde.'" AND fsolicitud <="'.$hasta.'" )');
        return $query->num_rows();
    }
    
    public function cantidad_notificaciones($nivel,$nombre_dep,$dep){
        if($nombre_dep == 'Mercadeo'){
            $query = $this->db->query('SELECT * FROM solicitudes WHERE estado ="COA"');
            $solicitudes = $query->num_rows();
            $total = $solicitudes;
        }
        
        elseif($nombre_dep == 'Administracion'){
            $query = $this->db->query('SELECT * FROM ordenes WHERE estado="SEP"');
            $ordenes = $query->num_rows();
            $total = $ordenes;
        }
        
        elseif($nombre_dep == 'Gerencia General'){
            $query = $this->db->query('SELECT solicitudes.*, cotizaciones.* FROM solicitudes INNER JOIN cotizaciones ON (solicitudes.id_solicitud = cotizaciones.solicitud) WHERE (solicitudes.estado = "COC" AND cotizaciones.aprobado <> "-1" AND cotizaciones.monto > "100000000")');
            $ordenes = $query->num_rows();
            $total = $ordenes;
        }
        
        
        elseif($nivel=="1") {
            $query = $this->db->query('SELECT * FROM solicitudes WHERE departamento="'.$dep.'" AND (estado ="SCR" OR estado ="COC")');
            $solicitudes = $query->num_rows();
            
            $query = $this->db->query('SELECT solicitudes.*, ordenes.* FROM solicitudes INNER JOIN ordenes ON (solicitudes.id_solicitud = ordenes.solicitud) WHERE (ordenes.estado = "SCR" AND solicitudes.departamento = "'.$dep.'")');
            $ordenes = $query->num_rows();
            $total = $solicitudes + $ordenes;
        }
        else{
            $query = $this->db->query('SELECT * FROM solicitudes WHERE (estado = "SAA" OR estado="COA") AND analista1 = "'.$this->session->id.'"');
            $solicitudes = $query->num_rows();
            $total = $solicitudes;
        }
        return $total;
    }
    
    public function orden_ver_periodo($desde, $hasta, $estado){
        $query = $this->db->query('SELECT * FROM ordenes WHERE ('.$estado.' forden >="'.$desde.'" AND forden <="'.$hasta.'" )');
        return $query->num_rows();
    }
    
    public function cliente_add_bd($nombre, $rif,$pais,$contacto,$telefono,$medio,$direccion,$observaciones){
        
        $query = $this->db->query('INSERT INTO clientes (nombre, rif, pais, contacto, telefono, medio, direccion, observacion) VALUES ("'.$nombre.'","'.$rif.'","'.$pais.'","'.$contacto.'","'.$telefono.'","'.$medio.'","'.$direccion.'","'.$observaciones.'")');
    }
    
    public function clientes_ver($especifico)
    {
       $query = $this->db->query('SELECT * FROM clientes '.$especifico.' ORDER BY nombre ASC');
       return $query->result_array();
    }
    
    public function departamentos_ver($especifico){
        $query = $this->db->query('SELECT * FROM departamentos '.$especifico.' ORDER BY id_departamento ASC');
        return $query->result_array(); 
    }
    
    public function departamento_nuevo($nombre, $tipo, $limite){
        
        $query = $this->db->query('INSERT INTO departamentos (nombre_departamento, tipo, limitebs) VALUES ("'.$nombre.'","'.$tipo.'","'.$limite.'")');
        return $query;
    }
    
    public function usuarios_ver($especifico){
        $query = $this->db->query('SELECT * FROM usuarios '.$especifico.' ORDER BY departamento DESC');
        return $query->result_array(); 
    }
    
    public function cotizacion_ver($id){
        $query = $this->db->query('SELECT * FROM cotizaciones WHERE solicitud = '.$id.' AND aprobado <> "-1" LIMIT 1');
        return $query->result_array(); 
    }
    
    public function cotizacion_ver_limite($id){
        $query = $this->db->query('SELECT * FROM cotizaciones WHERE solicitud = '.$id.' AND aprobado <> "-1" AND monto > "100000000" LIMIT 1');
        return $query->result_array(); 
    }
    
    public function cotizacion_add_bd($id_solicitud, $archivo, $monto){
        $query = $this->db->query('INSERT INTO cotizaciones (solicitud, archivo, fcotizacion, aprobado, monto) VALUES ("'.$id_solicitud.'","'.$archivo.'", NOW(), "0", "'.$monto.'")');
        
        $this->registro->solicitud_modificar_bd('COC',$id_solicitud);
    }
    
    public function cotizacion_cambiar_estado($id_solicitud, $accion){
        $query = $this->db->query('UPDATE cotizaciones SET aprobado="'.$accion.'" WHERE solicitud ="'.$id_solicitud.'"');
    }
    
    public function orden_add_bd($id_solicitud, $po, $detalle, $link, $adjunto, $tpago, $monto, $ia){
        $query = $this->db->query('INSERT INTO ordenes (solicitud, po, detalle_po, link_po, archivo, monto, item_aprob, t_pago, estado,forden) VALUES ("'.$id_solicitud.'","'.$po.'", "'.$detalle.'", "'.$link.'", "'.$adjunto.'", "'.$monto.'", "'.$ia.'", "'.$tpago.'","SCR", NOW())');
        
    }
    
    public function ordenes_ver($condicion){
       $query = $this->db->query('SELECT AVG(satisfacion) as total FROM ordenes '.$condicion.'');
       return $query->result_array(); 
    }
    
    public function ordenes_ver_listado($dep){
       $query = $this->db->query('SELECT * FROM solicitudes WHERE departamento="'.$dep.'" AND estado="OCR"');
       return $query->result_array(); 
    }
    
    public function ordenes_ver_listado_completo(){
       $query = $this->db->query('SELECT * FROM solicitudes WHERE estado="OCR"');
       return $query->result_array(); 
    }
    
    
    public function orden_ver_detalle($sol){
       $query = $this->db->query('SELECT * FROM ordenes WHERE solicitud="'.$sol.'" LIMIT 1');
       return $query->result_array(); 
    }
    
    public function orden_modificar_bd($estado, $id_solicitud){ 
        $query = $this->db->query('UPDATE ordenes SET estado="'.$estado.'" WHERE solicitud ="'.$id_solicitud.'"');
    }
    
    public function factura_add_bd($id_orden, $archivo, $id_solicitud, $satisfacion){
        $query = $this->db->query('INSERT INTO factura (orden, archivo, ffactura) VALUES ("'.$id_orden.'","'.$archivo.'", NOW())');
        $query = $this->db->query('UPDATE ordenes SET satisfacion="'.$satisfacion.'" WHERE id_orden = "'.$id_orden.'"');
        $this->registro->orden_modificar_bd('FAC',$id_solicitud);
    }
    
    public function factura_ver($id_orden){
        $query = $this->db->query('SELECT * FROM factura WHERE orden="'.$id_orden.'" LIMIT 1');
        return $query->result_array(); 
    }

}
?>