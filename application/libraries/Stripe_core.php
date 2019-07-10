<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Stripe_core
{
    protected $ci;

    protected $secretKey;

    protected $publishableKey;

    protected $apiVersion = '2019-02-19';

    public function __construct()
    {
        $this->ci             = &get_instance();
        $this->secretKey      = $this->ci->stripe_gateway->decryptSetting('api_secret_key');
        $this->publishableKey = $this->ci->stripe_gateway->getSetting('api_publishable_key');

        \Stripe\Stripe::setApiVersion($this->apiVersion);
        \Stripe\Stripe::setApiKey($this->secretKey);
    }

    public function create_customer($data)
    {
        return \Stripe\Customer::create($data);
    }

    public function get_customer($id)
    {
        return \Stripe\Customer::retrieve($id);
    }

    public function update_customer_source($customer_id, $token)
    {
        \Stripe\Customer::update($customer_id, [
            'source' => $token,
        ]);
    }

    public function get_customer_with_default_source($id)
    {
        return \Stripe\Customer::retrieve(['id' => $id, 'expand' => ['default_source']]);
    }

    public function create_charge($data)
    {
        return \Stripe\Charge::create($data);
    }

    public function create_source($data)
    {
        return \Stripe\Source::create($data);
    }

    public function get_source($source)
    {
        return \Stripe\Source::retrieve($source);
    }

    public function get_publishable_key()
    {
        return $this->publishableKey;
    }

    public function retrieve_token($token_id)
    {
        return \Stripe\Token::retrieve($token_id);
    }

    public function has_api_key()
    {
        return $this->secretKey != '';
    }


    public function create_plan($data)
    {
        return \Stripe\Plan::create($data);
    }

    public function create_subscription($data)
    {
        return \Stripe\Subscription::create($data);
    }

    public function get_subscriptions($customer_id)
    {
       return  \Stripe\Customer::retrieve($customer_id)->subscriptions->all();
    }

    public function update_subscriptions($subscriptionId,$data)
    {
        return \Stripe\Subscription::update($subscriptionId,$data);
    }

    public function delete_plan($planId)
    {
        return \Stripe\Plan::retrieve($planId); 
    }

    public function customer_all_cards($customer_id)
    {   

        return \Stripe\Customer::retrieve($customer_id)->sources->all(['limit'=>10, 'object' => 'card']);
    }


    public function delete_card($customer_id,$card)
    {
        $customer = \Stripe\Customer::retrieve($customer_id);
        return $customer->sources->retrieve($card)->delete();

    }

    public function getNextInvoice($customer_id)
    {
    
      return \Stripe\Invoice::upcoming(["customer" => $customer_id]);
    }

    public function allinvoices($data)
    {
        return \Stripe\Invoice::all($data);
    }


    public function invoiceStats($data='')
    {
        return \Stripe\Invoice::retrieve($data);
    }

}
