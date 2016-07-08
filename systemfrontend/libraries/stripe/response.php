<?php

$card['stripeToken'] = $_POST['stripeToken'];
//require_once('init.php');
require_once('lib/Stripe.php');
Stripe::setApiKey("sk_test_PCdbAXeTWMXiAmnNXtXoAqat");

$amount= 10*100;

if(isset($_POST)) {
	try{
	$response= Stripe_Charge::create(array( 
	"amount" => $amount, 
	"currency" => "usd", 
	"card" => $card['stripeToken'],
	 ));
	
	 $result = json_decode($response);
	// $card = $result->card;
	
	 $transection=$result->balance_transaction;
	  if(!empty($card))
	  {
		  echo $transection;
	   //redirect(base_url().'restaurants/successful_payment/'.$transection);
	  }
	 }catch(Exception $e){
	  // echo "The error was: " . $e->getMessage() ;die;
	   $err=1;
	   echo $e->getMessage();
	  // $this->session->set_flashdata("The error was: " . $e->getMessage());
	   //redirect(base_url()."restaurants/payments");
	}
}
	  
?>
