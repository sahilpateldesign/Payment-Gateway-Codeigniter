<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends CI_Controller {
    
    function __construct() {
        parent::__construct();
		
        $this->load->library('stripe_lib');
		$this->load->model('product_m');
    }
    
    public function index(){
        $data = array();
		
		$this->data['products'] = $this->product_m->getRows();
		

        $this->data['title'] = 'Home';
        $this->data['subview'] = 'products/index';
        $this->load->view('layout', $this->data);
        
    }
	
	function purchase($id){
		$data = array();
		
        $product = $this->product_m->getRows($id);
		
		if($this->input->post('stripeToken')){
			$postData = $this->input->post();
			$postData['product'] = $product;
			
			$paymentID = $this->payment($postData);
			
			if($paymentID){
				redirect('products/payment_status/'.$paymentID);
			}else{
				$apiError = !empty($this->stripe_lib->api_error)?' ('.$this->stripe_lib->api_error.')':'';
				$$this->data['error_msg'] = 'Transaction has been failed!'.$apiError;
			}
		}
        
		$this->data['product'] = $product;
        $this->load->view('products/details', $this->data);
    }
	
	function payment($postData){
		
		if(!empty($postData)){
			$token  = $postData['stripeToken'];
			$name = $postData['name'];
			$email = $postData['email'];
			$card_number = $postData['card_number'];
			$card_number = preg_replace('/\s+/', '', $card_number);
			$card_exp_month = $postData['card_exp_month'];
			$card_exp_year = $postData['card_exp_year'];
			$card_cvc = $postData['card_cvc'];
			
			$orderID = strtoupper(str_replace('.','',uniqid('', true)));
			
			$customer = $this->stripe_lib->addCustomer($email, $token);
			
			if($customer){
				$charge = $this->stripe_lib->createCharge($customer->id, $postData['product']['name'], $postData['product']['price'], $orderID);
				
				if($charge){
					if($charge['amount_refunded'] == 0 && empty($charge['failure_code']) && $charge['paid'] == 1 && $charge['captured'] == 1){

						$transactionID = $charge['balance_transaction'];
						$paidAmount = $charge['amount'];
						$paidAmount = ($paidAmount/100);
						$paidCurrency = $charge['currency'];
						$payment_status = $charge['status'];
						
						
						$orderData = array(
							'product_id' => $postData['product']['id'],
							'buyer_name' => $name,
							'buyer_email' => $email,
							'card_number' => $card_number,
							'card_exp_month' => $card_exp_month,
							'card_exp_year' => $card_exp_year,
							'paid_amount' => $paidAmount,
							'paid_amount_currency' => $paidCurrency,
							'txn_id' => $transactionID,
							'payment_status' => $payment_status
						);
						$orderID = $this->product_m->insertOrder($orderData);
						
						if($payment_status == 'succeeded'){
							return $orderID;
						}
					}
				}
			}
		}
		return false;
    }
	
	function payment_status($id){
		$data = array();
		
        $order = $this->product_m->getOrder($id);
		
        $this->data['title'] = 'Payment Status';
        $this->data['subview'] = 'products/payment-status';
		$this->data['order'] = $order;
        $this->load->view('layout', $this->data);
    }
}