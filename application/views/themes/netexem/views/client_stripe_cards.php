<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Stripe client Credit Cards 
 */
?>

<div class="panel_s section-heading section-credit-card">
        <?php if($this->session->flashdata('delete_card')){ ?>
    <div class="alert alert-success animated fadeIn hide">
        Card Deleted
   </div>
<?php } ?>
    <div class="panel-body">
        <h4 class="no-margin section-text"><?php echo _l('manage_payment_method'); ?></h4>
    </div>
</div>
<?php //echo "<pre>"; print_r($client_stripe_cards['data']); ?>
<div class="panel_s">
    <div class="panel-body">
      <?php
      $data['stripe_customer'] = "";
      $language = load_client_language($client->userid);
      $data['locale'] = get_locale_key($language);
      if(!empty($client->stripe_id)){

        $data['stripe_customer'] = $this->stripe_core->get_customer_with_default_source($client->stripe_id);


      } 
      $form = '<form action="' . site_url('gateways/stripe/new_card/'.$client->stripe_id) . '" method="POST">
      <script
      src="https://checkout.stripe.com/checkout.js" class="stripe-button"
      data-label="'.(isset($data['stripe_customer']) && !empty($data['stripe_customer']->default_source) ? _l('add_new_card') : _l('pay_with_card')).'"
      data-key="' . $this->stripe_gateway->getSetting('api_publishable_key') . '"
      data-name="' . get_option('companyname') . '"
      data-billing-address="true"
      data-description="change card";
      data-locale="'.$data['locale'].'"
      ' . (is_client_logged_in() ? 'data-email="' .$contact->email . '"' : '') . '
      data-currency="USD"
      >
      </script>
      </form>';
      echo $form;
      ?>
        <hr />
     <table class="table table-credit-cards" data-order-col="1" data-order-type="desc">
         <thead>
            <tr>
                <th class="th-name">Name</th>
                <th class="th-brand">Brand</th>
                <th class="th-last4">Card Last</th>
                <th class="th-status">Card Status</th>
                <th class="th-exp_year">Expire Year</th>

            </tr>
        </thead>
        <tbody>
            <?php if(!empty($client_stripe_cards['data'])){

                foreach ($client_stripe_cards['data'] as $key => $value) {  ?>
                     <tr>
                        <td data-order="<?php echo $value['name']; ?>"><?php echo $value['name']; ?>
                      | <a href="<?php echo site_url('payments_manage/delete_card/'.$value['id'].'/'.$value['customer']); ?>" class="delete-item-group _delete text-danger">
                        <?php echo _l('delete'); ?>
                      </a>
                  
                  </div>
                        </td>
                        <td data-order="<?php echo $value['brand']; ?>"><?php echo $value['brand']; ?></td>
                        
                        <td data-order="<?php echo $value['last4']; ?>"><?php echo $value['last4']; ?></td>
                        <td data-order="<?php echo $value['funding']; ?>"><?php echo $value['funding']; ?></td>
                        <td data-order="<?php echo $value['exp_year']; ?>"><?php echo $value['exp_year']; ?></td>
                    </tr>
                
               <?php }

            } ?>
        </tbody>
    </table>
</div>
</div>

