/*
 * Created on Sep 9, 2005
 *
 * 
 * 
 */

/**
 * @author odfl
 *
 *Old Dominion Freight Line (ODFL) grants you a nonexclusive copyright license to use all programming code 
 *examples from which you can generate similar function tailored to your own specific needs.
 *										
 *All sample code is provided by ODFL for illustrative purposes only. 
 *These examples have not been thoroughly tested under all conditions. 
 *ODFL, therefore, cannot guarantee or imply reliability, serviceability, 
 *or function of these programs.

 *All programs contained herein are provided to you "AS IS" without any warranties of any kind. 
 *The implied warranties of non-infringement, merchantability and fitness for a particular 
 *purpose are expressly disclaimed.
 * 
 * 
 */

import com.odfl.trace.*;

public class TraceTest {


	public static void main(String[] args) {

		// Make a service 
		TraceService traceService = new TraceServiceLocator();
		try{

		Trace port = traceService.getTrace();
		TraceResult tr = port.getTraceData("7", "P");
		//System.out.println("value of errorMessage is: " + tr.getErrorMessage());
		if(tr.getErrorMessage().equals("")){
		System.out.println("value of shipment status is: " + tr.getStatus());
		System.out.println("value of shipment status code is: " + tr.getStatusCode());
		System.out.println("delivery date is : " + tr.getProDate());
		System.out.println("po number is: " + tr.getPo());
		System.out.println("bill of lading number is: " + tr.getBol()); 
		System.out.println("number of pieces is: " + tr.getPieces());
		System.out.println("weight is: " + tr.getWeight());
		System.out.println("value of call is: " + tr.getCall());
		System.out.println("value of appointment is: " + tr.getAppointment());
		System.out.println("value of trailer is: " + tr.getTrailer());
		System.out.println("value of delivered is: " + tr.getDelivered());
		System.out.println("value of signature is: " + tr.getSignature());
		System.out.println("value of scac is: " + tr.getScac());
		System.out.println("value of url is: " + tr.getUrl());
		System.out.println("value of origin service center is: " + tr.getOrigTerminal());
		System.out.println("value of origin service center name is: " + tr.getOrigName());
		System.out.println("value of origin address is: " + tr.getOrigAddress());
		System.out.println("value of origin city is: " + tr.getOrigCity());
		System.out.println("value of origin state is: " + tr.getOrigState());
		System.out.println("value of origin zip is: " + tr.getOrigZip());
		System.out.println("value of origin phone is: " + tr.getOrigPhone());
		System.out.println("value of origin fax is: " + tr.getOrigFax());
		System.out.println("value of destination service center is: " + tr.getDestTerminal());
		System.out.println("value of destination service center name is: " + tr.getDestName());
		System.out.println("value of destination address is: " + tr.getDestAddress());
		System.out.println("value of destination city is: " + tr.getDestCity());
		System.out.println("value of destination state is: " + tr.getDestState());
		System.out.println("value of destination zip is: " + tr.getDestZip());
		System.out.println("value of destination phone is: " + tr.getDestPhone());
		System.out.println("value of destination fax is: " + tr.getDestFax());
		System.out.println("value of pro is: " + tr.getProNum());
		System.out.println("value of type is: " + tr.getType());
		}//end if
		else{
		System.out.println("value of errorMessage is: " + tr.getErrorMessage());
		}


		

		}//end try
		
		catch (Exception e)
        	{
            // Handle error.
            System.out.println("Exception occured while getting port" + e);
            
        	}//end catch

	}

}
