#include <iostream>
#include <string>
#include <cstdlib>

int main() {
  int choice;
  std::string welcome = "Welcome to Flexible Security (v0.1)";

  std::cout << std::endl;
  std::cout << std::string(welcome.size(), '*') << std::endl;
  std::cout << welcome << std::endl;
  std::cout << std::string(welcome.size(), '*') << std::endl;

  std::cout << std::endl;
  std::cout << "1) Basic live video streaming" << std::endl;
  std::cout << "2) TLS PSK security" << std::endl;
  std::cout << "3) TLS Certificate security" << std::endl;
  std::cout << "4) DTLS PSK security" << std::endl;
  std::cout << "5) DTLS Certificate security" << std::endl;
  std::cout << "6) DTLS Static PSK security" << std::endl;
  std::cout << std::endl;

  do {
    std::cin >> choice;

    if (choice == 1) {
      // OpenCV Video
      system("./client 127.0.0.1 10000");
    } else if (choice == 2) {
      // TLS PSK
      system("./client -s -t -v 3 -r -p 11000");
    } else if (choice == 3) {
      // TLS Cert
      system("./client -t -v 3 -r -p 11001");
    } else if (choice == 4) {
      // DTLS PSK
      system("./client -s -t -u -v 3 -r -p 11005");
    } else if (choice == 5) {
      // DTLS Cert
      system("./client -t -u -v 3 -r -p 11006");
    } else if (choice == 6) {
      // DTLS Static PSK
      system("./client -l PSK-AES128-CBC-SHA -t -u -v 3 -r -p 11010");
    }

  } while (choice != -1);

  return 0;
}
