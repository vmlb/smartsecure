cmake_minimum_required (VERSION 2.8)
project (IoT)

# Add executables  built from the source files
# "client.c"  "server.c" "scheme-test.c"
# The extensions are automatically found.

include_directories(${CMAKE_CURRENT_SOURCE_DIR}/include)

add_executable (client src/client.c)
add_executable (server src/server.c)
add_executable (scheme-test src/scheme-test.cpp)


# Link the executable to the libwolfssl library.
 
target_link_libraries (client  wolfssl)
target_link_libraries (server  wolfssl)
target_link_libraries (scheme-test wolfssl)



