#include <iostream>
#include <string>
#include <cstdlib>

int main() {
  int choice;
  std::string welcome = "Welcome to IoT Security Middleware (v1.0) security scheme testing";

  std::cout << std::endl;
  std::cout << std::string(welcome.size(), '*') << std::endl;
  std::cout << welcome << std::endl;
  std::cout << std::string(welcome.size(), '*') << std::endl;

  std::cout << std::endl;
  std::cout << "Please select one of the below options to run a test:" << std::endl; 
  std::cout << std::endl;
  std::cout << " 1) TLS PSK AES 128 CBC SHA NO SESSION RESUMPTION" << std::endl;
  std::cout << " 2) TLS PSK AES 128 CBC SHA WITH SESSION RESUMPTION" << std::endl;
  std::cout << std::endl;
  std::cout << " 3) TLS ECDHE RSA AES 256 SHA384 NO SESSION RESUMPTION" << std::endl;
  std::cout << " 4) TLS ECDHE RSA AES 256 SHA384 WITH SESSION RESUMPTION" << std::endl;
  std::cout << std::endl;
  std::cout << " 5) DTLS PSK AES 128 CBC SHA NO SESSION RESUMPTION" << std::endl;
  std::cout << " 6) DTLS PSK AES 128 CBC SHA WITH SESSION RESUMPTION" << std::endl;
  std::cout << std::endl;
  std::cout << " 7) DTLS ECDHE RSA AES 256 SHA384 NO SESSION RESUMPTION" << std::endl;
  std::cout << " 8) DTLS ECDHE RSA AES 256 SHA384 WITH SESSION RESUMPTION" << std::endl;
  std::cout << std::endl;
  
    

  do {
    std::cin >> choice;

   if (choice == 1) {
      
      // using TLS PSK WITH AES 128 CBC SHA scheme without session resumption
      system("gnome-terminal -e 'bash -c \"./examples/server/server -s -l PSK-AES128-CBC-SHA -v 3 -t -p 11000; exec bash\"'");
      system("gnome-terminal -e 'bash -c \"./examples/client/client -s -l PSK-AES128-CBC-SHA -v 3 -t -p 11000; exec bash\"'");
      
    } else if (choice == 2) {
               
      // using TLS PSK WITH AES 128 CBC SHA scheme with session resumption
      system("gnome-terminal -e 'bash -c \"./examples/server/server -s -l PSK-AES128-CBC-SHA -v 3 -r -t -p 11001; exec bash\"'");
      system("gnome-terminal -e 'bash -c \"./examples/client/client -s -l PSK-AES128-CBC-SHA -v 3 -r -t -p 11001; exec bash\"'");      
     
    } else if (choice == 3) {
            
      // using TLS ECDHE-RSA-AES256-SHA384 scheme without session resumption
      system("gnome-terminal -e 'bash -c \"examples/server/server -l ECDHE-RSA-AES256-SHA384 -c ./certs/server-cert.pem -k ./certs/server-key.pem -v 3 -t -p 11002; exec bash\"'");
      system("gnome-terminal -e 'bash -c \"examples/client/client -l ECDHE-RSA-AES256-SHA384 -v 3 -t -p 11002; exec bash\"'");
     
    } else if (choice == 4) {
      
      // using TLS ECDHE-RSA-AES256-SHA384 scheme with session resumption  
      system("gnome-terminal -e 'bash -c \"examples/server/server -l ECDHE-RSA-AES256-SHA384 -c ./certs/server-cert.pem -k ./certs/server-key.pem -v 3 -r -t -p 11003; exec bash\"'");
      system("gnome-terminal -e 'bash -c \"examples/client/client -l ECDHE-RSA-AES256-SHA384 -v 3 -r -t -p 11003; exec bash\"'");
      
      
    } else if (choice == 5) {
       
      // using DTLS PSK WITH AES 128 CBC SHA scheme without session resumption
      system("gnome-terminal -e 'bash -c \"./examples/server/server -s -l PSK-AES128-CBC-SHA -u -v 3 -t -p 11000; exec bash\"'");
      system("gnome-terminal -e 'bash -c \"./examples/client/client -s -l PSK-AES128-CBC-SHA -u -v 3 -t -p 11000; exec bash\"'");
      
    } else if (choice == 6) {
               
      // using DTLS PSK WITH AES 128 CBC SHA scheme with session resumption
      system("gnome-terminal -e 'bash -c \"./examples/server/server -s -l PSK-AES128-CBC-SHA -u -v 3 -r -t -p 11001; exec bash\"'");
      system("gnome-terminal -e 'bash -c \"./examples/client/client -s -l PSK-AES128-CBC-SHA -u -v 3 -r -t -p 11001; exec bash\"'");      
     
    } else if (choice == 7) {
            
      // using DTLS ECDHE-RSA-AES256-SHA384 scheme without session resumption
      system("gnome-terminal -e 'bash -c \"examples/server/server -l ECDHE-RSA-AES256-SHA384 -c ./certs/server-cert.pem -k ./certs/server-key.pem -v 3 -t -p 11002; exec bash\"'");
      system("gnome-terminal -e 'bash -c \"examples/client/client -l ECDHE-RSA-AES256-SHA384 -v 3 -t -p 11002; exec bash\"'");
     
    } else if (choice == 8) {
      
      // using DTLS ECDHE-RSA-AES256-SHA384 scheme with session resumption  
      system("gnome-terminal -e 'bash -c \"examples/server/server -l ECDHE-RSA-AES256-SHA384 -c ./certs/server-cert.pem -k ./certs/server-key.pem -v 3 -r -t -p 11003; exec bash\"'");
      system("gnome-terminal -e 'bash -c \"examples/client/client -l ECDHE-RSA-AES256-SHA384 -v 3 -r -t -p 11003; exec bash\"'");
      
    }
    
  } while (choice != -1);

  return 0;
}
