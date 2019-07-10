<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Customers area dedicated theme functions
 */

function add_netexem_theme_menu_item($slug, $item)
{
    return get_instance()->app_menu->add_theme_item($slug, $item);
}

function add_default_netexem_theme_menu_items()
{
    // if (is_knowledge_base_viewable(true)) {
    //     add_netexem_theme_menu_item('knowledge-base', [
    //         'name'     => _l('clients_nav_kb'),
    //         'href'     => site_url('knowledge-base'),
    //         'position' => 5,
    //     ]);
    // }

    if (!is_client_logged_in() && get_option('allow_registration') == 1) {
        add_netexem_theme_menu_item('register', [
                'name'     => _l('clients_nav_register'),
                'href'     => site_url('authentication/register'),
                'position' => 99,
            ]);
    }

    if (!is_client_logged_in()) {
        add_netexem_theme_menu_item('login', [
                    'name'     => _l('clients_nav_login'),
                    'href'     => site_url('authentication/login'),
                    'position' => 100,
                ]);
    } else {
         if (has_contact_permission('invoices')) {
            add_netexem_theme_menu_item('invoices', [
                    'name'     => _l('clients_nav_billing'),
                    'href'     => site_url('clients/invoices'),
                    'position' => 10,
                ]);
        }
        if (has_contact_permission('projects')) {
            add_netexem_theme_menu_item('projects', [
                    'name'     => _l('clients_nav_files'),
                    'href'     => site_url('clients/files'),
                    'position' => 15,
                ]);
        }
       
        // if (has_contact_permission('contracts')) {
        //     add_netexem_theme_menu_item('contracts', [
        //             'name'     => _l('clients_nav_contracts'),
        //             'href'     => site_url('clients/contracts'),
        //             'position' => 20,
        //         ]);
        // }
        // if (has_contact_permission('estimates')) {
        //     add_netexem_theme_menu_item('estimates', [
        //             'name'     => _l('clients_nav_estimates'),
        //             'href'     => site_url('clients/estimates'),
        //             'position' => 25,
        //         ]);
        // }
        // if (has_contact_permission('proposals')) {
        //     add_netexem_theme_menu_item('proposals', [
        //             'name'     => _l('clients_nav_proposals'),
        //             'href'     => site_url('clients/proposals'),
        //             'position' => 30,
        //         ]);
        // }
        if (has_contact_permission('support')) {
            add_netexem_theme_menu_item('support', [
                    'name'     => _l('clients_nav_support'),
                    'href'     => site_url('clients/tickets'),
                    'position' => 35,
                ]);
        }
        if (is_gdpr() && is_client_logged_in() && get_option('show_gdpr_in_customers_menu') == '1') {
            add_netexem_theme_menu_item('gdpr', [
                    'name'     => _l('clients/gdpr'),
                    'href'     => site_url('clients/gdpr'),
                    'position' => 40,
                ]);
        }
    }
}