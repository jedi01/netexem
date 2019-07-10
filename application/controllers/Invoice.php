<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Invoice extends Clients_controller
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
        
         
        $this->load->model("Clients_model");

    }
    public function index($id, $hash)
    {   
        $data = $this->input->post();
        $client_id =  get_client_user_id();
        $data['contact'] = $this->Clients_model->get_contact_by_user($client_id);

        if(isset($_POST)){
            $autopay = 0;
            if(isset($data['settings']['autopay']))
            {
                $autopay = $data['settings']['autopay'];
            }
            $this->db->where('id', $id);
            $this->db->update(db_prefix().'invoices', ['autopay' => $autopay]);
        }
        check_invoice_restrictions($id, $hash);
        $invoice = $this->invoices_model->get($id);

        $invoice = hooks()->apply_filters('before_client_view_invoice', $invoice);

        if (!is_client_logged_in()) {
            load_client_language($invoice->clientid);
        }
        // Handle Invoice PDF generator
        if ($this->input->post('invoicepdf')) {
            try {
                $pdf = invoice_pdf($invoice);
            } catch (Exception $e) {
                echo $e->getMessage();
                die;
            }

            $invoice_number = format_invoice_number($invoice->id);
            $companyname    = get_option('invoice_company_name');
            if ($companyname != '') {
                $invoice_number .= '-' . mb_strtoupper(slug_it($companyname), 'UTF-8');
            }
            $pdf->Output(mb_strtoupper(slug_it($invoice_number), 'UTF-8') . '.pdf', 'D');
            die();
        }
        // Handle $_POST payment
        if ($this->input->post('make_payment')) {
            $this->load->model('payments_model');
            if (!$this->input->post('paymentmode')) {
                set_alert('warning', _l('invoice_html_payment_modes_not_selected'));
                redirect(site_url('invoice/' . $id . '/' . $hash));
            } elseif ((!$this->input->post('amount') || $this->input->post('amount') == 0) && get_option('allow_payment_amount_to_be_modified') == 1) {
                set_alert('warning', _l('invoice_html_amount_blank'));
                redirect(site_url('invoice/' . $id . '/' . $hash));
            }

            $this->payments_model->process_payment($this->input->post(), $id);
        }
        if ($this->input->post('paymentpdf')) {


            $id                    = $this->input->post('paymentpdf');
            $payment               = $this->payments_model->get($id);
            $payment->invoice_data = $this->invoices_model->get($payment->invoiceid);
            $paymentpdf            = payment_pdf($payment);
            $paymentpdf->Output(mb_strtoupper(slug_it(_l('payment') . '-' . $payment->paymentid), 'UTF-8') . '.pdf', 'D');

            die;
        }
        $this->load->library('stripe_core');
        if(!empty($invoice->client->stripe_id)){
            $this->load->library('stripe_core');
            $data['stripe_customer'] = $this->stripe_core->get_customer_with_default_source($invoice->client->stripe_id);
        }

        $this->load->library('app_number_to_word', [
            'clientid' => $invoice->clientid,
        ],'numberword');
        
        $this->load->model('payment_modes_model');
        $this->load->model('payments_model');
        $data['payments']      = $this->payments_model->get_invoice_payments($id);
        $data['payment_modes'] = $this->payment_modes_model->get();
        $data['title']         = format_invoice_number($invoice->id);
        $this->use_navigation  = false;
        $this->use_submenu     = false;
        $data['hash']          = $hash;
        $data['invoice']       = hooks()->apply_filters('invoice_html_pdf_data', $invoice);
        $data['bodyclass']     = 'viewinvoice';
        $this->data            = $data;
        $this->view            = 'invoicehtml';

        add_views_tracking('invoice', $id);
        hooks()->do_action('invoice_html_viewed', $id);
        no_index_customers_area();
        $this->layout();
    }



    function updateInvoice()
    {
        $response['status'] = FALSE;
        $invoiceID = $_POST['invoice_id'];
        $option = $_POST['option'];
        $data = array("autopay"=>$option);
        $where['id'] = $invoiceID;
        $respo = $this->invoices_model->updateInvoice($where,$data);
        if($respo)
        {
            $response['status'] = TRUE;
        }
        echo json_encode($response);
        exit();
    }

    function invoicepdf($id, $hash)
    {
        $this->load->library("pdf");
        check_invoice_restrictions($id, $hash);
        $invoice = $this->invoices_model->get($id);

        $invoice = hooks()->apply_filters('before_client_view_invoice', $invoice);

        if (!is_client_logged_in()) {
            load_client_language($invoice->clientid);
        }
        // Handle Invoice PDF generator
         
        
        $this->load->library('app_number_to_word', [
            'clientid' => $invoice->clientid,
        ],'numberword');
        $this->load->model('payment_modes_model');
        $this->load->model('payments_model');
        $data['payments']      = $this->payments_model->get_invoice_payments($id);
        $data['payment_modes'] = $this->payment_modes_model->get();
        $data['title']         = format_invoice_number($invoice->id);
        $this->use_navigation  = false;
        $this->use_submenu     = false;
        $data['hash']          = $hash;
        $data['invoice']       = hooks()->apply_filters('invoice_html_pdf_data', $invoice);
        if($invoice->status == 2){
            $data['payment'] = TRUE;
            $data['inv_date'] = $this->invoices_model->getInvoicePayDate($invoice->id);
        }
       

        $this->load->view('themes/netexem/views/invoicepdf',$data);   

        $html = $this->output->get_output();

        $this->pdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $this->pdf->setPaper('A4', 'portrait');

        $this->pdf->set_option('enable_html5_parser', TRUE);

        $this->pdf->set_option('isPhpEnabled', true);

        $this->pdf->set_option('defaultFont', 'Montserrat');

        // Render the HTML as PDF
        $this->pdf->render();

        $file =  $this->pdf->output();
        // Get the generated PDF file contents
        $filename = format_invoice_number($id).".pdf";
        $this->pdf->stream($filename,array("Attachment"=>1));
           
           
    }
}
