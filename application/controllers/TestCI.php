<?php

defined('BASEPATH') or exit('No direct script access allowed');

class TestCI extends Admin_controller
{
    public function __construct()
    {
        parent::__construct();
        hooks()->do_action('after_clients_area_init', $this);

        if (!is_client_logged_in()) {
            redirect_after_login_to_current_url();
            redirect(site_url('authentication/login'));
        }

        if (is_client_logged_in() && !is_contact_email_verified()) {
            redirect(site_url('verification'));
        }


        $this->load->model("Clients_model");
        $this->load->library('stripe_core');
        $this->load->model('invoices_model');

    }

    public function index()
    {
        //step1 get all stripe clients
        $where['stripe_id !='] = "";
        $clients = $this->Clients_model->get("",$where);

        foreach ($clients as $client) {
            //step2 get all unpaid invoices of client in crm
            $clientid = $client['userid'];
            $invoicesInCRM = $this->invoices_model->getInvoices($clientid);

            //step3 get all invoices of client in stripe
            $clientStripeId = $client['stripe_id'];
            $subs = $this->stripe_core->get_subscriptions($clientStripeId);

            if(isset($subs->data[0])){
                $subscriptionId = $subs->data[0]->id;
                $arr = array("subscription"=>$subscriptionId);
                $allInvoices = $this->stripe_core->allinvoices($arr);
                $stripeInvoices = array();
                foreach ($allInvoices['data'] as $k4 => $v2) {

                    $epoch = $v2->date;
                    $dt = new DateTime("@$epoch");
                    $invDate = $dt->format('Y-m-d');
                    $status = $v2->status;
                    $strpData = array("date"=>$invDate,"status"=>$status);
                    array_push($stripeInvoices, $strpData);       
                }
            }

            $sizeofStripe = count($stripeInvoices);

            //step4 compare stripe invoices with crm invoices and get invoice of same dates
            for ($i=0; $i < $sizeofStripe ; $i++) { 
                
                if(isset($invoicesInCRM[$i]['date']) && isset($stripeInvoices[$i]['date']))
                {
                    
                    if($invoicesInCRM[$i]['date'] == $stripeInvoices[$i]['date']){  

                        //step5 check status of stripe invoice
                        if($stripeInvoices[$i]['status'] == "paid"){
                            echo "we should pay this invoice ".$invoicesInCRM[$i]['id']." ".$stripeInvoices[$i]['status']."<br>";

                            //step6 update status of crm invoice 
                            // $updateWhere["id"] = $invoicesInCRM[$i]['id'];
                            // $updateInvoice = array("status"=>2);
                            // $this->invoices_model->updateInvoice($updateWhere,$updateInvoice);
                        }  
                    }
                }         
            }
       }     
    }



   

}
?>