<?php

require_once 'Inf_Controller.php';

class invoice extends Inf_Controller {

    function __construct() {
        parent::__construct();
//        $this->load->library('cart');
    }

    function order_details() {

		if( ( $orders = $this->input->post('order_ids') ) ) {
			$this->download_zip( $orders );
		}

        $this->load->library( 'inf_pagination' );
        $pagination           = [ ];
        $pagination['limit']  = inf_pagination::PER_PAGE;
        $pagination['offset'] = 0;
        if ( $this->uri->segment( 4 ) && is_numeric( $this->uri->segment( 4 ) ) ) {
            $pagination['offset'] = intval( $this->uri->segment( 4 ) - 1 ) * inf_pagination::PER_PAGE;
        }


        $title = lang('invoice');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('invoice');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('invoice');
        $this->HEADER_LANG['page_small_header'] = '';

        $help_link = lang('order_history');
        $this->set("help_link", $help_link);

        $this->load_langauge_scripts();

		$total_rows = $this->invoice_model->getCountOfOrderDetails();
        $order_details = $this->invoice_model->getUserOrderDetails(null, null, $pagination);

		$links = $this->inf_pagination->create_links( [
			'base_url'   => base_url() . "admin/invoice/order_details",
			'total_rows' => $total_rows
		] );
		$this->set('offset', ++$pagination['offset'] );
		$this->set('total_amount', $total_rows );
		$this->set('links', $links );

        $this->set("order_details", $order_details);
        $this->setView();
    }

    function my_invoice($id = '') {

        $title = lang('invoice');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('invoice');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('invoice');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

//      $user_id = $this->LOG_USER_ID;
        $user_id = $this->validation_model->getUserIdFromOrder($id);
        $f_name = $this->validation_model->getUserFullName($user_id);
        $address1 = $this->validation_model->getUserAddress($user_id);
        $address2 = $this->validation_model->getUserAddress2($user_id);


        $order_details = $this->invoice_model->getOrderDetailsFromId($id);
        
        $fp_status = $this->invoice_model->getFPStatus($id);
        $payment_type = $this->invoice_model->getPaymentType($id);

        $user_email = $this->validation_model->getUserEmail($user_id);
        $user_phone = $this->validation_model->getUserMobileNumber($user_id);
        $site_info = $this->validation_model->getSiteInformation();
        $postcode =$this->validation_model->getUserPin($user_id);
        $city =$this->validation_model->getUserCity($user_id);

        $com_address = str_replace(",", "<br/>", $site_info['company_address']);

        $this->set("payment_type", $payment_type);
        $this->set("postcode", $postcode);
        $this->set("city", $city);
        $this->set("fp_status", $fp_status);
        $this->set("f_name", $f_name);
        $this->set("address1", $address1);
        $this->set("address2", $address2);
        $this->set("com_address", $com_address);
        $this->set("site_info", $site_info);
        $this->set("order_details", $order_details);
        $this->set("order_id", $id);
        $this->set("user_email", $user_email);
        $this->set("user_phone", $user_phone);

        $this->setView();
    }

    function show_customer($id = '', $batch_download = '') {

        $order_id = $id;
//        $user_id = $this->LOG_USER_ID;
        $user_id =$this->validation_model->getUserIdFromOrder($order_id);
        
        $order_details = $this->invoice_model->getOrderDetailsFromId($order_id);
        $fp_status = $this->invoice_model->getFPStatus($order_id);
        $payment_type = $this->invoice_model->getPaymentType($id);
        
        $user_email = $this->validation_model->getUserEmail($user_id);
        $user_phone = $this->validation_model->getUserMobileNumber($user_id);
        $site_image = $this->validation_model->getSiteInformation();

        $city=$this->validation_model->getUserCity($user_id);
        $postcode =$this->validation_model->getUserPin($user_id);
        $f_name = $this->validation_model->getUserFullName($user_id);
        $address1 = $this->validation_model->getUserAddress($user_id);
        $address2 = $this->validation_model->getUserAddress2($user_id);


        $base_url = base_url();
        $sub_total = 0;

        $total = 0;


        

 $content2="<div>          
    <div style='font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#000000'>
        <table style='float:right;width:100%;height:300px;'> 
            <tr> 
            <td width='65%'><div class='inv_wrap' style='overflow: hidden; display:flex;justify-content: space-between;'>
                <div style=''>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                   <div style='text-align:left;color: #8a8a8a;font-size: 7px;'><u>" . $site_image['company_address'] . "</u></div>
                    <br/>
                    <b>" . $f_name . "</b><br/>"; if ($address1 != 'NA' && $address1 !='') {
                                                $content2 .=$address1.",<br/>";
                                                }

                                                if ($address2 != 'NA' && $address2 !='') {

                                                    $content2 .=$address2.",<br/>";
                                                }
                                                if ($city != 'NA' && $city !='') {

                                                    $content2 .=$city.",";
                                                }
                                                if ($postcode != 'NA' && $postcode !='') {

                                                    $content2 .=$postcode."<br/>";
                                                }
        
         $content2 .="</div>
                    
            </div></td>
                <td width='35%'><img src=".$base_url.'public_html/images/logos/nlogo.png' ."  alt='Invoice' style='margin-bottom:20px;border:none;width:190px;height:150px;float:right;'>
                    <div style=''>" . $site_image['company_address'] . "</div>
                 </td>
                
           
        </tr>
        </table>
        <div style='width:100%;height:70px;'>  </div>
        <h3>INVOICE</h3><br> 

        <table style='border-collapse:collapse;width:100%;border-top:0px solid #dddddd;border-left:0px solid #dddddd;margin-bottom:20px'>
            <thead>
                <tr>
                    <td width='35%' style='font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:left;padding:10px;color:#222222;' >Order Details</td><td></td>
                </tr>
            </thead>
            <tbody>
                <tr style='font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;text-align:left;padding:15px'><td><b>Invoice ID: </b></td><td>INV-000" . $order_id . "</td></tr>
                <tr style='font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;text-align:left;padding:15px'><td><b>Date Added: </b></td><td>" . $order_details['0']['date'] . "</td></tr>
                <tr style='font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;text-align:left;padding:15px'><td><b>Payment Method:</b></td><td>" . $payment_type . "</td></tr>

            </tbody>
        </table>



        <table style='border-collapse:collapse;width:100%;border-top:0px solid #dddddd;border-left:0px solid #dddddd;margin-bottom:20px'>
            <thead>
                <tr>
                    <td style='font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;font-weight:bold;text-align:left;padding:12px;color:#222222; width:35%;' >Package</td>

                    <td style='font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;font-weight:bold;text-align:center;padding:12px;color:#222222;width:25%;'>Quantity</td>
                    <td style='font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;font-weight:bold;text-align:center;padding:12px;color:#222222;width:25%;'>Price</td>
                    <td style='font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;font-weight:bold;text-align:center;padding:12px;color:#222222;width:15%;'>Total</td>
                </tr>
            </thead>
            <tbody>";
           foreach ($order_details as $value) {   
$content2 .= "<tr><td style='font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;text-align:left;padding:10px'>" . $value['package_name'] . "</td>

                    <td style='font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;text-align:center;padding:10px'>" . $value['quantity'] . "</td>
                    <td style='font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;text-align:center;padding:10px'> &euro; " . $value['price'] . "</td>";

        $sub_total = $value['price'] * $value['quantity'];
        $total = $total + $sub_total;
            
      $content2 .=" <td style='font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;text-align:center;padding:10px'> &euro; " . $sub_total . "</td></tr>";
                    
           }
$content2 .="</tbody>
            <tfoot> ";
         if ($fp_status == '1') {

            $fp_price = 25;
            $total+=$fp_price;    
            $content2 .=    "<tr>
                    <td style='font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;font-weight:bold;text-align:left;padding:12px;color:#222222;' colspan='3'><b> Enrolment</b></td>
                    <td style='font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;text-align:center;padding:7px;color:#222222;'> &euro; " . $fp_price . "</td>
                </tr>";
            }
            
            
            
          $content2 .=  "<tr>
                    <td style='font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;font-weight:bold;text-align:left;padding:12px;color:#222222;' colspan='2'>TOTAL</td>
                    <td style='font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;font-weight:bold;text-align:right;padding:12px;color:#222222;' colspan='1'>TAX FREE</td>
                    <td style='font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;text-align:center;padding:7px;color:#222222;border-top:2px solid #dddddd;'> &euro; " . $total . "</td>
                </tr>
                
</tfoot>
        </table>
    </div>                                                        
    <br/> 
    <br/></div> 
    <div style='width:100%;height:80px;'>  </div>
   <div style='text-align:center;color: #8c8c8c;font-size: 10px;'>
                                                           <br/>

                                                           
                                                           EURO SOLUTION GMBH, Ruessenstrasse 12, 6340 Baar, Schweiz<br/>info@swisscoin.eu,

www.swisscoin.eu<br/>Raiffeisenbank Aarau-Lenzburg, IBAN: CH1480698000013826785, BIC:

RAIFCH22698<br/>CEO: Werner Marquetant, UID CHE-142.141.405 MWST
                                                         
                                                        
    </div>";

        $this->load->library('m_pdf');
        $pdf = $this->m_pdf->load();
        $pdf->WriteHTML($content2);
		if( true === $batch_download ) {
			return [
				'filename' => 'invoice-' . intval( $order_id ) . '.pdf',
				'content'  => $pdf->Output('', 'S')
			];
		} else {
			$pdf->Output('Invoice.pdf', 'D');
		}
    }


	function download_zip( $orders ) {

		$zip_file = realpath( APPPATH ) . '/../uploads/archive.zip';

		$zip = new ZipArchive();
		$zip->open( $zip_file,  ZipArchive::CREATE | ZipArchive::OVERWRITE );

		foreach ( $orders as $order ) {
			$file = $this->show_customer( $order, true );
			$zip->addFromString( $file['filename'], $file['content'] );
		}
		$zip->close();

		header('Content-Description: File Transfer');
		header( 'Content-type: application/zip' );
		header( 'Content-Disposition: attachment; filename="' . basename( $zip_file ) . '"' );
		header( "Content-length: " . filesize( $zip_file ) );
		header('Content-Transfer-Encoding: binary');
		header( "Pragma: no-cache" );
		header( "Expires: 0" );
		ob_clean();
		flush();

		readfile( $zip_file );
	}

}
