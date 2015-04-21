using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace SampleExpeditedTransitTimeWSClient
{
    class Program
    {
        static void Main(string[] args)
        {
            TimeLookupDelegateClient service = new TimeLookupDelegateClient();
            timeRequest request = new timeRequest();
            request.orgZip = "27360";
            request.destZip = "90210";
            request.billToAcct = "0";
            request.pickUpDateYMD = "20121123";

            timeResponse response = service.getTT(request);
            if (response.success)
            {
                Console.WriteLine(response.delvDate + " " + response.destSrvCntr + " " + response.orgSrvCntr + " " + response.message);
            }
            Console.WriteLine("Press any key to continue...");
            Console.ReadKey(true);
        }
    }
}
