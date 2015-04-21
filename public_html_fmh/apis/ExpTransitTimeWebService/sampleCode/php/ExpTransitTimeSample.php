<html>
               <head>
                                <title>PHP Exp Trans Time Sample</title>
                </head>
                <body>
                <p>PHP Exp Trans Time Sample</p>
                <?php
                                $soapClient = new SoapClient("http://www.odfl.com/wsExpTransTime/TimeLookupService/WEB-INF/wsdl/TimeLookupService.wsdl");

                                $params->arg0->orgZip = '90210';
                                $params->arg0->destZip = '27360';
                                $params->arg0->pickUpDateYMD = '20121123';
                                $params->arg0->billToAcct = '0';

                                try{
                                                $results = $soapClient->getTT($params);
                                } catch (SoapFault $exception){
                                                trigger_error("SOAP Fault: (faultcode: {$exception->faultcode}, faultstring:
                                                {$exception->faultstring})");

                                                var_dump($exception);
                                }
                                if($results->return->success){
                                                echo 'success';
                                                echo ' transit time=';
                                                echo $results->return->delvTime;
                                                echo $results->return->message;
                                                echo $results->return->destSrvCntr;
                                                echo $results->return->orgSrvCntr;
                                } else {
                                                echo 'failure ';
                                                $errors=$results->return->message;
                                                print_r($errors);
                                }
                ?>
                </body>
</html>
