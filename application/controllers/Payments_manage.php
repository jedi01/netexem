<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Payments_manage extends Clients_controller
{
    public function __construct()
    {
        parent::__construct();

        hooks()->do_action('after_clients_area_init', $this);

        /**
         * The Clients.php controller methods requires a logged in contact
         */
        if (!is_client_logged_in()) {
            redirect_after_login_to_current_url();
            redirect(site_url('authentication/login'));
        }

        if (is_client_logged_in() && !is_contact_email_verified()) {
            redirect(site_url('verification'));
        }
        
         $this->load->library('stripe_core');
          $this->load->model("Clients_model");

    }
    public function index()
    {
        $client_id =  get_client_user_id();
        $client_data = $this->Clients_model->get_client($client_id);
        $data['contact'] = $this->Clients_model->get_contact($client_id);
        $data['client'] = $this->Clients_model->get_client($client_id);
        $data['client_stripe_cards'] = $this->stripe_core->customer_all_cards($client_data->stripe_id);
        $this->data            = $data;
        $this->view            = 'client_stripe_cards';
        $this->layout();
        
    }


    public function delete_card($card,$customer_id)
    {
        $delete_card = $this->stripe_core->delete_card($customer_id,$card);
        $this->session->set_flashdata('delete_card', true);
        redirect($_SERVER['HTTP_REFERER']);

    }



}
