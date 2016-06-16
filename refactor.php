<?php 

public function post_confirm(){
	
	$id = Input::get('service_id');
	$servicio = Service::find($id);
	$id_driver = Input::get('driver_id');
	
	//Se comprueba que el parametro service_id que llega no sea nulo
	if($servicio != NULL){
		
		if($servicio->getStatus_id() == '6'){
			return Response::json(array('error' => '2'));
		}
		
		//Se comprueba que el servicio no tenga conductor asociado aun y su estado = 1
		if(!isset($servicio->getDriver_id()) && $servicio->getStatus_id() == '1'){
			$servicio = Service::update($id,array(
												'driver_id' => $id_driver,
												'status_id' => '2'
			));
			
			//El conductor ya no esta disponible para otros servicios
			Driver::update($id_driver,array("available" => '0'));
			
			$driverTmp = Driver::find($id_driver);
			Service::update($id, array(
			'car_id' => $driverTmp->getCar_id()
			));
			
			//Notificar a usuario
			$pushMessage = 'Tu servicio ha sido confirmado';
			$servicio = Service::find($id);
			$push = Push::make();
			
			//Se notifica al usuario dependiendo del tipo de dispositivo movil
			if($servicio->user->type == '1'){
				$result = $push->ios($servicio->getUser()->getUuid(),$pushMessage,1,'honk.wav','open',array('serviceId' => $servicio->getId()));	
			}
			else{
				$result = $push->android($servicio->getUser()->getUuid(),$pushMessage,1,'default','open',array('serviceId' => $servicio->getId()));
			}
			
			return Response::json(array('error' => '0'));
			
		} else{
			return Response::json(array('error' => '1'));
		}
	}else{
		return Response::json(array('error' => '3'));	
	}
}
?>