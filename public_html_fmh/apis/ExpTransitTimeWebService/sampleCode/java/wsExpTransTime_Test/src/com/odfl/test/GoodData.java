package com.odfl.test;

import java.rmi.RemoteException;
import java.util.ArrayList;
import java.util.Iterator;

import org.apache.log4j.Logger;

import com.ibm.ws.webservices.engine.client.Service;
import com.odfl.time.TimeLookupPortProxy;
import com.odfl.time.TimeRequest;
import com.odfl.time.TimeResponse;


public class GoodData {

	public static final String LIVE_URL = "http://www.odfl.com/wsExpTransTime/TimeLookupService";

	private TimeLookupPortProxy service = new TimeLookupPortProxy();
	private TimeRequest request;	

	private static final Logger LOG = Logger.getLogger(GoodData.class);

	public static void main(String[] args){
		GoodData gd = new GoodData();
		gd.setUp();
		try {
			gd.prod();
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
			LOG.error("Error: ", e);
		}
	}

	public void setUp(){
		request = new TimeRequest();
		request.setOrgZip("54401");
		request.setDestZip("27253");
		request.setPickUpDateYMD("20121123");
		request.setBillToAcct("0");


	}

	public void prod() throws Exception{
		service._getDescriptor().setEndpoint(LIVE_URL);
		runTests();
	}


	private void runTests() throws RemoteException{
		TimeResponse response = new TimeResponse();
		response = service.getTT(request);	


		if(response.isSuccess()){

			LOG.info("Success for Time Lookup");
			LOG.info("Delivered Date: "+response.getDelvDate()+" Delivered Time: "+response.getDelvTime()+" Deliverd Day: "+response.getDelvDay()+" Origin SVCNTR: "+response.getOrgSrvCntr()+" Destination SVCNTR: "+response.getDestSrvCntr()+" Message: "+response.getMessage());
		}

	
	else{
		LOG.info("Error for Time Lookup");
		LOG.info(response.getMessage());
	}
}
}

